<?php
if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $gender = $_POST['gender'];
    $jabatan = $_POST['jabatan'];
    $password = $_POST['password'];
    $tipe = $_POST['tipe'];
    $lokasi_kerja = $_POST['lokasi_kerja'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
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
        mysqli_query($conn, "INSERT INTO user(user_id,username,password,nama,gender,jabatan,tipe,lokasi_kerja)
        VALUES ('0','$username','$password','$nama','$gender','$jabatan','$tipe','$lokasi_kerja')");
        echo '
        <script type="text/javascript">
        
        $(document).ready(function(){
        
          swal({
            position: "top",
            type: "success",
            title: "Berhasi;",
            showConfirmButton: false,
            timer: 2500
          })
        });
        
        </script>
        ';

        header("Location: index.php?page=list_user");
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
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Data User</h4>
                            <p class="text-muted font-14">
                                Tabel Data User Aplikasi Profil Risiko

                            </p>
                           
                            <hr>
                            </hr>


                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>
                                                <th>
                                                    <center>Username</center>
                                                </th>
                                                <th>
                                                    <center>Password</center>
                                                </th>
                                                <th>
                                                    <center>Nama</center>
                                                </th>
                                                <th>
                                                    <center>Gender</center>
                                                </th>
                                                <th>
                                                    <center>Jabatan</center>
                                                </th>
                                                <th>
                                                    <center>Action</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../conn/conn.php";
                                            $no = 1;
                                            $query = mysqli_query($conn, "SELECT * FROM user order by user_id desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['username'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['password'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['nama']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['gender'] == "laki-laki" ? "L" : "P" ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= strtoupper($data['jabatan']) ?></center>
                                                    </td>


                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=edit_user&id=<?= $data['user_id'] ?>"> <i class="mdi mdi-pencil"></i>edit</a>
                                                            |
                                                            <a href="index.php?page=delete_user&id=<?= $data['user_id'] ?>"><i class=" mdi mdi-delete"></i>delete</a>
                                                        </center>
                                                    </td>


                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->


                            </div> <!-- end tab-content-->

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


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
                                            <input type="text" class="form-control" id="validationCustom01" name="username" placeholder="masukan username" required="" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^A-Za-z0-9_@#$%^&*()+=]/, '')">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom02">Password</label>
                                            <input type="password" class="form-control" id="validationCustom02" name="password" placeholder="masukan password"  required="" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^A-Za-z0-9_@#$%^&*()+=]/, '')">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="validationCustom03" name="nama" placeholder="masukan nama" required="">
                                            <div class="invalid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom04">Jabatan</label>
                                            <input type="text" class="form-control" id="validationCustom04" name="jabatan" placeholder="masukan jabatan" required="">
                                            <div class="invalid-feedback">
                                                Looks good!
                                            </div>
                                        </div>


                                        <label class="form-label" for="validationCustom05">Gender</label>
                                        <select class="form-select mb-3" name="gender" id="validationCustom05">
                                            <option value="laki-laki" selected>Laki-Laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>

                                        <label class="form-label" for="validationCustom06">Tipe User</label>
                                        <select class="form-select mb-3" name="tipe" id="validationCustom06">
                                            <option value="kepala cabang">Kepala Cabang</option>
                                            <option value="admin" selected>Admin</option>
                                            <option value="direksi">Direksi</option>
                                            <option value="kepala wilayah semarang">Kepala Wilayah Semarang</option>
                                            <option value="kepala wilayah solo">Kepala Wilayah Solo</option>
                                            <option value="kepala wilayah banyumas">Kepala Wilayah Banyumas</option>
                                            <option value="kepala wilayah pekalongan">Kepala Wilayah Pekalongan</option>

                                            <option value="pic semarang">Pic Area Semarang</option>
                                            <option value="pic solo">Pic Area Solo</option>
                                            <option value="pic banyumas">Pic Area Banyumas</option>
                                            <option value="pic pekalongan">Pic Area Pekalongan</option>
                                        </select>


                                        <label class="form-label" for="validationCustom07">Lokasi Kerja

                                        </label>

                                        <select class="form-select mb-3" name="lokasi_kerja" id="validationCustom07">
                                            <?php
                                            include "../conn/conn.php";
                                            $query_cabang = mysqli_query($conn, "SELECT * FROM jenis_cabang");
                                            while ($data = mysqli_fetch_array($query_cabang)) { ?>
                                                <option value="<?= $data['id_cabang'] ?>"><?= ucwords($data['cabang']) ?></option>
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
        <!-- container -->

    </div>
    <!-- content -->
</div>