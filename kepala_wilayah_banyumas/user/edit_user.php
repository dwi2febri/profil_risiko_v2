<?php
require dirname(__DIR__, 2).'/conn/conn.php';
$id = $_GET['id'];
$call_data = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM user WHERE user_id = ?", [$id]));
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $gender = $_POST['gender'];
    $jabatan = $_POST['jabatan'];
    $password = $_POST['password'];
    $tipe = $_POST['tipe'];
    $lokasi_kerja = $_POST['lokasi_kerja'];
    $query = simpro_db_query($conn, "SELECT * FROM user WHERE username = ?", [$username]);
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
            <script type="text/javascript">
            
            $(document).ready(function(){
            
              swal({
                position: "top",
                type: "error",
                title: "Gagal...!",
                showConfirmButton: false,
                text: "Username sudah ada...!",
                timer: 2500
              })
            });
            
            </script>
            ';
    } else {
        simpro_db_query($conn, "UPDATE user SET username=?,nama=?,gender=?,jabatan=?,
        password=?,tipe=?,lokasi_kerja=? WHERE user_id = ?", [$username, $nama, $gender, $jabatan, $password, $tipe, $lokasi_kerja, $id]);
        header("Location: index.php?page=list_user");
        exit();
    }
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tambahkan Akun Pengguna Baru</h4>
                            <p class="text-muted font-14">Isi form di bawah ini untuk menambahkan user baru
                            </p>


                            <div class="tab-content">
                                <div class="tab-pane show active" id="custom-styles-preview">
                                    <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom01">Username</label>
                                            <input type="text" class="form-control" id="validationCustom01" name="username" value="<?= $call_data['username'] ?>" placeholder="masukan username" required="">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom02">Password</label>
                                            <input type="password" class="form-control" id="validationCustom02" name="password" value="<?= $call_data['password'] ?>" placeholder="masukan password" required="">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="validationCustom03" name="nama" value="<?= $call_data['nama'] ?>" placeholder="masukan nama" required="">
                                            <div class="invalid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom04">Jabatan</label>
                                            <input type="text" class="form-control" id="validationCustom04" name="jabatan" value="<?= $call_data['jabatan'] ?>" placeholder="masukan jabatan" required="">
                                            <div class="invalid-feedback">
                                                Looks good!
                                            </div>
                                        </div>


                                        <label class="form-label" for="validationCustom05">Gender</label>
                                        <select class="form-select mb-3" name="gender" id="validationCustom05">
                                            <option value="laki-laki" <?= $call_data['gender'] == "laki-laki" ? "selected" : ""  ?>>Laki-Laki</option>
                                            <option value="perempuan" <?= $call_data['gender'] == "perempuan" ? "selected" : ""  ?>>Perempuan</option>
                                        </select>

                                        <label class="form-label" for="validationCustom06">Tipe User</label>
                                        <select class="form-select mb-3" name="tipe" id="validationCustom06">
                                            <option value="kepala cabang" <?= $call_data['tipe'] == "kepala cabang" ? "selected" : ""  ?>>Kepala Cabang</option>

                                            <option value="admin" <?= $call_data['tipe'] == "admin" ? "selected" : ""  ?>>Admin</option>
                                        </select>


                                        <label class="form-label" for="validationCustom07">Lokasi Kerja

                                        </label>

                                        <select class="form-select mb-3" name="lokasi_kerja" id="validationCustom07">
                                            <?php
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $query_cabang = mysqli_query($conn, "SELECT * FROM jenis_cabang");
                                            while ($data = mysqli_fetch_array($query_cabang)) { ?>
                                                <option value="<?= $data['id_cabang'] ?>" <?= $data['id_cabang'] == $call_data['lokasi_kerja'] ? ' selected' : '' ?>><?= ucwords($data['cabang']) ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a work place.
                                        </div>

                                        <div class="col-lg-12 ms-auto">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div> <!-- end preview-->
                            </div> <!-- end tab-content-->

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

            </div>
            <!-- end row -->
        </div>
    </div>
</div>