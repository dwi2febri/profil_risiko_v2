

<?php
include "../fungsi/fungsi.php";
if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $lokasi_kerja = $_POST['lokasi_kerja'];
    $tahun = $_POST['tahun'];
    $user = $_POST['user'];
    $periode = $_POST['periode'];
    $modal_inti = $_POST['modal_inti'];
    $total_aset = $_POST['total_aset'];
    $keterangan = $_POST['keterangan'];
    

    $dibuat_at = date('Y-m-d');
    $dibuat_by = $_SESSION['user_id'];
    $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ");
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <script>$.NotificationApp.send("Gagal","Your awesome message text","Position","Background color","Icon")</script>
        ';
    } else {
        mysqli_query($conn, "INSERT INTO frame_laporan_profil_risiko(id_profil_risiko,kantor_cabang,tahun,user,periode,modal_inti,total_aset,keterangan,dibuat_at,dibuat_by)
        VALUES ('0','$lokasi_kerja','$tahun','$user','$periode','$modal_inti','$total_aset','$keterangan','$dibuat_at','$dibuat_by')");

        //kre
        mysqli_query($conn, "INSERT INTO master_kredit_pilar1(id_mk_pilar1,id_profil_risiko,dibuat_by,total_aset)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by','$total_aset')");

        mysqli_query($conn, "INSERT INTO master_kredit_pilar2(id_mk_pilar2,id_profil_risiko,dibuat_by,modal_inti)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by','$modal_inti')");

        mysqli_query($conn, "INSERT INTO master_kredit_pilar3(id_mk_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

      

        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar1(id_inheren_kredit_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar2(id_inheren_kredit_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar3(id_inheren_kredit_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar4(id_inheren_kredit_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_kredit_lainnya(id_inheren_kredit_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_inheren_kredit(id_hasil_inheren_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        

        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar1(id_kpmr_kredit_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar2(id_kpmr_kredit_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar3(id_kpmr_kredit_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar4(id_kpmr_kredit_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_kpmr_kredit(id_hasil_kpmr_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil1(id_respon_kredit_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil2(id_respon_kredit_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil3(id_respon_kredit_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil4(id_respon_kredit_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_kredit(id_kpmr2_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren_kredit(id_keterangan_inheren_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_profil_kredit(id_ket_profil_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        



        //op
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar1(id_inheren_operasional_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar2(id_inheren_operasional_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar3(id_inheren_operasional_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar4(id_inheren_operasional_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar5(id_inheren_operasional_pilar5,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_operasional_lainnya(id_inheren_operasional_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar1(id_ket_inheren_operasional_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar2(id_ket_inheren_operasional_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar3(id_ket_inheren_operasional_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar4(id_ket_inheren_operasional_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar5(id_ket_inheren_operasional_pilar5,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_lainnya(id_ket_inheren_operasional_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar1(id_kpmr_operasional_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar2(id_kpmr_operasional_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar3(id_kpmr_operasional_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar4(id_kpmr_operasional_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
    
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil1(id_respon_operasional_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil2(id_respon_operasional_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil3(id_respon_operasional_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil4(id_respon_operasional_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        




        mysqli_query($conn, "INSERT INTO hasil_inheren_operasional(id_hasil_inheren_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_kpmr_operasional(id_hasil_kpmr_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren2_operasional(id_keterangan_inheren2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_operasional(id_kpmr2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_operasional(id_ket_profil_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        


        //kep
        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_pilar1(id_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_pilar2(id_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_lainnya(id_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar1(id_ket_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar2(id_ket_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_lainnya(id_ket_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar1(id_kpmr_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar2(id_kpmr_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar3(id_kpmr_kepatuhan_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar4(id_kpmr_kepatuhan_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil1(id_respon_kepatuhan_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil2(id_respon_kepatuhan_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil3(id_respon_kepatuhan_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil4(id_respon_kepatuhan_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        


        mysqli_query($conn, "INSERT INTO hasil_inheren_kepatuhan(id_hasil_inheren_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_kepatuhan(id_hasil_kpmr_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_kepatuhan(id_keterangan_inheren2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_kepatuhan(id_kpmr2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_kepatuhan(id_ket_profil_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");


        //lik
        mysqli_query($conn, "INSERT INTO master_likuiditas_pilar1(id_ml_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_likuiditas_pilar1(id_inheren_likuiditas_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_likuiditas_pilar2(id_inheren_likuiditas_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_likuiditas_lainnya(id_inheren_likuiditas_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_inheren_likuiditas(id_hasil_inheren_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren_likuiditas(id_keterangan_inheren_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        


       
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar1(id_kpmr_likuiditas_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar2(id_kpmr_likuiditas_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar3(id_kpmr_likuiditas_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar4(id_kpmr_likuiditas_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil1(id_respon_likuiditas_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil2(id_respon_likuiditas_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil3(id_respon_likuiditas_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil4(id_respon_likuiditas_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        


       
        mysqli_query($conn, "INSERT INTO hasil_kpmr_likuiditas(id_hasil_kpmr_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

      
        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_likuiditas(id_kpmr2_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_likuiditas(id_ket_profil_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");





        //rep
        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar1(id_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar2(id_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar3(id_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_lainnya(id_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar1(id_ket_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar2(id_ket_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar3(id_ket_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_lainnya(id_ket_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");



        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar1(id_kpmr_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar2(id_kpmr_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar3(id_kpmr_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar4(id_kpmr_reputasi_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil1(id_respon_reputasi_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil2(id_respon_reputasi_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil3(id_respon_reputasi_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil4(id_respon_reputasi_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        



        mysqli_query($conn, "INSERT INTO hasil_inheren_reputasi(id_hasil_inheren_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_reputasi(id_hasil_kpmr_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_reputasi(id_keterangan_inheren2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_reputasi(id_kpmr2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_reputasi(id_ket_profil_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");



        //stra
        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar1(id_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar2(id_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar3(id_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_lainnya(id_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar1(id_ket_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar2(id_ket_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar3(id_ket_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_lainnya(id_ket_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");



        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar1(id_kpmr_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar2(id_kpmr_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar3(id_kpmr_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar4(id_kpmr_stratejik_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil1(id_respon_stratejik_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil2(id_respon_stratejik_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil3(id_respon_stratejik_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil4(id_respon_stratejik_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_inheren_stratejik(id_hasil_inheren_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_stratejik(id_hasil_kpmr_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_stratejik(id_keterangan_inheren2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_stratejik(id_kpmr2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_stratejik(id_ket_profil_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");




        mysqli_query($conn, "INSERT INTO nilai_profil(id_nilai_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO peringkat_profil(id_peringkat_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

        header("Location: index.php?page=menulapawal");
        exit();
    }
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Buat laporan</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Menu Profil Risiko</h4>
                                </div>
                            </div>
                        </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tabel Riwayat Laporan yang Dibuat</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User

                            </p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup-modal">Tambah Laporan</button>
                            <div id="signup-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-body">

                                            <div class="text-center mt-2 mb-4">

                                                <h4><b>PEMBUATAN LAPORAN BARU</b></h4>

                                            </div>
                                            <form class="ps-3 pe-3" action="" method="POST" enctype="multipart/form-data">

                                                <div class="mb-3" style="pointer-events: none;">
                                                    <label for="kc" class="form-label">Kantor Cabang</label>
                                                    <select class="form-select mb-3" name="lokasi_kerja" id="kc" required="">
                                                        <?php
                                                        include "../conn/conn.php";
                                                        $kode_kantor = $_SESSION['lokasi_kerja'];
                                                        $query_cabang = mysqli_query($conn, "SELECT * FROM jenis_cabang");
                                                        while ($data = mysqli_fetch_array($query_cabang)) { ?>
                                                            <option value="<?= $data['id_cabang'] ?>" <?= $data['id_cabang'] == $kode_kantor ? ' selected' : '' ?>><?= ucwords($data['cabang']) ?></option>
                                                        <?php
                                                        };
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tahun" class="form-label">Tahun</label>
                                                    <select class="form-select mb-3" name="tahun" id="tahun" required="">
                                                        <option value=" " selected> </option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                        <option value="2032">2032</option>
                                                        <option value="2033">2033</option>
                                                        <option value="2034">2034</option>
                                                        <option value="2035">2035</option>
                                                        <option value="2036">2036</option>
                                                        <option value="2037">2037</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="user" class="form-label">Jenis Profil Risiko</label>

                                                    <select class="form-select mb-3" name="user" id="user" required="">
                                                    <option value=" " selected> </option>
                                                                <?php
                                                                include "../conn/conn.php";
                                                                $query_periode = mysqli_query($conn, "SELECT * FROM user_profil_risiko");
                                                                while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                    <option value="<?= $data['id_user_profil_risiko'] ?>"><?= ucwords($data['tipe_user']) ?></option>
                                                                <?php
                                                                };
                                                                ?>
                                                    </select>

                                                </div>

                                                

                                                <div class="mb-3">
                                                    <label for="periode" class="form-label">Periode</label>
                                                    <select class="form-select mb-3" name="periode" id="periode" required="">
                                                    <option value=" " selected> </option>
                                                                <?php
                                                                include "../conn/conn.php";
                                                                $query_periode = mysqli_query($conn, "SELECT * FROM periode_laporan_profil_risiko");
                                                                while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                    <option value="<?= $data['id_periode'] ?>"><?= ucwords($data['periode_laporan']) ?></option>
                                                                <?php
                                                                };
                                                                ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="modal_inti" class="form-label">Modal Inti</label>
                                                    <input type="number" name="modal_inti" class="form-control" id="modal_inti" required="">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="total_aset" class="form-label">Total Aset</label>
                                                    <input type="number" name="total_aset" class="form-control" id="total_aset" required="">
                                                </div>


                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea type="text" name="keterangan" class="form-control" id="keterangan" required=""></textarea>
                                                </div>



                                                <div class="mb-3 text-center">
                                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <hr>
                            </hr>










                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>

                                                <th>
                                                    <center>Aksi</center>
                                                </th>
                                                <th>
                                                    <center>Tindak Lanjut</center>
                                                </th>
                                                <th>
                                                    <center>Kantor Cabang</center>
                                                </th>
                                                <th>
                                                    <center>Tahun</center>
                                                </th>
                                                <th>
                                                    <center>Jenis Profil Risiko</center>
                                                </th>
                                                <th>
                                                    <center>Periode</center>
                                                </th>
                                                <th>
                                                    <center>Modal Inti</center>
                                                </th>
                                                <th>
                                                    <center>Total Aset</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat</center>
                                                </th>
                                                <th>
                                                    <center>Keterangan</center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../conn/conn.php";
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $id_user = $_SESSION['user_id'];
                                            $cabang_awal = 22;
                                            $cabang_akhir = 28;
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE frame_laporan_profil_risiko.kantor_cabang BETWEEN '$cabang_awal' AND '$cabang_akhir' order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=menulapawal&id=<?= $data['id_profil_risiko'] ?>"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['id_profil_risiko'] == $id) echo 'checked'; ?> disabled></i> aktifkan</a>
                                                            | <a href="../kepala_wilayah_pekalongan/laporan/cetak_laporan_kc.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank"> cetak </a> |
                                                            <a href="index.php?page=delete_frame&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin menghapus data?');"><i class=" mdi mdi-delete"></i>hapus</a>
                                                        </center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="../kepala_wilayah_pekalongan/laporan/cetak_tindak_lanjut.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank"> cetak </a>
                                                           
                                                        </center>
                                                    </td>

                                                    <td>
                                                        <center><?= $data['cabang'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tipe_user'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['periode_laporan']) ?></center>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($data['modal_inti']) ?>
                                                    <td>
                                                        Rp. <?= rupiah($data['total_aset']) ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= ucwords($data['dibuat_at']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['nama']) ?></center>
                                                    </td>
                                                    <td>
                                                        <?= ucwords($data['keterangan']) ?>
                                                    </td>

                                                   





                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->


                            </div> <!-- end tab-content-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container -->

    </div>
    <!-- content -->
</div>
<style id="oaiMenuLaporanActionAlign">
.table-action center{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:4px !important;
    white-space:nowrap !important;
    min-width:210px !important;
}
.table-action center a{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:3px !important;
    white-space:nowrap !important;
    line-height:1.2 !important;
}
.table-action center input[type="checkbox"]{
    flex:0 0 auto !important;
    margin:0 3px 0 0 !important;
    vertical-align:middle !important;
}
.table-action center i{
    display:inline-flex !important;
    align-items:center !important;
    line-height:1 !important;
}
</style>

