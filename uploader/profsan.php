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

    <title>Profile | SISPPI</title>
    
    <meta name="description" content="Website Sistem Informasi Akademik Online Pondok Pesantren" />
    <meta name="keywords" content="Website Sistem Informasi Akademik Online Pondok Pesantren">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png" />

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
    <link rel="stylesheet" href="assets/vendor/libs/fullcalendar/fullcalendar.css"/>
    <link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="assets/vendor/libs/animate-css/animate.css" />

    <link rel="stylesheet" href="assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <script type="text/javascript" src="../DataTables/datatables.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <!-- Page CSS -->
    <link rel="stylesheet" href="assets/vendor/css/pages/app-calendar.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/page-profile.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/card-analytics.css" />
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


if ($rowsan['NIS'] !== NULL && $rowsan['NIK'] !== NULL && $rowsan['id_kamar'] !== NULL) {
  // Query row untuk mengindeks status pendaftaran pada detail pendaftaran
  $santri = query("SELECT pendaftaran.*, akun.*,detail_pendaftaran.*,santri.*,santri.status AS 'stats_santri', santri.created_At AS 'joined',thn_ajaran.*,kelas_santri.*, kelas.*, kamar.* FROM akun INNER JOIN pendaftaran ON akun.id_user = pendaftaran.Id INNER JOIN detail_pendaftaran ON pendaftaran.Id = detail_pendaftaran.id_user INNER JOIN santri ON santri.id_akun = akun.Id INNER JOIN kelas_santri ON santri.NIS = kelas_santri.NIS INNER JOIN kelas ON kelas_santri.id_kelas = kelas.id_kelas INNER JOIN kamar ON santri.id_kamar = kamar.id_kamar INNER JOIN thn_ajaran ON kelas_santri.id_tahun = thn_ajaran.id_thn WHERE akun.Id = '$idak'")[0];
  // $santri = query("SELECT santri.*,santri.status AS 'stats_santri', thn_ajaran.* , kelas_santri.* , kelas.*, kamar.* FROM santri INNER JOIN kelas_santri ON santri.NIS = kelas_santri.NIS INNER JOIN kelas ON kelas_santri.id_kelas = kelas.id_kelas INNER JOIN kamar ON santri.id_kamar = kamar.id_kamar INNER JOIN thn_ajaran ON kelas_santri.id_tahun = thn_ajaran.id_thn WHERE santri.id_santri = '$idsan'")[0];

}else {
  // Query row untuk mengindeks status pendaftaran pada detail pendaftaran
  $santri = query("SELECT pendaftaran.*, akun.*,detail_pendaftaran.*,santri.*,santri.status AS 'stats_santri', santri.created_At AS 'joined' FROM akun INNER JOIN pendaftaran ON akun.id_user = pendaftaran.Id INNER JOIN detail_pendaftaran ON pendaftaran.Id = detail_pendaftaran.id_user INNER JOIN santri ON santri.id_akun = akun.Id WHERE akun.Id = '$idak'")[0];
  $kelas = "Belum Ada Data";
  $tahunajaran = "Belum Ada Data";

}
// cari data berkas santri
$rowberkas = query("SELECT * FROM data_berkas WHERE id_santri = '$idsan'");
$countcatatan = query("SELECT COUNT(id_catatan) AS 'jumcatatan' FROM catatan WHERE id_santri = '$idsan'")[0];
$tahun = query("SELECT * FROM thn_ajaran WHERE status = '1'")[0];
  $tahunon = $tahun['id_thn'];
  $semester = query("SELECT * FROM semester WHERE status = '1'")[0];
  $semesteron = $semester['semester'];
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
                <a class="dropdown-item" href="pages-account-settings-account.html">
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
        
        <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
        <div class="col-12">
            <div class="card mb-4">
            <div class="user-profile-header-banner">
                <img src="assets/img/pages/header.png" alt="Banner image" class="rounded-top">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                <img src="assets/img/avatars/<?=$santri['gambar'];?>" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img">
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                    <h4><?=ucwords($santri['fullname']);?> (<?=ucwords($santri['notelp']);?>)</h4>
                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                        <!-- <li class="list-inline-item fw-semibold">
                        <i class='bx bx-pen'></i> Cabang Bangka
                        </li>
                        <li class="list-inline-item fw-semibold">
                        <i class='bx bx-map'></i> Kota Pangkalpinang
                        </li> -->
                        <li class="list-inline-item fw-semibold">
                        <i class='bx bx-calendar-alt'></i> Bergabung Pada <?=date('l, d F Y', strtotime($santri["created_At"]));?>
                        </li>
                    </ul>
                    </div>
                    <?php if ($santri['status_pendaftaran'] === '1') {?>
                      <a href="javascript:void(0)" class="btn btn-danger text-nowrap">
                        <i class='bx bx-upload'></i> Belum Verifikasi Berkas
                      </a>
                    <?php } elseif ($santri['status_pendaftaran'] === '2') {?>
                      <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                        <i class='bx bx-pencil'></i> Telah Melengkapi Data
                      </a>
                    <?php } elseif ($santri['status_pendaftaran'] === '3') {?>
                      <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                        <i class='bx bx-user-check'></i> Terverifikasi
                      </a>
                    <?php } else {?>
                      <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                        <i class='bx bxs-radiation'></i> Error
                      </a>
                    <?php } ?>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <!--/ Header -->
        <!-- Navbar pills -->
        <?php
        switch ($santri['status_pendaftaran']) {
            case 1:
                $page               = "welcome1.php";
                $_SESSION['active'] = "1";
                break;
            case 2:
                $page               = "welcome.php";
                $_SESSION['active'] = "2";
                break;
            case 3:
                $page               = "welcome.php";
                $_SESSION['active'] = "3";
                break;
          default:
            $page 	= "welcome1.php";
            $_SESSION['active']	= "1";
            break;
        } 
        include $page;
        ?>

        <!--/ Navbar pills -->
        <div class="row">
            <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="col-md-12">
                            <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                            <li class="mb-4 nav-item"><a class="nav-link active" href="javascript:void(0);"><i class='bx bx-user'></i>Catatan Santri</a></li>
                            <li class="mb-4 nav-item"><a class="nav-link" href="tahfidz.php?idsan=<?=$idsan;?>"><i class='bx bx-book'></i> Tahfidz</a></li>
                            <li class="mb-4 nav-item"><a class="nav-link" href="suluk.php?idsan=<?=$idsan;?>"><i class='bx bx-pencil'></i> Suluk</a></li>
                            <li class="mb-4 nav-item"><a class="nav-link" href="kunjungan.php?idsan=<?=$idsan;?>"><i class='bx bx-car'></i> Kunjungan</a></li>
                            <li class="mb-4 nav-item"><a class="nav-link" href="kesehatan.php?idsan=<?=$idsan;?>"><i class='bx bx-plus-medical'></i> Kesehatan</a></li>
                            <li class="mb-4 nav-item"><a class="nav-link" href="izin.php?idsan=<?=$idsan;?>"><i class='bx bx-wrench'></i> Izin Keluar & Pulang</a></li>
                            
                            </ul>
                    </div>
                </div>    
            <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <!-- Profile Overview -->
                    <div class="card mb-4">
                    <div class="card-body">
                        <div class="col-xl-12">
                        <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                            <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-book"></i>Tambah Catatan</button>
                            </li>
                            <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false"><i class="tf-icons bx bx-notepad"></i>Laporan Catatan Santri <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countcatatan['jumcatatan'];?></span></button>
                            </li>
                            
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                            <form action="func/addcatatan.php" method="POST">
                                        <div class="row">
                                            <input type="hidden" name="id_santri" value="<?=$idsan;?>">
                                            <input type="hidden" name="nis" value="<?=$nis;?>">
                                            <div class="col-md-6">
                                            <label class="form-label" for="basic-icon-default-phone">Tanggal <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                <input type="date" name="tgl" class="form-control "/>
                                            </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                            <label class="form-label" for="basic-icon-default-message">Point Penghargaan/Pelanggaran <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                                                <select name="point" id="point" class="form-control select2">
                                                    <option value="">--Pilih Point Penghargaan/Pelanggaran--</option>
                                                    <?php
                                                        $point = query("SELECT * FROM point");
                                                        foreach ($point as $pnt) :?>
                                                        <option value="<?=$pnt['id_point'];?>"><?=ucwords($pnt['keterangan']).' ('.$pnt['point'].') Point'?></option>
                                                    <?php endforeach?>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-md-12">
                                            <label class="form-label" for="basic-icon-default-phone">Apresiasi/Tindakan <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-comment"></i></span>
                                                <textarea name="keterangan" id="" cols="3" rows="3" class="form-control"></textarea>
                                            </div>
                                            </div>
                                            
                                            
                                            <span><small><span class="text-danger">*</span>) Hati-hati dalam mengonfirmasi catatan santri.</small></span>
                                            
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary me-2">Simpan &raquo;<i class="bx bx-send"></i></button>
                                            <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></a></button>
                                        </div>
                            </form>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                <div class="card-datatable table-responsive">
                                <table id="manlapcat" class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kebaikan/Pelanggaran</th>
                                    <th>Apresiasi/Tindakan</th>
                                    <th>Point</th>
                                    <!-- <th class="text-truncate">Issued Date</th> -->
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    $catatan = query("SELECT * FROM catatan WHERE id_santri = '$idsan'");
                                    foreach ($catatan as $ctt) :?>
                                    <tr>
                                      <?php
                                        $idpoint = $ctt['id_point'];
                                        $pointct = query("SELECT * FROM point WHERE id_point = '$idpoint'")[0];
                                      ?>
                                      <td><?=$i;?></td>
                                      <td><?=date('l, d F Y', strtotime($ctt["tanggal"]));?></td>
                                      <td><?=ucwords($pointct['keterangan']);?></td>
                                      <td><?=$ctt['keterangan'];?></td>
                                      <td><?=$pointct['point'];?></td>
                                      <td>
                                      <div class="d-inline-block">
                                        <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                          <a href="func/hapuscatatan.php?id_catatan=<?=$ctt['id_catatan'];?>&idsan=<?=$idsan;?>&nis=<?=$nis;?>" onclick="return confirm('Apakah Anda Yakin Menghapus Catatan Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                        </div>
                                      </div>
                                      </td>
                                    </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kebaikan/Pelanggaran</th>
                                    <th>Apresiasi/Tindakan</th>
                                    <th>Point</th>
                                    <!-- <th class="text-truncate">Issued Date</th> -->
                                    <th>Aksi</th>
                                </tr>
                                </tfoot>
                            </table>
                            <script>
                                            $(document).ready(function() {
                                                $('#manlapcat').DataTable( {
                                                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                    dom: 'Blftipr',
                                                    buttons: [
                                                        'copy', 'csv', 'excel', 'pdf', 'print'
                                                    ]
                                                } );
                                            } );
                                    </script> 
                                </div>
                            </div>
                            
                        </div>
                        </div>
                        </div>

                    </div>
                    </div>
                    <!--/ Profile Overview -->
                </div>
                </div> 
            </div>
            </div>
            </div>
        </div>






    </div>
    <!-- / Content -->

          
          

<!-- Footer -->
<?php
  include 'footer.php';
?>
<!-- / Footer -->

          
          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
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
  
</body>
</html>
