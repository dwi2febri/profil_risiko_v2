<?php
$uploadType = 'likuiditas';
$redirectPage = 'maslik';
$targetTables = ['master_likuiditas_pilar1'];
$templateFields = [
    'aset_likuid', 'kas', 'giro_aba', 'tabungan_aba', 'total_aset', 'kewajiban_lancar', 'kewajiban_segera', 'tabungan', 'deposito', 'pendanaan_jangka_pendek', 'kewajiban_jangka_pendek', 'deposito_1bln', 'deposito_3bln', 'deposito_6bln', 'deposito_12bln', 'pendanaan_non_inti', 'dpk_lbh_2m', 'deposito_diatas_cr', 'deposito_diatas_lps', 'korporasi', 'dpk_des_thn_sebelum', 'alat_likuid', 'penempatan_pd_bank_lain', 'modal_disetor', 'kredit_des_thn_sebelum', 'pinjaman', 'kredit_kolek_lancar', 'pertumbuhan_kredit', 'dpk_dijamin_lps', 'simpanan_tdk_dijamin_lps', 'total_dpk', 'dpk_tdk_dijamin_lps', 'deposan_tabungan_terbesar25', 'besar_deposan25', 'besar_penabung25', 'deposito_rs', 'arus_kas_netto', 'kas_besar_debet', 'kas_besar_kredit', 'deposito_inti', 'sisa_jangka_waktu_deposito', 'kredit_l_dp'
];
require __DIR__ . '/upload_csv_handler.php';
