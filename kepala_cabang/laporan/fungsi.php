<?php
require dirname(__DIR__, 2).'/conn/conn.php';
function rupiah($dampak_keuangan)
{
    $rupiah = number_format($dampak_keuangan, 0, ",", ".");
    return $rupiah;
}
