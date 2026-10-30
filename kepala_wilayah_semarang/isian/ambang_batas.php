<?php
$id = $_GET['idam'];
require dirname(__DIR__, 2).'/conn/conn.php';
$amkre = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ambang_batas_kredit WHERE id_ambang_batas_kredit = ?", [$id]));
$amlik = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ambang_batas_likuiditas WHERE id_ambang_batas_likuiditas = ?", [$id]));

if (isset($_POST['submit'])) {


    //AMbang kredit
    $ap_per_ta = $_POST['ap_per_ta'];
    $pbl_per_tap = $_POST['pbl_per_tap'];
    $apbt_per_pbl = $_POST['apbt_per_pbl'];
    $abapb_per_pbl = $_POST['abapb_per_pbl'];
    $kyd_per_ap = $_POST['kyd_per_ap'];
    $kspg_per_tk = $_POST['kspg_per_tk'];
    $km_per_tkyd = $_POST['km_per_tkyd'];
    $kjpen_per_tkyd = $_POST['kjpen_per_tkyd'];
    $kjm_per_tkyd = $_POST['kjm_per_tkyd'];
    $kjpan_per_tkyd = $_POST['kjpan_per_tkyd'];
    $nkp150_per_nkyd = $_POST['nkp150_per_nkyd'];
    $kdatdb_per_tkyd = $_POST['kdatdb_per_tkyd'];
    $kak_per_tkyd = $_POST['kak_per_tkyd'];
    $kakr2_per_tkyd = $_POST['kakr2_per_tkyd'];
    $opk_per_tkyd = $_POST['opk_per_tkyd'];
    $kta_per_tkyd = $_POST['kta_per_tkyd'];
    $kknp_per_tkyd = $_POST['kknp_per_tkyd'];
    $kpep_per_tkyd = $_POST['kpep_per_tkyd'];
    $kp350_per_tkyd = $_POST['kp350_per_tkyd'];
    $di25_per_tk = $_POST['di25_per_tk'];
    $kpse_per_tk = $_POST['kpse_per_tk'];
    $apb_per_tap = $_POST['apb_per_tap'];
    $sppap_per_tk = $_POST['sppap_per_tk'];
    $ayda_per_kyd = $_POST['ayda_per_kyd'];
    $kbn_per_tk = $_POST['kbn_per_tk'];
    $nkp150_per_tkp150 = $_POST['nkp150_per_tkp150'];
    $nkpd50_per_tkpd50 = $_POST['nkpd50_per_tkpd50'];
    $nkdpapht_prt_tkyd = $_POST['nkdpapht_prt_tkyd'];
    $nkdpskmht_per_tkyd = $_POST['nkdpskmht_per_tkyd'];
    $nalrdbd_per_tknalrdbd = $_POST['nalrdbd_per_tknalrdbd'];
    $kmsjt_per_tkyd = $_POST['kmsjt_per_tkyd'];
    $kkr_per_tk = $_POST['kkr_per_tk'];
    $kp4_per_tkyd = $_POST['kp4_per_tkyd'];
    $kdp3p4_per_tkyd = $_POST['kdp3p4_per_tkyd'];
    $nf6bt_per_ne6bt = $_POST['nf6bt_per_ne6bt'];
    $nomf6bt_per_pe6bt = $_POST['nomf6bt_per_pe6bt'];

    $rr_ap_per_ta = $_POST['rr_ap_per_ta'];
    $rr_pbl_per_tap = $_POST['rr_pbl_per_tap'];
    $rr_apbt_per_pbl = $_POST['rr_apbt_per_pbl'];
    $rr_abapb_per_pbl = $_POST['rr_abapb_per_pbl'];
    $rr_kyd_per_ap = $_POST['rr_kyd_per_ap'];
    $rr_kspg_per_tk = $_POST['rr_kspg_per_tk'];
    $rr_km_per_tkyd = $_POST['rr_km_per_tkyd'];
    $rr_kjpen_per_tkyd = $_POST['rr_kjpen_per_tkyd'];
    $rr_kjm_per_tkyd = $_POST['rr_kjm_per_tkyd'];
    $rr_kjpan_per_tkyd = $_POST['rr_kjpan_per_tkyd'];
    $rr_nkp150_per_nkyd = $_POST['rr_nkp150_per_nkyd'];
    $rr_kdatdb_per_tkyd = $_POST['rr_kdatdb_per_tkyd'];
    $rr_kak_per_tkyd = $_POST['rr_kak_per_tkyd'];
    $rr_kakr2_per_tkyd = $_POST['rr_kakr2_per_tkyd'];
    $rr_opk_per_tkyd = $_POST['rr_opk_per_tkyd'];
    $rr_kta_per_tkyd = $_POST['rr_kta_per_tkyd'];
    $rr_kknp_per_tkyd = $_POST['rr_kknp_per_tkyd'];
    $rr_kpep_per_tkyd = $_POST['rr_kpep_per_tkyd'];
    $rr_kp350_per_tkyd = $_POST['rr_kp350_per_tkyd'];
    $rr_di25_per_tk = $_POST['rr_di25_per_tk'];
    $rr_kpse_per_tk = $_POST['rr_kpse_per_tk'];
    $rr_apb_per_tap = $_POST['rr_apb_per_tap'];
    $rr_sppap_per_tk = $_POST['rr_sppap_per_tk'];
    $rr_ayda_per_kyd = $_POST['rr_ayda_per_kyd'];
    $rr_kbn_per_tk = $_POST['rr_kbn_per_tk'];
    $rr_nkp150_per_tkp150 = $_POST['rr_nkp150_per_tkp150'];
    $rr_nkpd50_per_tkpd50 = $_POST['rr_nkpd50_per_tkpd50'];
    $rr_nkdpapht_prt_tkyd = $_POST['rr_nkdpapht_prt_tkyd'];
    $rr_nkdpskmht_per_tkyd = $_POST['rr_nkdpskmht_per_tkyd'];
    $rr_nalrdbd_per_tknalrdbd = $_POST['rr_nalrdbd_per_tknalrdbd'];
    $rr_kmsjt_per_tkyd = $_POST['rr_kmsjt_per_tkyd'];
    $rr_kkr_per_tk = $_POST['rr_kkr_per_tk'];
    $rr_kp4_per_tkyd = $_POST['rr_kp4_per_tkyd'];
    $rr_kdp3p4_per_tkyd = $_POST['rr_kdp3p4_per_tkyd'];
    $rr_nf6bt_per_ne6bt = $_POST['rr_nf6bt_per_ne6bt'];
    $rr_nomf6bt_per_pe6bt = $_POST['rr_nomf6bt_per_pe6bt'];

    $rrr_ap_per_ta = $_POST['rrr_ap_per_ta'];
    $rrr_pbl_per_tap = $_POST['rrr_pbl_per_tap'];
    $rrr_apbt_per_pbl = $_POST['rrr_apbt_per_pbl'];
    $rrr_abapb_per_pbl = $_POST['rrr_abapb_per_pbl'];
    $rrr_kyd_per_ap = $_POST['rrr_kyd_per_ap'];
    $rrr_kspg_per_tk = $_POST['rrr_kspg_per_tk'];
    $rrr_km_per_tkyd = $_POST['rrr_km_per_tkyd'];
    $rrr_kjpen_per_tkyd = $_POST['rrr_kjpen_per_tkyd'];
    $rrr_kjm_per_tkyd = $_POST['rrr_kjm_per_tkyd'];
    $rrr_kjpan_per_tkyd = $_POST['rrr_kjpan_per_tkyd'];
    $rrr_nkp150_per_nkyd = $_POST['rrr_nkp150_per_nkyd'];
    $rrr_kdatdb_per_tkyd = $_POST['rrr_kdatdb_per_tkyd'];
    $rrr_kak_per_tkyd = $_POST['rrr_kak_per_tkyd'];
    $rrr_kakr2_per_tkyd = $_POST['rrr_kakr2_per_tkyd'];
    $rrr_opk_per_tkyd = $_POST['rrr_opk_per_tkyd'];
    $rrr_kta_per_tkyd = $_POST['rrr_kta_per_tkyd'];
    $rrr_kknp_per_tkyd = $_POST['rrr_kknp_per_tkyd'];
    $rrr_kpep_per_tkyd = $_POST['rrr_kpep_per_tkyd'];
    $rrr_kp350_per_tkyd = $_POST['rrr_kp350_per_tkyd'];
    $rrr_di25_per_tk = $_POST['rrr_di25_per_tk'];
    $rrr_kpse_per_tk = $_POST['rrr_kpse_per_tk'];
    $rrr_apb_per_tap = $_POST['rrr_apb_per_tap'];
    $rrr_sppap_per_tk = $_POST['rrr_sppap_per_tk'];
    $rrr_ayda_per_kyd = $_POST['rrr_ayda_per_kyd'];
    $rrr_kbn_per_tk = $_POST['rrr_kbn_per_tk'];
    $rrr_nkp150_per_tkp150 = $_POST['rrr_nkp150_per_tkp150'];
    $rrr_nkpd50_per_tkpd50 = $_POST['rrr_nkpd50_per_tkpd50'];
    $rrr_nkdpapht_prt_tkyd = $_POST['rrr_nkdpapht_prt_tkyd'];
    $rrr_nkdpskmht_per_tkyd = $_POST['rrr_nkdpskmht_per_tkyd'];
    $rrr_nalrdbd_per_tknalrdbd = $_POST['rrr_nalrdbd_per_tknalrdbd'];
    $rrr_kmsjt_per_tkyd = $_POST['rrr_kmsjt_per_tkyd'];
    $rrr_kkr_per_tk = $_POST['rrr_kkr_per_tk'];
    $rrr_kp4_per_tkyd = $_POST['rrr_kp4_per_tkyd'];
    $rrr_kdp3p4_per_tkyd = $_POST['rrr_kdp3p4_per_tkyd'];
    $rrr_nf6bt_per_ne6bt = $_POST['rrr_nf6bt_per_ne6bt'];
    $rrr_nomf6bt_per_pe6bt = $_POST['rrr_nomf6bt_per_pe6bt'];

    $rrrr_ap_per_ta = $_POST['rrrr_ap_per_ta'];
    $rrrr_pbl_per_tap = $_POST['rrrr_pbl_per_tap'];
    $rrrr_apbt_per_pbl = $_POST['rrrr_apbt_per_pbl'];
    $rrrr_abapb_per_pbl = $_POST['rrrr_abapb_per_pbl'];
    $rrrr_kyd_per_ap = $_POST['rrrr_kyd_per_ap'];
    $rrrr_kspg_per_tk = $_POST['rrrr_kspg_per_tk'];
    $rrrr_km_per_tkyd = $_POST['rrrr_km_per_tkyd'];
    $rrrr_kjpen_per_tkyd = $_POST['rrrr_kjpen_per_tkyd'];
    $rrrr_kjm_per_tkyd = $_POST['rrrr_kjm_per_tkyd'];
    $rrrr_kjpan_per_tkyd = $_POST['rrrr_kjpan_per_tkyd'];
    $rrrr_nkp150_per_nkyd = $_POST['rrrr_nkp150_per_nkyd'];
    $rrrr_kdatdb_per_tkyd = $_POST['rrrr_kdatdb_per_tkyd'];
    $rrrr_kak_per_tkyd = $_POST['rrrr_kak_per_tkyd'];
    $rrrr_kakr2_per_tkyd = $_POST['rrrr_kakr2_per_tkyd'];
    $rrrr_opk_per_tkyd = $_POST['rrrr_opk_per_tkyd'];
    $rrrr_kta_per_tkyd = $_POST['rrrr_kta_per_tkyd'];
    $rrrr_kknp_per_tkyd = $_POST['rrrr_kknp_per_tkyd'];
    $rrrr_kpep_per_tkyd = $_POST['rrrr_kpep_per_tkyd'];
    $rrrr_kp350_per_tkyd = $_POST['rrrr_kp350_per_tkyd'];
    $rrrr_di25_per_tk = $_POST['rrrr_di25_per_tk'];
    $rrrr_kpse_per_tk = $_POST['rrrr_kpse_per_tk'];
    $rrrr_apb_per_tap = $_POST['rrrr_apb_per_tap'];
    $rrrr_sppap_per_tk = $_POST['rrrr_sppap_per_tk'];
    $rrrr_ayda_per_kyd = $_POST['rrrr_ayda_per_kyd'];
    $rrrr_kbn_per_tk = $_POST['rrrr_kbn_per_tk'];
    $rrrr_nkp150_per_tkp150 = $_POST['rrrr_nkp150_per_tkp150'];
    $rrrr_nkpd50_per_tkpd50 = $_POST['rrrr_nkpd50_per_tkpd50'];
    $rrrr_nkdpapht_prt_tkyd = $_POST['rrrr_nkdpapht_prt_tkyd'];
    $rrrr_nkdpskmht_per_tkyd = $_POST['rrrr_nkdpskmht_per_tkyd'];
    $rrrr_nalrdbd_per_tknalrdbd = $_POST['rrrr_nalrdbd_per_tknalrdbd'];
    $rrrr_kmsjt_per_tkyd = $_POST['rrrr_kmsjt_per_tkyd'];
    $rrrr_kkr_per_tk = $_POST['rrrr_kkr_per_tk'];
    $rrrr_kp4_per_tkyd = $_POST['rrrr_kp4_per_tkyd'];
    $rrrr_kdp3p4_per_tkyd = $_POST['rrrr_kdp3p4_per_tkyd'];
    $rrrr_nf6bt_per_ne6bt = $_POST['rrrr_nf6bt_per_ne6bt'];
    $rrrr_nomf6bt_per_pe6bt = $_POST['rrrr_nomf6bt_per_pe6bt'];








    //Ambang Batas Likuiditas
    $al_per_ta = $_POST['al_per_ta'];
    $ta_al_per_td_al = $_POST['ta_al_per_td_al'];
    $al_per_kl = $_POST['al_per_kl'];
    $tal_per_pjp = $_POST['tal_per_pjp'];
    $al_per_kjp = $_POST['al_per_kjp'];
    $akn_per_tdpk = $_POST['akn_per_tdpk'];
    $tabungan_per_tdpk = $_POST['tabungan_per_tdpk'];
    $djw3bln_per_tdpk = $_POST['djw3bln_per_tdpk'];
    $djw6bln_per_tdpk = $_POST['djw6bln_per_tdpk'];
    $djw12bln_per_tdpk = $_POST['djw12bln_per_tdpk'];
    $md_per_tdpk = $_POST['md_per_tdpk'];
    $pin_per_tdpk = $_POST['pin_per_tdpk'];
    $kyd_per_tdpkbk = $_POST['kyd_per_tdpkbk'];
    $dpkydlps_per_dpk = $_POST['dpkydlps_per_dpk'];
    $alkl_per_dpk3 = $_POST['alkl_per_dpk3'];
    $dtsd6bln_per_al = $_POST['dtsd6bln_per_al'];
    $pk_per_ps = $_POST['pk_per_ps'];
    $ddpt25_per_tdpk = $_POST['ddpt25_per_tdpk'];
    $pni_per_tp = $_POST['pni_per_tp'];
    $pnial_per_taal = $_POST['pnial_per_taal'];
    $drs_per_al = $_POST['drs_per_al'];
    $al_per_pni = $_POST['al_per_pni'];
    $di_per_tdpk = $_POST['di_per_tdpk'];

    $rr_al_per_ta = $_POST['rr_al_per_ta'];
    $rr_ta_al_per_td_al = $_POST['rr_ta_al_per_td_al'];
    $rr_al_per_kl = $_POST['rr_al_per_kl'];
    $rr_tal_per_pjp = $_POST['rr_tal_per_pjp'];
    $rr_al_per_kjp = $_POST['rr_al_per_kjp'];
    $rr_akn_per_tdpk = $_POST['rr_akn_per_tdpk'];
    $rr_tabungan_per_tdpk = $_POST['rr_tabungan_per_tdpk'];
    $rr_djw3bln_per_tdpk = $_POST['rr_djw3bln_per_tdpk'];
    $rr_djw6bln_per_tdpk = $_POST['rr_djw6bln_per_tdpk'];
    $rr_djw12bln_per_tdpk = $_POST['rr_djw12bln_per_tdpk'];
    $rr_md_per_tdpk = $_POST['rr_md_per_tdpk'];
    $rr_pin_per_tdpk = $_POST['rr_pin_per_tdpk'];
    $rr_kyd_per_tdpkbk = $_POST['rr_kyd_per_tdpkbk'];
    $rr_dpkydlps_per_dpk = $_POST['rr_dpkydlps_per_dpk'];
    $rr_alkl_per_dpk3 = $_POST['rr_alkl_per_dpk3'];
    $rr_dtsd6bln_per_al = $_POST['rr_dtsd6bln_per_al'];
    $rr_pk_per_ps = $_POST['rr_pk_per_ps'];
    $rr_ddpt25_per_tdpk = $_POST['rr_ddpt25_per_tdpk'];
    $rr_pni_per_tp = $_POST['rr_pni_per_tp'];
    $rr_pnial_per_taal = $_POST['rr_pnial_per_taal'];
    $rr_drs_per_al = $_POST['rr_drs_per_al'];
    $rr_al_per_pni = $_POST['rr_al_per_pni'];
    $rr_di_per_tdpk = $_POST['rr_di_per_tdpk'];

    $rrr_al_per_ta = $_POST['rrr_al_per_ta'];
    $rrr_ta_al_per_td_al = $_POST['rrr_ta_al_per_td_al'];
    $rrr_al_per_kl = $_POST['rrr_al_per_kl'];
    $rrr_tal_per_pjp = $_POST['rrr_tal_per_pjp'];
    $rrr_al_per_kjp = $_POST['rrr_al_per_kjp'];
    $rrr_akn_per_tdpk = $_POST['rrr_akn_per_tdpk'];
    $rrr_tabungan_per_tdpk = $_POST['rrr_tabungan_per_tdpk'];
    $rrr_djw3bln_per_tdpk = $_POST['rrr_djw3bln_per_tdpk'];
    $rrr_djw6bln_per_tdpk = $_POST['rrr_djw6bln_per_tdpk'];
    $rrr_djw12bln_per_tdpk = $_POST['rrr_djw12bln_per_tdpk'];
    $rrr_md_per_tdpk = $_POST['rrr_md_per_tdpk'];
    $rrr_pin_per_tdpk = $_POST['rrr_pin_per_tdpk'];
    $rrr_kyd_per_tdpkbk = $_POST['rrr_kyd_per_tdpkbk'];
    $rrr_dpkydlps_per_dpk = $_POST['rrr_dpkydlps_per_dpk'];
    $rrr_alkl_per_dpk3 = $_POST['rrr_alkl_per_dpk3'];
    $rrr_dtsd6bln_per_al = $_POST['rrr_dtsd6bln_per_al'];
    $rrr_pk_per_ps = $_POST['rrr_pk_per_ps'];
    $rrr_ddpt25_per_tdpk = $_POST['rrr_ddpt25_per_tdpk'];
    $rrr_pni_per_tp = $_POST['rrr_pni_per_tp'];
    $rrr_pnial_per_taal = $_POST['rrr_pnial_per_taal'];
    $rrr_drs_per_al = $_POST['rrr_drs_per_al'];
    $rrr_al_per_pni = $_POST['rrr_al_per_pni'];
    $rrr_di_per_tdpk = $_POST['rrr_di_per_tdpk'];

    $rrrr_al_per_ta = $_POST['rrrr_al_per_ta'];
    $rrrr_ta_al_per_td_al = $_POST['rrrr_ta_al_per_td_al'];
    $rrrr_al_per_kl = $_POST['rrrr_al_per_kl'];
    $rrrr_tal_per_pjp = $_POST['rrrr_tal_per_pjp'];
    $rrrr_al_per_kjp = $_POST['rrrr_al_per_kjp'];
    $rrrr_akn_per_tdpk = $_POST['rrrr_akn_per_tdpk'];
    $rrrr_tabungan_per_tdpk = $_POST['rrrr_tabungan_per_tdpk'];
    $rrrr_djw3bln_per_tdpk = $_POST['rrrr_djw3bln_per_tdpk'];
    $rrrr_djw6bln_per_tdpk = $_POST['rrrr_djw6bln_per_tdpk'];
    $rrrr_djw12bln_per_tdpk = $_POST['rrrr_djw12bln_per_tdpk'];
    $rrrr_md_per_tdpk = $_POST['rrrr_md_per_tdpk'];
    $rrrr_pin_per_tdpk = $_POST['rrrr_pin_per_tdpk'];
    $rrrr_kyd_per_tdpkbk = $_POST['rrrr_kyd_per_tdpkbk'];
    $rrrr_dpkydlps_per_dpk = $_POST['rrrr_dpkydlps_per_dpk'];
    $rrrr_alkl_per_dpk3 = $_POST['rrrr_alkl_per_dpk3'];
    $rrrr_dtsd6bln_per_al = $_POST['rrrr_dtsd6bln_per_al'];
    $rrrr_pk_per_ps = $_POST['rrrr_pk_per_ps'];
    $rrrr_ddpt25_per_tdpk = $_POST['rrrr_ddpt25_per_tdpk'];
    $rrrr_pni_per_tp = $_POST['rrrr_pni_per_tp'];
    $rrrr_pnial_per_taal = $_POST['rrrr_pnial_per_taal'];
    $rrrr_drs_per_al = $_POST['rrrr_drs_per_al'];
    $rrrr_al_per_pni = $_POST['rrrr_al_per_pni'];
    $rrrr_di_per_tdpk = $_POST['rrrr_di_per_tdpk'];







    simpro_db_query($conn, "UPDATE ambang_batas_kredit SET 
    ap_per_ta = ?,
    pbl_per_tap = ?,
    apbt_per_pbl = ?,
    abapb_per_pbl = ?,
    kyd_per_ap = ?,
    kspg_per_tk = ?,
    km_per_tkyd = ?,
    kjpen_per_tkyd = ?,
    kjm_per_tkyd = ?,
    kjpan_per_tkyd = ?,
    nkp150_per_nkyd = ?,
    kdatdb_per_tkyd = ?,
    kak_per_tkyd = ?,
    kakr2_per_tkyd = ?,
    opk_per_tkyd = ?,
    kta_per_tkyd = ?,
    kknp_per_tkyd = ?,
    kpep_per_tkyd = ?,
    kp350_per_tkyd = ?,
    di25_per_tk = ?,
    kpse_per_tk = ?,
    apb_per_tap = ?,
    sppap_per_tk = ?,
    ayda_per_kyd = ?,
    kbn_per_tk = ?,
    nkp150_per_tkp150 = ?,
    nkpd50_per_tkpd50 = ?,
    nkdpapht_prt_tkyd = ?,
    nkdpskmht_per_tkyd = ?,
    nalrdbd_per_tknalrdbd = ?,
    kmsjt_per_tkyd = ?,
    kkr_per_tk = ?,
    kp4_per_tkyd = ?,
    kdp3p4_per_tkyd = ?,
    nf6bt_per_ne6bt = ?,
    nomf6bt_per_pe6bt = ?,
    rr_ap_per_ta = ?,
    rr_pbl_per_tap = ?,
    rr_apbt_per_pbl = ?,
    rr_abapb_per_pbl = ?,
    rr_kyd_per_ap = ?,
    rr_kspg_per_tk = ?,
    rr_km_per_tkyd = ?,
    rr_kjpen_per_tkyd = ?,
    rr_kjm_per_tkyd = ?,
    rr_kjpan_per_tkyd = ?,
    rr_nkp150_per_nkyd = ?,
    rr_kdatdb_per_tkyd = ?,
    rr_kak_per_tkyd = ?,
    rr_kakr2_per_tkyd = ?,
    rr_opk_per_tkyd = ?,
    rr_kta_per_tkyd = ?,
    rr_kknp_per_tkyd = ?,
    rr_kpep_per_tkyd = ?,
    rr_kp350_per_tkyd = ?,
    rr_di25_per_tk = ?,
    rr_kpse_per_tk = ?,
    rr_apb_per_tap = ?,
    rr_sppap_per_tk = ?,
    rr_ayda_per_kyd = ?,
    rr_kbn_per_tk = ?,
    rr_nkp150_per_tkp150 = ?,
    rr_nkpd50_per_tkpd50 = ?,
    rr_nkdpapht_prt_tkyd = ?,
    rr_nkdpskmht_per_tkyd = ?,
    rr_nalrdbd_per_tknalrdbd = ?,
    rr_kmsjt_per_tkyd = ?,
    rr_kkr_per_tk = ?,
    rr_kp4_per_tkyd = ?,
    rr_kdp3p4_per_tkyd = ?,
    rr_nf6bt_per_ne6bt = ?,
    rr_nomf6bt_per_pe6bt = ?,
    rrr_ap_per_ta = ?,
    rrr_pbl_per_tap = ?,
    rrr_apbt_per_pbl = ?,
    rrr_abapb_per_pbl = ?,
    rrr_kyd_per_ap = ?,
    rrr_kspg_per_tk = ?,
    rrr_km_per_tkyd = ?,
    rrr_kjpen_per_tkyd = ?,
    rrr_kjm_per_tkyd = ?,
    rrr_kjpan_per_tkyd = ?,
    rrr_nkp150_per_nkyd = ?,
    rrr_kdatdb_per_tkyd = ?,
    rrr_kak_per_tkyd = ?,
    rrr_kakr2_per_tkyd = ?,
    rrr_opk_per_tkyd = ?,
    rrr_kta_per_tkyd = ?,
    rrr_kknp_per_tkyd = ?,
    rrr_kpep_per_tkyd = ?,
    rrr_kp350_per_tkyd = ?,
    rrr_di25_per_tk = ?,
    rrr_kpse_per_tk = ?,
    rrr_apb_per_tap = ?,
    rrr_sppap_per_tk = ?,
    rrr_ayda_per_kyd = ?,
    rrr_kbn_per_tk = ?,
    rrr_nkp150_per_tkp150 = ?,
    rrr_nkpd50_per_tkpd50 = ?,
    rrr_nkdpapht_prt_tkyd = ?,
    rrr_nkdpskmht_per_tkyd = ?,
    rrr_nalrdbd_per_tknalrdbd = ?,
    rrr_kmsjt_per_tkyd = ?,
    rrr_kkr_per_tk = ?,
    rrr_kp4_per_tkyd = ?,
    rrr_kdp3p4_per_tkyd = ?,
    rrr_nf6bt_per_ne6bt = ?,
    rrr_nomf6bt_per_pe6bt = ?,
    rrrr_ap_per_ta = ?,
    rrrr_pbl_per_tap = ?,
    rrrr_apbt_per_pbl = ?,
    rrrr_abapb_per_pbl = ?,
    rrrr_kyd_per_ap = ?,
    rrrr_kspg_per_tk = ?,
    rrrr_km_per_tkyd = ?,
    rrrr_kjpen_per_tkyd = ?,
    rrrr_kjm_per_tkyd = ?,
    rrrr_kjpan_per_tkyd = ?,
    rrrr_nkp150_per_nkyd = ?,
    rrrr_kdatdb_per_tkyd = ?,
    rrrr_kak_per_tkyd = ?,
    rrrr_kakr2_per_tkyd = ?,
    rrrr_opk_per_tkyd = ?,
    rrrr_kta_per_tkyd = ?,
    rrrr_kknp_per_tkyd = ?,
    rrrr_kpep_per_tkyd = ?,
    rrrr_kp350_per_tkyd = ?,
    rrrr_di25_per_tk = ?,
    rrrr_kpse_per_tk = ?,
    rrrr_apb_per_tap = ?,
    rrrr_sppap_per_tk = ?,
    rrrr_ayda_per_kyd = ?,
    rrrr_kbn_per_tk = ?,
    rrrr_nkp150_per_tkp150 = ?,
    rrrr_nkpd50_per_tkpd50 = ?,
    rrrr_nkdpapht_prt_tkyd = ?,
    rrrr_nkdpskmht_per_tkyd = ?,
    rrrr_nalrdbd_per_tknalrdbd = ?,
    rrrr_kmsjt_per_tkyd = ?,
    rrrr_kkr_per_tk = ?,
    rrrr_kp4_per_tkyd = ?,
    rrrr_kdp3p4_per_tkyd = ?,
    rrrr_nf6bt_per_ne6bt = ?,
    rrrr_nomf6bt_per_pe6bt = ? WHERE id_ambang_batas_kredit = ?", [$ap_per_ta, $pbl_per_tap, $apbt_per_pbl, $abapb_per_pbl, $kyd_per_ap, $kspg_per_tk, $km_per_tkyd, $kjpen_per_tkyd, $kjm_per_tkyd, $kjpan_per_tkyd, $nkp150_per_nkyd, $kdatdb_per_tkyd, $kak_per_tkyd, $kakr2_per_tkyd, $opk_per_tkyd, $kta_per_tkyd, $kknp_per_tkyd, $kpep_per_tkyd, $kp350_per_tkyd, $di25_per_tk, $kpse_per_tk, $apb_per_tap, $sppap_per_tk, $ayda_per_kyd, $kbn_per_tk, $nkp150_per_tkp150, $nkpd50_per_tkpd50, $nkdpapht_prt_tkyd, $nkdpskmht_per_tkyd, $nalrdbd_per_tknalrdbd, $kmsjt_per_tkyd, $kkr_per_tk, $kp4_per_tkyd, $kdp3p4_per_tkyd, $nf6bt_per_ne6bt, $nomf6bt_per_pe6bt, $rr_ap_per_ta, $rr_pbl_per_tap, $rr_apbt_per_pbl, $rr_abapb_per_pbl, $rr_kyd_per_ap, $rr_kspg_per_tk, $rr_km_per_tkyd, $rr_kjpen_per_tkyd, $rr_kjm_per_tkyd, $rr_kjpan_per_tkyd, $rr_nkp150_per_nkyd, $rr_kdatdb_per_tkyd, $rr_kak_per_tkyd, $rr_kakr2_per_tkyd, $rr_opk_per_tkyd, $rr_kta_per_tkyd, $rr_kknp_per_tkyd, $rr_kpep_per_tkyd, $rr_kp350_per_tkyd, $rr_di25_per_tk, $rr_kpse_per_tk, $rr_apb_per_tap, $rr_sppap_per_tk, $rr_ayda_per_kyd, $rr_kbn_per_tk, $rr_nkp150_per_tkp150, $rr_nkpd50_per_tkpd50, $rr_nkdpapht_prt_tkyd, $rr_nkdpskmht_per_tkyd, $rr_nalrdbd_per_tknalrdbd, $rr_kmsjt_per_tkyd, $rr_kkr_per_tk, $rr_kp4_per_tkyd, $rr_kdp3p4_per_tkyd, $rr_nf6bt_per_ne6bt, $rr_nomf6bt_per_pe6bt, $rrr_ap_per_ta, $rrr_pbl_per_tap, $rrr_apbt_per_pbl, $rrr_abapb_per_pbl, $rrr_kyd_per_ap, $rrr_kspg_per_tk, $rrr_km_per_tkyd, $rrr_kjpen_per_tkyd, $rrr_kjm_per_tkyd, $rrr_kjpan_per_tkyd, $rrr_nkp150_per_nkyd, $rrr_kdatdb_per_tkyd, $rrr_kak_per_tkyd, $rrr_kakr2_per_tkyd, $rrr_opk_per_tkyd, $rrr_kta_per_tkyd, $rrr_kknp_per_tkyd, $rrr_kpep_per_tkyd, $rrr_kp350_per_tkyd, $rrr_di25_per_tk, $rrr_kpse_per_tk, $rrr_apb_per_tap, $rrr_sppap_per_tk, $rrr_ayda_per_kyd, $rrr_kbn_per_tk, $rrr_nkp150_per_tkp150, $rrr_nkpd50_per_tkpd50, $rrr_nkdpapht_prt_tkyd, $rrr_nkdpskmht_per_tkyd, $rrr_nalrdbd_per_tknalrdbd, $rrr_kmsjt_per_tkyd, $rrr_kkr_per_tk, $rrr_kp4_per_tkyd, $rrr_kdp3p4_per_tkyd, $rrr_nf6bt_per_ne6bt, $rrr_nomf6bt_per_pe6bt, $rrrr_ap_per_ta, $rrrr_pbl_per_tap, $rrrr_apbt_per_pbl, $rrrr_abapb_per_pbl, $rrrr_kyd_per_ap, $rrrr_kspg_per_tk, $rrrr_km_per_tkyd, $rrrr_kjpen_per_tkyd, $rrrr_kjm_per_tkyd, $rrrr_kjpan_per_tkyd, $rrrr_nkp150_per_nkyd, $rrrr_kdatdb_per_tkyd, $rrrr_kak_per_tkyd, $rrrr_kakr2_per_tkyd, $rrrr_opk_per_tkyd, $rrrr_kta_per_tkyd, $rrrr_kknp_per_tkyd, $rrrr_kpep_per_tkyd, $rrrr_kp350_per_tkyd, $rrrr_di25_per_tk, $rrrr_kpse_per_tk, $rrrr_apb_per_tap, $rrrr_sppap_per_tk, $rrrr_ayda_per_kyd, $rrrr_kbn_per_tk, $rrrr_nkp150_per_tkp150, $rrrr_nkpd50_per_tkpd50, $rrrr_nkdpapht_prt_tkyd, $rrrr_nkdpskmht_per_tkyd, $rrrr_nalrdbd_per_tknalrdbd, $rrrr_kmsjt_per_tkyd, $rrrr_kkr_per_tk, $rrrr_kp4_per_tkyd, $rrrr_kdp3p4_per_tkyd, $rrrr_nf6bt_per_ne6bt, $rrrr_nomf6bt_per_pe6bt, $id]);





    simpro_db_query($conn, "UPDATE ambang_batas_likuiditas SET
    al_per_ta = ?,
    ta_al_per_td_al = ?,
    al_per_kl = ?,
    tal_per_pjp = ?,
    al_per_kjp = ?,
    akn_per_tdpk = ?,
    tabungan_per_tdpk = ?,
    djw3bln_per_tdpk = ?,
    djw6bln_per_tdpk = ?,
    djw12bln_per_tdpk = ?,
    md_per_tdpk = ?,
    pin_per_tdpk = ?,
    kyd_per_tdpkbk = ?,
    dpkydlps_per_dpk = ?,
    alkl_per_dpk3 = ?,
    dtsd6bln_per_al = ?,
    pk_per_ps = ?,
    ddpt25_per_tdpk = ?,
    pni_per_tp = ?,
    pnial_per_taal = ?,
    drs_per_al = ?,
    al_per_pni = ?,
    di_per_tdpk = ?,
    rr_al_per_ta = ?,
    rr_ta_al_per_td_al = ?,
    rr_al_per_kl = ?,
    rr_tal_per_pjp = ?,
    rr_al_per_kjp = ?,
    rr_akn_per_tdpk = ?,
    rr_tabungan_per_tdpk = ?,
    rr_djw3bln_per_tdpk = ?,
    rr_djw6bln_per_tdpk = ?,
    rr_djw12bln_per_tdpk = ?,
    rr_md_per_tdpk = ?,
    rr_pin_per_tdpk = ?,
    rr_kyd_per_tdpkbk = ?,
    rr_dpkydlps_per_dpk = ?,
    rr_alkl_per_dpk3 = ?,
    rr_dtsd6bln_per_al = ?,
    rr_pk_per_ps = ?,
    rr_ddpt25_per_tdpk = ?,
    rr_pni_per_tp = ?,
    rr_pnial_per_taal = ?,
    rr_drs_per_al = ?,
    rr_al_per_pni = ?,
    rr_di_per_tdpk = ?,
    rrr_al_per_ta = ?,
    rrr_ta_al_per_td_al = ?,
    rrr_al_per_kl = ?,
    rrr_tal_per_pjp = ?,
    rrr_al_per_kjp = ?,
    rrr_akn_per_tdpk = ?,
    rrr_tabungan_per_tdpk = ?,
    rrr_djw3bln_per_tdpk = ?,
    rrr_djw6bln_per_tdpk = ?,
    rrr_djw12bln_per_tdpk = ?,
    rrr_md_per_tdpk = ?,
    rrr_pin_per_tdpk = ?,
    rrr_kyd_per_tdpkbk = ?,
    rrr_dpkydlps_per_dpk = ?,
    rrr_alkl_per_dpk3 = ?,
    rrr_dtsd6bln_per_al = ?,
    rrr_pk_per_ps = ?,
    rrr_ddpt25_per_tdpk = ?,
    rrr_pni_per_tp = ?,
    rrr_pnial_per_taal = ?,
    rrr_drs_per_al = ?,
    rrr_al_per_pni = ?,
    rrr_di_per_tdpk = ?,
    rrrr_al_per_ta = ?,
    rrrr_ta_al_per_td_al = ?,
    rrrr_al_per_kl = ?,
    rrrr_tal_per_pjp = ?,
    rrrr_al_per_kjp = ?,
    rrrr_akn_per_tdpk = ?,
    rrrr_tabungan_per_tdpk = ?,
    rrrr_djw3bln_per_tdpk = ?,
    rrrr_djw6bln_per_tdpk = ?,
    rrrr_djw12bln_per_tdpk = ?,
    rrrr_md_per_tdpk = ?,
    rrrr_pin_per_tdpk = ?,
    rrrr_kyd_per_tdpkbk = ?,
    rrrr_dpkydlps_per_dpk = ?,
    rrrr_alkl_per_dpk3 = ?,
    rrrr_dtsd6bln_per_al = ?,
    rrrr_pk_per_ps = ?,
    rrrr_ddpt25_per_tdpk = ?,
    rrrr_pni_per_tp = ?,
    rrrr_pnial_per_taal = ?,
    rrrr_drs_per_al = ?,
    rrrr_al_per_pni = ?,
    rrrr_di_per_tdpk = ? WHERE id_ambang_batas_likuiditas = ?", [$al_per_ta, $ta_al_per_td_al, $al_per_kl, $tal_per_pjp, $al_per_kjp, $akn_per_tdpk, $tabungan_per_tdpk, $djw3bln_per_tdpk, $djw6bln_per_tdpk, $djw12bln_per_tdpk, $md_per_tdpk, $pin_per_tdpk, $kyd_per_tdpkbk, $dpkydlps_per_dpk, $alkl_per_dpk3, $dtsd6bln_per_al, $pk_per_ps, $ddpt25_per_tdpk, $pni_per_tp, $pnial_per_taal, $drs_per_al, $al_per_pni, $di_per_tdpk, $rr_al_per_ta, $rr_ta_al_per_td_al, $rr_al_per_kl, $rr_tal_per_pjp, $rr_al_per_kjp, $rr_akn_per_tdpk, $rr_tabungan_per_tdpk, $rr_djw3bln_per_tdpk, $rr_djw6bln_per_tdpk, $rr_djw12bln_per_tdpk, $rr_md_per_tdpk, $rr_pin_per_tdpk, $rr_kyd_per_tdpkbk, $rr_dpkydlps_per_dpk, $rr_alkl_per_dpk3, $rr_dtsd6bln_per_al, $rr_pk_per_ps, $rr_ddpt25_per_tdpk, $rr_pni_per_tp, $rr_pnial_per_taal, $rr_drs_per_al, $rr_al_per_pni, $rr_di_per_tdpk, $rrr_al_per_ta, $rrr_ta_al_per_td_al, $rrr_al_per_kl, $rrr_tal_per_pjp, $rrr_al_per_kjp, $rrr_akn_per_tdpk, $rrr_tabungan_per_tdpk, $rrr_djw3bln_per_tdpk, $rrr_djw6bln_per_tdpk, $rrr_djw12bln_per_tdpk, $rrr_md_per_tdpk, $rrr_pin_per_tdpk, $rrr_kyd_per_tdpkbk, $rrr_dpkydlps_per_dpk, $rrr_alkl_per_dpk3, $rrr_dtsd6bln_per_al, $rrr_pk_per_ps, $rrr_ddpt25_per_tdpk, $rrr_pni_per_tp, $rrr_pnial_per_taal, $rrr_drs_per_al, $rrr_al_per_pni, $rrr_di_per_tdpk, $rrrr_al_per_ta, $rrrr_ta_al_per_td_al, $rrrr_al_per_kl, $rrrr_tal_per_pjp, $rrrr_al_per_kjp, $rrrr_akn_per_tdpk, $rrrr_tabungan_per_tdpk, $rrrr_djw3bln_per_tdpk, $rrrr_djw6bln_per_tdpk, $rrrr_djw12bln_per_tdpk, $rrrr_md_per_tdpk, $rrrr_pin_per_tdpk, $rrrr_kyd_per_tdpkbk, $rrrr_dpkydlps_per_dpk, $rrrr_alkl_per_dpk3, $rrrr_dtsd6bln_per_al, $rrrr_pk_per_ps, $rrrr_ddpt25_per_tdpk, $rrrr_pni_per_tp, $rrrr_pnial_per_taal, $rrrr_drs_per_al, $rrrr_al_per_pni, $rrrr_di_per_tdpk, $id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=frame_ambang");
    exit();
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Tentukan Ambang Batas Kredit dan Likuiditas</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Penetapan Ambang Batas Kredit dan Likuiditas</h4>
                            <p class="text-muted font-13">
                                Isilah Form dibawah ini untuk menetapkan ambang batas kredit san likuiditas
                            </p>
                            <hr>
                            </hr>


                            <div class="row">
                                <div class="col-12">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-primary" form="my_form" type="submit" name="submit">Submit</button>
                                    </div>

                                </div>
                            </div>



                            <br></br>
                            <p class="text-muted font-13">
                                *Untuk angka decimal mohon untuk mengganti , menjadi . |contoh : (92,31) diganti dengan (92.31)
                            </p>


                            <!-- PILAR 1-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="8">
                                                <h3><b>KREDIT | PILAR 1 :KOMPOSISI DAN KONSENTRASI ASET DAN KEWAJIBAN</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class=" text-center">
                                                AMBANG BATAS
                                            </th>
                                            <th colspan="5">
                                                RUMUS 2 - 4
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>



                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Produktif / Total Aset</th>
                                            <td><input type="text" form="my_form" name="ap_per_ta" value="<?= $amkre['ap_per_ta'] ?>" class="form-control" id="ap_per_ta"></td>
                                            <td colspan="3"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">a. Penempatan Bank Lain / Total Aset Produktif</th>
                                            <td><input type="text" form="my_form" name="pbl_per_tap" value="<?= $amkre['pbl_per_tap'] ?>" class="form-control" id="pbl_per_tap"></td>
                                            <td><input type="text" form="my_form" name="rr_pbl_per_tap" value="<?= $amkre['rr_pbl_per_tap'] ?>" class="form-control" id="rr_pbl_per_tap"></td>
                                            <td><input type="text" form="my_form" name="rrr_pbl_per_tap" value="<?= $amkre['rrr_pbl_per_tap'] ?>" class="form-control" id="rrr_pbl_per_tap"></td>
                                            <td><input type="text" form="my_form" name="rrrr_pbl_per_tap" value="<?= $amkre['rrrr_pbl_per_tap'] ?>" class="form-control" id="rrrr_pbl_per_tap"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">b. ABA Pada 1 Bank Tertinggi / Penempatan Bank Lain</th>
                                            <td><input type="text" form="my_form" name="apbt_per_pbl" value="<?= $amkre['apbt_per_pbl'] ?>" class="form-control" id="apbt_per_pbl"></td>
                                            <td><input type="text" form="my_form" name="rr_apbt_per_pbl" value="<?= $amkre['rr_apbt_per_pbl'] ?>" class="form-control" id="rr_apbt_per_pbl"></td>
                                            <td><input type="text" form="my_form" name="rrr_apbt_per_pbl" value="<?= $amkre['rrr_apbt_per_pbl'] ?>" class="form-control" id="rrr_apbt_per_pbl"></td>
                                            <td><input type="text" form="my_form" name="rrrr_apbt_per_pbl" value="<?= $amkre['rrrr_apbt_per_pbl'] ?>" class="form-control" id="rrrr_apbt_per_pbl"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">c. ABA Pada BPR / Penempatan Bank Lain</th>
                                            <td><input type="text" form="my_form" name="abapb_per_pbl" value="<?= $amkre['abapb_per_pbl'] ?>" class="form-control" id="abapb_per_pbl"></td>
                                            <td><input type="text" form="my_form" name="rr_abapb_per_pbl" value="<?= $amkre['rr_abapb_per_pbl'] ?>" class="form-control" id="rr_abapb_per_pbl"></td>
                                            <td><input type="text" form="my_form" name="rrr_abapb_per_pbl" value="<?= $amkre['rrr_abapb_per_pbl'] ?>" class="form-control" id="rrr_abapb_per_pbl"></td>
                                            <td><input type="text" form="my_form" name="rrrr_abapb_per_pbl" value="<?= $amkre['rrrr_abapb_per_pbl'] ?>" class="form-control" id="rrrr_abapb_per_pbl"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">d. NOA Kredit Plafond sampai dengan 150jt / NOA KYD</th>
                                            <td><input type="text" form="my_form" name="nkp150_per_nkyd" value="<?= $amkre['nkp150_per_nkyd'] ?>" class="form-control" id="nkp150_per_nkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_nkp150_per_nkyd" value="<?= $amkre['rr_nkp150_per_nkyd'] ?>" class="form-control" id="rr_nkp150_per_nkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_nkp150_per_nkyd" value="<?= $amkre['rrr_nkp150_per_nkyd'] ?>" class="form-control" id="rrr_nkp150_per_nkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nkp150_per_nkyd" value="<?= $amkre['rrrr_nkp150_per_nkyd'] ?>" class="form-control" id="rrrr_nkp150_per_nkyd"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">e. Kredit PEP / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kpep_per_tkyd" value="<?= $amkre['kpep_per_tkyd'] ?>" class="form-control" id="kpep_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kpep_per_tkyd" value="<?= $amkre['rr_kpep_per_tkyd'] ?>" class="form-control" id="rr_kpep_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kpep_per_tkyd" value="<?= $amkre['rrr_kpep_per_tkyd'] ?>" class="form-control" id="rrr_kpep_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kpep_per_tkyd" value="<?= $amkre['rrrr_kpep_per_tkyd'] ?>" class="form-control" id="rrrr_kpep_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">f. Kredit plafon >= 350jt / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kp350_per_tkyd" value="<?= $amkre['kp350_per_tkyd'] ?>" class="form-control" id="kp350_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kp350_per_tkyd" value="<?= $amkre['rr_kp350_per_tkyd'] ?>" class="form-control" id="rr_kp350_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kp350_per_tkyd" value="<?= $amkre['rrr_kp350_per_tkyd'] ?>" class="form-control" id="rrr_kp350_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kp350_per_tkyd" value="<?= $amkre['rrrr_kp350_per_tkyd'] ?>" class="form-control" id="rrrr_kp350_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">g. Saldo PPAP / Total Kredit</th>
                                            <td><input type="text" form="my_form" name="sppap_per_tk" value="<?= $amkre['sppap_per_tk'] ?>" class="form-control" id="sppap_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rr_sppap_per_tk" value="<?= $amkre['rr_sppap_per_tk'] ?>" class="form-control" id="rr_sppap_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrr_sppap_per_tk" value="<?= $amkre['rrr_sppap_per_tk'] ?>" class="form-control" id="rrr_sppap_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_sppap_per_tk" value="<?= $amkre['rrrr_sppap_per_tk'] ?>" class="form-control" id="rrrr_sppap_per_tk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">h. AYDA / KYD</th>
                                            <td><input type="text" form="my_form" name="ayda_per_kyd" value="<?= $amkre['ayda_per_kyd'] ?>" class="form-control" id="ayda_per_kyd"></td>
                                            <td><input type="text" form="my_form" name="rr_ayda_per_kyd" value="<?= $amkre['rr_ayda_per_kyd'] ?>" class="form-control" id="rr_ayda_per_kyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_ayda_per_kyd" value="<?= $amkre['rrr_ayda_per_kyd'] ?>" class="form-control" id="rrr_ayda_per_kyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_ayda_per_kyd" value="<?= $amkre['rrrr_ayda_per_kyd'] ?>" class="form-control" id="rrrr_ayda_per_kyd"></td>
                                        </tr>









                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Yang DIberikan / Aset Produktif</th>
                                            <td><input type="text" form="my_form" name="kyd_per_ap" value="<?= $amkre['kyd_per_ap'] ?>" class="form-control" id="kyd_per_ap"></td>
                                            <td colspan="3"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">a. Kredit Skema Potong Gaji / Total Kredit</th>
                                            <td><input type="text" form="my_form" name="kspg_per_tk" value="<?= $amkre['kspg_per_tk'] ?>" class="form-control" id="kspg_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rr_kspg_per_tk" value="<?= $amkre['rr_kspg_per_tk'] ?>" class="form-control" id="rr_kspg_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrr_kspg_per_tk" value="<?= $amkre['rrr_kspg_per_tk'] ?>" class="form-control" id="rrr_kspg_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kspg_per_tk" value="<?= $amkre['rrrr_kspg_per_tk'] ?>" class="form-control" id="rrrr_kspg_per_tk"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">b. kredit Musiman (Grace Period) / Total KYD</th>
                                            <td><input type="text" form="my_form" name="km_per_tkyd" value="<?= $amkre['km_per_tkyd'] ?>" class="form-control" id="km_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_km_per_tkyd" value="<?= $amkre['rr_km_per_tkyd'] ?>" class="form-control" id="rr_km_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_km_per_tkyd" value="<?= $amkre['rrr_km_per_tkyd'] ?>" class="form-control" id="rrr_km_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_km_per_tkyd" value="<?= $amkre['rrrr_km_per_tkyd'] ?>" class="form-control" id="rrrr_km_per_tkyd"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">c. Kredit Jangka Pendek / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kjpen_per_tkyd" value="<?= $amkre['kjpen_per_tkyd'] ?>" class="form-control" id="kjpen_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kjpen_per_tkyd" value="<?= $amkre['rr_kjpen_per_tkyd'] ?>" class="form-control" id="rr_kjpen_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kjpen_per_tkyd" value="<?= $amkre['rrr_kjpen_per_tkyd'] ?>" class="form-control" id="rrr_kjpen_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kjpen_per_tkyd" value="<?= $amkre['rrrr_kjpen_per_tkyd'] ?>" class="form-control" id="rrrr_kjpen_per_tkyd"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">d. Kredit Jangka Menengah / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kjm_per_tkyd" value="<?= $amkre['kjm_per_tkyd'] ?>" class="form-control" id="kjm_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kjm_per_tkyd" value="<?= $amkre['rr_kjm_per_tkyd'] ?>" class="form-control" id="rr_kjm_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kjm_per_tkyd" value="<?= $amkre['rrr_kjm_per_tkyd'] ?>" class="form-control" id="rrr_kjm_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kjm_per_tkyd" value="<?= $amkre['rrrr_kjm_per_tkyd'] ?>" class="form-control" id="rrrr_kjm_per_tkyd"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">e. Kredit Jangka Panjang / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kjpan_per_tkyd" value="<?= $amkre['kjpan_per_tkyd'] ?>" class="form-control" id="kjpan_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kjpan_per_tkyd" value="<?= $amkre['rr_kjpan_per_tkyd'] ?>" class="form-control" id="rr_kjpan_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kjpan_per_tkyd" value="<?= $amkre['rrr_kjpan_per_tkyd'] ?>" class="form-control" id="rrr_kjpan_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kjpan_per_tkyd" value="<?= $amkre['rrrr_kjpan_per_tkyd'] ?>" class="form-control" id="rrrr_kjpan_per_tkyd"></td>

                                        </tr>

                                        

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">f. Kredit Dengan Tanah dan Bangunan / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kdatdb_per_tkyd" value="<?= $amkre['kdatdb_per_tkyd'] ?>" class="form-control" id="kdatdb_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kdatdb_per_tkyd" value="<?= $amkre['rr_kdatdb_per_tkyd'] ?>" class="form-control" id="rr_kdatdb_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kdatdb_per_tkyd" value="<?= $amkre['rrr_kdatdb_per_tkyd'] ?>" class="form-control" id="rrr_kdatdb_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kdatdb_per_tkyd" value="<?= $amkre['rrrr_kdatdb_per_tkyd'] ?>" class="form-control" id="rrrr_kdatdb_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">g. Kredit Agunan Kendaraan Bermotor / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kak_per_tkyd" value="<?= $amkre['kak_per_tkyd'] ?>" class="form-control" id="kak_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kak_per_tkyd" value="<?= $amkre['rr_kak_per_tkyd'] ?>" class="form-control" id="rr_kak_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kak_per_tkyd" value="<?= $amkre['rrr_kak_per_tkyd'] ?>" class="form-control" id="rrr_kak_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kak_per_tkyd" value="<?= $amkre['rrrr_kak_per_tkyd'] ?>" class="form-control" id="rrrr_kak_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">h. Kredit Agunan Kendaraan Roda 2 / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kakr2_per_tkyd" value="<?= $amkre['kakr2_per_tkyd'] ?>" class="form-control" id="kakr2_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kakr2_per_tkyd" value="<?= $amkre['rr_kakr2_per_tkyd'] ?>" class="form-control" id="rr_kakr2_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kakr2_per_tkyd" value="<?= $amkre['rrr_kakr2_per_tkyd'] ?>" class="form-control" id="rrr_kakr2_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kakr2_per_tkyd" value="<?= $amkre['rrrr_kakr2_per_tkyd'] ?>" class="form-control" id="rrrr_kakr2_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">i. OSC Produk KUB / Total KYD</th>
                                            <td><input type="text" form="my_form" name="opk_per_tkyd" value="<?= $amkre['opk_per_tkyd'] ?>" class="form-control" id="opk_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_opk_per_tkyd" value="<?= $amkre['rr_opk_per_tkyd'] ?>" class="form-control" id="rr_opk_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_opk_per_tkyd" value="<?= $amkre['rrr_opk_per_tkyd'] ?>" class="form-control" id="rrr_opk_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_opk_per_tkyd" value="<?= $amkre['rrrr_opk_per_tkyd'] ?>" class="form-control" id="rrrr_opk_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">j. Kredit Tanpa Agunan / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kta_per_tkyd" value="<?= $amkre['kta_per_tkyd'] ?>" class="form-control" id="kta_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kta_per_tkyd" value="<?= $amkre['rr_kta_per_tkyd'] ?>" class="form-control" id="rr_kta_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kta_per_tkyd" value="<?= $amkre['rrr_kta_per_tkyd'] ?>" class="form-control" id="rrr_kta_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kta_per_tkyd" value="<?= $amkre['rrrr_kta_per_tkyd'] ?>" class="form-control" id="rrrr_kta_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">k. Kredit Korporasi (non perorangan) / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kknp_per_tkyd" value="<?= $amkre['kknp_per_tkyd'] ?>" class="form-control" id="kknp_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kknp_per_tkyd" value="<?= $amkre['rr_kknp_per_tkyd'] ?>" class="form-control" id="rr_kknp_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kknp_per_tkyd" value="<?= $amkre['rrr_kknp_per_tkyd'] ?>" class="form-control" id="rrr_kknp_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kknp_per_tkyd" value="<?= $amkre['rrrr_kknp_per_tkyd'] ?>" class="form-control" id="rrrr_kknp_per_tkyd"></td>

                                        </tr>

                                        
                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">25 Debitur Inti / Total Kredit</th>
                                            <td><input type="text" form="my_form" name="di25_per_tk" value="<?= $amkre['di25_per_tk'] ?>" class="form-control" id="di25_per_tk"></td>
                                            <td colspan="3"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit per sektor ekonomi / Total Kredit</th>
                                            <td><input type="text" form="my_form" name="kpse_per_tk" value="<?= $amkre['kpse_per_tk'] ?>" class="form-control" id="kpse_per_tk"></td>
                                            <td colspan="3"></td>
                                        </tr>






                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->


                            <hr>
                            </hr>

                            <br></br>

                            <!-- PILAR 2-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>KREDIT | PILAR 2 :KUALITAS ASET</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class=" text-center">
                                                AMBANG BATAS
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>



                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Profuktif Bermasalah / Total Aset Produktif</th>
                                            <td><input type="text" form="my_form" name="apb_per_tap" value="<?= $amkre['apb_per_tap'] ?>" class="form-control" id="apb_per_tap"></td>
                                            <td><input type="text" form="my_form" name="rr_apb_per_tap" value="<?= $amkre['rr_apb_per_tap'] ?>" class="form-control" id="rr_apb_per_tap"></td>
                                            <td><input type="text" form="my_form" name="rrr_apb_per_tap" value="<?= $amkre['rrr_apb_per_tap'] ?>" class="form-control" id="rrr_apb_per_tap"></td>
                                            <td><input type="text" form="my_form" name="rrrr_apb_per_tap" value="<?= $amkre['rrrr_apb_per_tap'] ?>" class="form-control" id="rrrr_apb_per_tap"></td>
                                        </tr>

                                       









                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Bermasalah Neto / Total Kredit</th>
                                            <td><input type="text" form="my_form" name="kbn_per_tk" value="<?= $amkre['kbn_per_tk'] ?>" class="form-control" id="kbn_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rr_kbn_per_tk" value="<?= $amkre['rr_kbn_per_tk'] ?>" class="form-control" id="rr_kbn_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrr_kbn_per_tk" value="<?= $amkre['rrr_kbn_per_tk'] ?>" class="form-control" id="rrr_kbn_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kbn_per_tk" value="<?= $amkre['rrrr_kbn_per_tk'] ?>" class="form-control" id="rrrr_kbn_per_tk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">a. NPL Kredit Plafon sampai dengan 150 jt / Total KYD plafond sampai dengan 150 jt </th>
                                            <td><input type="text" form="my_form" name="nkp150_per_tkp150" value="<?= $amkre['nkp150_per_tkp150'] ?>" class="form-control" id="nkp150_per_tkp150"></td>
                                            <td><input type="text" form="my_form" name="rr_nkp150_per_tkp150" value="<?= $amkre['rr_nkp150_per_tkp150'] ?>" class="form-control" id="rr_nkp150_per_tkp150"></td>
                                            <td><input type="text" form="my_form" name="rrr_nkp150_per_tkp150" value="<?= $amkre['rrr_nkp150_per_tkp150'] ?>" class="form-control" id="rrr_nkp150_per_tkp150"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nkp150_per_tkp150" value="<?= $amkre['rrrr_nkp150_per_tkp150'] ?>" class="form-control" id="rrrr_nkp150_per_tkp150"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">b. NPL Kredit Plafon diatas 50 jt/ Total KYD Plafond diatas 50 jt</th>
                                            <td><input type="text" form="my_form" name="nkpd50_per_tkpd50" value="<?= $amkre['nkpd50_per_tkpd50'] ?>" class="form-control" id="nkpd50_per_tkpd50"></td>
                                            <td><input type="text" form="my_form" name="rr_nkpd50_per_tkpd50" value="<?= $amkre['rr_nkpd50_per_tkpd50'] ?>" class="form-control" id="rr_nkpd50_per_tkpd50"></td>
                                            <td><input type="text" form="my_form" name="rrr_nkpd50_per_tkpd50" value="<?= $amkre['rrr_nkpd50_per_tkpd50'] ?>" class="form-control" id="rrr_nkpd50_per_tkpd50"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nkpd50_per_tkpd50" value="<?= $amkre['rrrr_nkpd50_per_tkpd50'] ?>" class="form-control" id="rrrr_nkpd50_per_tkpd50"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">c. NPL Kredit dengan Perikatan APHT / Total KYD</th>
                                            <td><input type="text" form="my_form" name="nkdpapht_prt_tkyd" value="<?= $amkre['nkdpapht_prt_tkyd'] ?>" class="form-control" id="nkdpapht_prt_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_nkdpapht_prt_tkyd" value="<?= $amkre['rr_nkdpapht_prt_tkyd'] ?>" class="form-control" id="rr_nkdpapht_prt_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_nkdpapht_prt_tkyd" value="<?= $amkre['rrr_nkdpapht_prt_tkyd'] ?>" class="form-control" id="rrr_nkdpapht_prt_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nkdpapht_prt_tkyd" value="<?= $amkre['rrrr_nkdpapht_prt_tkyd'] ?>" class="form-control" id="rrrr_nkdpapht_prt_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">d. NPL Kredit dengan Perikatan SKMHT / Total KYD</th>
                                            <td><input type="text" form="my_form" name="nkdpskmht_per_tkyd" value="<?= $amkre['nkdpskmht_per_tkyd'] ?>" class="form-control" id="nkdpskmht_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_nkdpskmht_per_tkyd" value="<?= $amkre['rr_nkdpskmht_per_tkyd'] ?>" class="form-control" id="rr_nkdpskmht_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_nkdpskmht_per_tkyd" value="<?= $amkre['rrr_nkdpskmht_per_tkyd'] ?>" class="form-control" id="rrr_nkdpskmht_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nkdpskmht_per_tkyd" value="<?= $amkre['rrrr_nkdpskmht_per_tkyd'] ?>" class="form-control" id="rrrr_nkdpskmht_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">e. NPL Nilai Agunan Lebih Rendah Dari Baki Debet / Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet</th>
                                            <td><input type="text" form="my_form" name="nalrdbd_per_tknalrdbd" value="<?= $amkre['nalrdbd_per_tknalrdbd'] ?>" class="form-control" id="nalrdbd_per_tknalrdbd"></td>
                                            <td><input type="text" form="my_form" name="rr_nalrdbd_per_tknalrdbd" value="<?= $amkre['rr_nalrdbd_per_tknalrdbd'] ?>" class="form-control" id="rr_nalrdbd_per_tknalrdbd"></td>
                                            <td><input type="text" form="my_form" name="rrr_nalrdbd_per_tknalrdbd" value="<?= $amkre['rrr_nalrdbd_per_tknalrdbd'] ?>" class="form-control" id="rrr_nalrdbd_per_tknalrdbd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nalrdbd_per_tknalrdbd" value="<?= $amkre['rrrr_nalrdbd_per_tknalrdbd'] ?>" class="form-control" id="rrrr_nalrdbd_per_tknalrdbd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">f. Kredit Macet sudah jatuh tempo / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kmsjt_per_tkyd" value="<?= $amkre['kmsjt_per_tkyd'] ?>" class="form-control" id="kmsjt_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kmsjt_per_tkyd" value="<?= $amkre['rr_kmsjt_per_tkyd'] ?>" class="form-control" id="rr_kmsjt_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kmsjt_per_tkyd" value="<?= $amkre['rrr_kmsjt_per_tkyd'] ?>" class="form-control" id="rrr_kmsjt_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kmsjt_per_tkyd" value="<?= $amkre['rrrr_kmsjt_per_tkyd'] ?>" class="form-control" id="rrrr_kmsjt_per_tkyd"></td>
                                        </tr>




                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Kualitas Rendah / Total Kredit</th>
                                            <td><input type="text" form="my_form" name="kkr_per_tk" value="<?= $amkre['kkr_per_tk'] ?>" class="form-control" id="kkr_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rr_kkr_per_tk" value="<?= $amkre['rr_kkr_per_tk'] ?>" class="form-control" id="rr_kkr_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrr_kkr_per_tk" value="<?= $amkre['rrr_kkr_per_tk'] ?>" class="form-control" id="rrr_kkr_per_tk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kkr_per_tk" value="<?= $amkre['rrrr_kkr_per_tk'] ?>" class="form-control" id="rrrr_kkr_per_tk"></td>
                                            <td colspan="3"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">a. Kredit Par 4 / Total KYD</th>
                                            <td><input type="text" form="my_form" name="kp4_per_tkyd" value="<?= $amkre['kp4_per_tkyd'] ?>" class="form-control" id="kp4_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kp4_per_tkyd" value="<?= $amkre['rr_kp4_per_tkyd'] ?>" class="form-control" id="rr_kp4_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kp4_per_tkyd" value="<?= $amkre['rrr_kp4_per_tkyd'] ?>" class="form-control" id="rrr_kp4_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kp4_per_tkyd" value="<?= $amkre['rrrr_kp4_per_tkyd'] ?>" class="form-control" id="rrrr_kp4_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">b. Kredit DP (PAR 3 + PAR 4 )/ Total KYD</th>
                                            <td><input type="text" form="my_form" name="kdp3p4_per_tkyd" value="<?= $amkre['kdp3p4_per_tkyd'] ?>" class="form-control" id="kdp3p4_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rr_kdp3p4_per_tkyd" value="<?= $amkre['rr_kdp3p4_per_tkyd'] ?>" class="form-control" id="rr_kdp3p4_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrr_kdp3p4_per_tkyd" value="<?= $amkre['rrr_kdp3p4_per_tkyd'] ?>" class="form-control" id="rrr_kdp3p4_per_tkyd"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kdp3p4_per_tkyd" value="<?= $amkre['rrrr_kdp3p4_per_tkyd'] ?>" class="form-control" id="rrrr_kdp3p4_per_tkyd"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">c. NOA FPD 6 Bulan Terakhir / NOA Ekspansi 6 Bulan Terakhir</th>
                                            <td><input type="text" form="my_form" name="nf6bt_per_ne6bt" value="<?= $amkre['nf6bt_per_ne6bt'] ?>" class="form-control" id="nf6bt_per_ne6bt"></td>
                                            <td><input type="text" form="my_form" name="rr_nf6bt_per_ne6bt" value="<?= $amkre['rr_nf6bt_per_ne6bt'] ?>" class="form-control" id="rr_nf6bt_per_ne6bt"></td>
                                            <td><input type="text" form="my_form" name="rrr_nf6bt_per_ne6bt" value="<?= $amkre['rrr_nf6bt_per_ne6bt'] ?>" class="form-control" id="rrr_nf6bt_per_ne6bt"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nf6bt_per_ne6bt" value="<?= $amkre['rrrr_nf6bt_per_ne6bt'] ?>" class="form-control" id="rrrr_nf6bt_per_ne6bt"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">d. Nominal FPD 6 Bulan Terakhir / Plafond Ekspansi 6 Bulan Terakhir</th>
                                            <td><input type="text" form="my_form" name="nomf6bt_per_pe6bt" value="<?= $amkre['nomf6bt_per_pe6bt'] ?>" class="form-control" id="nomf6bt_per_pe6bt"></td>
                                            <td><input type="text" form="my_form" name="rr_nomf6bt_per_pe6bt" value="<?= $amkre['rr_nomf6bt_per_pe6bt'] ?>" class="form-control" id="rr_nomf6bt_per_pe6bt"></td>
                                            <td><input type="text" form="my_form" name="rrr_nomf6bt_per_pe6bt" value="<?= $amkre['rrr_nomf6bt_per_pe6bt'] ?>" class="form-control" id="rrr_nomf6bt_per_pe6bt"></td>
                                            <td><input type="text" form="my_form" name="rrrr_nomf6bt_per_pe6bt" value="<?= $amkre['rrrr_nomf6bt_per_pe6bt'] ?>" class="form-control" id="rrrr_nomf6bt_per_pe6bt"></td>
                                        </tr>








                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->




                            <hr>
                            </hr>

                            <br></br>




                            <!-- PILAR 1 LIK-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>LIKUIDITAS | PILAR 1 :KOMPOSISI DAN KONSENTRASI ASET DAN KEWAJIBAN</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class=" text-center">
                                                AMBANG BATAS
                                            </th>
                                            <th colspan="5">
                                                RUMUS 2 - 4
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>



                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Likuid / Total Aset</th>
                                            <td><input type="text" form="my_form" name="al_per_ta" value="<?= $amlik['al_per_ta'] ?>" class="form-control" id="al_per_ta"></td>
                                            <td colspan="3"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Aset-Aset Likuid / Total DPK-Aset Likuid</th>
                                            <td><input type="text" form="my_form" name="ta_al_per_td_al" value="<?= $amlik['ta_al_per_td_al'] ?>" class="form-control" id="ta_al_per_td_al"></td>
                                            <td><input type="text" form="my_form" name="rr_ta_al_per_td_al" value="<?= $amlik['rr_ta_al_per_td_al'] ?>" class="form-control" id="rr_ta_al_per_td_al"></td>
                                            <td><input type="text" form="my_form" name="rrr_ta_al_per_td_al" value="<?= $amlik['rrr_ta_al_per_td_al'] ?>" class="form-control" id="rrr_ta_al_per_td_al"></td>
                                            <td><input type="text" form="my_form" name="rrrr_ta_al_per_td_al" value="<?= $amlik['rrrr_ta_al_per_td_al'] ?>" class="form-control" id="rrrr_ta_al_per_td_al"></td>
                                        </tr>












                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Likuid / Kewajiban Lancar</th>
                                            <td><input type="text" form="my_form" name="al_per_kl" value="<?= $amlik['al_per_kl'] ?>" class="form-control" id="al_per_kl"></td>
                                            <td colspan="3"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">a. Total Aset Likuid / Pendanaan Jangka Pendek </th>
                                            <td><input type="text" form="my_form" name="tal_per_pjp" value="<?= $amlik['tal_per_pjp'] ?>" class="form-control" id="tal_per_pjp"></td>
                                            <td><input type="text" form="my_form" name="rr_tal_per_pjp" value="<?= $amlik['rr_tal_per_pjp'] ?>" class="form-control" id="rr_tal_per_pjp"></td>
                                            <td><input type="text" form="my_form" name="rrr_tal_per_pjp" value="<?= $amlik['rrr_tal_per_pjp'] ?>" class="form-control" id="rrr_tal_per_pjp"></td>
                                            <td><input type="text" form="my_form" name="rrrr_tal_per_pjp" value="<?= $amlik['rrrr_tal_per_pjp'] ?>" class="form-control" id="rrrr_tal_per_pjp"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">b. Aset Likuid / Kewajiban Jangka Pendek</th>
                                            <td><input type="text" form="my_form" name="al_per_kjp" value="<?= $amlik['al_per_kjp'] ?>" class="form-control" id="al_per_kjp"></td>
                                            <td><input type="text" form="my_form" name="rr_al_per_kjp" value="<?= $amlik['rr_al_per_kjp'] ?>" class="form-control" id="rr_al_per_kjp"></td>
                                            <td><input type="text" form="my_form" name="rrr_al_per_kjp" value="<?= $amlik['rrr_al_per_kjp'] ?>" class="form-control" id="rrr_al_per_kjp"></td>
                                            <td><input type="text" form="my_form" name="rrrr_al_per_kjp" value="<?= $amlik['rrrr_al_per_kjp'] ?>" class="form-control" id="rrrr_al_per_kjp"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">c. Arus Kas Netto / Total DPK</th>
                                            <td><input type="text" form="my_form" name="akn_per_tdpk" value="<?= $amlik['akn_per_tdpk'] ?>" class="form-control" id="akn_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_akn_per_tdpk" value="<?= $amlik['rr_akn_per_tdpk'] ?>" class="form-control" id="rr_akn_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_akn_per_tdpk" value="<?= $amlik['rrr_akn_per_tdpk'] ?>" class="form-control" id="rrr_akn_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_akn_per_tdpk" value="<?= $amlik['rrrr_akn_per_tdpk'] ?>" class="form-control" id="rrrr_akn_per_tdpk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">d. Tabungan / Total DPK</th>
                                            <td><input type="text" form="my_form" name="tabungan_per_tdpk" value="<?= $amlik['tabungan_per_tdpk'] ?>" class="form-control" id="tabungan_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_tabungan_per_tdpk" value="<?= $amlik['rr_tabungan_per_tdpk'] ?>" class="form-control" id="rr_tabungan_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_tabungan_per_tdpk" value="<?= $amlik['rrr_tabungan_per_tdpk'] ?>" class="form-control" id="rrr_tabungan_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_tabungan_per_tdpk" value="<?= $amlik['rrrr_tabungan_per_tdpk'] ?>" class="form-control" id="rrrr_tabungan_per_tdpk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">e. Deposito Jangka Waktu 3 Bulan / Total DPK</th>
                                            <td><input type="text" form="my_form" name="djw3bln_per_tdpk" value="<?= $amlik['djw3bln_per_tdpk'] ?>" class="form-control" id="djw3bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_djw3bln_per_tdpk" value="<?= $amlik['rr_djw3bln_per_tdpk'] ?>" class="form-control" id="rr_djw3bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_djw3bln_per_tdpk" value="<?= $amlik['rrr_djw3bln_per_tdpk'] ?>" class="form-control" id="rrr_djw3bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_djw3bln_per_tdpk" value="<?= $amlik['rrrr_djw3bln_per_tdpk'] ?>" class="form-control" id="rrrr_djw3bln_per_tdpk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">f. Deposito Jangka Waktu 6 Bulan / Total DPK</th>
                                            <td><input type="text" form="my_form" name="djw6bln_per_tdpk" value="<?= $amlik['djw6bln_per_tdpk'] ?>" class="form-control" id="djw6bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_djw6bln_per_tdpk" value="<?= $amlik['rr_djw6bln_per_tdpk'] ?>" class="form-control" id="rr_djw6bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_djw6bln_per_tdpk" value="<?= $amlik['rrr_djw6bln_per_tdpk'] ?>" class="form-control" id="rrr_djw6bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_djw6bln_per_tdpk" value="<?= $amlik['rrrr_djw6bln_per_tdpk'] ?>" class="form-control" id="rrrr_djw6bln_per_tdpk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">g. Deposito Jangka Waktu 12 Bulan / Total DPK</th>
                                            <td><input type="text" form="my_form" name="djw12bln_per_tdpk" value="<?= $amlik['djw12bln_per_tdpk'] ?>" class="form-control" id="djw12bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_djw12bln_per_tdpk" value="<?= $amlik['rr_djw12bln_per_tdpk'] ?>" class="form-control" id="rr_djw12bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_djw12bln_per_tdpk" value="<?= $amlik['rrr_djw12bln_per_tdpk'] ?>" class="form-control" id="rrr_djw12bln_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_djw12bln_per_tdpk" value="<?= $amlik['rrrr_djw12bln_per_tdpk'] ?>" class="form-control" id="rrrr_djw12bln_per_tdpk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">h. Modal Disetor / Total DPK</th>
                                            <td><input type="text" form="my_form" name="md_per_tdpk" value="<?= $amlik['md_per_tdpk'] ?>" class="form-control" id="md_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_md_per_tdpk" value="<?= $amlik['rr_md_per_tdpk'] ?>" class="form-control" id="rr_md_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_md_per_tdpk" value="<?= $amlik['rrr_md_per_tdpk'] ?>" class="form-control" id="rrr_md_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_md_per_tdpk" value="<?= $amlik['rrrr_md_per_tdpk'] ?>" class="form-control" id="rrrr_md_per_tdpk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">i. Pinjaman / Total DPK</th>
                                            <td><input type="text" form="my_form" name="pin_per_tdpk" value="<?= $amlik['pin_per_tdpk'] ?>" class="form-control" id="pin_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_pin_per_tdpk" value="<?= $amlik['rr_pin_per_tdpk'] ?>" class="form-control" id="rr_pin_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_pin_per_tdpk" value="<?= $amlik['rrr_pin_per_tdpk'] ?>" class="form-control" id="rrr_pin_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_pin_per_tdpk" value="<?= $amlik['rrrr_pin_per_tdpk'] ?>" class="form-control" id="rrrr_pin_per_tdpk"></td>
                                        </tr>




                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Yang Diberikan / Total Dana Pihak Ketiga Bukan Bank</th>
                                            <td><input type="text" form="my_form" name="kyd_per_tdpkbk" value="<?= $amlik['kyd_per_tdpkbk'] ?>" class="form-control" id="kyd_per_tdpkbk"></td>
                                            <td><input type="text" form="my_form" name="rr_kyd_per_tdpkbk" value="<?= $amlik['rr_kyd_per_tdpkbk'] ?>" class="form-control" id="rr_kyd_per_tdpkbk"></td>
                                            <td><input type="text" form="my_form" name="rrr_kyd_per_tdpkbk" value="<?= $amlik['rrr_kyd_per_tdpkbk'] ?>" class="form-control" id="rrr_kyd_per_tdpkbk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_kyd_per_tdpkbk" value="<?= $amlik['rrrr_kyd_per_tdpkbk'] ?>" class="form-control" id="rrrr_kyd_per_tdpkbk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">a. DPK Yang Dijamin LPS / DPK</th>
                                            <td><input type="text" form="my_form" name="dpkydlps_per_dpk" value="<?= $amlik['dpkydlps_per_dpk'] ?>" class="form-control" id="dpkydlps_per_dpk"></td>
                                            <td><input type="text" form="my_form" name="rr_dpkydlps_per_dpk" value="<?= $amlik['rr_dpkydlps_per_dpk'] ?>" class="form-control" id="rr_dpkydlps_per_dpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_dpkydlps_per_dpk" value="<?= $amlik['rrr_dpkydlps_per_dpk'] ?>" class="form-control" id="rrr_dpkydlps_per_dpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_dpkydlps_per_dpk" value="<?= $amlik['rrrr_dpkydlps_per_dpk'] ?>" class="form-control" id="rrrr_dpkydlps_per_dpk"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">b. Alat Likuid + Kredit Lancar / Dana Pihak Ke 3</th>
                                            <td><input type="text" form="my_form" name="alkl_per_dpk3" value="<?= $amlik['alkl_per_dpk3'] ?>" class="form-control" id="alkl_per_dpk3"></td>
                                            <td><input type="text" form="my_form" name="rr_alkl_per_dpk3" value="<?= $amlik['rr_alkl_per_dpk3'] ?>" class="form-control" id="rr_alkl_per_dpk3"></td>
                                            <td><input type="text" form="my_form" name="rrr_alkl_per_dpk3" value="<?= $amlik['rrr_alkl_per_dpk3'] ?>" class="form-control" id="rrr_alkl_per_dpk3"></td>
                                            <td><input type="text" form="my_form" name="rrrr_alkl_per_dpk3" value="<?= $amlik['rrrr_alkl_per_dpk3'] ?>" class="form-control" id="rrrr_alkl_per_dpk3"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">c. Deposito Tenor Sampai Dengan 6 Bulan / Alat Likuid</th>
                                            <td><input type="text" form="my_form" name="dtsd6bln_per_al" value="<?= $amlik['dtsd6bln_per_al'] ?>" class="form-control" id="dtsd6bln_per_al"></td>
                                            <td><input type="text" form="my_form" name="rr_dtsd6bln_per_al" value="<?= $amlik['rr_dtsd6bln_per_al'] ?>" class="form-control" id="rr_dtsd6bln_per_al"></td>
                                            <td><input type="text" form="my_form" name="rrr_dtsd6bln_per_al" value="<?= $amlik['rrr_dtsd6bln_per_al'] ?>" class="form-control" id="rrr_dtsd6bln_per_al"></td>
                                            <td><input type="text" form="my_form" name="rrrr_dtsd6bln_per_al" value="<?= $amlik['rrrr_dtsd6bln_per_al'] ?>" class="form-control" id="rrrr_dtsd6bln_per_al"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">d. Pertumbuhan Kredit (sem II tahun sebelumnya - Tw I tahun ini) / Pertumbuhan Simpanan (sem II tahun sebelumnya - Tw I tahun ini) </th>
                                            <td><input type="text" form="my_form" name="pk_per_ps" value="<?= $amlik['pk_per_ps'] ?>" class="form-control" id="pk_per_ps"></td>
                                            <td><input type="text" form="my_form" name="rr_pk_per_ps" value="<?= $amlik['rr_pk_per_ps'] ?>" class="form-control" id="rr_pk_per_ps"></td>
                                            <td><input type="text" form="my_form" name="rrr_pk_per_ps" value="<?= $amlik['rrr_pk_per_ps'] ?>" class="form-control" id="rrr_pk_per_ps"></td>
                                            <td><input type="text" form="my_form" name="rrrr_pk_per_ps" value="<?= $amlik['rrrr_pk_per_ps'] ?>" class="form-control" id="rrrr_pk_per_ps"></td>
                                        </tr>



                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">25 Deposan dan Penabung Terbesar / Total DPK</th>
                                            <td><input type="text" form="my_form" name="ddpt25_per_tdpk" value="<?= $amlik['ddpt25_per_tdpk'] ?>" class="form-control" id="ddpt25_per_tdpk"></td>
                                            <td colspan="3"></td>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pendanaan Non Inti / Total Pendanaan</th>
                                            <td><input type="text" form="my_form" name="pni_per_tp" value="<?= $amlik['pni_per_tp'] ?>" class="form-control" id="pni_per_tp"></td>
                                            <td colspan="3"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">a. Pendanaan Non Inti - Alat Likuid / Total Aset - Aset Likuid</th>
                                            <td><input type="text" form="my_form" name="pnial_per_taal" value="<?= $amlik['pnial_per_taal'] ?>" class="form-control" id="pnial_per_taal"></td>
                                            <td><input type="text" form="my_form" name="rr_pnial_per_taal" value="<?= $amlik['rr_pnial_per_taal'] ?>" class="form-control" id="rr_pnial_per_taal"></td>
                                            <td><input type="text" form="my_form" name="rrr_pnial_per_taal" value="<?= $amlik['rrr_pnial_per_taal'] ?>" class="form-control" id="rrr_pnial_per_taal"></td>
                                            <td><input type="text" form="my_form" name="rrrr_pnial_per_taal" value="<?= $amlik['rrrr_pnial_per_taal'] ?>" class="form-control" id="rrrr_pnial_per_taal"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">b. Deposito Rate Special / Alat Likuid</th>
                                            <td><input type="text" form="my_form" name="drs_per_al" value="<?= $amlik['drs_per_al'] ?>" class="form-control" id="drs_per_al"></td>
                                            <td><input type="text" form="my_form" name="rr_drs_per_al" value="<?= $amlik['rr_drs_per_al'] ?>" class="form-control" id="rr_drs_per_al"></td>
                                            <td><input type="text" form="my_form" name="rrr_drs_per_al" value="<?= $amlik['rrr_drs_per_al'] ?>" class="form-control" id="rrr_drs_per_al"></td>
                                            <td><input type="text" form="my_form" name="rrrr_drs_per_al" value="<?= $amlik['rrrr_drs_per_al'] ?>" class="form-control" id="rrrr_drs_per_al"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">c. Aset Likuid / Pendanaan Non Inti</th>
                                            <td><input type="text" form="my_form" name="al_per_pni" value="<?= $amlik['al_per_pni'] ?>" class="form-control" id="al_per_pni"></td>
                                            <td><input type="text" form="my_form" name="rr_al_per_pni" value="<?= $amlik['rr_al_per_pni'] ?>" class="form-control" id="rr_al_per_pni"></td>
                                            <td><input type="text" form="my_form" name="rrr_al_per_pni" value="<?= $amlik['rrr_al_per_pni'] ?>" class="form-control" id="rrr_al_per_pni"></td>
                                            <td><input type="text" form="my_form" name="rrrr_al_per_pni" value="<?= $amlik['rrrr_al_per_pni'] ?>" class="form-control" id="rrrr_al_per_pni"></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">d. Deposito Inti / Total DPK</th>
                                            <td><input type="text" form="my_form" name="di_per_tdpk" value="<?= $amlik['di_per_tdpk'] ?>" class="form-control" id="di_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rr_di_per_tdpk" value="<?= $amlik['rr_di_per_tdpk'] ?>" class="form-control" id="rr_di_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrr_di_per_tdpk" value="<?= $amlik['rrr_di_per_tdpk'] ?>" class="form-control" id="rrr_di_per_tdpk"></td>
                                            <td><input type="text" form="my_form" name="rrrr_di_per_tdpk" value="<?= $amlik['rrrr_di_per_tdpk'] ?>" class="form-control" id="rrrr_di_per_tdpk"></td>
                                        </tr>








                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->































                            <hr>
                            </hr>

                            <br></br>









                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>


            <!-- end row -->


            <!-- end row -->



            <!-- end row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->



</div>