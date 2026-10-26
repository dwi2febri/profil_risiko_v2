<?php include "verif.php"; ?>
<?php
include "../conn/conn.php";
$user_id = $_SESSION['user_id'];
$data_profile = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'"));
if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    mysqli_query($conn, "UPDATE user SET password = '$password' WHERE user_id = '$user_id'");
    header("Location: index.php?page=profile");
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

                        <h4 class="page-title">Profil User</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <!-- end row -->



            <div class="row">
                <div class="col-sm-12">
                    <!-- Profile -->
                    <div class="card bg-secondary">
                        <div class="card-body profile-user-box">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-lg">
                                                <img src="../assets/images/users/avatar.png" alt="" class="rounded-circle img-thumbnail">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <h4 class="mt-1 mb-1 text-white"><?= ucwords($data_profile['nama']) ?></h4>
                                                <p class="font-13 text-white-50"> Nama</p>

                                                <ul class="mb-0 list-inline text-light">
                                                    <li class="list-inline-item me-3">
                                                        <h5 class="mb-1"><?= ucwords($data_profile['jabatan']) ?></h5>
                                                        <p class="mb-0 font-13 text-white-50">Jabatan</p>
                                                    </li>

                                                    <li class="list-inline-item me-3">
                                                        <h5 class="mb-1"><?= ucwords($data_profile['username']) ?></h5>
                                                        <p class="mb-0 font-13 text-white-50">Username</p>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <h5 class="mb-1"><?= ucwords($data_profile['password']) ?></h5>
                                                        <p class="mb-0 font-13 text-white-50">Password</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col-->





                                <div class="col-sm-8">
                                    <div class="row align-items-center">
                                        <div class="col-auto">

                                            <br></br>

                                            <form action="" method="POST">
                                                <div class="mb-3">
                                                    <h4 class="mt-1 mb-1 text-white">Ganti Password</h4>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" name="password" id="password" class="form-control" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^A-Za-z0-9_@#$%^&*()+=]/, '')" placeholder="Enter your password">
                                                        <div class="input-group-text" data-password="false">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 mb-0 text-center">
                                                    <button name="submit" type="submit" class="btn btn-light"><i class="mdi mdi-account-edit me-1"></i>Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end row -->

                        </div> <!-- end card-body/ profile-user-box-->
                    </div><!--end profile/ card -->
                </div> <!-- end col-->
            </div>

            <!-- end row -->



            <!-- end row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->



</div>