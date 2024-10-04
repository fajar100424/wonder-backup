<?php
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
$countcatatan = query("SELECT COUNT(id_catatan) AS 'jumcatatan' FROM catatan WHERE id_santri = '$idsan'")[0];
$tahun = query("SELECT * FROM thn_ajaran WHERE status = '1'")[0];
  $tahunon = $tahun['id_thn'];
  $semester = query("SELECT * FROM semester WHERE status = '1'")[0];
  $semesteron = $semester['semester'];
?>

      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
        <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
        <div class="col-12">
            <div class="card mb-4">
            <div class="user-profile-header-banner">
                <img src="../dashboard/assets/img/pages/header.png" alt="Banner image" class="rounded-top">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                <img src="../dashboard/assets/img/avatars/<?=$santri['gambar'];?>" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img">
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                    <h4><?=ucwords($santri['fullname']);?> (<?=ucwords($santri['NIS']);?>)</h4>
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
                    <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                    <i class='bx bx-user-check'></i> <?=ucwords($santri['status']);?>
                    </a>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <!--/ Header -->
        <!-- Navbar pills -->
        <div class="row">
            <div class="col-lg-12">
            <div class="card mb-4">
            <div class="card-header">
            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active"><i class="tf-icons bx bx-home"></i> Informasi Santri</button>
                  </li>
              </ul>
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <!-- Profile Overview -->
                    <div class="card mb-4">
                      <div class="card-body">
                            <!-- <small class="text-muted text-uppercase"></small> -->
                            <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user-check"></i><span class="fw-semibold mx-2">Tahun Ajaran: </span> <span style="font-weight: bolder;"><?=ucwords($tahunajaran);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span class="fw-semibold mx-2">Semester: </span> <span><?=ucwords($semesteron);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class='bx bx-phone'></i><span class="fw-semibold mx-2">No. Telpon Ortu:</span> <span><?=$santri['waortu'];?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-home-alt"></i><span class="fw-semibold mx-2">Kelas: </span> <span><?=ucwords($kelas);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span class="fw-semibold mx-2">Status:</span> <span><?=ucwords($santri['status']);?></span></li>
                            </ul>
                      </div>
                    </div>
                    <!--/ Profile Overview -->
                </div>
                </div> 
            </div>
            </div>
            </div>
        </div>
        <!--/ Navbar pills -->
        <div class="row">
            <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="col-md-12">
                            <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                              <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=12&idsan=<?=$idsan;?>"><i class='bx bx-user'></i>Catatan Santri</a></li>
                              <li class="mb-4 nav-item"><a class="nav-link active" href="index.php?page=13&idsan=<?=$idsan;?>"><i class='bx bx-book'></i> Tahfidz</a></li>
                              <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=14&idsan=<?=$idsan;?>"><i class='bx bx-pencil'></i> Suluk</a></li>
                              <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=15&idsan=<?=$idsan;?>"><i class='bx bx-car'></i> Kunjungan</a></li>
                              <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=16&idsan=<?=$idsan;?>"><i class='bx bx-plus-medical'></i> Kesehatan</a></li>
                              <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=17&idsan=<?=$idsan;?>"><i class='bx bx-wrench'></i> Izin Keluar & Pulang</a></li>
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
                              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-book"></i>Daftar Mata Pelajaran Santri Semester Ini</button>
                              </li>
                          </ul>
                          <div class="tab-content">
                              <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                              <?php
                              // Update harus dinamis
                              $idkelas =0;
                                if ($idkelas > 0) {?>
                                <h5>Silakan Pilih Mata Pelajaran: </h5>
                              <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                                  <?php
                                  $mapel = query("SELECT mapel.*,kelas.*,jadwal.* FROM jadwal INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas INNER JOIN mapel ON jadwal.id_mapel = mapel.id_mapel WHERE jadwal.id_kelas = '$idkelas' GROUP BY mapel.mapel;");
                                  foreach ($mapel as $mpl) :?>
                                  <li class="nav-item mr-5" style="margin-right: 5px;margin-bottom:5px;"><a class="nav-link active btn btn-lg" href="#"><i class='bx bx-book'></i><?=ucwords($mpl['mapel']);?></a></li>
                                  <?php endforeach; ?>
                              </ul>
                              <?php } else {?>
                                <h4 class="text-warning">Belum Ada Data Kelas Santri</h4>
                              <?php } ?>
                              </div>
                          </div>
                          </div>
                          </div>

                      </div>
                      </div>
                      <!--/ Profile Overview -->
                  </div>
              </div>
              <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12">
                      <!-- Profile Overview -->
                      <div class="card mb-4">
                      <div class="card-body">
                          <div class="col-xl-12">
                          <div class="nav-align-top mb-4">
                          <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                              <li class="nav-item">
                              <button type="button" class="nav-link active"><i class="tf-icons bx bx-note"></i>Riwayat Tahfidz Santri</button>
                              </li>
                          </ul>
                          <div class="tab-content">
                              <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                              <div class="card-datatable table-responsive">
                                <table id="manlaphafalan" class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Tanggal</th>
                                    <th>Mapel</th>
                                    <th>Materi</th>
                                    <th>Jumlah Hafalan Baru</th>
                                    <th>Remedial 1</th>
                                    <th>Remedial 2</th>
                                    <th>Remedial 3</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i=1;
                                    $tahfidz = query("SELECT * FROM tahfidz WHERE id_santri = '$idsan'");
                                    foreach ($tahfidz as $tfz) :?>
                                    <tr>
                                      <?php
                                      $id_jadwal = $tfz['id_jadwal'];
                                      $jadwal = query("SELECT * FROM jadwal WHERE id_jadwal = '$id_jadwal'")[0];
                                      $idmapel = $jadwal['id_mapel'];
                                      $mapel = query("SELECT * FROM mapel WHERE id_mapel = '$idmapel'")[0];
                                      $idmateri = $tfz['id_materi'];
                                      $materi = query("SELECT * FROM materi WHERE id_materi = '$idmateri'")[0];
                                      ?>
                                      <td><?=$i;?></td>
                                      <td>
                                        <?php
                                        $idtahun = $tfz['id_tahun'];
                                        $tahun = query("SELECT * FROM thn_ajaran WHERE id_thn = '$idtahun'")[0];
                                        ?>
                                        <?=$tahun['thn_ajaran_start'].'/'.$tahun['thn_ajaran_end'];?>
                                      </td>
                                      <td><?=ucwords($tfz['semester']);?></td>
                                      <td><?=date('l, d F Y', strtotime($tfz["tanggal"]));?></td>
                                      <td><?=ucwords($mapel['mapel']);?></td>
                                      <td><?=ucwords($materi['bab']);?></td>
                                      <td><?=$tfz['jum_hafalan'];?> Halaman</td>
                                      <td><?=$tfz['remed1'];?></td>
                                      <td><?=$tfz['remed2'];?></td>
                                      <td><?=$tfz['remed3'];?></td>
                                    </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Tanggal</th>
                                    <th>Mapel</th>
                                    <th>Materi</th>
                                    <th>Jumlah Hafalan Baru</th>
                                    <th>Remedial 1</th>
                                    <th>Remedial 2</th>
                                    <th>Remedial 3</th>
                                </tr>
                                </tfoot>
                                </table>
                                <script>
                                                $(document).ready(function() {
                                                    $('#manlaphafalan').DataTable( {
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
        </div>
        <!-- Content wrapper -->
        <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>