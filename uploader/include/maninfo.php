<?php
$countinfo = query("SELECT COUNT(id_info) AS 'juminfo' FROM info");
$event = query("SELECT * FROM calendar");
$countkegiatan = query("SELECT COUNT(id_calendar) AS 'jumkegiatan' FROM calendar");
?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-12 mb-4">
                <div class="card">
                <div class="card-header">
                <h5 class="p">Manajemen Informasi</h5>
                </div>
                <div class="card-body">
                <div class="col-xl-12">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Daftar Informasi <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countinfo[0]['juminfo'];?></span></button>
                    </li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                    <div class="card-datatable table-responsive">
                    <table id="maninfo" class="table table-responsive table-bordered">
                        <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Heading</th>
                            <th>Keterangan</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($info as $inf) :?>
                        <tr>
                            <td><img src="assets/img/info/<?=$inf['gambar'];?>" alt="<?=$inf['gambar'];?>" class="w-px-50 rounded"></td>
                            <td><?=ucwords($inf['heading']);?></td>
                            <td><?=ucwords($inf['keterangan']);?></td>
                            <td><?=date('l, d F Y', strtotime($inf["created_at"]));?></td>
                            <td>
                            <div class="d-inline-block">
                                    <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="func/hapusinfo.php?id=<?=$inf['id_info'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Info Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                    </div>
                                    </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Gambar</th>
                            <th>Heading</th>
                            <th>Keterangan</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                        </tfoot>
                    </table>
                    <script>
                                    $(document).ready(function() {
                                        $('#maninfo').DataTable( {
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
              <div class="card-header">
                <h5 class="p">Tambah Informasi Baru</h5>
                <hr>
              </div>
              <div class="card-body">
                <form action="func/addinfo.php" id="formAccountSettings" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="assets/img/illustrations/bulb-light.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload Foto Informasi Baru</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="gambar" class="form-control"/>
                                </label>
                                <p class="text-muted mb-0">Format yang diizinkan JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                            </div>
                        </div>
                        <br>
                        
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                <label for="h2" class="form-label">Header Informasi <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="heading" name="heading" placeholder="Masukkan Text Header Informasi" autofocus required/>
                                </div>
                                <div class="mb-3 col-md-12">
                                <label for="keterangan" class="form-label">Deskripsi Informasi <span class="text-danger">*</span></label>
                                <textarea name="keterangan" id="keterangan" cols="3" rows="3" class="form-control"></textarea>
                                </div>
                                
                                <span><small><span class="text-danger">*</span>) Kolom wajib diisi.</small></span>
                                
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan <i class="bx bx-send"></i></button>
                                <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></button>
                            </div>
                            </form>
                
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-12 mb-4" id="event">
                <div class="card">
                <div class="card-header">
                <h5 class="p">Manajemen Kegiatan Kalender Akademik</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewEvent"> Tambah Kegiatan + </button>
                </div>
                <div class="card-body">
                <div class="col-xl-12">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active"><i class="tf-icons bx bx-home"></i> Daftar Kegiatan Akademik <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countkegiatan[0]['jumkegiatan'];?></span></button>
                    </li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane fade show active">
                    <div class="card-datatable table-responsive">
                    <table id="mankegiatan" class="table table-responsive table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Mulai</th>
                            <th>Berakhir</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($event as $evt) {?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?=ucwords($evt['kegiatan']);?></td>
                            <td><?=date('l, d F Y, H:i', strtotime($evt["mulai"]));?></td>
                            <td><?=date('l, d F Y, H:i', strtotime($evt["selesai"]));?></td>
                            <td>
                            <div class="d-inline-block">
                                    <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="func/hapusevent.php?id=<?=$evt['id_calendar'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Kegiatan Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                    </div>
                                    </div>
                            </td>
                        </tr>
                        <?php $i++;}?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Mulai</th>
                            <th>Berakhir</th>
                            <th>Aksi</th>
                        </tr>
                        </tfoot>
                    </table>
                    <script>
                                    $(document).ready(function() {
                                        $('#mankegiatan').DataTable( {
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

        </div>
        <!-- Footer -->
        <?php
          include 'footer.php';
        ?>
        <!-- / Footer -->
    </div>
    <!-- / Content wrapper -->

<!-- Add New Event -->
<div class="modal fade" id="addNewEvent" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3>Tambah Kegiatan Seputar WONDER</h3>
          <p>Tambah Kegiatan Baru di Kalendar Seputar WONDER</p>
        </div>
          <form action="func/addevent.php" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-label">Keterangan Kegiatan</div>
                        <textarea name="kegiatan" class="form-control" id="kegiatan" cols="30"
                            rows="2"></textarea>
                    </div>
                    <div class="form-group mt-4">
                        <div class="form-label">Tgl Mulai</div>
                        <input type="datetime-local" class="form-control" name="mulai" id="mulai">
                    </div>
                    <div class="form-group mt-4">
                        <div class="form-label">Tgl Selesai</div>
                        <input type="datetime-local" class="form-control" name="selesai" id="selesai">
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
          </form>
      </div>
    </div>
  </div>
</div>
<!--/ Add New Event -->  


  <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>
