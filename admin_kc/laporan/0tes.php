<?

$pdf->Cell(188, 5, 'Risiko reputasi', 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Row(array($ket5['inheren_reputasi'], $ket5['inheren_reputasi'], $ket5['tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_ket5['inheren_reputasi'], $pembanding_ket5['kpmr_reputasi'], $pembanding_ket5['tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
$pdf->Row(array($inheren5['hasil_peringkat'], $kpmr5['hasil_peringkat'], $ket5['peringkat_tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_inheren5['hasil_peringkat'], $pembanding_kpmr5['hasil_peringkat'], $pembanding_ket5['peringkat_tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa








