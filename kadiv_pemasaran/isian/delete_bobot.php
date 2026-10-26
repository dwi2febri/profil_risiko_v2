<?php
include "../conn/conn.php";
$id = $_GET['idbobot'];


mysqli_query($conn, "DELETE FROM bobot_kredit_per_pilar WHERE id_bobot='$id'");


mysqli_query($conn, "DELETE FROM bobot_kredit_per_parameter WHERE id_bobot='$id'");



mysqli_query($conn, "DELETE FROM bobot_operasional_per_pilar WHERE id_bobot='$id'");


mysqli_query($conn, "DELETE FROM bobot_operasional_per_parameter WHERE id_bobot='$id'");



mysqli_query($conn, "DELETE FROM bobot_kepatuhan_per_pilar WHERE id_bobot='$id'");


mysqli_query($conn, "DELETE FROM bobot_kepatuhan_per_parameter WHERE id_bobot='$id'");



mysqli_query($conn, "DELETE FROM bobot_likuiditas_per_pilar WHERE id_bobot='$id'");


mysqli_query($conn, "DELETE FROM bobot_likuiditas_per_parameter WHERE id_bobot='$id'");



mysqli_query($conn, "DELETE FROM bobot_reputasi_per_pilar WHERE id_bobot='$id'");


mysqli_query($conn, "DELETE FROM bobot_reputasi_per_parameter WHERE id_bobot='$id'");



mysqli_query($conn, "DELETE FROM bobot_stratejik_per_pilar WHERE id_bobot='$id'");


mysqli_query($conn, "DELETE FROM bobot_stratejik_per_parameter WHERE id_bobot='$id'");




echo "<script>window.location.href='index.php?page=bobot';</script>'";
exit;
