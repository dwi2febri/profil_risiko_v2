<?php



//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO STRATEJIK)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN STRATEJIK');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Penetapan Strategi Bisnis'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Penetapan Strategi Bisnis',  $pil_stra1['hasil_pil1_par1'],  $ket_pil_stra1['ket_in_stra_pil1_1'].$ket_pil_stra1['ket_in_stra_pil1_1a'].$ket_pil_stra1['ket_in_stra_pil1_1b'].$ket_pil_stra1['ket_in_stra_pil1_1c'].$ket_pil_stra1['ket_in_stra_pil1_1d'].$ket_pil_stra1['ket_in_stra_pil1_1e'].$ket_pil_stra1['ket_in_stra_pil1_1f']));
$pdf->Row(array('','Penetapan Strategi Bisnis',  $pil_stra1['pilar1_1'], ''));
$pdf->Row(array('','Evaluasi Posisi Kompetitif di industri',  $pil_stra1['pilar1_1a'],  ''));
$pdf->Row(array('','Analisa Faktor Eksternal',  $pil_stra1['pilar1_1b'],  ''));
$pdf->Row(array('','Rencana Keberlangsungan Manajerial',  $pil_stra1['pilar1_1c'],  ''));
$pdf->Row(array('','Kecukupan Sumber Daya',  $pil_stra1['pilar1_1d'],  ''));
$pdf->Row(array('','Analisa Beban Kerja pada Seluruh Unit Kerja dalam mencapai target',  $pil_stra1['pilar1_1e'],  ''));
$pdf->Row(array('','Analisa Potensi Pasar',  $pil_stra1['pilar1_1f'],  ''));


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Penetapan Strategi Bisnis',$hasil6['pil1_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Penyusunan Rencana Bisnis'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis',  $pil_stra2['hasil_pil2_par1'],  $ket_pil_stra2['ket_in_stra_pil2_1'].$ket_pil_stra2['ket_in_stra_pil2_1a'].$ket_pil_stra2['ket_in_stra_pil2_1b'].$ket_pil_stra2['ket_in_stra_pil2_1c'].$ket_pil_stra2['ket_in_stra_pil2_1d'].$ket_pil_stra2['ket_in_stra_pil2_1e'].$ket_pil_stra2['ket_in_stra_pil2_1f'].$ket_pil_stra2['ket_in_stra_pil2_1g'].$ket_pil_stra2['ket_in_stra_pil2_1h'].$ket_pil_stra2['ket_in_stra_pil2_1i']));
$pdf->Row(array('','Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis',  $pil_stra2['pilar2_1'],  ''));
$pdf->Row(array('','Perubahan Lingkungan Bisnis',  $pil_stra2['pilar2_1a'],  ''));
$pdf->Row(array('','Perkembangan Teknologi',  $pil_stra2['pilar2_1b'],  ''));
$pdf->Row(array('','Struktur Organisasi dan SDM',  $pil_stra2['pilar2_1c'],  ''));
$pdf->Row(array('','Pengendalian Internal',  $pil_stra2['pilar2_1d'],  ''));
$pdf->Row(array('','Analisa Produk Eksisting',  $pil_stra2['pilar2_1e'],  ''));
$pdf->Row(array('','Analisa Layanan Eksisting',  $pil_stra2['pilar2_1f'],  ''));
$pdf->Row(array('','Analisa Produk dan Layanan Baru',  $pil_stra2['pilar2_1g'],  ''));
$pdf->Row(array('','Identifikasi Perubahan Lingkungan Bisnis',  $pil_stra2['pilar2_1h'],  ''));
$pdf->Row(array('','Kesesuaian Kebijakan yang Ditetapkan dengan Implementasi Kebijakan Terhadap Rencana Bisnis',  $pil_stra2['pilar2_1i'],  ''));


$pdf->Row(array('2','Keunggulan kompetitif BPR dan ancaman dari kompetitor',  $pil_stra2['hasil_pil2_par2'],  $ket_pil_stra2['ket_in_stra_pil2_2'].$ket_pil_stra2['ket_in_stra_pil2_2a'].$ket_pil_stra2['ket_in_stra_pil2_2b'].$ket_pil_stra2['ket_in_stra_pil2_2c']));
$pdf->Row(array('','Keunggulan kompetitif BPR dan ancaman dari kompetitor',  $pil_stra2['pilar2_2'],  ''));
$pdf->Row(array('','Kondisi persaingan / kompetitor',  $pil_stra2['pilar2_2a'],  ''));
$pdf->Row(array('','Preferensi Nasabah',  $pil_stra2['pilar2_2b'],  ''));
$pdf->Row(array('','Analisa Indikator Utama Posisi Bisnis Peer Group',  $pil_stra2['pilar2_2c'],  ''));


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Penyusunan Rencana Bisnis',$hasil6['pil2_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil2']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Pencapaian Target Bisnis'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan rencana bisnis bpr, khususnya untuk faktor permodalan, kualitas aset, kredit, likuiditas, penyaluran kredit kepada umkm, dan rentabilitas',  $pil_stra3['hasil_pil3_par1'],  $ket_pil_stra3['ket_in_stra_pil3_1'].$ket_pil_stra3['ket_in_stra_pil3_1a'].$ket_pil_stra3['ket_in_stra_pil3_1b'].$ket_pil_stra3['ket_in_stra_pil3_1c'].$ket_pil_stra3['ket_in_stra_pil3_1d'].$ket_pil_stra3['ket_in_stra_pil3_1e'].$ket_pil_stra3['ket_in_stra_pil3_1f'].$ket_pil_stra3['ket_in_stra_pil3_1g'].$ket_pil_stra3['ket_in_stra_pil3_1h'].$ket_pil_stra3['ket_in_stra_pil3_1i'].$ket_pil_stra3['ket_in_stra_pil3_1j'].$ket_pil_stra3['ket_in_stra_pil3_1k'].$ket_pil_stra3['ket_in_stra_pil3_1l'].$ket_pil_stra3['ket_in_stra_pil3_1m'].$ket_pil_stra3['ket_in_stra_pil3_1n'].$ket_pil_stra3['ket_in_stra_pil3_1o'].$ket_pil_stra3['ket_in_stra_pil3_1p']));
$pdf->Row(array('','Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan rencana bisnis bpr, khususnya untuk faktor permodalan, kualitas aset, kredit, likuiditas, penyaluran kredit kepada umkm, dan rentabilitas',  $pil_stra3['pilar3_1'],  ''));
$pdf->Row(array('','Capaian target kuantitatif terhadap 6 parameter kuantitaif',  $pil_stra3['pilar3_1a'],  ''));
$pdf->Row(array('','Modal Inti',  $pil_stra3['pilar3_1b'],  ''));
$pdf->Row(array('','Saldo Kredit Bermasalah',  $pil_stra3['pilar3_1c'],  ''));
$pdf->Row(array('','Laba Sebelum Pajak',  $pil_stra3['pilar3_1d'],  ''));
$pdf->Row(array('','NIM',  $pil_stra3['pilar3_1e'],  ''));
$pdf->Row(array('','Komposisi Tabungan Terhadap Dana Pihak Ketiga',  $pil_stra3['pilar3_1f'],  ''));
$pdf->Row(array('','Komposisi Deposito Terhadap Dana Pihak Ketiga',  $pil_stra3['pilar3_1g'],  ''));
$pdf->Row(array('','Komposisi Pendapatan Bunga Kontraktual Terhadap Aset Produktif',  $pil_stra3['pilar3_1h'],  ''));
$pdf->Row(array('','Komposisi Pendapatan Bunga Kontraktual Terhadap Pendapatan',  $pil_stra3['pilar3_1i'],  ''));
$pdf->Row(array('','Komposisi Biaya Tenaga Kerja terhadap Beban Operasional',  $pil_stra3['pilar3_1j'],  ''));
$pdf->Row(array('','Trend Pertumbuhan Aset',  $pil_stra3['pilar3_1k'],  ''));
$pdf->Row(array('','Trend Pertumbuhan Kredit',  $pil_stra3['pilar3_1l'],  ''));
$pdf->Row(array('','Trend Pertumbuhan Dana',  $pil_stra3['pilar3_1m'],  ''));
$pdf->Row(array('','Trend Pertumbuhan Laba',  $pil_stra3['pilar3_1n'],  ''));
$pdf->Row(array('','Pertumbuhan Penyaluran pada Sektor Usaha Produktif',  $pil_stra3['pilar3_1o'],  ''));
$pdf->Row(array('','Penerimaan Hapus Buku',  $pil_stra3['pilar3_1p'],  ''));


$pdf->Row(array('2','Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan strategis terkait dengan faktor pengembangan produk/jasa baru, perubahan sasaran bisnis, investasi strategis, rencana penggabungan, peleburan, dan pengambilalihan, serta pencapaian target bisnis',  $pil_stra3['hasil_pil3_par2'],  $ket_pil_stra3['ket_in_stra_pil3_2'].$ket_pil_stra3['ket_in_stra_pil3_2a'].$ket_pil_stra3['ket_in_stra_pil3_2b'].$ket_pil_stra3['ket_in_stra_pil3_2c'].$ket_pil_stra3['ket_in_stra_pil3_2d'].$ket_pil_stra3['ket_in_stra_pil3_2e'].$ket_pil_stra3['ket_in_stra_pil3_2f']));
$pdf->Row(array('','Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan strategis terkait dengan faktor pengembangan produk/jasa baru, perubahan sasaran bisnis, investasi strategis, rencana penggabungan, peleburan, dan pengambilalihan, serta pencapaian target bisnis',  $pil_stra3['pilar3_2'],  ''));
$pdf->Row(array('','Capaian target kualitatif',  $pil_stra3['pilar3_2a'],  ''));
$pdf->Row(array('','Realisasi Pemenuhan Jumlah SDM Terhadap Target RBB',  $pil_stra3['pilar3_2b'],  ''));
$pdf->Row(array('','Realisasi Waktu Pemenuhan SDM',  $pil_stra3['pilar3_2c'],  ''));
$pdf->Row(array('','Realisasi Modul Pelatihan dan Pendidikan Terhadap Target',  $pil_stra3['pilar3_2d'],  ''));
$pdf->Row(array('','Realisasi Pelaksanaan Kegiatan Usaha Baru Terhadap Target',  $pil_stra3['pilar3_2e'],  ''));
$pdf->Row(array('','Realisasi Pemindahan Jaringan Kantor',  $pil_stra3['pilar3_2f'],  ''));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Pencapaian Target Bisnis',$hasil6['pil3_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : LAINNYA'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_stra4['hasil_pil4_par1'], $ket_pil_stra4['ket_in_stra_pil4_1a'].$ket_pil_stra4['ket_in_stra_pil4_1b'].$ket_pil_stra4['ket_in_stra_pil4_1c'].$ket_pil_stra4['ket_in_stra_pil4_1d']));
$pdf->Row(array('','Evaluasi Isu Stratejik Akibat Perubahan Lingkungan Bisnis',  $pil_stra4['pilar4_1a'],  ''));
$pdf->Row(array('','Evaluasi Pelaksanaan Tugas Core dan Supporting RTU',  $pil_stra4['pilar4_1b'],  ''));
$pdf->Row(array('','Evaluasi Capaian Target RBB',  $pil_stra4['pilar4_1c'],  ''));
$pdf->Row(array('','Evaluasi Penyusunan dan Penerapan Rencana Kontinjensi',  $pil_stra4['pilar4_1d'],  ''));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Lainnya',$hasil6['pil4_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil4']));













//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN stratejik', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Penetapan Strategi Bisnis',$hasil6['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Penyusunan Rencana Bisnis',$hasil6['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Pencapaian Target Bisnis',$hasil6['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Lainnya',$hasil6['pil4_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil6['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil6['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN STRATEJIK', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_stratejik['ket_inheren']));






