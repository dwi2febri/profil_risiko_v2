
<?php




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR STRATEJIK');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko stratejik yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_stratejik1['pil1_total1'],  $ru_stra1['respon_pil1_1a'].$ru_stra1['respon_pil1_1b'].$ru_stra1['respon_pil1_1c'].$ru_stra1['respon_pil1_1d'].$ru_stra1['respon_pil1_1e']));


$pdf->Row(array('','Apakah ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP stratejik, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_stratejik1['pilar1_1a'], ''));
$pdf->Row(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Dewan Komisaris telah dilakukan (Ketentuan stratejik yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_stratejik1['pilar1_1b'],  ''));
$pdf->Row(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko stratejik dalam menjalankan tugas dan fungsinya',  $kpmr_stratejik1['pilar1_1c'],  ''));
$pdf->Row(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko stratejik sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_stratejik1['pilar1_1d'],  ''));
$pdf->Row(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_stratejik1['pilar1_1e'],  ''));

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko stratejik secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_stratejik1['pil1_total2'],  $ru_stra1['respon_pil1_2a'].$ru_stra1['respon_pil1_2b'].$ru_stra1['respon_pil1_2c'].$ru_stra1['respon_pil1_2d'].$ru_stra1['respon_pil1_2e']));
$pdf->Row(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko stratejik secara tertulis dan dalam foru_stram rapat (terdapat notulen)',  $kpmr_stratejik1['pilar1_2a'], ''));
$pdf->Row(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko stratejik kepada Direksi secara tertulis dan foru_stram rapat',  $kpmr_stratejik1['pilar1_2b'],  ''));
$pdf->Row(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko stratejik',  $kpmr_stratejik1['pilar1_2c'],  ''));
$pdf->Row(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko stratejik',  $kpmr_stratejik1['pilar1_2d'],  ''));
$pdf->Row(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_stratejik1['pilar1_2e'],  ''));

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko stratejik, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_stratejik1['pil1_total3'],  $ru_stra1['respon_pil1_3a'].$ru_stra1['respon_pil1_3b'].$ru_stra1['respon_pil1_3c']));
$pdf->Row(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko stratejik (Pelatihan tentang manajemen risiko stratejik yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko stratejik)',  $kpmr_stratejik1['pilar1_3a'], ''));
$pdf->Row(array('','Ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Direksi apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP Perstratejikan, SE Direksi, SK BWMK)',  $kpmr_stratejik1['pilar1_3b'],  ''));
$pdf->Row(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Direksi dilakukan (Ketentuan stratejik yang diterbitkan selama periode penilaian)',  $kpmr_stratejik1['pilar1_3c'],  ''));

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko stratejik, dan melakukan komunikasi kebijakan Manajemen Risiko stratejik terhadap seluruh jenjang organisasi BPR?',  $kpmr_stratejik1['pil1_total4'],  $ru_stra1['respon_pil1_4a'].$ru_stra1['respon_pil1_4b'].$ru_stra1['respon_pil1_4c'].$ru_stra1['respon_pil1_4d'].$ru_stra1['respon_pil1_4e']));
$pdf->Row(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko stratejik',  $kpmr_stratejik1['pilar1_4a'], ''));
$pdf->Row(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluru_strah unit kerja',  $kpmr_stratejik1['pilar1_4b'],  ''));
$pdf->Row(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko stratejik kepada seluru_strah unit kerja',  $kpmr_stratejik1['pilar1_4c'],  ''));
$pdf->Row(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_stratejik1['pilar1_4d'],  ''));
$pdf->Row(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_stratejik1['pilar1_4e'],  ''));


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi stratejik dan fungsi Manajemen Risiko stratejik?',  $kpmr_stratejik1['pil1_total5'],  $ru_stra1['respon_pil1_5a'].$ru_stra1['respon_pil1_5b'].$ru_stra1['respon_pil1_5c'].$ru_stra1['respon_pil1_5d']));
$pdf->Row(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja perstratejik dan melaksanakan tugasnya secara independen',  $kpmr_stratejik1['pilar1_5a'], ''));
$pdf->Row(array('','Apakah kecukupan organisasi di unit kerja stratejik telah didukung dengan kompetensi yang baik',  $kpmr_stratejik1['pilar1_5b'],  ''));
$pdf->Row(array('','Apakah kecukupan organisasi di satuan manajemen risiko stratejik telah didukung dengan kompetensi yang baik',  $kpmr_stratejik1['pilar1_5c'],  ''));
$pdf->Row(array('','Apakah proses perstratejik dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_stratejik1['pilar1_5d'],  ''));


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko stratejik?',  $kpmr_stratejik1['pil1_total6'],  $ru_stra1['respon_pil1_6a'].$ru_stra1['respon_pil1_6b'].$ru_stra1['respon_pil1_6c']));
$pdf->Row(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko stratejik, tidak terdapat perangkapan jabatan, independen',  $kpmr_stratejik1['pilar1_6a'], ''));
$pdf->Row(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_stratejik1['pilar1_6b'],  ''));
$pdf->Row(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang stratejik',  $kpmr_stratejik1['pilar1_6c'],  ''));



$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr6['pil1_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko stratejik yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_stratejik2['pil2_total1'],  $ru_stra2['respon_pil2_1a'].$ru_stra2['respon_pil2_1b'].$ru_stra2['respon_pil2_1c'].$ru_stra2['respon_pil2_1d'].$ru_stra2['respon_pil2_1e']));


$pdf->Row(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko stratejik',  $kpmr_stratejik2['pilar2_1a'], ''));
$pdf->Row(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko stratejik',  $kpmr_stratejik2['pilar2_1b'],  ''));
$pdf->Row(array('','Apakah kebijakan manajemen risiko stratejik dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_stratejik2['pilar2_1c'],  ''));
$pdf->Row(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko stratejik memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko stratejik, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_stratejik2['pilar2_1d'],  ''));
$pdf->Row(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_stratejik2['pilar2_1e'],  ''));


$pdf->Row(array('2','"Apakah BPR:
1. memiliki prosedur Manajemen Risiko stratejik dan penetapan limit Risiko stratejik yang ditetapkan oleh Direksi ?
2. melaksanakan prosedur Manajemen Risiko stratejik dan penetapan limit Risiko stratejik secara konsisten untuk seluruh aktivitas ? Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko stratejik dan penetapan limit Risiko stratejik secara berkala?"',  $kpmr_stratejik2['pil2_total2'],  $ru_stra2['respon_pil2_2a'].$ru_stra2['respon_pil2_2b'].$ru_stra2['respon_pil2_2c'].$ru_stra2['respon_pil2_2d'].$ru_stra2['respon_pil2_2e'].$ru_stra2['respon_pil2_2f'].$ru_stra2['respon_pil2_2g'].$ru_stra2['respon_pil2_2h']));


$pdf->Row(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko stratejik yang ditetapkan dalam SK Direksi',  $kpmr_stratejik2['pilar2_2a'], ''));
$pdf->Row(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko stratejik',  $kpmr_stratejik2['pilar2_2b'],  ''));
$pdf->Row(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_stratejik2['pilar2_2c'],  ''));
$pdf->Row(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko stratejik',  $kpmr_stratejik2['pilar2_2d'],  ''));
$pdf->Row(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_stratejik2['pilar2_2e'],  ''));
$pdf->Row(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi stratejik',  $kpmr_stratejik2['pilar2_2f'],  ''));
$pdf->Row(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_stratejik2['pilar2_2g'],  ''));
$pdf->Row(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_stratejik2['pilar2_2h'],  ''));
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko stratejik sesuai dengan ketentuan?',  $kpmr_stratejik2['pil2_total3'],  $ru_stra2['respon_pil2_3a'].$ru_stra2['respon_pil2_3b'].$ru_stra2['respon_pil2_3c']));


$pdf->Row(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_stratejik2['pilar2_3a'], ''));
$pdf->Row(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_stratejik2['pilar2_3b'],  ''));
$pdf->Row(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_stratejik2['pilar2_3c'],  ''));


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr6['pil2_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko stratejik yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko stratejik?',  $kpmr_stratejik3['pil3_total1'],  $ru_stra3['respon_pil3_1a'].$ru_stra3['respon_pil3_1b'].$ru_stra3['respon_pil3_1c'].$ru_stra3['respon_pil3_1d'].$ru_stra3['respon_pil3_1e'].$ru_stra3['respon_pil3_1f'].$ru_stra3['respon_pil3_1g'].$ru_stra3['respon_pil3_1h'].$ru_stra3['respon_pil3_1i'].$ru_stra3['respon_pil3_1j']));


$pdf->Row(array('','Apakah dalam aktvitas perstratejik seluruh SDM telah berpedoman pada penerapan manajemen risiko stratejik',  $kpmr_stratejik3['pilar3_1a'], ''));
$pdf->Row(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas stratejik',  $kpmr_stratejik3['pilar3_1b'],  ''));
$pdf->Row(array('','Apakah dalam proses perstratejik dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_stratejik3['pilar3_1c'],  ''));
$pdf->Row(array('','Apakah dalam proses pengambilan keputusan bidang perstratejikan dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_stratejik3['pilar3_1d'],  ''));
$pdf->Row(array('','Apakah dalam proses manajamen risiko stratejik telah didukung dengan data stratejik yang akurat dan informatif',  $kpmr_stratejik3['pilar3_1e'],  ''));
$pdf->Row(array('','Apakah dalam proses manajemen risiko stratejik telah melakukan analisa karakteristik risiko stratejik yang melekat pada produk dan layanan',  $kpmr_stratejik3['pilar3_1f'],  ''));
$pdf->Row(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko stratejik telah dilakukan evaluasi',  $kpmr_stratejik3['pilar3_1g'],  ''));
$pdf->Row(array('','Apakah dalam melakukan pengukuran risiko stratejik telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_stratejik3['pilar3_1h'],  ''));
$pdf->Row(array('','Apakah dalam melakukan pemantauan risiko stratejik telah dilakukan evaluasi terhadap eksposur risiko stratejik',  $kpmr_stratejik3['pilar3_1i'],  ''));
$pdf->Row(array('','Apabila terdapat perubahan yang material dalam faktor risiko stratejik apakah juga dilakukan penyesuaian pelaporan',  $kpmr_stratejik3['pilar3_1j'],  ''));


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko stratejik serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_stratejik3['pil3_total2'],  $ru_stra3['respon_pil3_2a'].$ru_stra3['respon_pil3_2b'].$ru_stra3['respon_pil3_2c'].$ru_stra3['respon_pil3_2d'].$ru_stra3['respon_pil3_2e']));


$pdf->Row(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_stratejik3['pilar3_2a'], ''));
$pdf->Row(array('','Apakah sistem informasi risiko stratejik dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_stratejik3['pilar3_2b'],  ''));
$pdf->Row(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko stratejik yang lengkap dan cepat',  $kpmr_stratejik3['pilar3_2c'],  ''));
$pdf->Row(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan stratejik terhadap kebijakan manajemen risiko stratejik (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_stratejik3['pilar3_2d'],  ''));
$pdf->Row(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_stratejik3['pilar3_2e'],  ''));



$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr6['pil3_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko stratejik, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_stratejik4['pil4_total1'],  $ru_stra4['respon_pil4_1a'].$ru_stra4['respon_pil4_1b'].$ru_stra4['respon_pil4_1c'].$ru_stra4['respon_pil4_1d'].$ru_stra4['respon_pil4_1e']));


$pdf->Row(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko stratejik di berapa cabang atau unit kerja di bidang manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1a'], ''));
$pdf->Row(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko stratejik telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_stratejik4['pilar4_1b'],  ''));
$pdf->Row(array('','Apakah SKAI dalam penerapan manajemen risiko stratejik telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk stratejik kebijakan manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1c'],  ''));
$pdf->Row(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1d'],  ''));
$pdf->Row(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1e'],  ''));


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko stratejik telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_stratejik4['pil4_total2'],  $ru_stra4['respon_pil4_2a'].$ru_stra4['respon_pil4_2b']));


$pdf->Row(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perstratejikan',  $kpmr_stratejik4['pilar4_2a'], ''));
$pdf->Row(array('','Apakah unit kerja stratejik telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_stratejik4['pilar4_2b'],  ''));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr6['pil4_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR STRATEJIK', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr6['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr6['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr6['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr6['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr6['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr6['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR STRATEJIK', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_stratejik['ket_kpmr']));




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI STRATEJIK');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();






$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket6['inheren_stratejik'], $ket6['kpmr_stratejik'], $ket6['tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_ket6['inheren_stratejik'], $pembanding_ket6['kpmr_stratejik'], $pembanding_ket6['tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
$pdf->Row(array($inheren6['hasil_peringkat'], $kpmr6['hasil_peringkat'], $ket6['peringkat_tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_inheren6['hasil_peringkat'], $pembanding_kpmr6['hasil_peringkat'], $pembanding_ket6['peringkat_tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
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


$pdf->Row(array('Tingkat Risiko',$ket6['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket6['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket6['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa






