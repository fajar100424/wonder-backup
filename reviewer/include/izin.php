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
  $tahun = query("SELECT * FROM thn_ajaran WHERE status = '1'")[0];
  $tahunon = $tahun['id_thn'];
  $semester = query("SELECT * FROM semester WHERE status = '1'")[0];
  $semesteron = $semester['semester'];
  $countizp = query("SELECT COUNT(id_izin_pulang) AS 'jumizp' FROM izin_pulang WHERE id_santri ='$idsan'")[0];
  $countizk = query("SELECT COUNT(id_izin_keluar) AS 'jumizk' FROM izin_keluar WHERE id_santri = '$idsan'")[0];
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
                                <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=13&idsan=<?=$idsan;?>"><i class='bx bx-book'></i> Tahfidz</a></li>
                                <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=14&idsan=<?=$idsan;?>"><i class='bx bx-pencil'></i> Suluk</a></li>
                                <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=15&idsan=<?=$idsan;?>"><i class='bx bx-car'></i> Kunjungan</a></li>
                                <li class="mb-4 nav-item"><a class="nav-link" href="index.php?page=16&idsan=<?=$idsan;?>"><i class='bx bx-plus-medical'></i> Kesehatan</a></li>
                                <li class="mb-4 nav-item"><a class="nav-link active" href="index.php?page=17&idsan=<?=$idsan;?>"><i class='bx bx-wrench'></i> Izin Keluar & Pulang</a></li>
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
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-izin-pulang" aria-controls="navs-pills-justified-izin-pulang" aria-selected="false"><i class="tf-icons bx bx-notepad"></i>Laporan Izin Pulang Santri <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countizp['jumizp'];?></span></button>
                            </li>
                            <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-izin-keluar" aria-controls="navs-pills-justified-izin-keluar" aria-selected="false"><i class="tf-icons bx bx-notepad"></i>Laporan Izin Keluar Santri <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countizk['jumizk'];?></span></button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-justified-izin-pulang" role="tabpanel">
                                <div class="card-datatable table-responsive">
                                <table id="manizinpulang" class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Hari</th>
                                    <th>Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i =1;
                                    $izinpulang = query("SELECT * FROM izin_pulang WHERE id_santri = '$idsan'");
                                    foreach ($izinpulang as $izp) :?>
                                    <tr>
                                    <td><?=$i;?></td>
                                    <td><?=date('l, d F Y', strtotime($izp["tgl"]));?></td>
                                    <td><?=$izp['jumlah'].' Hari';?></td>
                                    <td><?=ucwords($izp['keterangan']);?></td>
                                    </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Hari</th>
                                    <th>Keterangan</th>
                                </tr>
                                </tfoot>
                            </table>
                            <script>
                                            $(document).ready(function() {
                                                $('#manizinpulang').DataTable( {
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
                            <div class="tab-pane fade" id="navs-pills-justified-izin-keluar" role="tabpanel">
                                <div class="card-datatable table-responsive">
                                <table id="manizinkeluar" class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pukul</th>
                                    <th>Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i =1;
                                    $izin_keluar = query("SELECT * FROM izin_keluar WHERE id_santri = '$idsan'");
                                    foreach ($izin_keluar as $izk) :?>
                                    <tr>
                                    <td><?=$i;?></td>
                                    <td><?=date('l, d F Y', strtotime($izk["tgl"]));?></td>
                                    <td><?=$izk['jam_start'].' - '.$izk['jam_end'];?></td>
                                    <td><?=ucwords($izk['keterangan']);?></td>
                                    </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pukul</th>
                                    <th>Keterangan</th>
                                </tr>
                                </tfoot>
                            </table>
                            <script>
                                            $(document).ready(function() {
                                                $('#manizinkeluar').DataTable( {
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
