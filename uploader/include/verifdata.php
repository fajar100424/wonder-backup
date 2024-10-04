<?php
require ('func/functions.php');
ob_start();
session_start();
?>
<!DOCTYPE html>
<!-- beautify ignore:start -->
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-bordered" data-assets-path="assets/" data-template="vertical-menu-template-bordered">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Konfirmasi Pendaftaran Santri |Pondok Pesantren</title>
    
    <meta name="description" content="Website Sistem Informasi Akademik Online Pondok Pesantren" />
    <meta name="keywords" content="Website Sistem Informasi Akademik Online Pondok Pesantren">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../asset/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="fonts.googleapis.com/index.html">
    <link rel="preconnect" href="fonts.gstatic.com/index.html" crossorigin>
    <link href="fonts.googleapis.com/css28ebe.css?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-bordered.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/css/fajar.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <!-- Page CSS -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-profile.css" />
    <!-- <link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/> -->

    <script type="text/javascript" src="../DataTables/datatables.min.js"></script>
    

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="async" src="www.googletagmanager.com/gtag/jsa735?id=GA_MEASUREMENT_ID"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'GA_MEASUREMENT_ID');
    </script>
    <!-- Custom notification for demo -->
    <!-- beautify ignore:end -->

</head>

<body style="background-color: #21aff329;">
<?php
if (!isset($_SESSION["login"])) {
  echo "<script>swal('Anda Belum Login!', 'Silakan Login Terlebih Dahulu!', 'error').then(function(){
    setTimeout(document.location.href = '../index.php', 100);
    });</script>";
  exit();
}
$id = $_SESSION['id_user'];
$row = query("SELECT * FROM users WHERE id_user = '$id'")[0];
$idunt = $row['id_unit'];
$unit = query("SELECT * FROM unit WHERE id_unit = '$idunt'")[0];
date_default_timezone_set('Asia/Jakarta');
if ($row['id_unit'] != "1") {
        session_unset();
        session_destroy();
        echo "<script>swal('Bukan Otoritas Anda!', 'Anda Tidak Memiliki Akses Ke Halaman Ini!', 'error').then(function(){
          setTimeout(document.location.href = '../index.php', 100);
          });</script>";
        exit();
}
$tgl = date('Y-m');
$idsan = $_GET['idsan'];
$rowsan = query("SELECT * FROM santri WHERE id_santri = '$idsan'")[0];
$idak = $rowsan['id_akun'];

$rowall = query("SELECT pendaftaran.*, akun.*,detail_pendaftaran.*,santri.*,santri.status AS 'stats_santri', santri.created_At AS 'joined' FROM akun INNER JOIN pendaftaran ON akun.id_user = pendaftaran.Id INNER JOIN detail_pendaftaran ON pendaftaran.Id = detail_pendaftaran.id_user INNER JOIN santri ON santri.id_akun = akun.Id WHERE akun.Id = '$idak'")[0];
$santri = query("SELECT * FROM santri WHERE id_santri = '$idsan'")[0];
include 'preloader.php';
?>

  <!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
  <div class="layout-container">
    
    <!-- Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

        
        <?php include 'brand.php';?>

        <div class="menu-inner-shadow"></div>

        
        
        <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="index.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Fitur &amp; Halaman</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-book-reader'></i>
            <div data-i18n="Pendaftaran">Pendaftaran</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="pendaftaran.php" class="menu-link">
                <div data-i18n="Pendaftaran Santri Baru">Pendaftaran Santri Baru</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="reportregis.php" class="menu-link">
                <div data-i18n="Laporan Pendaftaran">Laporan Pendaftaran</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Kesantrian">Kesantrian</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item active">
                <a href="santri.php" class="menu-link">
                <div data-i18n="Profile Santri">Profile Santri</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="mansantri.php" class="menu-link">
                <div data-i18n="Manajemen Kesantrian">Manajemen Kesantrian</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-briefcase"></i>
            <div data-i18n="Kepegawaian">Kepegawaian</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="pegawai.php" class="menu-link">
                <div data-i18n="Manajemen Pegawai">Manajemen Pegawai</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="job.php" class="menu-link">
                <div data-i18n="Amanah dan Tugas">Amanah dan Tugas</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="presensi.php" class="menu-link">
                <div data-i18n="Presensi">Presensi</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bxs-graduation'></i>
            <div data-i18n="Akademik">Akademik</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="tahun.php" class="menu-link">
                <div data-i18n="Tahun Ajaran">Tahun Ajaran</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="group.php" class="menu-link">
                <div data-i18n="Kelompok Ngaji">Kelompok Ngaji</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="moveclass.php" class="menu-link">
                <div data-i18n="Pindah Kelas">Pindah Kelas</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="grade.php" class="menu-link">
                <div data-i18n="Penilaian Santri">Penilaian Santri</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="graduation.php" class="menu-link">
                <div data-i18n="Kelulusan">Kelulusan</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="mapel.php" class="menu-link">
                <div data-i18n="Mata Pelajaran">Mata Pelajaran</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="jampel.php" class="menu-link">
                <div data-i18n="Jam Pelajaran">Jam Pelajaran</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="jadwal.php" class="menu-link">
                <div data-i18n="Jadwal Pelajaran">Jadwal Pelajaran</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="presensipel.php" class="menu-link">
                <div data-i18n="Presensi Pelajaran">Presensi Pelajaran</div>
                </a>
            </li>
            </ul>
        </li>


        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-wrench"></i>
            <div data-i18n="Pengaturan">Pengaturan</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="maninfo.php" class="menu-link">
                <div data-i18n="Informasi">Informasi</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="manuser.php" class="menu-link">
                <div data-i18n="Manajemen Pengguna">Manajemen Pengguna</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="maintenance.php" class="menu-link">
                <div data-i18n="Pemeliharaan">Pemeliharaan</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="logout.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-log-out"></i>
            <div data-i18n="Logout">Logout</div>
            </a>
        </li>
        </ul>
    </aside>
    <!-- / Menu -->

    

        <!-- Layout container -->
        <div class="layout-page">
        
        



        <!-- Navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        

        

        

            
            

            
            
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
                </a>
            </div>
            

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                
                <!-- Search -->
                <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                    <a class="nav-item nav-link px-0">
                    <i class="bx bx-home-circle bx-sm"></i>
                    <span>
                        <b>Profile Ananda <?=ucwords($santri['fullname']);?></b> 
                    </span>
                    
                    </a>
                </div>
                </div>
                <!-- /Search -->
                


                

                <ul class="navbar-nav flex-row align-items-center ms-auto">
                
                <!-- Language -->
                <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class='flag-icon flag-icon-id flag-icon-squared rounded-circle fs-3 me-1'></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="en">
                        <i class="flag-icon flag-icon-id flag-icon-squared rounded-circle fs-4 me-1"></i>
                        <span class="align-middle">Indonesia</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="fr">
                        <i class="flag-icon flag-icon-us flag-icon-squared rounded-circle fs-4 me-1"></i>
                        <span class="align-middle">English</span>
                        </a>
                    </li>
                    </ul>
                </li>
                <!--/ Language -->


                

                <!-- Style Switcher -->
                <li class="nav-item me-2 me-xl-0">
                    <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                    <i class='bx bx-sm'></i>
                    </a>
                </li>
                <!--/ Style Switcher -->

                <!-- Quick links  -->
                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class='bx bx-grid-alt bx-sm'></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                        <h5 class="text-body mb-0 me-auto">Pintasan</h5>
                        
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="bx bx-user fs-4"></i>
                            </span>
                            <a href="manuser.php" class="stretched-link">Aplikasi Pengguna</a>
                            <small class="text-muted mb-0">Manajemen Pengguna</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="bx bx-user-check fs-4"></i>
                            </span>
                            <a href="adduser.php" class="stretched-link">Tambah User</a>
                            <small class="text-muted mb-0">User Baru</small>
                        </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="bx bx-pie-chart-alt-2 fs-4"></i>
                            </span>
                            <a href="santri.php" class="stretched-link">Profile Santri</a>
                            <small class="text-muted mb-0">Profile Santri</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="bx bx-cog fs-4"></i>
                            </span>
                            <a href="editprof.php" class="stretched-link">Pengaturan</a>
                            <small class="text-muted mb-0">Atur Profile</small>
                        </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="bx bx-help-circle fs-4"></i>
                            </span>
                            <a href="help.php" class="stretched-link">Pusat Bantuan</a>
                            <small class="text-muted mb-0">Layanan Tanya Jawab</small>
                        </div>
                        </div>
                    </div>
                    </div>
                </li>
                <!-- Quick links -->


                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="assets/img/avatars/<?=$row['gambar'];?>" alt class="w-px-40 rounded-circle">
                    </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="profile.php">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <img src="assets/img/avatars/<?=$row['gambar'];?>" alt class="w-px-40 rounded-circle">
                            </div>
                            </div>
                            <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?=$row['fullname'];?></span>
                            <small class="text-muted"><?=ucwords($unit['unit']);?></small>
                            </div>
                        </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="profile.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="editprof.php">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="help.php">
                        <i class="bx bx-support me-2"></i>
                        <span class="align-middle">Help</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                    </ul>
                </li>
                <!--/ User -->
                

                </ul>
            </div>

            
            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper  d-none">
                <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search...">
                <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
            </div>
            
            
            </nav>
        <!-- / Navbar -->

        

    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        
        <div class="container flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="col-lg-12 mb-4">
            <div class="card">
              <div class="card-header">
                <h5 class="p"><span><button class="btn btn-sm btn-primary" style="border-radius: 25px;"><a href="profsan.php?idsan=<?=$idsan;?>" class="text-white"><i class='bx bxs-chevron-left-circle'></i> Kembali</button></a></span>  Konfirmasi Data Pendaftaran Ananda <?=ucwords($santri['fullname']);?></h5>
                <hr>
                <small class="text-light fw-semibold">Konfirmasi Data Santri Dengan Baik dan Benar ( <span class="text-danger">*</span> )</small>
              </div>
              <div class="card-body">
                
              <form method="POST" action="func/verifdata.php" enctype="multipart/form-data">
                        <input type="hidden" name="id_santri" value="<?=$rowall['id_santri'];?>">
                        <!-- Personal Details -->
                        <div id="personal-details" class="tab">
                        <hr>
                        <h5><i class="bx bx-user"></i> Data Informasi Pribadi</h5>
                        <div class="row g-3">
                            <div class="col-12">
                            <div class="row">
                                <div class="col-md mb-md-0 mb-2">
                                <div class="form-check custom-option custom-option-icon border-warning">
                                    <label class="form-check-label custom-option-content" for="customRadioBuilder">
                                    <span class="custom-option-body">
                                        <i class="bx bx-pencil"></i>
                                        <span class="custom-option-title">Saya menyetujui</span>
                                        <small>Bahwa saya yakin dan sadar akan mengisi form ini dengan data yang benar dan valid.</small>
                                    </span>
                                    <input name="acc" class="form-check-input bg-danger border-warning" type="radio" value="1" id="customRadioBuilder" checked />
                                    </label>
                                </div>
                                </div>
                                
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="anakke">Anak ke</label>
                            <input type="number" id="anakke" name="anakke" class="form-control" placeholder="1"/>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="jumlahsaudara">Jumlah Saudara</label>
                            <input type="number" id="jumlahsaudara" name="jumlahsaudara" class="form-control" placeholder="2"/>
                            </div>
                            <div class="col-sm-6">
                                        <label class="form-label" for="status_dalam_keluarga">Status Dalam Keluarga <span class="text-danger">*)</span></label>
                                        <select class="select2" id="status_dalam_keluarga" name="status_dalam_keluarga" required>
                                        <option value="0">--Pilih Status--</option>
                                        <option value="Anak Kandung">Anak Kandung</option>
                                        <option value="Anak Tiri">Anak Tiri</option>
                                        <option value="Anak Angkat">Anak Angkat</option>
                                        </select>
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                            <label class="form-label" for="nis">NISN (Nomor Induk Siswa Nasional) <span class="text-danger">*)</span></label>
                            <input type="text" id="nis" name="nis" class="form-control" placeholder="09876528" />
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="nik">NIK (Nomor Induk Kependudukan) <span class="text-danger">*)</span></label>
                            <input type="text" id="nik" name="nik" class="form-control" placeholder="098765281234567" />
                            </div>
                            <div class="col-sm-6">
                                        <label class="form-label" for="status_ayah">Status Ayah Kandung <span class="text-danger">*)</span></label>
                                        <select class="select2" id="status_ayah" name="status_ayah" required>
                                        <option value="0">--Pilih Status--</option>
                                        <option value="Masih Hidup">Masih Hidup</option>
                                        <option value="Sudah Wafat">Sudah Wafat</option>
                                        </select>
                            </div>
                            <div class="col-sm-6">
                                        <label class="form-label" for="status_ibu">Status Ibu Kandung <span class="text-danger">*)</span></label>
                                        <select class="select2" id="status_ibu" name="status_ibu" required>
                                        <option value="0">--Pilih Status--</option>
                                        <option value="Masih Hidup">Masih Hidup</option>
                                        <option value="Sudah Wafat">Sudah Wafat</option>
                                        </select>
                            </div>
                            <!-- <div class="col-sm-6">
                            <label class="form-label" for="plContact">Contact</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">US (+1)</span>
                                <input type="text" id="plContact" name="plContact" class="form-control contact-number-mask" placeholder="202 555 0111" />
                            </div>
                            </div> -->

                            
                        </div>
                        </div>

                        <!-- School Details -->
                        <div id="school-details" class="tab">
                        <hr>
                        <h5><i class="bx bx-home"></i> Data Informasi Sekolah Asal</h5>
                        <div class="row g-3">
                            <div class="col-12">
                            <div class="row">
                                <div class="col-xl mb-xl-0 mb-2">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioSell">
                                    <span class="custom-option-body">
                                        <i class="bx bx-home"></i>
                                        <span class="custom-option-title">Negeri</span>
                                        <small>Pilih jika status sekolah asal sebelumnya adalah negeri.</small>
                                    </span>
                                    <input name="status_sekolah" class="form-check-input" type="radio" value="negeri" id="customRadioSell" checked />
                                    </label>
                                </div>
                                </div>
                                <div class="col-xl mb-xl-0 mb-2">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioRent">
                                    <span class="custom-option-body">
                                        <i class="bx bx-wallet"></i>
                                        <span class="custom-option-title">Swasta</span>
                                        <small>Pilih jika status sekolah asal sebelumnya adalah swasta.<br /></small>
                                    </span>
                                    <input name="status_sekolah" class="form-check-input" type="radio" value="swasta" id="customRadioRent" />
                                    </label>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="jenis_sekolah">Jenis Sekolah Asal</label>
                            <select id="jenis_sekolah" name="jenis_sekolah" class="select2 form-select" data-allow-clear="true">
                                <option value="0">Pilih Jenis Sekolah</option>
                                <option value="PAUD">PAUD</option>
                                <option value="TK">TK</option>
                                <option value="SD">SD</option>
                                <option value="MI">MI</option>
                                <option value="SMP">SMP</option>
                                <option value="MTs">MTs</option>
                                <option value="Paket A">Paket A</option>
                                <option value="Paket B">Paket B</option>
                                <option value="Bukan Sekolah Formal">Bukan Sekolah Formal</option>
                            </select>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="nama_sekolah">Nama Sekolah <span class="text-danger">*)</span></label>
                            <input type="text" id="nama_sekolah" name="nama_sekolah" class="form-control" placeholder="SD NEGERI 1" />
                            </div>
                            <div class="col-lg-12">
                            <label class="form-label" for="alamat_sekolah">Alamat Sekolah Asal</label>
                            <textarea id="alamat_sekolah" name="alamat_sekolah" class="form-control" rows="2" placeholder="Jl. Inderalaya 12"></textarea>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="tahun_lulus">Tahun Lulus <span class="text-danger">*)</span></label>
                            <select id="tahun_lulus" class="select2 form-select" name="tahun_lulus">
                            <?php
                            for ($year = (int)date('Y'); 1900 <= $year; $year--): ?>
                                <option value="<?=$year;?>"><?=$year;?></option>
                            <?php endfor; ?>
                            </select>
                            </div>
                        </div>
                        </div>

                        <!-- Data Ayah -->
                        <div id="DataAyah" class="tab">
                        <hr>
                        <h5><i class="bx bx-male"></i> Data Ayah</h5>
                        <div class="row g-3">
                            <div class="col-sm-12">
                            <label class="form-label d-block" for="nama_ayah">Nama Ayah <span class="text-danger">*)</span></label>
                            <input type="text" id="nama_ayah" name="nama_ayah" class="form-control" placeholder="Muhammad"/>
                            </div>
                            <div class="col-sm-12">
                            <label class="form-label" for="nika">NIK <span class="text-danger">*)</span></label>
                            <input type="number" id="nika" name="nika" class="form-control" placeholder="Umumnya 16 Digit" />
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="ayah_status">Status Ayah</label>
                            <select id="ayah_status" name="ayah_status" class="select2 form-select">
                                <option value="0">Pilih Status</option>
                                <option value="Ayah Kandung">Ayah Kandung</option>
                                <option value="Ayah Tiri">Ayah Tiri</option>
                                <option value="Ayah Angkat">Ayah Angkat</option>
                            </select>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="pendidikan_ayah">Pendidikan Terakhir Ayah <span class="text-danger">*)</span></label>
                            <select id="pendidikan_ayah" name="pendidikan_ayah" class="select2 form-select">
                                <option value="0">Pilih Pendidikan</option>
                                <option value="SD/MI">SD/MI</option>
                                <option value="SLTP/MTs">SLTP/MTs</option>
                                <option value="SLTA/MA">SLTA/MA</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="Non Formal">Non Formal</option>
                            </select>
                            </div>
                            <div class="col-sm-12">
                            <label class="form-label" for="pekerjaan_ayah">Pekerjaan <span class="text-danger">*)</span></label>
                            <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                <?php
                                $koneksi = mysqli_connect("localhost","rdmittif_simak_uji","1234qwer4897","rdmittif_simak_uji");
                                $query = mysqli_query($koneksi, "SELECT * FROM pekerjaan");
                                $i = 1;
                                while ($job = mysqli_fetch_assoc($query)) {?>

                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pekerjaan_ayah[]" value="<?=$job['pekerjaan'];?>" id="defaultCheck<?=$i;?>" />
                                <label class="form-check-label" for="defaultCheck<?=$i;?>">
                                    <?=ucwords($job['pekerjaan']);?>
                                </label>
                                </div>
                                <?php $i++; }?>
                            </select>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="penghasilan_ayah">Penghasilan / Bulan <span class="text-danger">*)</span></label>
                            <select id="penghasilan_ayah" name="penghasilan_ayah" class="select2 form-select">
                                <option value="0">Pilih Penghasilan</option>
                                <option value="gol1"><= Rp 500.000</option>
                                <option value="gol2">Rp 500.001 - Rp 1.000.000</option>
                                <option value="gol3">Rp 1.000.001 - Rp 2.000.000</option>
                                <option value="gol4">Rp 2.000.001 - Rp 3.000.000</option>
                                <option value="gol5">Rp 3.000.001 - Rp 5.000.000</option>
                                <option value="gol6">> Rp 5.000.000</option>
                                <option value="gol0">Rp. 0 (sudah wafat/Tidak Berpenghasilan)</option>
                            </select>
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                            <label class="form-label" for="notelp">Nomor Whatsapp <span class="text-danger">(Yang Dapat Dihubungi)</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">IDN (+62)</span>
                                    <input type="number" name="notelp" class="form-control" placeholder="812 5556 0111"/>
                                </div>
                            </div>

                        </div>
                        </div>

                        <!-- Data Ibu -->
                        <div id="DataIbu" class="tab">
                        <hr>
                        <h5><i class="bx bx-female"></i> Data Ibu</h5>
                        <div class="row g-3">
                            <div class="col-sm-12">
                            <label class="form-label d-block" for="nama_ibu">Nama Ibu <span class="text-danger">*)</span></label>
                            <input type="text" id="nama_ibu" name="nama_ibu" class="form-control" placeholder="Siti"/>
                            </div>
                            <div class="col-sm-12">
                            <label class="form-label" for="nik_ibu">NIK <span class="text-danger">*)</span></label>
                            <input type="number" id="nik_ibu" name="nik_ibu" class="form-control" placeholder="Umumnya 16 Digit" />
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="ibu_status">Status Ibu</label>
                            <select id="ibu_status" name="ibu_status" class="select2 form-select">
                                <option selected disabled value="0">Pilih Status</option>
                                <option value="Ibu Kandung">Ibu Kandung</option>
                                <option value="Ibu Tiri">Ibu Tiri</option>
                                <option value="Ibu Angkat">Ibu Angkat</option>
                            </select>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="pendidikan_ibu">Pendidikan Terakhir Ibu <span class="text-danger">*)</span></label>
                            <select id="pendidikan_ibu" name="pendidikan_ibu" class="select2 form-select">
                                <option value="0">Pilih Pendidikan</option>
                                <option value="SD/MI">SD/MI</option>
                                <option value="SLTP/MTs">SLTP/MTs</option>
                                <option value="SLTA/MA">SLTA/MA</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="Non Formal">Non Formal</option>
                            </select>
                            </div>
                            <div class="col-sm-12">
                            <label class="form-label" for="pekerjaan_ibu">Pekerjaan <span class="text-danger">*)</span></label>
                            <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                <?php
                                $koneksi = mysqli_connect("localhost","rdmittif_simak_uji","1234qwer4897","rdmittif_simak_uji");
                                $query = mysqli_query($koneksi, "SELECT * FROM pekerjaan");
                                $i = 1;
                                while ($job = mysqli_fetch_assoc($query)) {?>

                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pekerjaan_ibu[]" value="<?=$job['pekerjaan'];?>" id="defaultCheck<?=$i;?>" />
                                <label class="form-check-label" for="defaultCheck<?=$i;?>">
                                    <?=ucwords($job['pekerjaan']);?>
                                </label>
                                </div>
                                <?php $i++; }?>
                            </select>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" for="penghasilan_ibu">Penghasilan / Bulan <span class="text-danger">*)</span></label>
                            <select id="penghasilan_ibu" name="penghasilan_ibu" class="select2 form-select">
                                <option value="0">Pilih Penghasilan</option>
                                <option value="gol1"><= Rp 500.000</option>
                                <option value="gol2">Rp 500.001 - Rp 1.000.000</option>
                                <option value="gol3">Rp 1.000.001 - Rp 2.000.000</option>
                                <option value="gol4">Rp 2.000.001 - Rp 3.000.000</option>
                                <option value="gol5">Rp 3.000.001 - Rp 5.000.000</option>
                                <option value="gol6">> Rp 5.000.000</option>
                                <option value="gol0">Rp. 0 (sudah wafat/Tidak Berpenghasilan)</option>
                            </select>
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                            <label class="form-label" for="notelp_ibu">Nomor Whatsapp <span class="text-danger">(Yang Dapat Dihubungi)</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">IDN (+62)</span>
                                    <input type="number" name="notelp_ibu" class="form-control" placeholder="812 5556 0111"/>
                                </div>
                            </div>
                            
                        </div>
                        </div>

                        <!-- Data Penunjang -->
                        <div id="DataPenunjang" class="tab">
                        <hr>
                        <h5><i class="bx bxs-buildings"></i> Data Alamat Orang Tua/Wali</h5>
                        <div class="row g-3">
                            
                            <div class="col-sm-6">
                            <label class="form-label" for="form_prov">Pilih Provinsi<span class="text-danger">*)</span></label>
                            <select class="select2 form-select form-control-sm" name="form_prov" id="form_prov">
                                <option value="0">Pilih Provinsi</option>
                                <?php 
                                $daerah = mysqli_query($koneksi,"SELECT kode,nama FROM wilayah_2020 WHERE CHAR_LENGTH(kode)=2 ORDER BY nama");
                                while($d = mysqli_fetch_array($daerah)){
                                ?>
                                <option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
                                <?php 
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="form_kab">Pilih Kabupaten<span class="text-danger">*)</span></label>
                                <select class="select2 form-select form-control-sm" name="form_kab" id="form_kab">
                                <option value="0">Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="form_kec">Pilih Kecamatan<span class="text-danger">*)</span></label>
                                <select class="select2 form-select form-control-sm" name="form_kec" id="form_kec">
                                <option value="0">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="form_des">Pilih Desa<span class="text-danger">*)</span></label>
                                <select class="select2 form-select form-control-sm" name="form_des" id="form_des">
                                <option value="0">Pilih Desa</option>
                                </select>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function(){

                                // sembunyikan form kabupaten, kecamatan dan desa
                                $("#form_kab").hide();
                                $("#form_kec").hide();
                                $("#form_des").hide();

                                // ambil data kabupaten ketika data memilih provinsi
                                $('body').on("change","#form_prov",function(){
                                    var id = $(this).val();
                                    var data = "id="+id+"&data=kabupaten";
                                    $.ajax({
                                    type: 'POST',
                                    url: "../daftar/getdaerah.php",
                                    data: data,
                                    success: function(hasil) {
                                        $("#form_kab").html(hasil);
                                        $("#form_kab").show();
                                        $("#form_kec").hide();
                                        $("#form_des").hide();
                                    }
                                    });
                                });

                                // ambil data kecamatan/kota ketika data memilih kabupaten
                                $('body').on("change","#form_kab",function(){
                                    var id = $(this).val();
                                    var data = "id="+id+"&data=kecamatan";
                                    $.ajax({
                                    type: 'POST',
                                    url: "../daftar/getdaerah.php",
                                    data: data,
                                    success: function(hasil) {
                                        $("#form_kec").html(hasil);
                                        $("#form_kec").show();
                                        $("#form_des").hide();
                                    }
                                    });
                                });

                                // ambil data desa ketika data memilih kecamatan/kota
                                $('body').on("change","#form_kec",function(){
                                    var id = $(this).val();
                                    var data = "id="+id+"&data=desa";
                                    $.ajax({
                                    type: 'POST',
                                    url: "../daftar/getdaerah.php",
                                    data: data,
                                    success: function(hasil) {
                                        $("#form_des").html(hasil);
                                        $("#form_des").show();
                                    }
                                    });
                                });


                                });
                            </script>
                            <div class="col-sm-6">
                                <label class="form-label" for="rtrw">RT / RW /No Rumah<span class="text-danger">*)</span></label>
                                <input type="text" class="form-control" name="rtrw" id="rtrw" placeholder="001/002/340">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="jalan">Jalan<span class="text-danger">*)</span></label>
                                <input type="text" class="form-control" name="jalan" id="jalan" placeholder="Jalan Inderalaya No 35">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="kodepos">Kode POS<span class="text-danger">*)</span></label>
                                <input type="text" class="form-control" name="kodepos" id="kodepos" placeholder="001135">
                            </div>
                            <hr>
                            <h5><i class="bx bx-note"></i> Data Penunjang Lainnya</h5>
                            <div class="col-sm-12">
                                <label class="form-label" for="transport">Transportasi dari Rumah ke Pondok <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="transport[]" value="jalan kaki" id="defaultCheck1"/>
                                    <label class="form-check-label" for="defaultCheck1">
                                    Jalan Kaki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="transport[]" value="sepeda motor" id="defaultCheck2" />
                                    <label class="form-check-label" for="defaultCheck2">
                                    Sepeda Motor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="transport[]" value="mobil pribadi" id="defaultCheck3" />
                                    <label class="form-check-label" for="defaultCheck3">
                                    Mobil Pribadi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="transport[]" value="Angkutan Umum" id="defaultCheck4" />
                                    <label class="form-check-label" for="defaultCheck4">
                                    Angkutan Umum
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="transport[]" value="mukim" id="defaultCheck5" />
                                    <label class="form-check-label" for="defaultCheck5">
                                    Mukim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="transport[]" value="lainnya" id="defaultCheck6" />
                                    <label class="form-check-label" for="defaultCheck6">
                                    Lainnya
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="penyakit">Penyakit diderita <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Data medis akan dilaporkan kepada kepengasuhan dan unit kesehatan pondok guna antisipasi, pencegahan dan tindakan medis lainnya. <span class="text-danger"> Jika Tidak Ada Harap tetap diisi dengan "Tidak Ada Riwayat Penyakit"</span></small>
                                <textarea id="penyakit" name="penyakit" class="form-control" rows="2" placeholder="TBC, Diabetes, Demam, Dll"></textarea>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="bahasa">Penguasaan Bahasa <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="bahasa[]" value="Inggris" id="defaultCheck1" />
                                    <label class="form-check-label" for="defaultCheck1">
                                    Bahasa Inggris
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="bahasa[]" value="Arab" id="defaultCheck2" />
                                    <label class="form-check-label" for="defaultCheck2">
                                    Bahasa Arab
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="bahasa[]" value="Jepang" id="defaultCheck3" />
                                    <label class="form-check-label" for="defaultCheck3">
                                    Bahasa Jepang
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="bahasa[]" value="Mandarin" id="defaultCheck4" />
                                    <label class="form-check-label" for="defaultCheck4">
                                    Bahasa Mandarin
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="hafalan">Hafalan Al-Quran <span class="text-danger">*)</span></label>
                                    <select class="select2" id="hafalan" name="hafalan" required>
                                    <option value="0">--Jumlah Hafalan--</option>
                                    <option value="Belum Ada">Belum Ada</option>
                                    <?php for ($j=1; $j < 31; $j++) { ?>
                                        <option value="<?=$j;?>"><?=$j;?> Juz</option>
                                    <?php } ?>
                                    </select>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="hobi">Hobi <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Data Ini digunakan untuk mengetahui minat dan bakat anak</small>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="olahraga" id="defaultCheck1" />
                                    <label class="form-check-label" for="defaultCheck1">
                                    Olahraga
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="kesenian" id="defaultCheck2" />
                                    <label class="form-check-label" for="defaultCheck2">
                                    Kesenian
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="membaca" id="defaultCheck3" />
                                    <label class="form-check-label" for="defaultCheck3">
                                    Membaca
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="menulis" id="defaultCheck4" />
                                    <label class="form-check-label" for="defaultCheck4">
                                    Menulis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="traveling" id="defaultCheck4" />
                                    <label class="form-check-label" for="defaultCheck4">
                                    Traveling
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="lainnya" id="defaultCheck4" />
                                    <label class="form-check-label" for="defaultCheck4">
                                    Lainnya
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="info">Info Lainnya <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Informasi yang perlu perhatian khusus pada calon santri, seperti kebiasaan buruk dan lain sebagainya <span class="text-danger">(Harus diisi agar tidak kosong)</span></small>
                                <textarea id="info" name="info" class="form-control" rows="2"></textarea>
                            </div>
                            <h5><i class="bx bx-book"></i> Upload Data Berkas</h5>
                            <div class="col-sm-12">
                                <label class="form-label" for="kk">Kartu Keluarga <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Gambar dan tulisan yang dikirim harus bisa terbaca</small>
                                <div class="button-wrapper">
                                            <label for="kk" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload Berkas Kartu Keluarga</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="kk" name="kk" class="form-control"/>
                                            </label>
                                            <p class="text-muted mb-0">Format yang diizinkan PDF,JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="ktp_ayah">KTP Ayah <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Gambar dan tulisan yang dikirim harus bisa terbaca</small>
                                <div class="button-wrapper">
                                            <label for="ktp_ayah" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload Berkas KTP Ayah</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="ktp_ayah" name="ktp_ayah" class="form-control"/>
                                            </label>
                                            <p class="text-muted mb-0">Format yang diizinkan PDF,JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="ktp_ibu">KTP Ibu <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Gambar dan tulisan yang dikirim harus bisa terbaca</small>
                                <div class="button-wrapper">
                                            <label for="ktp_ibu" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload Berkas KTP Ibu</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="ktp_ibu" name="ktp_ibu" class="form-control"/>
                                            </label>
                                            <p class="text-muted mb-0">Format yang diizinkan PDF,JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="akta_kelahiran">Akta Kelahiran <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Gambar dan tulisan yang dikirim harus bisa terbaca</small>
                                <div class="button-wrapper">
                                            <label for="akta_kelahiran" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload Berkas Akta Kelahiran</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="akta_kelahiran" name="akta_kelahiran" class="form-control"/>
                                            </label>
                                            <p class="text-muted mb-0">Format yang diizinkan PDF,JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <label class="form-label" for="pas_foto">Pas Foto Berwarna <span class="text-danger">*)</span></label>
                                <div class="button-wrapper">
                                            <label for="pas_foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload Berkas Pas Foto Berwarna</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="pas_foto" name="pas_foto" class="form-control"/>
                                            </label>
                                            <p class="text-muted mb-0">Format yang diizinkan JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="conregis" class="form-label">Verifikasi Pendaftaran <span class="text-danger">*</span></label>
                                <select name="conregis" id="conregis" class="select2 form-select" required>
                                    <option value="0">-- Verifikasi --</option>
                                    <option value="4">Tolak</option>
                                    <option value="3">Diterima</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="switch switch-primary">
                                    <input type="checkbox" class="switch-input" name="formValidationSwitch" />
                                    <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label">Saya dengan yakin mengonfirmasi data santri dengan benar dan sadar ( <span class="text-danger">*</span> )</span>
                                </label>
                            </div>
                            
                        </div>
                        </div>
                        <hr/>
                        <div style="overflow:auto;">
                        <div style="float:right;">
                            <button class="btn btn-success" type="submit" name="submitButton">Konfirmasi &raquo;</button>
                        </div>
                        </div>
                    </form>
                
              </div>
            </div>
            </div>
        </div>



        <!--/ Header -->
        <!-- Navbar pills -->
        
        <!--/ Navbar pills -->




        </div>
    </div>
    <!-- Content wrapper -->
        
        <?php
        include 'footer.php';
        ?>
        </div>
        <!-- / Layout container -->
    </div>

    
    
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->

  

  
  <!-- Core JS -->
  <script src="assets/js/fajar.js"></script>
  <!-- build:js assets/vendor/js/core.js -->
  <!-- <script src="assets/vendor/libs/jquery/jquery.js"></script> -->
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/js/bootstrap.js"></script>
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  
  <script src="assets/vendor/libs/hammer/hammer.js"></script>
  <script src="assets/vendor/libs/i18n/i18n.js"></script>
  <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
  
  <script src="assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
  <script src="assets/vendor/libs/select2/select2.js"></script>
  <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
<script src="assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
<script src="assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
<script src="assets/vendor/libs/cleavejs/cleave.js"></script>
<script src="assets/vendor/libs/cleavejs/cleave-phone.js"></script>

<script src="assets/vendor/libs/moment/moment.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="assets/js/dashboards-ecommerce.js"></script>
  <script src="assets/js/pages-account-settings-account.js"></script>
    <script src="assets/js/pages-auth-multisteps.js"></script>
</body>
</html>
