

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);


$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(47, 47, 47, 47));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket6['inheren_reputasi'], $inheren6['hasil_peringkat'], $pembanding_ket6['inheren_reputasi'], $pembanding_inheren6['hasil_peringkat']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Risiko Inheren',$ket6['ket_profil_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
