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

    <title>Penilaian Santri | SISPPI</title>
    
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
    <script type="text/javascript">
    function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox' ) {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }
    </script>
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
$idkelas = $_GET['id_kelas'];
$kelass = query("SELECT * FROM kelas WHERE id_kelas = '$idkelas'")[0];
$idsan = $_GET['idsan'];
$nis = $_GET['nis'];
$santri = query("SELECT santri.*,santri.status AS 'stats_santri', thn_ajaran.* , kelas_santri.* , kelas.*, kamar.* FROM santri INNER JOIN kelas_santri ON santri.NIS = kelas_santri.NIS INNER JOIN kelas ON kelas_santri.id_kelas = kelas.id_kelas INNER JOIN kamar ON santri.id_kamar = kamar.id_kamar INNER JOIN thn_ajaran ON kelas_santri.id_tahun = thn_ajaran.id_thn WHERE santri.id_santri = '$idsan'")[0];

$tahun = query("SELECT * FROM thn_ajaran WHERE status = '1'")[0];
$tahunon = $tahun['id_thn'];
$semester = query("SELECT * FROM semester WHERE status = '1'")[0];
$semesteron = $semester['semester'];

$mapel = query("SELECT mapel.*,kelas.*,jadwal.* FROM jadwal INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas INNER JOIN mapel ON jadwal.id_mapel = mapel.id_mapel WHERE jadwal.id_kelas = '$idkelas' GROUP BY mapel.mapel;");

include 'preloader.php';
?>

  <!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
  <div class="layout-container">
  <!-- Menu -->
  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    
    <?php
    include 'brand.php';
    ?>

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
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class='menu-icon tf-icons bx bx-group'></i>
          <div data-i18n="Kesantrian">Kesantrian</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
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
      <li class="menu-item active open">
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
          <li class="menu-item active">
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
                <b>Penilaian Santri</b> 
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
        <!-- Jadwal Pelajaran -->
        <div class="row">
            <div class="col-lg-12">
            <div class="card mb-4">
            <div class="card-header">
            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active"><i class="tf-icons bx bx-home"></i>Daftar Nilai Santri <?=ucwords($santri['fullname']);?> Semester Ini</button>
                  </li>
              </ul>
            </div>
            <div class="card-body">
            <div class="alert alert-danger d-flex" role="alert">
            <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2"><i class="bx bx-envelope fs-6"></i></span>
            <div class="d-flex flex-column ps-1">
                <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Warning!... ! </h6>
                <span>Yang ditampilkan pada table di bawah ini adalah daftar nilai yang telah diinputkan pada semester yang aktif dan tahun ajaran yang aktif sekarang!</span>
            </div>
            </div>
            <hr>
                <div class="row">
                    <!-- Days Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <!-- Profile Overview -->
                        <div class="card mb-4">
                        <div class="card-header">
                            
                        </div>
                        <div class="card-body">
                          <div class="card-datatable table-responsive">
                            <table id="mansantri" class="table table-responsive table-bordered">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Kelas</th>
                                  <th>Tahun Ajaran</th>
                                  <th>Semester</th>
                                  <th>Mapel</th>
                                  <th>Harian 1</th>
                                  <th>Harian 2</th>
                                  <th>Harian 3</th>
                                  <th>Tugas 1</th>
                                  <th>Tugas 2</th>
                                  <th>Tugas 3</th>
                                  <th>UTS</th>
                                  <th>UAS</th>
                                  <th>Rata-Rata</th>
                                  <th>Grade</th>
                                  <th>Ditambahkan Pada</th>
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $i=1;
                                $nilai = query("SELECT nilai.* FROM nilai WHERE id_santri = '$idsan'");
                                foreach ($nilai as $nil) {?>
                                <tr>
                                  <td><?=$i;?></td>
                                  <td><span class="badge bg-label-success" style="font-size: large;">
                                  <?php
                                  $idkelassan = $nil['id_kelas'];
                                  $kelassan = query("SELECT * FROM kelas WHERE id_kelas = '$idkelassan'")[0];
                                  ?>
                                    <?=ucwords($kelassan['kelas'].' '.$kelassan['tingkat']);?>
                                  </span></td>
                                  <td>
                                    <?php
                                    $idtasan = $nil['id_tahun'];
                                    $tasan = query("SELECT * FROM thn_ajaran WHERE id_thn = '$idtasan'")[0];
                                    ?>
                                    <?=$tasan['thn_ajaran_start'].'/'.$tasan['thn_ajaran_end'];?>
                                  </td>
                                  <td><?=ucwords($nil['semester']);?></td>
                                  <td>
                                    <?php
                                    $idmapelsan = $nil['id_mapel'];
                                    $mapelsan = query("SELECT * FROM mapel WHERE id_mapel = '$idmapelsan'")[0];
                                    ?>
                                    <?=ucwords($mapelsan['mapel']);?>
                                  </td>
                                  <td><?=ucwords($nil['harian1']);?></td>
                                  <td><?=ucwords($nil['harian2']);?></td>
                                  <td><?=ucwords($nil['harian3']);?></td>
                                  <td><?=ucwords($nil['tugas2']);?></td>
                                  <td><?=ucwords($nil['tugas2']);?></td>
                                  <td><?=ucwords($nil['tugas3']);?></td>
                                  <td><?=ucwords($nil['uts']);?></td>
                                  <td><?=ucwords($nil['uas']);?></td>
                                  <td>
                                    <?php
                                    $ratanh = (($nil['harian1']+$nil['harian2']+$nil['harian3']) / 3) * 0.2;
                                    $ratant = (($nil['tugas1'] + $nil['tugas2'] + $nil['tugas3'])/ 10) * 0.1;
                                    $uts = ($nil['uts']) * 0.3;
                                    $uas = ($nil['uas']) * 0.4;
                                    $nr = $ratanh + $ratant + $uts + $uas;
                                    $nr = round($nr,2);
                                    if ($nr >= 93) { $grade = 'A';?>
                                        <span class="badge bg-label-success" style="font-size: large;"><?=$nr;?></span>
                                    <?php }elseif ($nr <= 92 && $nr >= 80) { $grade = 'B';?>
                                        <span class="badge bg-label-info" style="font-size: large;"><?=$nr;?></span>
                                    <?php }elseif ($nr <= 79 && $nr >= 60) { $grade = 'C';?>
                                        <span class="badge bg-label-warning" style="font-size: large;"><?=$nr;?></span>
                                    <?php }else { $grade = 'D';?>
                                        <span class="badge bg-label-danger" style="font-size: large;"><?=$nr;?></span>
                                    <?php }?>
                                    
                                  </td>
                                  <td>
                                    <?php
                                    if ($grade == 'A') :?>
                                        <span class="badge bg-label-success" style="font-size: large;"><?=$grade;?></span>
                                    <?php elseif ($grade == 'B') :?>
                                        <span class="badge bg-label-info" style="font-size: large;"><?=$grade;?></span>
                                    <?php elseif ($grade == 'C') :?>
                                        <span class="badge bg-label-warning" style="font-size: large;"><?=$grade;?></span>
                                    <?php elseif ($grade == 'D') :?>
                                        <span class="badge bg-label-danger" style="font-size: large;"><?=$grade;?></span>
                                    <?php else :?>
                                        <span class="badge bg-label-danger" style="font-size: large;">ERROR</span>
                                    <?php endif;?>
                                  </td>
                                  <td><?=date('l, d F Y', strtotime($nil["created_at"]));?></td>
                                  <td>
                                    <div class="d-inline-block">
                                        <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                          <a href="func/hapusgradesan.php?idsan=<?=$idsan;?>&nis=<?=$nis;?>&id_kelas=<?=$idkelassan;?>&idgradesan=<?=$nil['id_nilai'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Data Nilai Santri Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                        </div>
                                    </div>
                                  </td>
                                </tr>
                                <?php $i++;}?>
                              </tbody>
                              <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Mapel</th>
                                    <th>Harian 1</th>
                                    <th>Harian 2</th>
                                    <th>Harian 3</th>
                                    <th>Tugas 1</th>
                                    <th>Tugas 2</th>
                                    <th>Tugas 3</th>
                                    <th>UTS</th>
                                    <th>UAS</th>
                                    <th>Rata-Rata</th>
                                    <th>Grade</th>
                                    <th>Ditambahkan Pada</th>
                                    <th>Aksi</th>
                                    </tr>
                              </tfoot>
                            </table>
                            <script>
                                          $(document).ready(function() {
                                                $('#mansantri').DataTable( {
                                                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                    dom: 'Blftipr',
                                                    buttons: [
                                                        'copy', 'csv', 'excel', 'pdf', 'print'
                                                    ]
                                                } );
                                            } );
                                    </script>  
                          </div>
                            <hr>
                            <h5 class="text-center">Tambah Nilai Ananda <?=$santri['fullname'];?></h5>
                            <hr>
                            <form action="func/addnilai.php" method="POST">
                              <input type="hidden" name="idsan" value="<?=$idsan;?>">
                              <input type="hidden" name="nis" value="<?=$nis;?>">
                              <input type="hidden" name="id_kelas" value="<?=$idkelas;?>">
                              <input type="hidden" name="tahun" value="<?=$tahunon;?>">
                              <input type="hidden" name="semester" value="<?=$semesteron;?>">
                                        <div class="row">
                                            <div class="mb-4 col-md-6">
                                            <label class="form-label" for="basic-icon-default-phone">Tahun Ajaran <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                <input type="text" disabled name="thn_ajaran" class="form-control " value="<?=$tahun['thn_ajaran_start'].'/'.$tahun['thn_ajaran_end']?>"/>
                                            </div>
                                            </div>
                                            <div class="mb-4 col-md-6">
                                            <label class="form-label" for="basic-icon-default-phone">Semester <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                <input type="text" disabled name="smstr" class="form-control" value="<?=ucwords($semester['semester']);?>"/>
                                            </div>
                                            </div>
                                            <div class="mb-4 col-md-6">
                                            <label class="form-label" for="basic-icon-default-phone">Kelas <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                <input type="text" disabled name="kls" class="form-control" value="<?=ucwords($kelass['kelas'].' '.$kelass['tingkat']);?>"/>
                                            </div>
                                            </div>
                                            <div class="mb-4 col-md-6">
                                            <label class="form-label" for="basic-icon-default-message">Mapel <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                                                <select name="mapel" id="mapel" class="form-control select2">
                                                    <option value="">--Pilih Mapel--</option>
                                                    <?php
                                                        foreach ($mapel as $mpl) :?>
                                                        <option value="<?=$mpl['id_mapel'];?>"><?=ucwords($mpl['mapel']);?></option>
                                                    <?php endforeach?>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                            <label class="form-label" for="nt1">Nilai Tugas 1 <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="nt1" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                            <label class="form-label" for="nt2">Nilai Tugas 2 <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="nt2" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                            <label class="form-label" for="nt3">Nilai Tugas 3 <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="nt3" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                            <label class="form-label" for="uh1">Ulangan Harian 1 <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="uh1" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                            <label class="form-label" for="uh2">Ulangan Harian 2 <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="uh2" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                            <label class="form-label" for="uh3">Ulangan Harian 3 <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="uh3" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-6 col-md-6">
                                            <label class="form-label" for="uts">Ujian Tengah Semester <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="uts" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-lg-6 col-md-6">
                                            <label class="form-label" for="uas">Ujian Akhir Semester <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                                <input type="number" name="uas" class="form-control "/>
                                            </div>
                                            </div>
                                            

                                            
                                            
                                            <span><small><span class="text-danger">*</span>) Hati-hati dalam mengonfirmasi catatan santri.</small></span>
                                            
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary me-2">Simpan &raquo;<i class="bx bx-send"></i></button>
                                            <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></a></button>
                                            <a href="grade.php?kelas=<?=$idkelas;?>" class="btn btn-label-warning"> Kembali <i class="bx bx-back"></i></a>
                                        </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    <!-- Days End -->
                    
                </div>

            </div> 
            </div>
            </div>
        </div>
        <!--/ header -->
        






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
