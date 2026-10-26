<?php
session_start();
                                include "conn/conn.php";
                                $user_id = $_SESSION['user_id'];
                                $nama = $_SESSION['nama'];
                                $username = $_SESSION['username'];
                                $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id ='$user_id'"));
 

                                    if ($data['tipe'] == "admin") {
                                        header("location:admin/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala cabang") {
                                        header("location:kepala_cabang/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "admin kc") {
                                        header("location:admin_kc/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala wilayah semarang") {
                                        header("location:kepala_wilayah_semarang/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala wilayah solo") {
                                        header("location:kepala_wilayah_solo/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala wilayah banyumas") {
                                        header("location:kepala_wilayah_banyumas/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala wilayah pekalongan") {
                                        header("location:kepala_wilayah_pekalongan/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi pemasaran") {
                                        header("location:kadiv_pemasaran/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi penyelesaian kredit") {
                                        header("location:kadiv_penyelesaian_kredit/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi operasional") {
                                        header("location:kadiv_operasional/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi sdm") {
                                        header("location:kadiv_sdm/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi kepatuhan") {
                                        header("location:kadiv_kepatuhan/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi sekper") {
                                        header("location:kadiv_sekper/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi litbang") {
                                        header("location:kadiv_litbang/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "kepala divisi skai") {
                                        header("location:satker_skai/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "direksi") {
                                        header("location:direksi/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "pic semarang") {
                                        header("location:pic_area_semarang/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "pic solo") {
                                        header("location:pic_area_solo/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "pic pekalongan") {
                                        header("location:pic_area_pekalongan/index.php");
                                        exit();
                                    } elseif ($data['tipe'] == "pic banyumas") {
                                        header("location:pic_area_banyumas/index.php");
                                        exit();
                                    }
                
                            
                            ?>