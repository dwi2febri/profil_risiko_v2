<?php
/** Preserve SQL literal text while separating bound markers from adjacent keywords. */
function simpro_sql_placeholders(string $sql): string
{
    $out = ''; $quote = null; $length = strlen($sql);
    for ($i=0; $i<$length; $i++) {
        $char = $sql[$i];
        if ($quote !== null) {
            $out .= $char;
            if ($char === '\\' && $i+1<$length) { $out .= $sql[++$i]; continue; }
            if ($char === $quote) {
                if ($i+1<$length && $sql[$i+1] === $quote) $out .= $sql[++$i];
                else $quote = null;
            }
        } elseif ($char === '#' || ($char === '-' && substr($sql, $i, 2) === '--' && ($i+2 === $length || ctype_space($sql[$i+2])))) {
            $end = strpos($sql, "\n", $i);
            if ($end === false) { $out .= substr($sql, $i); break; }
            $out .= substr($sql, $i, $end-$i); $i=$end-1;
        } elseif ($char === '/' && substr($sql, $i, 2) === '/*') {
            $end = strpos($sql, '*/', $i+2);
            if ($end === false) { $out .= substr($sql, $i); break; }
            $out .= substr($sql, $i, $end+2-$i); $i=$end+1;
        } elseif ($char === "'" || $char === '"' || $char === '`') {
            $quote = $char; $out .= $char;
        } elseif ($char === '?') $out .= ' ? ';
        else $out .= $char;
    }
    return $out;
}

/** Bind values separately from SQL; existing callers keep mysqli_result/boolean results. */
function simpro_db_query(mysqli $conn, string $sql, array $params = [])
{
    // mysqli_stmt_close resets connection affected_rows to -1. Keep only the
    // latest statement per connection so legacy callers can still read stats.
    static $statements = null;
    if ($statements === null) $statements = new WeakMap();
    if (isset($statements[$conn])) {
        try { mysqli_stmt_close($statements[$conn]); } catch (Error $closed) {}
        unset($statements[$conn]);
    }
    $stmt = mysqli_prepare($conn, simpro_sql_placeholders($sql));
    if (!$stmt) return false;
    $statements[$conn] = $stmt;
    if ($params) {
        $types = '';
        foreach ($params as $value) $types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    if (!mysqli_stmt_execute($stmt)) return false;
    return mysqli_stmt_field_count($stmt) > 0 ? mysqli_stmt_get_result($stmt) : true;
}

function simpro_app_base_path(): string
{
    $root = str_replace('\\', '/', dirname(__DIR__));
    $file = str_replace('\\', '/', (string)($_SERVER['SCRIPT_FILENAME'] ?? ''));
    $script = str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    $suffix = str_starts_with($file, $root.'/') ? substr($file, strlen($root)) : '';
    return $suffix !== '' && str_ends_with($script, $suffix) ? rtrim(substr($script, 0, -strlen($suffix)), '/').'/' : rtrim(dirname($script), '/').'/';
}

/** Allow-list numeric record identifiers; do not modify or blacklist free-text input. */
function simpro_validate_record_ids(array $input, bool $allowArrays = false): bool
{
    foreach ($input as $key => $value) {
        if (!preg_match('/^(?:id(?:_[a-z0-9_]+)?|[a-z0-9_]+_id)$/iD', (string)$key)) continue;
        $values = is_array($value) && $allowArrays ? $value : [$value];
        foreach ($values as $item) {
            if ($item === '' || $item === null) continue;
            if (!is_scalar($item) || !preg_match('/^-?\d+$/D', (string)$item)) return false;
        }
    }
    return true;
}

function simpro_database_request_guard(): void
{
    if (PHP_SAPI === 'cli') return;
    $publicLogin = realpath((string)($_SERVER['SCRIPT_FILENAME'] ?? '')) === realpath(dirname(__DIR__).'/index.php');
    if (!$publicLogin) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            if (str_contains((string)($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json') || strtolower((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest') {
                http_response_code(401);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['error'=>'Silakan login terlebih dahulu.']);
            } else header('Location: '.simpro_app_base_path(), true, 302);
            exit;
        }
    }
    if (!simpro_validate_record_ids($_GET) || !simpro_validate_record_ids($_POST, true)) {
        http_response_code(400);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Parameter ID tidak valid.';
        exit;
    }
}
