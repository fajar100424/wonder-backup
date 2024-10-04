<?php
if (!isset($_POST['tahun'])){
  $tahun = date('Y');
}else {
  $tahun = $_POST['tahun'];
}
$totpendaftar = query("SELECT COUNT(Id) AS 'totpendaftar' FROM `detail_pendaftaran` WHERE tanggal_daftar LIKE '%$tahun%'");

$totacc = query("SELECT COUNT(Id) AS 'totacc' FROM `detail_pendaftaran` WHERE tanggal_daftar LIKE '%$tahun%' AND status_pendaftaran LIKE '1' OR status_pendaftaran LIKE '2';");
$totdec = query("SELECT COUNT(Id) AS 'totdec' FROM `detail_pendaftaran` WHERE tanggal_daftar LIKE '%$tahun%' AND status_pendaftaran LIKE '-1';");
$totwait = query("SELECT COUNT(Id) AS 'totwait' FROM `detail_pendaftaran` WHERE tanggal_daftar LIKE '%$tahun%' AND status_pendaftaran LIKE '0' OR status_pendaftaran LIKE 'NULL';");

$totverif = query("SELECT COUNT(Id) AS 'totverif' FROM `detail_pendaftaran` WHERE tanggal_daftar LIKE '%$tahun%' AND status_pendaftaran LIKE '2'");
$totnverif = query("SELECT COUNT(Id) AS 'totnverif' FROM `detail_pendaftaran` WHERE tanggal_daftar LIKE '%$tahun%' AND status_pendaftaran LIKE '1'");

// Rekapitulasi :
// TPA
$tpalk = query("SELECT COUNT(pendaftaran.Id) AS 'tpalk' FROM detail_pendaftaran INNER JOIN pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%tpa%' AND pendaftaran.jenis_kelamin LIKE 'l';");
$tpapr = query("SELECT COUNT(pendaftaran.Id) AS 'tpapr' FROM detail_pendaftaran INNER JOIN pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%tpa%' AND pendaftaran.jenis_kelamin LIKE 'p';");
// TK Islam
$tkilk = query("SELECT COUNT(pendaftaran.Id) AS 'tkilk' FROM detail_pendaftaran INNER JOIN pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%tk islam%' AND pendaftaran.jenis_kelamin LIKE 'l';"); 
$tkipr = query("SELECT COUNT(pendaftaran.Id) AS 'tkipr' FROM detail_pendaftaran INNER JOIN pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%tk islam%' AND pendaftaran.jenis_kelamin LIKE 'p';");
// Lil
$lillk = query("SELECT COUNT(pendaftaran.Id) AS 'lillk',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mujahadah%' AND pendaftaran.jenis_kelamin LIKE 'l';");
$lilpr = query("SELECT COUNT(pendaftaran.Id) AS 'lilpr',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mujahadah%' AND pendaftaran.jenis_kelamin LIKE 'p';");
// Diniah
$dinlk = query("SELECT COUNT(pendaftaran.Id) AS 'dinlk',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%diniah%' AND pendaftaran.jenis_kelamin LIKE 'l';");
$dinpr = query("SELECT COUNT(pendaftaran.Id) AS 'dinpr',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%diniah%' AND pendaftaran.jenis_kelamin LIKE 'p';");
// MI
$milk = query("SELECT COUNT(pendaftaran.Id) AS 'milk',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%MI / SD%' AND pendaftaran.jenis_kelamin LIKE 'l';");
$mipr = query("SELECT COUNT(pendaftaran.Id) AS 'mipr',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%MI / SD%' AND pendaftaran.jenis_kelamin LIKE 'p';");;
// MTs Pusat
$mtsplk = query("SELECT COUNT(pendaftaran.Id) AS 'mtsplk',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.kampus LIKE '%indralaya%' AND pendaftaran.jenis_kelamin LIKE 'l';");
$mtsppr = query("SELECT COUNT(pendaftaran.Id) AS 'mtsppr',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.kampus LIKE '%indralaya%' AND pendaftaran.jenis_kelamin LIKE 'p'");

// MTs Lecah
$mtsllk = query("SELECT COUNT(pendaftaran.Id) AS 'mtsllk' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.kampus LIKE '%lecah%' AND pendaftaran.jenis_kelamin LIKE 'l'");
$mtslpr = query("SELECT COUNT(pendaftaran.Id) AS 'mtslpr',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.kampus LIKE '%lecah%' AND pendaftaran.jenis_kelamin LIKE 'p'");

// MTs Kuripan
$mtsklk = query("SELECT COUNT(pendaftaran.Id) AS 'mtsklk',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.kampus LIKE '%kuripan%' AND pendaftaran.jenis_kelamin LIKE 'l'");
$mtskpr = query("SELECT COUNT(pendaftaran.Id) AS 'mtskpr',pendaftaran.jenis_kelamin FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.kampus LIKE '%kuripan%' AND pendaftaran.jenis_kelamin LIKE 'p'");

// MA Pusat
$maplk = query("SELECT COUNT(pendaftaran.Id) AS 'maplk' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.kampus LIKE '%indralaya%' AND pendaftaran.jenis_kelamin LIKE 'l'");
$mappr = query("SELECT COUNT(pendaftaran.Id) AS 'mappr' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.kampus LIKE '%indralaya%' AND pendaftaran.jenis_kelamin LIKE 'p'");

// MA Lecah
$mallk = query("SELECT COUNT(pendaftaran.Id) AS 'mallk' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.kampus LIKE '%lecah%' AND pendaftaran.jenis_kelamin LIKE 'l'");
$malpr = query("SELECT COUNT(pendaftaran.Id) AS 'malpr' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.kampus LIKE '%lecah%' AND pendaftaran.jenis_kelamin LIKE 'pr'");

// MA Kuripan
$maklk = query("SELECT COUNT(pendaftaran.Id) AS 'maklk' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.kampus LIKE '%kuripan%' AND pendaftaran.jenis_kelamin LIKE 'l'");
$makpr = query("SELECT COUNT(pendaftaran.Id) AS 'makpr' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.kampus LIKE '%kuripan%' AND pendaftaran.jenis_kelamin LIKE 'pr'");
// Total Rekapitulasi
$total_rekap_laki = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_laki' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'l';");
$total_rekap_perempuan = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_perempuan' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'p';");
$total_rekap_laki_pusat = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_laki_pusat' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'l' AND pendaftaran.kampus LIKE '%indralaya%';")[0]['total_rekap_laki_pusat'];
$total_rekap_perempuan_pusat = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_perempuan_pusat' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'p' AND pendaftaran.kampus LIKE '%indralaya%';")[0]['total_rekap_perempuan_pusat'];
$total_rekap_laki_kuripan = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_laki_kuripan' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'l' AND pendaftaran.kampus LIKE '%kuripan%';")[0]['total_rekap_laki_kuripan'];
$total_rekap_perempuan_kuripan = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_perempuan_kuripan' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'p' AND pendaftaran.kampus LIKE '%kuripan%';")[0]['total_rekap_perempuan_kuripan'];
$total_rekap_laki_lecah = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_laki_lecah' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'l' AND pendaftaran.kampus LIKE '%lecah%';")[0]['total_rekap_laki_lecah'];
$total_rekap_perempuan_lecah = query("SELECT COUNT(pendaftaran.Id) AS 'total_rekap_perempuan_lecah' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.jenis_kelamin LIKE 'p' AND pendaftaran.kampus LIKE '%lecah%';")[0]['total_rekap_perempuan_lecah'];

// End Of Rekapitulasi

// Rekapitulasi mukim non mukim
$mukim_mts_laki = query("SELECT COUNT(pendaftaran.Id) AS 'mukim_mts_laki' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.status LIKE '%asrama%' AND pendaftaran.jenis_kelamin LIKE 'l'")[0]['mukim_mts_laki'];
$non_mukim_mts_laki = query("SELECT COUNT(pendaftaran.Id) AS 'non_mukim_mts_laki' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.status LIKE '%Non Mukim%' AND pendaftaran.jenis_kelamin LIKE 'l';")[0]['non_mukim_mts_laki'];
$mukim_mts_perempuan = query("SELECT COUNT(pendaftaran.Id) AS 'mukim_mts_perempuan' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.status LIKE '%asrama%' AND pendaftaran.jenis_kelamin LIKE 'p'")[0]['mukim_mts_perempuan'];
$non_mukim_mts_perempuan = query("SELECT COUNT(pendaftaran.Id) AS 'non_mukim_mts_perempuan' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%mts%' AND pendaftaran.status LIKE '%Non Mukim%' AND pendaftaran.jenis_kelamin LIKE 'p';")[0]['non_mukim_mts_perempuan'];


$mukim_ma_laki = query("SELECT COUNT(pendaftaran.Id) AS 'mukim_ma_laki' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.status LIKE '%asrama%' AND pendaftaran.jenis_kelamin LIKE 'l'")[0]['mukim_ma_laki'];
$non_mukim_ma_laki = query("SELECT COUNT(pendaftaran.Id) AS 'non_mukim_ma_laki' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.status LIKE '%Non Mukim%' AND pendaftaran.jenis_kelamin LIKE 'l';")[0]['non_mukim_ma_laki'];
$mukim_ma_perempuan = query("SELECT COUNT(pendaftaran.Id) AS 'mukim_ma_perempuan' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.status LIKE '%asrama%' AND pendaftaran.jenis_kelamin LIKE 'p'")[0]['mukim_ma_perempuan'];
$non_mukim_ma_perempuan = query("SELECT COUNT(pendaftaran.Id) AS 'non_mukim_ma_perempuan' FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' AND pendaftaran.tingkat LIKE '%ma%' AND pendaftaran.status LIKE '%Non Mukim%' AND pendaftaran.jenis_kelamin LIKE 'p';")[0]['non_mukim_ma_perempuan'];

// End Rekapitulasi mukim non mukim
// Rekapitulasi Berdasarkan provinsi
$rekap_provinsi = query("SELECT COUNT(pendaftaran.Id) AS 'jumlah', pendaftaran.provinsi FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' GROUP BY pendaftaran.provinsi;");
// End Rekapitulasi Berdasarkan provinsi
// Rekapitulasi Berdasarkan job
$rekap_provinsi = query("SELECT COUNT(pendaftaran.Id) AS 'jumlah', pendaftaran.provinsi FROM pendaftaran INNER JOIN detail_pendaftaran ON detail_pendaftaran.id_user = pendaftaran.Id WHERE pendaftaran.created_at LIKE '%$tahun%' GROUP BY pendaftaran.provinsi;");
// End Rekapitulasi Berdasarkan job
?>


      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
            

<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card" style="box-shadow: -5px -5px 13px #ededed, 5px 5px 13px #74b9ff;">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">Selamat Data Di Dashboard Visualisasi Pendaftaran! 🎉</h5>
            <p class="mb-0">Silakan Pilih Tahun Ajaran yang Ingin Divisualisasikan</p>
            <small class="text-muted">Secara default akan menampilkan visualisasi data pendaftaran di tahun ajaran saat ini</small>
            <hr>
            <form action="" method="POST">
                       <div class="row">
                        <div class="col-lg-6">
                        <select name="tahun" id="tahun" class="select2 form-select form-control-sm" required>
                            <option value="<?=$tahun?>" selected><?=$tahun?></option>
                            <?php
                                for ($i= date('Y'); $i > 1990; $i--) {
                                echo "<option value='$i'>$i</option>";
                                }
                            ?>
                        </select>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" name="cari" class="btn btn-primary text-nowrap">
                                <i class="bx bx-search-alt"></i> Visualisasikan
                            </button>
                        </div>
                       </div>
              </form>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="../dashboard/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.html">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12">
    <div class="row">
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/briefcase.png" alt="Total Pendaftaran" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">Lihat Detail</a>
                </div>
              </div>
            </div>
            <span>Total Pendaftaran</span>
            <h3 class="card-title text-nowrap mb-1"><?=$totpendaftar[0]['totpendaftar'];?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/wallet-info.png" alt="Belum Dikonfirmasi" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span>Total Belum Dikonfirmasi</span>
            <h3 class="card-title text-nowrap mb-1"><?=$totwait[0]['totwait'];?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12">
    <div class="row">
      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/user-check.svg" alt="Diterima" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                </div>
              </div>
            </div>
            <span class="d-block mb-1">Diterima</span>
            <h3 class="card-title text-nowrap mb-2"><?=$totacc[0]['totacc'];?></h3>
            <small class="text-danger fw-semibold"><i class='bx bx-down-arrow-alt'></i> -14.82%</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/user-times.svg" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                </div>
              </div>
            </div>
            <span>Ditolak</span>
            <h3 class="card-title text-nowrap mb-1"><?=$totdec[0]['totdec'];?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div class="col-12 col-lg-12">
    <div class="row">
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/file-check-alt.svg" alt="Sudah Verif" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">Lihat Detail</a>
                </div>
              </div>
            </div>
            <span>Sudah Verifikasi Data</span>
            <h3 class="card-title text-nowrap mb-1"><?=$totverif[0]['totverif'];?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/file-block-alt.svg" alt="Belum Verif" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                </div>
              </div>
            </div>
            <span>Belum Verifikasi Data</span>
            <h3 class="card-title text-nowrap mb-1"><?=$totnverif[0]['totnverif'];?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
<div class="row">
  <!-- Registration Statistics -->
  <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Registration Statistics</h5>
          <small class="text-muted"><?=$totpendaftar[0]['totpendaftar']?> Pendaftaran</small>
        </div>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
            <a class="dropdown-item" href="javascript:void(0);">Lihat Detail</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column align-items-center gap-1">
            <h2 class="mb-2"><?=$totpendaftar[0]['totpendaftar']?></h2>
            <span>Total Pendaftar</span>
          </div>
          <div id="orderStatisticsChart"></div>
        </div>
        <ul class="p-0 m-0">
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-user-check'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Diterima</h6>
                <small class="text-muted">Sudah diberikan username & password oleh admin</small>
              </div>
              <div class="user-progress">
                <small class="fw-semibold"><?=$totacc[0]['totacc']?></small>
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-danger"><i class='bx bx-user-x'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Ditolak</h6>
                <small class="text-muted">Dinyatakan tidak valid saat mendaftar</small>
              </div>
              <div class="user-progress">
                <small class="fw-semibold"><?=$totdec[0]['totdec']?></small>
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-success"><i class='bx bx-file'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Sudah Verifikasi Data</h6>
                <small class="text-muted">Sudah memverifikasi data lengkap pada dashboard santri</small>
              </div>
              <div class="user-progress">
                <small class="fw-semibold"><?=$totverif[0]['totverif']?></small>
              </div>
            </div>
          </li>
          <li class="d-flex">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-file'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Belum Verifikasi Data</h6>
                <small class="text-muted">Belum melengkapi data pada dashboard santri</small>
              </div>
              <div class="user-progress">
                <small class="fw-semibold"><?=$totnverif[0]['totnverif']?></small>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--/ Registration Statistics -->


  <!-- pill table -->
  <div class="col-lg-8 col-12 col-sm-12 order-3 order-lg-4 mb-4 mb-lg-4">
    <div class="card text-center">
      <div class="card-header py-3">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-rekap" aria-controls="navs-pills-rekap" aria-selected="true">Rekapitulasi Santri Baru</button>
          </li>
          <!-- <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-os" aria-controls="navs-pills-os" aria-selected="false">Operating System</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-country" aria-controls="navs-pills-country" aria-selected="false">Country</button>
          </li> -->
        </ul>
      </div>
      <div class="tab-content pt-0">
        <div class="tab-pane fade show active" id="navs-pills-rekap" role="tabpanel">
          <div class="table-responsive text-start">
            <table class="table table-borderless text-nowrap">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tingkat</th>
                  <th class="w-50">Data In Percentage</th>
                  <th>Pendaftar Laki-laki</th>
                  <th>Pendaftar Perempuan</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-warning me-2"><i class='bx bx-file'></i></span>
                      <span> TPA</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_tpa = ($tpalk[0]['tpalk'] + $tpapr[0]['tpapr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_tpa < 50)
                        { echo "bg-warning";
                        }elseif ($data_tpa >= 50) {
                        echo "bg-info";
                        }elseif ($data_tpa >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_tpa;?>%" aria-valuenow="<?=$data_tpa;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_tpa,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$tpalk[0]['tpalk'];?></td>
                  <td><?=$tpapr[0]['tpapr'];?></td>
                  <td><?=$tpalk[0]['tpalk'] + $tpapr[0]['tpapr'];?></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> TK Islam</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_tk_islam = ($tkilk[0]['tkilk'] + $tkipr[0]['tkipr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_tk_islam < 50)
                        { echo "bg-warning";
                        }elseif ($data_tk_islam >= 50) {
                        echo "bg-info";
                        }elseif ($data_tk_islam >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_tk_islam;?>%" aria-valuenow="<?=$data_tk_islam;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_tk_islam,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$tkilk[0]['tkilk'];?></td>
                  <td><?=$tkipr[0]['tkipr'];?></td>
                  <td><?=$tkilk[0]['tkilk'] + $tkipr[0]['tkipr'];?></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> Lil Athfal</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_lil = ($lillk[0]['lillk'] + $lilpr[0]['lilpr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_lil < 50)
                        { echo "bg-warning";
                        }elseif ($data_lil >= 50) {
                        echo "bg-info";
                        }elseif ($data_lil >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_lil;?>%" aria-valuenow="<?=$data_lil;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_lil,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$lillk[0]['lillk'];?></td>
                  <td><?=$lilpr[0]['lilpr'];?></td>
                  <td><?=$lillk[0]['lillk'] + $lilpr[0]['lilpr'];?></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> Diniah</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_din = ($dinlk[0]['dinlk'] + $dinpr[0]['dinpr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_din < 50)
                        { echo "bg-warning";
                        }elseif ($data_din >= 50) {
                        echo "bg-info";
                        }elseif ($data_din >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_din;?>%" aria-valuenow="<?=$data_din;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_din,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$dinlk[0]['dinlk'];?></td>
                  <td><?=$dinpr[0]['dinpr'];?></td>
                  <td><?=$dinlk[0]['dinlk'] + $dinpr[0]['dinpr'];?></td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> MI</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_mi = ($milk[0]['milk'] + $mipr[0]['mipr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_mi < 50)
                        { echo "bg-warning";
                        }elseif ($data_mi >= 50) {
                        echo "bg-info";
                        }elseif ($data_mi >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_mi;?>%" aria-valuenow="<?=$data_mi;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_mi,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$milk[0]['milk'];?></td>
                  <td><?=$mipr[0]['mipr'];?></td>
                  <td><?=$milk[0]['milk'] + $mipr[0]['mipr'];?></td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> MTs Pusat</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_mtsp = ($mtsplk[0]['mtsplk'] + $mtsppr[0]['mtsppr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_mtsp < 50)
                        { echo "bg-warning";
                        }elseif ($data_mtsp >= 50) {
                        echo "bg-info";
                        }elseif ($data_mtsp >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_mtsp;?>%" aria-valuenow="<?=$data_mtsp;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_mtsp,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$mtsplk[0]['mtsplk'];?></td>
                  <td><?=$mtsppr[0]['mtsppr'];?></td>
                  <td><?=$mtsplk[0]['mtsplk'] + $mtsppr[0]['mtsppr'];?></td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> MTs Lecah</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_mtsl = ($mtsllk[0]['mtsllk'] + $mtslpr[0]['mtslpr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_mtsl < 50)
                        { echo "bg-warning";
                        }elseif ($data_mtsl >= 50) {
                        echo "bg-info";
                        }elseif ($data_mtsl >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_mtsl;?>%" aria-valuenow="<?=$data_mtsl;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_mtsl,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$mtsllk[0]['mtsllk'];?></td>
                  <td><?=$mtslpr[0]['mtslpr'];?></td>
                  <td><?=$mtsllk[0]['mtsllk'] + $mtslpr[0]['mtslpr'];?></td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> MTs Kuripan</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_mtsk = ($mtsklk[0]['mtsklk'] + $mtskpr[0]['mtskpr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_mtsk < 50)
                        { echo "bg-warning";
                        }elseif ($data_mtsk >= 50) {
                        echo "bg-info";
                        }elseif ($data_mtsk >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_mtsk;?>%" aria-valuenow="<?=$data_mtsk;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_mtsk,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$mtsklk[0]['mtsklk'];?></td>
                  <td><?=$mtskpr[0]['mtskpr'];?></td>
                  <td><?=$mtsklk[0]['mtsklk'] + $mtskpr[0]['mtskpr'];?></td>
                </tr>
                <tr>
                  <td>9</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> MA Pusat</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_map = ($maplk[0]['maplk'] + $mappr[0]['mappr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_map < 50)
                        { echo "bg-warning";
                        }elseif ($data_map >= 50) {
                        echo "bg-info";
                        }elseif ($data_map >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_map;?>%" aria-valuenow="<?=$data_map;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_map,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$maplk[0]['maplk'];?></td>
                  <td><?=$mappr[0]['mappr'];?></td>
                  <td><?=$maplk[0]['maplk'] + $mappr[0]['mappr'];?></td>
                </tr>
                <tr>
                  <td>10</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> MA Lecah</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_mal = ($mallk[0]['mallk'] + $malpr[0]['malpr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']);
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_mal < 50)
                        { echo "bg-warning";
                        }elseif ($data_mal >= 50) {
                        echo "bg-info";
                        }elseif ($data_mal >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_mal;?>%" aria-valuenow="<?=$data_mal;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_mal,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$mallk[0]['mallk'];?></td>
                  <td><?=$malpr[0]['malpr'];?></td>
                  <td><?=$mallk[0]['mallk'] + $malpr[0]['malpr'];?></td>
                </tr>
                <tr>
                  <td>11</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-book'></i></span>
                      <span> MA Kuripan</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <?php
                      $data_mak = ($maklk[0]['maklk'] + $makpr[0]['makpr'])/($total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']) * 100;
                      ?>
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar <?php 
                        if($data_mak < 50)
                        { echo "bg-warning";
                        }elseif ($data_mak >= 50) {
                        echo "bg-info";
                        }elseif ($data_mak >= 100) {
                        echo "bg-primary";
                        }else{
                          echo "bg-danger";
                        }?>" role="progressbar" style="width: <?=$data_mak;?>%" aria-valuenow="<?=$data_mak;?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold"><?php
                      echo number_format($data_mak,2);
                      ?>%</small>
                    </div>
                  </td>
                  <td><?=$maklk[0]['maklk'];?></td>
                  <td><?=$makpr[0]['makpr'];?></td>
                  <td><?=$maklk[0]['maklk'] + $makpr[0]['makpr'];?></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div class="d-flex align-items-center text-center">
                      <span class="avatar-initial rounded bg-label-success me-2"><i class='bx bx-pie-chart'></i></span>
                      <span> Total</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="<?=$total_rekap_laki[0]['total_rekap_laki'] + $total_rekap_perempuan[0]['total_rekap_perempuan'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-semibold">100%</small>
                    </div>
                  </td>
                  <td><?=$total_rekap_laki[0]['total_rekap_laki']?></td>
                  <td><?=$total_rekap_perempuan[0]['total_rekap_perempuan']?></td>
                  <td><?=$total_rekap_laki[0]['total_rekap_laki'] + $total_rekap_perempuan[0]['total_rekap_perempuan'];?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ pill table -->
</div>

<div class="row mt-2">
    <!-- Rekapitulasi Pendaftar Berdasar Lokasi Sekolah -->
  <!-- Bar Charts -->
  <div class="col-xl-8 col-12 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0 center">Rekapitulasi Santri Baru Ponpes Al-Ittifaqiah Berdasarkan Cabang Ponpes Tahun <strong>2022/2023</strong></h5>
      </div>
      <div class="card-body">
        <canvas id="barChartCabang" class="chartjs" data-height="400"></canvas>
      </div>
    </div>
  </div>
  <!-- /Bar Charts -->
  <div class="col-xl-4 col-12">
    <div class="col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
              <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                <div class="card-title">
                  <h5 class="text-nowrap mb-2">Kampus Pusat</h5>
                  <span class="badge bg-label-warning rounded-pill">Tahun <?=$tahun;?></span>
                </div>
                <div class="mt-sm-auto">
                  <small class="text-success text-nowrap fw-semibold"><i class='bx bx-chevron-up'></i> 68.2%</small>
                  <h3 class="mb-0"><?=$total_rekap_laki_pusat+$total_rekap_perempuan_pusat;?></h3>
                </div>
              </div>
              <div id="profileReportChart"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/university.svg" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span>Kuripan</span>
            <h3 class="card-title text-nowrap mb-1"><?=$total_rekap_laki_kuripan+$total_rekap_perempuan_kuripan;?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/building.svg" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span class="d-block mb-1">Lecah</span>
            <h3 class="card-title text-nowrap mb-2"><?=$total_rekap_laki_lecah+$total_rekap_perempuan_lecah;?></h3>
            <small class="text-danger fw-semibold"><i class='bx bx-down-arrow-alt'></i> -14.82%</small>
          </div>
        </div>
      </div>
      </div>
  </div>
  <!-- Rekapitulasi Pendaftar Berdasar Lokasi Sekolah -->
  <!-- Rekapitulasi Pendaftar Berdasar Jenis Sekolah Ogan Ilir -->
  <div class="col-xl-8 col-12 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0 center">Rekapitulasi Santri Baru Ponpes Al-Ittifaqiah Indralaya Tahun <strong>2022/2023</strong></h5>
      </div>
      <div class="card-body">
        <canvas id="barChart" class="chartjs" data-height="400"></canvas>
      </div>
    </div>
  </div>
  <!-- /Bar Charts -->
  <div class="col-xl-4 col-12">
    <div class="col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
              <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                <div class="card-title">
                  <h5 class="text-nowrap mb-2">Total Pendaftar</h5>
                  <span class="badge bg-label-warning rounded-pill">Tahun 2022</span>
                </div>
                <div class="mt-sm-auto">
                  <small class="text-success text-nowrap fw-semibold"><i class='bx bx-chevron-up'></i> 68.2%</small>
                  <h3 class="mb-0"><?=$total_rekap_laki[0]['total_rekap_laki']+$total_rekap_perempuan[0]['total_rekap_perempuan']?></h3>
                </div>
              </div>
              <div id="profileReportChart"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/mars.svg" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span>Laki-laki</span>
            <h3 class="card-title text-nowrap mb-1"><?=$total_rekap_laki[0]['total_rekap_laki']?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/venus.svg" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span class="d-block mb-1">Perempuan</span>
            <h3 class="card-title text-nowrap mb-2"><?=$total_rekap_perempuan[0]['total_rekap_perempuan']?></h3>
            <small class="text-danger fw-semibold"><i class='bx bx-down-arrow-alt'></i> -14.82%</small>
          </div>
        </div>
      </div>
      </div>
  </div>
  <!-- Rekapitulasi Pendaftar Berdasar Jenis Sekolah Ogan Ilir-->




  <!-- Rekapitulasi Pendaftar Berdasar Jenis Mukim -->
  <!-- Bar Charts -->
  <div class="col-xl-8 col-12 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0 center">Rekapitulasi Santri Baru Ponpes Al-Ittifaqiah Berdasarkan (Mukim/Non-Mukim) Tahun <strong>2022/2023</strong></h5>
      </div>
      <div class="card-body">
        <canvas id="barChartMukim" class="chartjs" data-height="400"></canvas>
      </div>
    </div>
  </div>
  <!-- /Bar Charts -->
  <div class="col-xl-4 col-12">
  <div class="row">
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span>Mukim (Lk)</span>
            <h3 class="card-title text-nowrap mb-1"><?=$mukim_mts_laki+$mukim_ma_laki?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span class="d-block mb-1">Non-Mukim (Lk)</span>
            <h3 class="card-title text-nowrap mb-2"><?=$non_mukim_mts_laki+$non_mukim_ma_laki?></h3>
            <small class="text-danger fw-semibold"><i class='bx bx-down-arrow-alt'></i> -14.82%</small>
          </div>
        </div>
      </div>
      </div>
      <div class="row">
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span>Mukim (Pr)</span>
            <h3 class="card-title text-nowrap mb-1"><?=$mukim_mts_perempuan+$mukim_ma_perempuan?></h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="../dashboard/assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span class="d-block mb-1">Non-Mukim (Pr)</span>
            <h3 class="card-title text-nowrap mb-2"><?=$non_mukim_mts_perempuan+$non_mukim_ma_perempuan?></h3>
            <small class="text-danger fw-semibold"><i class='bx bx-down-arrow-alt'></i> -14.82%</small>
          </div>
        </div>
      </div>
      </div>
  </div>
  <!-- Rekapitulasi Pendaftar Berdasar Jenis Mukim -->



    <!-- Rekapitulasi Pendaftar Berdasar Domisili -->
  <!-- Bar Charts -->
  <div class="col-xl-12 col-12 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0 center">Rekapitulasi Santri Baru Ponpes Al-Ittifaqiah Berdasarkan Domisili Santri Tahun <strong>2022/2023</strong></h5>
      </div>
      <div class="card-body">
        <canvas id="barChartDomisili" class="chartjs" data-height="400"></canvas>
      </div>
    </div>
  </div>

  <!-- Rekapitulasi Pendaftar Berdasar Domisili -->


  <!-- Rekapitulasi Pendaftar Berdasar Pekerjaan Ortu Santri -->
  <!-- Bar Charts -->
  <!-- <div class="col-xl-12 col-12 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0 center">Rekapitulasi Santri Baru Ponpes Al-Ittifaqiah Berdasarkan Pekerjaan Ortu Santri Tahun <strong>2022/2023</strong></h5>
      </div>
      <div class="card-body">
        <canvas id="barChartJob" class="chartjs" data-height="400"></canvas>
      </div>
    </div>
  </div> -->

  <!-- Rekapitulasi Pendaftar Berdasar Pekerjaan Ortu Santri -->

  
</div>

            
          </div>
          <!-- / Content -->

          
          

<!-- Footer -->
<?php
include 'footer.php';
?>
<!-- / Footer -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
$jumlil = $lillk[0]['lillk']+$lilpr[0]['lilpr'];
$jumtpa = $tpalk[0]['tpalk']+$tpapr[0]['tpapr'];
$jumdin = $dinlk[0]['dinlk']+$dinpr[0]['dinpr'];
$jumtki = $tkilk[0]['tkilk']+$tkipr[0]['tkipr'];
$jummi = $milk[0]['milk']+$mipr[0]['mipr'];
$jummts = $mtsplk[0]['mtsplk']+$mtsppr[0]['mtsppr']+$mtsllk[0]['mtsllk']+$mtslpr[0]['mtslpr']+$mtsklk[0]['mtsklk']+$mtskpr[0]['mtskpr'];
$jumma = $maplk[0]['maplk']+$mappr[0]['mappr']+$mallk[0]['mallk']+$maklk[0]['maklk']+$makpr[0]['makpr'];
?>
<script>
  // Rekapitulasi Pendaftaran Berdasarkan Jenis
  const ctx = document.getElementById('barChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Mujahadah dan Pembibitan','TPA','Madrasah Diniah','TK Islam','MI/SD','MTs/SMP','MA/SMA'],
      datasets: [{
        label: 'Jumlah',
        data: [<?=$jumlil?>,<?=$jumtpa?>,<?=$jumdin?>,<?=$jumtki?>,<?=$jummi?>,<?=$jummts?>,<?=$jumma?>],
        backgroundColor: [
          'rgba(153, 102, 255, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
        },
        {
        label: 'Laki-Laki',
        data: [<?=$lillk[0]['lillk']?>,<?=$tpalk[0]['tpalk']?>,<?=$dinlk[0]['dinlk']?>,<?=$tkilk[0]['tkilk']?>,<?=$milk[0]['milk']?>,<?=$mtsplk[0]['mtsplk']+$mtsllk[0]['mtsllk']+$mtsklk[0]['mtsklk']?>,<?=$maplk[0]['maplk']+$mallk[0]['mallk']+$maklk[0]['maklk']?>],
        backgroundColor: [
          'rgba(255, 99, 132, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
      },
      {
        label: 'Perempuan',
        data: [<?=$lilpr[0]['lilpr']?>,<?=$tpapr[0]['tpapr']?>,<?=$dinpr[0]['dinpr']?>,<?=$tkipr[0]['tkipr']?>,<?=$mipr[0]['mipr']?>,<?=$mtsppr[0]['mtsppr']+$mtslpr[0]['mtslpr']+$mtskpr[0]['mtskpr']?>,<?=$mappr[0]['mappr']+$malpr[0]['malpr']+$makpr[0]['makpr']?>],
        backgroundColor: [
          'rgba(255, 205, 86, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Rekapitulasi Pendaftaran Berdasarkan Cabang Ponpes

  const ctxcabang = document.getElementById('barChartCabang');

  new Chart(ctxcabang, {
    type: 'bar',
    data: {
      labels: ['Kampus Indralaya Ogan Ilir','Kampus Kuripan OKU Selatan','Kampus Lecah Muara Enim'],
      datasets: [{
        label: 'Jumlah',
        data: [<?= "$total_rekap_laki_pusat+$total_rekap_perempuan_pusat, $total_rekap_laki_kuripan+$total_rekap_perempuan_kuripan, $total_rekap_laki_lecah+$total_rekap_perempuan_lecah"?>],
        backgroundColor: [
          'rgba(153, 102, 255, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
        },
        {
        label: 'Laki-Laki',
        data: [<?="$total_rekap_laki_pusat, $total_rekap_laki_kuripan, $total_rekap_laki_lecah"?>],
        backgroundColor: [
          'rgba(255, 99, 132, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
      },
      {
        label: 'Perempuan',
        data: [<?="$total_rekap_perempuan_pusat, $total_rekap_perempuan_kuripan, $total_rekap_perempuan_lecah"?>],
        backgroundColor: [
          'rgba(255, 205, 86, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  // Rekapitulasi Mukim/NonMukim
  const ctmukim = document.getElementById('barChartMukim');

  new Chart(ctmukim, {
    type: 'bar',
    data: {
      labels: ['MTs Pusat','MA Pusat','Total'],
      datasets: [{
        label: 'Mukim (Lk)',
        data: [<?=$mukim_mts_laki?>,<?=$mukim_ma_laki?>,<?=$mukim_mts_laki+$mukim_ma_laki?>],
        backgroundColor: [
          'rgba(153, 102, 255, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
        },
        {
        label: 'Non Mukim (Lk)',
        data: [<?=$non_mukim_mts_laki?>,<?=$non_mukim_ma_laki?>,<?=$non_mukim_mts_laki+$non_mukim_ma_laki?>],
        backgroundColor: [
          'rgba(255, 99, 132, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
      },
      {
        label: 'Mukim (Pr)',
        data: [<?=$mukim_mts_perempuan?>,<?=$mukim_ma_perempuan?>,<?=$mukim_mts_perempuan+$mukim_ma_perempuan?>],
        backgroundColor: [
          'rgba(255, 205, 86, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
      },
      {
        label: 'Non Mukim (Pr)',
        data: [<?=$non_mukim_mts_perempuan?>,<?=$non_mukim_ma_perempuan?>,<?=$non_mukim_mts_perempuan+$non_mukim_ma_perempuan?>],
        backgroundColor: [
          'rgba(255, 255, 86, 0.9)'
        ],
        borderWidth: 1,
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

    // Rekapitulasi Domisili
    const ctdomisili = document.getElementById('barChartDomisili');

    new Chart(ctdomisili, {
      type: 'bar',
      data: {
        labels: [
          <?php
                       foreach ($rekap_provinsi as $rkp_prov) {
                        echo '"'.$rkp_prov['provinsi'].'",';
                      }
                    ?>
        ],
        datasets: [
        {
          label: 'Jumlah',
          data: [
            <?php
                       foreach ($rekap_provinsi as $rkp_prov) {
                        echo '"'.$rkp_prov['jumlah'].'",';
                      }
                    ?>
          ],
          backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 205, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(201, 203, 207, 0.7)'
          ],
          borderWidth: 1,
          borderRadius: 5
        }]
      },
      options: {
        indexAxis: 'y',
        // pointStyle: 'circle',
        responsive: true,
        plugins: {
          legend: {
            position: 'right',
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Rekapitulasi Job
    const ctjob = document.getElementById('barChartJob');

    new Chart(ctjob, {
      type: 'bar',
      data: {
        labels: ['Pensiunan','Guru','Dosen'],
        datasets: [{
          label: 'Pekerjaan Orang Tua Ayah',
          data: [12,32,12,2,2,1,12],
          backgroundColor: [
            'rgba(153, 102, 255, 0.9)'
          ],
          borderWidth: 1,
          borderRadius: 5
          },
          {
          label: 'Pekerjaan Orang Tua Ibu',
          data: [12, 19, 3, 5, 2, 3,15],
          backgroundColor: [
            'rgba(255, 99, 132, 0.9)'
          ],
          borderWidth: 1,
          borderRadius: 5
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          }
        },
        scales: {
          x:{
            stacked: true,
          },
          y: {
            stacked: true,
            beginAtZero: true
          }
        }
      }
    });
</script>  
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php 
$totaccfix = $totacc[0]['totacc'];
$totdecfix = $totdec[0]['totdec'];
$totveriffix = $totverif[0]['totverif'];
$totnveriffix = $totnverif[0]['totnverif'];
?>
<script>
     var options = {
          labels: ['Diterima', 'Ditolak', 'Sudah Verifikasi', 'Belum Verifikasi'],
          series: [<?=$totaccfix;?>, <?=$totdecfix;?>, <?=$totveriffix;?>, <?=$totnveriffix;?>],
          chart: {
          width: 180,
          type: 'donut',
        },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270
          }
        },
        dataLabels: {
          enabled: false
        },
        fill: {
          type: 'gradient',
        },
        legend: {
          show: false
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              show: false
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#orderStatisticsChart"), options);
        chart.render();  
</script>


        </div>
        <!-- Content wrapper -->
    
    
        <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>