<?php
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM frame_laporan_profil_risiko WHERE id_profil_risiko='$id'");

//kre
mysqli_query($conn, "DELETE FROM master_kredit_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM master_kredit_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM master_kredit_pilar3 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM kpmr_kredit_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_kredit_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_kredit_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_kredit_pilar4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM hasil_kpmr_kredit WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM inheren_kredit_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_kredit_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_kredit_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_kredit_pilar4 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_kredit_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM hasil_inheren_kredit WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM respon_unit_kerja_kredit_pil1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_kredit_pil2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_kredit_pil3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_kredit_pil4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM keterangan_kpmr2_kredit WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_inheren_kredit WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_profil_kredit WHERE id_profil_risiko='$id'");


//lik
mysqli_query($conn, "DELETE FROM master_likuiditas_pilar1 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM kpmr_likuiditas_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_likuiditas_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_likuiditas_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_likuiditas_pilar4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_likuiditas_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM respon_unit_kerja_likuiditas_pil1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_likuiditas_pil2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_likuiditas_pil3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_likuiditas_pil4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM hasil_inheren_likuiditas WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM hasil_kpmr_likuiditas WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_kpmr2_likuiditas WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_inheren_likuiditas WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_profil_likuiditas WHERE id_profil_risiko='$id'");


//op
mysqli_query($conn, "DELETE FROM inheren_operasional_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_operasional_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_operasional_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_operasional_pilar4 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren5_operasional_pilar WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_operasional_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM ket_inheren_operasional_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_operasional_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_operasional_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_operasional_pilar4 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_operasional_pilar5 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_operasional_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM kpmr_operasional_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_operasional_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_operasional_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_operasional_pilar4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM respon_unit_kerja_operasional_pil1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_operasional_pil2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_operasional_pil3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_operasional_pil4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM hasil_inheren_operasional WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM hasil_kpmr_operasional WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_inheren2_operasional WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_kpmr2_operasional WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_profil_operasional WHERE id_profil_risiko='$id'");

//kep
mysqli_query($conn, "DELETE FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM ket_inheren_kepatuhan_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_kepatuhan_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_kepatuhan_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM kpmr_kepatuhan_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_kepatuhan_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_kepatuhan_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_kepatuhan_pilar4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM respon_unit_kerja_kepatuhan_pil1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_kepatuhan_pil2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_kepatuhan_pil3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_kepatuhan_pil4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM hasil_inheren_kepatuhan WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_inheren2_kepatuhan WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_kpmr2_kepatuhan WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_profil_kepatuhan WHERE id_profil_risiko='$id'");



//rep
mysqli_query($conn, "DELETE FROM inheren_reputasi_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_reputasi_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_reputasi_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM ket_inheren_reputasi_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_reputasi_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_reputasi_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM kpmr_reputasi_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_reputasi_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_reputasi_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_reputasi_pilar4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM respon_unit_kerja_reputasi_pil1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_reputasi_pil2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_reputasi_pil3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_reputasi_pil4 WHERE id_profil_risiko='$id'");


mysqli_query($conn, "DELETE FROM hasil_inheren_reputasi WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM hasil_kpmr_reputasi WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_inheren2_reputasi WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_kpmr2_reputasi WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_profil_reputasi WHERE id_profil_risiko='$id'");




//stra
mysqli_query($conn, "DELETE FROM inheren_stratejik_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_stratejik_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_stratejik_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM inheren_stratejik_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM ket_inheren_stratejik_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_stratejik_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM ket_inheren_stratejik_lainnya WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM kpmr_stratejik_pilar1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_stratejik_pilar2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_stratejik_pilar3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM kpmr_stratejik_pilar4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM respon_unit_kerja_stratejik_pil1 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_stratejik_pil2 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_stratejik_pil3 WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM respon_unit_kerja_stratejik_pil4 WHERE id_profil_risiko='$id'");

mysqli_query($conn, "DELETE FROM hasil_inheren_stratejik WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM hasil_kpmr_stratejik WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_inheren2_stratejik WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_kpmr2_stratejik WHERE id_profil_risiko='$id'");
mysqli_query($conn, "DELETE FROM keterangan_profil_stratejik WHERE id_profil_risiko='$id'");

echo "<script>window.location.href='index.php?page=menulapawal';</script>'";
exit;
