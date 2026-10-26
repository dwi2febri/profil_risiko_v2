<?=




//kpmr reputasi
$kpmr_reputasi_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar1 WHERE id_profil_risiko ='$id'"));
$krep_pilar1 = $kpmr_reputasi_pilar1['jumlah'];


$kpmr_reputasi_pilar2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar2 WHERE id_profil_risiko ='$id'"));
$krep_pilar2 = $kpmr_reputasi_pilar2['jumlah'];

$kpmr_reputasi_pilar3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar3 WHERE id_profil_risiko ='$id'"));
$krep_pilar3 = $kpmr_reputasi_pilar3['jumlah'];

$kpmr_reputasi_pilar4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar4 WHERE id_profil_risiko ='$id'"));
$krep_pilar4 = $kpmr_reputasi_pilar4['jumlah'];

$respon_unit_kerja_reputasi_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil1 WHERE id_profil_risiko ='$id'"));
$krep_ru1 = $respon_unit_kerja_reputasi_pil1['jumlah'];

$respon_unit_kerja_reputasi_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil2 WHERE id_profil_risiko ='$id'"));
$krep_ru2 = $respon_unit_kerja_reputasi_pil2['jumlah'];

$respon_unit_kerja_reputasi_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil3 WHERE id_profil_risiko ='$id'"));
$krep_ru3 = $respon_unit_kerja_reputasi_pil3['jumlah'];

$respon_unit_kerja_reputasi_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil4 WHERE id_profil_risiko ='$id'"));
$krep_ru4 = $respon_unit_kerja_reputasi_pil4['jumlah'];

$keterangan_kpmr2_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_reputasi WHERE id_profil_risiko ='$id'"));
$krep_ket = $keterangan_kpmr2_reputasi['jumlah'];

$kpmr_reputasi = round((($krep_pilar1 + $krep_pilar2 + $krep_pilar3 + $krep_pilar4 + $krep_ru1 + $krep_ru2 + $krep_ru3 + $krep_ru4 + $krep_ket) / 170) * 100);



