<?php
include "../conn/conn.php";
function rupiah($dampak_keuangan)
{
    $rupiah = number_format($dampak_keuangan, 0, ",", ".");
    return $rupiah;
}
