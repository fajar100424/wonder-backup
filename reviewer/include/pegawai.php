<?php
$users = query("SELECT * FROM users WHERE is_deleted = '0' AND id_unit != '1'");
$totusers = query("SELECT COUNT(id_user) AS 'totusers' FROM users WHERE id_unit != '1'")[0];
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
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Daftar Pegawai <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$totusers['totusers'];?></span></button>
                  </li>
                </ul>
              </div>
              <div class="card-body">
              <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                  <div class="card-datatable table-responsive">
                  <table id="manusers" class="table table-responsive table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Telpon</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Unit</th>
                        <th>Dibuat Pada</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;
                      foreach ($users as $usr) {?>
                      <tr>
                        <td><?=$i;?></td>
                        <td><?=ucwords($usr['fullname']);?></td>
                        <td><?=ucwords($usr['email']);?></td>
                        <td><?=hp($usr['notelp']);?></td>
                        <td><?=ucwords($usr['alamat']);?></td>
                        <td>
                          <?php if ($usr['status'] === "aktif") {?>
                            <span class="badge bg-label-success">Aktif</span>
                          <?php }elseif ($usr['status'] === "nonaktif") {?>
                            <span class="badge bg-label-danger">Non-Aktif</span>
                          <?php } else {?>
                            <span class="badge bg-label-warning">Error</span>
                          <?php } ?>
                        </td>
                        <td><?php
                        $idunt = $usr['id_unit'];
                        $unit = query("SELECT unit FROM unit WHERE id_unit = '$idunt'")[0];
                        ?><?=ucwords($unit['unit']);?></td>
                        <td><?=date('l, d F Y', strtotime($usr["created_At"]));?></td>
                      </tr>
                      <?php $i++;}?>
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>No Telpon</th>
                          <th>Alamat</th>
                          <th>Status</th>
                          <th>Unit</th>
                          <th>Dibuat Pada</th>
                        </tr>
                    </tfoot>
                  </table>
                  <script>
                                $(document).ready(function() {
                                      $('#manusers').DataTable( {
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
          <!-- Tambah Pengguna -->
          <!-- <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card">
              <div class="card-header">
                <h5 class="p">Tambah Pengguna Baru</h5>
                <hr>
              </div>
              <div class="card-body">
                <form action="func/adddonasi.php" id="formAccountSettings" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="assets/img/infaq.jpg" alt="infaq" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload Gambar Donasi</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="gambar" class="form-control"/>
                                </label>
                                <p class="text-muted mb-0">Format yang diizinkan JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                            </div>
                        </div>
                        <br>
                        
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                <label for="produk" class="form-label">Nama Donasi <span class="text-danger">*</span></label>
                                <input class="form-control" type="produk" id="produk" name="produk" placeholder="Nama Donasi Atau Judul Donasi" autofocus required/>
                                </div>
                                <div class="mb-3 col-md-6">
                                <?php
                                    $kategori = query("SELECT * FROM kategori");
                                ?>
                                <label for="kategori" class="form-label">Kategori Donasi <span class="text-danger">*</span></label>
                                <select name="kategori" id="kategori" required class="select2 form-select">
                                    <option value="">-- Pilih Kategori Donasi --</option>
                                    <?php foreach ($kategori as $ktg) {?>
                                    <option value="<?=$ktg['id_kategori'];?>"><?=ucwords($ktg['kategori']);?></option>
                                    <?php } ?>
                                </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                <label for="deskripsi" class="form-label">Deskripsi Donasi <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Silakan Tuliskan Deskripsi Donasi di Kolom Ini "></textarea>
                                </div>
                                <div class="mb-3 col-md-6">
                                <label for="target" class="form-label">Target Dana <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text">Rp.</span>
                                    <input type="number" name="target" id="target" class="form-control" placeholder="Target Dana Yang Ingin Dikumpulkan"/>
                                </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                <label for="deadline" class="form-label">Tenggat Waktu <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="deadline" name="deadline" placeholder="Tenggat Waktu" autofocus required/>
                                </div>
                                <div class="mb-3 col-md-6">
                                <?php
                                    $administrator = query("SELECT * FROM users");
                                ?>
                                <label for="admin" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                <select name="admin" id="admin" required class="select2 form-select">
                                    <option value="">-- Pilih Penanggung Jawab --</option>
                                    <?php foreach ($administrator as $admin) {?>
                                    <option value="<?=$admin['id_user'];?>"><?=ucwords($admin['fullname']);?></option>
                                    <?php } ?>
                                </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status Donasi <span class="text-danger">*</span></label>
                                <select name="status" id="status" required class="select2 form-select">
                                    <option value="">-- Pilih Status Donasi --</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
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
          </div> -->
          
        </div>

        </div>
        <!-- Content -->
        <!-- Footer -->
        <?php include 'footer.php'; ?>
        <!-- / Footer -->
    </div>
    <!-- / Content wrapper -->

  <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>
