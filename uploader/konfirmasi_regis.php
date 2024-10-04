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
$info;

$idregis = $_GET['idregis'];
$ida = $_GET['ida'];
$idd = $_GET['idd'];
$regis = query("SELECT a.*, a.id as id_daftar, b.id as id_akun,b.*,c.Id as id_detail,c.* 
FROM pendaftaran a, akun b, detail_pendaftaran c 
WHERE a.id=b.id_user 
AND b.role_user=1 
AND c.id_user = a.id
AND a.Id = $idregis")[0];

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
  <li class="menu-item active">
    <a href="pendaftaran.php" class="menu-link">
      <i class="menu-icon tf-icons bx bx-book-reader"></i>
      <div data-i18n="Pendaftaran Santri Baru">Pendaftaran Santri Baru</div>
    </a>
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
                <b>Konfirmasi Pendaftaran Santri</b> 
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
                <h5 class="p"><span><button class="btn btn-sm btn-primary" style="border-radius: 25px;"><a href="pendaftaran.php" class="text-white"><i class='bx bxs-chevron-left-circle'></i> Kembali</button></a></span>  Konfirmasi Data Pendaftaran Ananda <?=ucwords($regis['fullname']);?></h5>
                <hr>
              </div>
              <div class="card-body">
              <form id="formValidationExamples" action="func/conregis.php" method="POST" enctype="multipart/form-data" class="row g-3">
              <input class="form-control" type="hidden" name="id_akun" value="<?=$regis['id_akun'];?>">
              <input class="form-control" type="hidden" name="id_detail" value="<?=$regis['id_detail'];?>">
              <input class="form-control" type="hidden" name="id_daftar" value="<?=$regis['id_daftar'];?>">
              <input class="form-control" type="hidden" name="id_admin" value="<?=$row['id_user'];?>">
              <small class="text-light fw-semibold">Konfirmasi Data Santri Dengan Baik dan Benar ( <span class="text-danger">*</span> )</small>
                <!-- Account Details -->

                <div class="col-12">
                  <h6 class="fw-semibold">1. Data Pribadi Santri</h6>
                  <hr class="mt-0" />
                </div>
                <div class="col-sm-12">
                  <label class="form-label" for="fullname">Nama Lengkap</label>
                  <input type="text" id="fullname" name="fullname" class="form-control" value="<?=$regis['fullname'];?>" />
                </div>

                <div class="col-sm-6">
                  <label for="kampus" class="form-label">Pilihan Kampus</label>
                  <input type="text" name="kampus" id="kampus" class="form-control" value="<?=$regis['kampus'];?>">
                </div>
                <div class="col-sm-6">
                  <label for="tingkat" class="form-label">Tingkat</label>
                  <input type="text" name="tingkat" id="tingkat" class="form-control" value="<?=$regis['tingkat'];?>">
                </div>
                <div class="col-sm-12">
                  <label class="form-label" for="status">Status Santri</label>
                  <div class="form-check">
                    <input type="radio" id="mukim" name="status" value="Mukim / Asrama" class="form-check-input" <?php if ($regis["status"] === 'Mukim / Asrama') {echo "checked";} else {echo " ";}?>/>
                    <label class="form-check-label" for="mukim">Mukim/Asrama</label>
                  </div>
                  <div class="form-check">
                    <input type="radio" id="nonmukim" name="status" value="Non Mukim" class="form-check-input" <?php if ($regis["status"] === 'Non Mukim') {echo "checked";} else {echo " ";}?>/>
                    <label class="form-check-label" for="nonmukim">Non Mukim</label>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                  <input type="text" class="form-control" name="tempat_lahir" value="<?=ucwords($regis['tempat_lahir']);?>">
                </div>
                <div class="col-sm-6">
                  <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" class="form-control" name="tanggal_lahir" value="<?=$regis['tanggal_lahir']?>">
                </div>
                <div class="col-sm-12">
                  <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                  <div class="form-check">
                    <input type="radio" id="L" name="jenis_kelamin" value="L" class="form-check-input" <?php if ($regis["jenis_kelamin"] === 'L') {echo "checked";} else {echo " ";}?>/>
                    <label class="form-check-label" for="L">Laki-laki</label>
                  </div>
                  <div class="form-check">
                    <input type="radio" id="P" name="jenis_kelamin" value="P" class="form-check-input" <?php if ($regis["jenis_kelamin"] === 'P') {echo "checked";} else {echo " ";}?>/>
                    <label class="form-check-label" for="P">Perempuan</label>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label for="goldar" class="form-label">Golongan Darah</label>
                  <input type="text" name="goldar" id="goldar" class="form-control" value="<?=$regis['goldar'];?>">
                </div>
                <div class="col-sm-6">
                  <label for="provinsi" class="form-label">Provinsi</label>
                  <input type="text" name="provinsi" id="provinsi" class="form-control" value="<?=$regis['provinsi'];?>">
                </div>
                <div class="col-sm-6">
                  <label for="kabupaten" class="form-label">Kabupaten</label>
                  <input type="text" name="kabupaten" id="kabupaten" class="form-control" value="<?=$regis['kabupaten'];?>">
                </div>
                <div class="col-sm-6">
                  <label for="kecamatan" class="form-label">Kecamatan</label>
                  <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="<?=$regis['kecamatan'];?>">
                </div>
                <div class="col-sm-6">
                  <label for="desa" class="form-label">Kelurahan/Desa</label>
                  <input type="text" name="desa" id="desa" class="form-control" value="<?=$regis['desa'];?>">
                </div>
                <div class="col-sm-12">
                  <label class="form-label" for="bs-validation-bio">Alamat</label>
                  <textarea class="form-control" id="bs-validation-bio" name="alamat" rows="3"><?=$regis['alamat'];?></textarea>
                </div>
                <!-- Personal Info -->
                <!-- Data Pembayaran Santri -->
                  <div class="mb-3 col-md-12">
                    <label for="nova" class="form-label">Nomor VA<span class="text-danger">*</span></label>
                      <div class="input-group input-group-merge">
                        <span class="input-group-text">VA :</span>
                        <input type="text" name="nova" class="form-control " required/>
                      </div>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Biaya Pembayaran Pendaftaran<span class="text-danger">*</span></label>
                      <div class="input-group input-group-merge">
                        <span class="input-group-text">Rp.</span>
                        <input type="number" name="biayaregis" class="form-control " required/>
                      </div>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="status_pembayaran" class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                    <select name="status_pembayaran" id="status_pembayaran" class="select2 form-select" required>
                      <option value="">-- Status Pembayaran --</option>
                      <option value="0">Belum Lunas</option>
                      <option value="1">Lunas</option>
                    </select>
                  </div>
                  
                <!-- End Data Pemabayaran Santri -->
                <div class="row">
                    <div class="col-lg-12 mt-4">
                      <h6 class="mt-2 fw-semibold">2. Data Login Santri</h6>
                      <hr class="mt-0" />
                    </div>
                    <div class="col-lg-12 mb-3">
                      <label class="form-label" for="notelp">Nomor Telepon <span class="text-danger">(Yang diinput Wali Santri)</span></label>
                      <div class="input-group input-group-merge">
                        <span class="input-group-text">IDN </span>
                        <input type="text" name="notelp" class="form-control" value="<?=hportu($regis['notelp']);?>" required/>
                      </div>
                    </div>
                    <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="password">Password Baru<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <input class="form-control" type="password" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    </div>
                    <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="confirmPassword">Konfirmasi Password <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    </div>
                    <div class="mb-3 col-md-6">
                    <label for="conregis" class="form-label">Verifikasi Pendaftaran <span class="text-danger">*</span></label>
                    <select name="conregis" id="conregis" class="select2 form-select" required>
                      <option value="">-- Verifikasi --</option>
                      <option value="0">Tolak</option>
                      <option value="1">Diterima</option>
                    </select>
                    </div>
                    
                    <span><small><span class="text-danger">*</span>) Hati-hati dalam mengubah password santri.</small></span>
                    
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
                
                <div class="col-12">
                  <button type="submit" name="submitButton" class="btn btn-primary">Daftar &raquo;</button>
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
    <!-- / Content -->

          
          

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      ©<script>
      document.write(new Date().getFullYear())
      </script>
      <a href="https://themeselection.com/" target="_blank" class="footer-link fw-bolder">Pondok Pesantren Al-Ittifaqiah Indralaya</a>
      <b> | SISPPI |</b> 
                <small>Telp. 0711-580017</small>
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
