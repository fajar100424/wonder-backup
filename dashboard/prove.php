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

    <title>Konfirmasi Pembayaran Santri |Pondok Trendi</title>
    
    <meta name="description" content="Website Sistem Informasi Akademik Online Pondok Trendi" />
    <meta name="keywords" content="Website Sistem Informasi Akademik Online Pondok Trendi">
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
$info;

$bebaspayment = query("SELECT bebas_pay.*,payment.*,bebas_payment.* FROM bebas_payment INNER JOIN bebas_pay ON bebas_payment.id_bebas_pay = bebas_pay.id_bebas_pay INNER JOIN payment ON bebas_pay.payment_id = payment.payment_id WHERE bebas_payment.status = 'Lunas'");
$bebaspaymentpending = query("SELECT bebas_pay.*,payment.*,bebas_payment.* FROM bebas_payment INNER JOIN bebas_pay ON bebas_payment.id_bebas_pay = bebas_pay.id_bebas_pay INNER JOIN payment ON bebas_pay.payment_id = payment.payment_id WHERE bebas_payment.status = 'Pending'");
$bulanpayment = query("SELECT bulan_pay.*,payment.*,bulan_payment.* FROM bulan_payment INNER JOIN bulan_pay ON bulan_payment.id_bulan_pay = bulan_pay.id_bulan_pay INNER JOIN payment ON bulan_pay.payment_id = payment.payment_id WHERE bulan_payment.status = 'Lunas'");
$bulanpaymentpending = query("SELECT bulan_pay.*,payment.*,bulan_payment.* FROM bulan_payment INNER JOIN bulan_pay ON bulan_payment.id_bulan_pay = bulan_pay.id_bulan_pay INNER JOIN payment ON bulan_pay.payment_id = payment.payment_id WHERE bulan_payment.status = 'Pending'");
$countbepay = query("SELECT COUNT(bebas_payment.id_bebas_payment) AS 'jumbepay',bebas_pay.*,payment.*,bebas_payment.* FROM bebas_payment INNER JOIN bebas_pay ON bebas_payment.id_bebas_pay = bebas_pay.id_bebas_pay INNER JOIN payment ON bebas_pay.payment_id = payment.payment_id WHERE bebas_payment.status = 'Lunas'")[0];
$countbepayp = query("SELECT COUNT(bebas_payment.id_bebas_payment) AS 'jumbepay',bebas_pay.*,payment.*,bebas_payment.* FROM bebas_payment INNER JOIN bebas_pay ON bebas_payment.id_bebas_pay = bebas_pay.id_bebas_pay INNER JOIN payment ON bebas_pay.payment_id = payment.payment_id WHERE bebas_payment.status = 'Pending'")[0];
$countbulpay = query("SELECT COUNT(bulan_payment.id_bulan_payment) AS 'jumbulpay', bulan_pay.*,payment.*,bulan_payment.* FROM bulan_payment INNER JOIN bulan_pay ON bulan_payment.id_bulan_pay = bulan_pay.id_bulan_pay INNER JOIN payment ON bulan_pay.payment_id = payment.payment_id WHERE bulan_payment.status = 'Lunas'")[0];
$countbulpayp = query("SELECT COUNT(bulan_payment.id_bulan_payment) AS 'jumbulpay', bulan_pay.*,payment.*,bulan_payment.* FROM bulan_payment INNER JOIN bulan_pay ON bulan_payment.id_bulan_pay = bulan_pay.id_bulan_pay INNER JOIN payment ON bulan_pay.payment_id = payment.payment_id WHERE bulan_payment.status = 'Pending'")[0];

$countpayment = $countbepay['jumbepay'] + $countbulpay['jumbulpay'];
include 'preloader.php';
?>

  <!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
  <div class="layout-container">
    <!-- Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    
    <div class="app-brand demo ">
        <a href="index.php" class="app-brand-link">
        <span class="app-brand-logo demo">
            <img src="assets/img/logo.jpeg" alt="" width="50" style="border-radius: 15%;">
        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2">Trendi</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

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
        <li class="menu-item active open">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-money"></i>
            <div data-i18n="Keuangan">Keuangan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
            <a href="payment.php" class="menu-link">
                <div data-i18n="Pembayaran Santri">Pembayaran Santri</div>
            </a>
            </li>
            <li class="menu-item active">
            <a href="prove.php" class="menu-link">
                <div data-i18n="Bukti Transfer Wali Murid">Bukti Transfer Wali Murid</div>
            </a>
            </li>
            <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Tabungan Santri">Tabungan Santri</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                <a href="cashschool.php" class="menu-link">
                    <div data-i18n="Tabungan Pondok">Tabungan Pondok</div>
                </a>
                </li>
                <li class="menu-item">
                <a href="cashbank.php" class="menu-link">
                    <div data-i18n="Tabungan Bank">Tabungan Bank</div>
                </a>
                </li>
            </ul>
            </li>
            <li class="menu-item">
                <a href="invoice.php" class="menu-link">
                    <div data-i18n="Kirim Tagihan">Kirim Tagihan</div>
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
                <b>Konfirmasi Pembayaran Santri</b> 
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
          <!-- Quick links  -->


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
                      <small class="text-muted"><?=$row['role'];?></small>
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
        <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card">
              <div class="card-header">
              <h5 class="p">Manajemen Pembayaran Santri</h5>
              </div>
              <div class="card-body">
              <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Daftar Pembayaran Santri yang Lunas <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countpayment;?></span></button>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                  <div class="card-datatable table-responsive">
                  <table id="manpayment" class="table table-responsive table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Santri</th>
                        <th>Nama Pembayaran</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <th>Tarif Pembayaran</th>
                        <th>Nominal Pembayaran</th>
                        <th>No.Hp</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i =1; foreach ($bebaspayment as $bepay) :?>
                        <?php
                        $idtahunbepay = $bepay['id_tahun'];
                        $idsanpay = $bepay['id_santri'];
                        $tahunbepay = query("SELECT * FROM thn_ajaran WHERE id_thn = '$idtahunbepay'")[0];    
                        $sanpay = query("SELECT * FROM santri WHERE id_santri = '$idsanpay'")[0];
                        ?>
                      <tr>
                        <td><?=$i;?></td>
                        <td><?=ucwords($sanpay['fullname']);?></td>
                        <td><?=ucwords($bepay['pembayaran'].' Tahun '.$tahunbepay['thn_ajaran_start'].'/'.$tahunbepay['thn_ajaran_end'])?></td>
                        <td>Bebas</td>
                        <td><?=$tahunbepay['thn_ajaran_start'].'/'.$tahunbepay['thn_ajaran_end']?></td>
                        <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bepay['bebas_bill']);?></span></td>
                        <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bepay['nominal']);?></span></td>
                        <td><?=$bepay['notelp'];?></td>
                        <td><span class="badge bg-label-success" style="font-size: large;"><?=$bepay['status'];?></span></td>
                        <td>
                            <div class="d-inline-block">
                                <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a href="ubahpayment.php?idpayment=<?=$bepay['id_bebas_payment'];?>" class="dropdown-item">Ubah</a>
                                <div class="dropdown-divider"></div>
                                <a href="func/hapusconpaymentbebas.php?idpay=<?=$bepay['id_bebas_payment'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Transaksi Pembayaran Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                </div>
                            </div>
                        </td>
                      </tr>
                      <?php $i++; endforeach; ?>
                      <?php foreach ($bulanpayment as $bulpay) :?>
                        <?php
                        $idtahunbulpay = $bulpay['id_tahun'];
                        $idsanpay = $bulpay['id_santri'];
                        $idbulan = $bulpay['id_bulan'];
                        $bulanbulpay = query("SELECT * FROM bulan WHERE id_bulan = '$idbulan'")[0];
                        $tahunbepay = query("SELECT * FROM thn_ajaran WHERE id_thn = '$idtahunbulpay'")[0];    
                        $sanpay = query("SELECT * FROM santri WHERE id_santri = '$idsanpay'")[0];
                        ?>
                      <tr>
                        <td><?=$i;?></td>
                        <td><?=ucwords($sanpay['fullname']);?></td>
                        <td><?=ucwords($bulpay['pembayaran'].' Bulan '.$bulanbulpay['bulan']);?></td>
                        <td>Bulanan</td>
                        <td><?=$tahunbepay['thn_ajaran_start'].'/'.$tahunbepay['thn_ajaran_end']?></td>
                        <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bulpay['bulan_pay']);?></span></td>
                        <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bulpay['nominal']);?></span></td>
                        <td><?=$bulpay['notelp'];?></td>
                        <td><span class="badge bg-label-success" style="font-size: large;"><?=$bulpay['status'];?></span></td>
                        <td>
                            <div class="d-inline-block">
                                <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a href="ubahpaymentbul.php?idpayment=<?=$bulpay['id_bulan_payment'];?>" class="dropdown-item">Ubah</a>
                                <div class="dropdown-divider"></div>
                                <a href="func/hapusconpaymentbul.php?idpay=<?=$bulpay['id_bulan_payment'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Transaksi Pembayaran Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                </div>
                            </div>
                        </td>
                      </tr>
                      <?php $i++; endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Santri</th>
                            <th>Nama Pembayaran</th>
                            <th>Tipe</th>
                            <th>Tahun</th>
                            <th>Tarif Pembayaran</th>
                            <th>Nominal Pembayaran</th>
                            <th>No.Hp</th>
                            <th>Status</th>
                            <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
                  <script>
                                $(document).ready(function() {
                                      $('#manpayment').DataTable( {
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
        </div>
        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card">
              <div class="card-body">
              <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-bebas" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Konfirmasi Pembayaran Bebas Santri<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countbepayp['jumbepay'];?></span></button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-bulan" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Konfirmasi Pembayaran Bulanan Santri<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countbulpayp['jumbulpay'];?></span></button>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-pills-justified-bebas" role="tabpanel">
                  <div class="card-datatable table-responsive">
                  <table id="manbebas" class="table table-responsive table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Santri</th>
                        <th>Nama Pembayaran</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <th>Tarif Pembayaran</th>
                        <th>Nominal Pembayaran</th>
                        <th>No.Hp</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i =1; foreach ($bebaspaymentpending as $bepayp) :?>
                        <?php
                        $idtahunbepayp = $bepayp['id_tahun'];
                        $idsanbepayp = $bepayp['id_santri'];
                        $namasantri = query("SELECT fullname FROM santri WHERE id_santri = '$idsanbepayp'")[0];
                        $namasantri = $namasantri['fullname'];
                        $tahunbepayp = query("SELECT * FROM thn_ajaran WHERE id_thn = '$idtahunbepayp'")[0];    
                        ?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?=ucwords($namasantri);?></td>
                            <td><?=ucwords($bepayp['pembayaran'].' Tahun'.$tahunbepayp['thn_ajaran_start'].'/'.$tahunbepayp['thn_ajaran_end'])?></td>
                            <td>Bebas</td>
                            <td><?=$tahunbepayp['thn_ajaran_start'].'/'.$tahunbepayp['thn_ajaran_end']?></td>
                            <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bepayp['bebas_bill']);?></span></td>
                            <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bepayp['nominal']);?></span></td>
                            <td><?=$bepayp['notelp'];?></td>
                            <td>
                                <div class="d-inline-block">
                                    <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                    <a href="conpayment.php?idpayment=<?=$bepayp['id_bebas_payment'];?>" class="dropdown-item">Konfirmasi</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="func/hapusconpaymentbebas.php?idpay=<?=$bepayp['id_bebas_payment'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Transaksi Pembayaran Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                      <?php $i++; endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Santri</th>
                            <th>Nama Pembayaran</th>
                            <th>Tipe</th>
                            <th>Tahun</th>
                            <th>Tarif Pembayaran</th>
                            <th>Nominal Pembayaran</th>
                            <th>No.Hp</th>
                            <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
                  <script>
                                $(document).ready(function() {
                                      $('#manbebas').DataTable( {
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
                    <div class="tab-pane fade" id="navs-pills-justified-bulan" role="tabpanel">
                    <div class="card-datatable table-responsive">
                    <table id="manbulan" class="table table-responsive table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Santri</th>
                            <th>Nama Pembayaran</th>
                            <th>Tipe</th>
                            <th>Tahun</th>
                            <th>Tarif Pembayaran</th>
                            <th>Nominal Pembayaran</th>
                            <th>No.Hp</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i =1; foreach ($bulanpaymentpending as $bulpayp) :?>
                            <?php
                            $idtahunbulpayp = $bulpayp['id_tahun'];
                            $idsanbulpayp =  $bulpayp['id_santri'];
                            $namasantribul = query("SELECT fullname FROM santri WHERE id_santri = '$idsanbulpayp'")[0];
                            $namasantribul = $namasantribul['fullname'];
                            $tahunbulpayp = query("SELECT * FROM thn_ajaran WHERE id_thn = '$idtahunbulpayp'")[0];   
                            $idbulanpayp = $bulpayp['id_bulan'];
                            $bulanpayp = query("SELECT * FROM bulan WHERE id_bulan = '$idbulanpayp'")[0]; 
                            ?>
                            <tr>
                                <td><?=$i;?></td>
                                <td><?=ucwords($namasantribul);?></td>
                                <td><?=ucwords($bulpayp['pembayaran'].' Tahun'.$tahunbulpayp['thn_ajaran_start'].'/'.$tahunbulpayp['thn_ajaran_end'].' - Bulan '.$bulanpayp['bulan']);?></td>
                                <td>Bulanan</td>
                                <td><?=$tahunbulpayp['thn_ajaran_start'].'/'.$tahunbulpayp['thn_ajaran_end']?></td>
                                <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bulpayp['bulan_pay']);?></span></td>
                                <td><span class="badge bg-label-success" style="font-size: large;"><?=rupiah($bulpayp['nominal']);?></span></td>
                                <td><?=$bulpayp['notelp'];?></td>
                                <td>
                                    <div class="d-inline-block">
                                        <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                        <a href="conpaymentbul.php?idpayment=<?=$bulpayp['id_bulan_payment'];?>" class="dropdown-item">Konfirmasi</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="func/hapusconpaymentbul.php?idpay=<?=$bulpayp['id_bulan_payment'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Transaksi Pembayaran Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++; endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Santri</th>
                                <th>Nama Pembayaran</th>
                                <th>Tipe</th>
                                <th>Tahun</th>
                                <th>Tarif Pembayaran</th>
                                <th>Nominal Pembayaran</th>
                                <th>No.Hp</th>
                                <th>Aksi</th>
                        </tr>
                        </tfoot>
                    </table>
                    <script>
                                    $(document).ready(function() {
                                        $('#manbulan').DataTable( {
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
        </div>
        </div>


        <!--/ Header -->
        <!-- Navbar pills -->
        
        <!--/ Navbar pills -->




      </div>
    </div>
    <!-- / Content -->

          
          

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      ©<script>
      document.write(new Date().getFullYear())
      </script>
      <a href="https://themeselection.com/" target="_blank" class="footer-link fw-bolder">PondokTrendi</a>
      <b> | Dermawan Pondok Trendi |</b> 
                <small>Jl Air Aman, Desa Petaling Kec. Mendo Barat - Bangka, Telp. 0853-6868-6876</small>
    </div>
  </div>
</footer>
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
