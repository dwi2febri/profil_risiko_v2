<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__.'/../conn/conn.php';
require_once __DIR__.'/../fungsi/authentication.php';
function security_check($value, $message) { if (!$value) throw new RuntimeException($message); }
foreach (["1' OR '1'='1", '1 OR 1=1', '1 UNION SELECT 1', '0; SELECT SLEEP(2)', ['1']] as $id) {
    security_check(!simpro_validate_record_ids(['id'=>$id]), 'Unsafe identifier accepted');
}
security_check(simpro_validate_record_ids(['id'=>'545','id_parameter'=>'23','tab'=>'final','search'=>"O'Brien"]), 'Legitimate input rejected');
security_check(simpro_validate_record_ids(['id'=>['1','2']], true), 'Valid bulk identifiers rejected');
security_check(!simpro_validate_record_ids(['id'=>['1','2 OR 1=1']], true), 'Unsafe bulk identifier accepted');
security_check(mysqli_character_set_name($conn) === 'utf8mb4', 'Connection charset is ambiguous');
$payloads = ["' OR 1=1 -- ", "x'); DROP TABLE user; --", "O'Brien \\ notes", 'normal assessment text'];
mysqli_query($conn, 'CREATE TEMPORARY TABLE simpro_security_probe (id INT PRIMARY KEY, note VARCHAR(512))');
try {
    foreach ($payloads as $index=>$payload) {
        $id=$index+1;
        security_check(simpro_db_query($conn, 'INSERT INTO simpro_security_probe (id,note) VALUES (?,?)', [$id,$payload]) === true, 'Bound insert failed');
        $result=simpro_db_query($conn, 'SELECT note FROM simpro_security_probe WHERE id=?', [$id]);
        security_check(mysqli_fetch_assoc($result)['note'] === $payload, 'Input was interpreted as SQL or changed');
        security_check(simpro_db_query($conn, 'UPDATE simpro_security_probe SET note=? WHERE id=?', [$payload.' updated',$id]) === true, 'Bound update failed');
    }
    security_check((int)mysqli_fetch_row(mysqli_query($conn,'SELECT COUNT(*) FROM simpro_security_probe'))[0] === count($payloads), 'Injection altered rows');
    security_check(simpro_db_query($conn, 'DELETE FROM simpro_security_probe WHERE id=?', [1]) === true, 'Bound delete failed');
} finally { mysqli_query($conn,'DROP TEMPORARY TABLE simpro_security_probe'); }
$user=mysqli_fetch_assoc(simpro_db_query($conn, 'SELECT username,password,user_id FROM user WHERE tipe=? LIMIT 1', ['admin']));
security_check($user && simpro_authenticate($conn,$user['username'],$user['password'])['user_id'] == $user['user_id'], 'Existing account cannot login');
security_check(simpro_authenticate($conn,"' OR 1=1 -- ",'invalid') === null, 'Username injection bypassed authentication');
security_check(simpro_authenticate($conn,$user['username'],"' OR 1=1 -- ") === null, 'Password injection bypassed authentication');
echo "PASS bound SELECT/INSERT/UPDATE/DELETE, identifier validation, real login and SQL-injection rejection; persistent data unchanged\n";
