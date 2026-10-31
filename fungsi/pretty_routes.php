<?php
/** URL aliases for the existing role index controllers; permission checks stay in index.php. */
function simpro_route_url(string $roleBase, array $params): string
{
    $page = is_string($params['page'] ?? null) ? $params['page'] : '';
    if ($page !== '' && !preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/D', $page)) return $roleBase.'index.php?'.http_build_query($params);
    unset($params['page']);
    $path = $roleBase.$page;
    if ($page === 'pembanding') $path .= '/';
    if ($page === 'menulapawal') {
        // This alias is also a physical directory: keep its slash so mod_dir
        // and PHP agree on the canonical URL instead of redirecting in a loop.
        $path = $roleBase.'laporan/';
        if (isset($params['id']) && is_scalar($params['id']) && ctype_digit((string)$params['id'])) {
            $path .= rawurlencode((string)$params['id']);
            unset($params['id']);
            if (isset($params['tab']) && is_string($params['tab']) && preg_match('/^[a-zA-Z0-9_-]+$/D', $params['tab'])) {
                $path .= '/'.rawurlencode($params['tab']);
                unset($params['tab']);
            }
        } elseif (($params['id'] ?? null) === '') unset($params['id']);
    }
    $query = http_build_query($params);
    return $path.($query !== '' ? '?'.$query : '');
}

function simpro_route_absolute_location(string $location, string $roleBase): string
{
    if (preg_match('~^(?:[a-z][a-z0-9+.-]*:|//|/)~i', $location)) return $location;
    $parts = parse_url($roleBase.$location);
    $segments = [];
    foreach (explode('/', $parts['path'] ?? '') as $segment) {
        if ($segment === '..') array_pop($segments);
        elseif ($segment !== '' && $segment !== '.') $segments[] = $segment;
    }
    return '/'.implode('/', $segments).(isset($parts['query']) ? '?'.$parts['query'] : '').(isset($parts['fragment']) ? '#'.$parts['fragment'] : '');
}

function simpro_routes_bootstrap(): array
{
    $script = str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? ''));
    $roleBase = rtrim(dirname($script), '/').'/';
    $projectBase = rtrim(dirname(rtrim($roleBase, '/')), '/').'/';
    $path = parse_url((string)($_SERVER['REQUEST_URI'] ?? $script), PHP_URL_PATH) ?: $script;
    $relative = str_starts_with($path, $roleBase) ? substr($path, strlen($roleBase)) : '';
    if (preg_match('~^laporan(?:/([0-9]+)(?:/([a-zA-Z0-9_-]+))?)?/?$~D', $relative, $match)) {
        $_GET['page'] = 'menulapawal';
        if (isset($match[1]) && $match[1] !== '') $_GET['id'] = $match[1];
        if (isset($match[2]) && $match[2] !== '') $_GET['tab'] = $match[2];
    } elseif (preg_match('~^([a-zA-Z][a-zA-Z0-9_]*)/?$~D', $relative, $match)) {
        $_GET['page'] = $match[1];
    }
    // Legacy includes occasionally read REQUEST rather than GET.
    foreach (['page', 'id', 'tab'] as $key) if (isset($_GET[$key])) $_REQUEST[$key] = $_GET[$key];
    // Progress Excel is dispatched by the existing role controller after its
    // layout. Hold that layout so the download can discard it before XML output,
    // including on PHP-FPM installations with output_buffering disabled/small.
    if (($_GET['page'] ?? '') === 'progress_pengisian' && ($_GET['cetak_excel'] ?? '') === '1') {
        ob_start();
    }
    header_register_callback(static function() use ($roleBase): void {
        foreach (headers_list() as $header) {
            if (stripos($header, 'Location:') !== 0) continue;
            $location = trim(substr($header, 9));
            $absolute = simpro_route_absolute_location($location, $roleBase);
            if ($absolute !== $location) header('Location: '.$absolute, true, http_response_code());
        }
    });
    $canonical = simpro_route_url($roleBase, $_GET);
    $current = (string)($_SERVER['REQUEST_URI'] ?? '');
    $ajax = strtolower((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest';
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && !$ajax && $current !== $canonical && $canonical !== $roleBase.'index.php?'.http_build_query($_GET)) {
        header('Location: '.$canonical, true, 302);
        exit;
    }
    return ['roleBase'=>$roleBase, 'projectBase'=>$projectBase, 'page'=>(string)($_GET['page'] ?? ''), 'params'=>$_GET, 'canonical'=>$canonical];
}
