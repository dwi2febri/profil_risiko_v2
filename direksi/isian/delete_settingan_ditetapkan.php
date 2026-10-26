<?php
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM frame_setting_risiko_ditetapkan WHERE id_frame_setris_ditetapkan='$id'");




mysqli_query($conn, "DELETE FROM setting_risiko_inheren_kredit WHERE id_frame_setris_ditetapkan='$id'");


mysqli_query($conn, "DELETE FROM setting_risiko_kpmr_kredit WHERE id_frame_setris_ditetapkan='$id'");



mysqli_query($conn, "DELETE FROM setting_risiko_inheren_operasional WHERE id_frame_setris_ditetapkan='$id'");


mysqli_query($conn, "DELETE FROM setting_risiko_kpmr_operasional WHERE id_frame_setris_ditetapkan='$id'");



mysqli_query($conn, "DELETE FROM setting_risiko_inheren_kepatuhan WHERE id_frame_setris_ditetapkan='$id'");


mysqli_query($conn, "DELETE FROM setting_risiko_kpmr_kepatuhan WHERE id_frame_setris_ditetapkan='$id'");



mysqli_query($conn, "DELETE FROM setting_risiko_inheren_likuiditas WHERE id_frame_setris_ditetapkan='$id'");


mysqli_query($conn, "DELETE FROM setting_risiko_kpmr_likuiditas WHERE id_frame_setris_ditetapkan='$id'");



mysqli_query($conn, "DELETE FROM setting_risiko_inheren_reputasi WHERE id_frame_setris_ditetapkan='$id'");


mysqli_query($conn, "DELETE FROM setting_risiko_kpmr_reputasi WHERE id_frame_setris_ditetapkan='$id'");



mysqli_query($conn, "DELETE FROM setting_risiko_inheren_stratejik WHERE id_frame_setris_ditetapkan='$id'");


mysqli_query($conn, "DELETE FROM setting_risiko_kpmr_stratejik WHERE id_frame_setris_ditetapkan='$id'");




echo "<script>window.location.href='index.php?page=setris';</script>'";
exit;
