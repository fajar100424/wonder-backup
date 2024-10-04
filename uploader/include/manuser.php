<?php
$users = query("SELECT * FROM users");
$totusers = query("SELECT COUNT(id_user) AS 'totusers' FROM users")[0];
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
                <h5 class="p">Manajemen User Sistem WONDER</h5>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewUser"> Tambah User + </button>
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Daftar Pengguna <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$totusers['totusers'];?></span></button>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                 
                <!-- <form action="func/tambahjen.php" method="POST">
                  <div class="row">
                      <div class="col-lg-3">
                      <input type="text" name="jenis" class="form-control-md form-control" placeholder="Tambah Jenis Donasi">
                      </div>
                      <div class="col-lg-3">
                      <button type="submit" class="btn btn-primary">Tambah <i class="bx bx-send"></i></button>
                      </div>
                  </div>
                </form> -->
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
                        <th>Username</th>
                        <th>No Telpon</th>
                        <th>Role</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;
                      foreach ($users as $usr) {?>
                      <tr>
                        <td><?=$i;?></td>
                        <td><a href="index.php?page=10&id_user<?=$usr['id_user']?>"><?=ucwords($usr['nama']);?></a></td>
                        <td><?=ucwords($usr['username']);?></td>
                        <td><?=hp($usr['no_hp']);?></td>
                        <td>
                          <?php if ($usr['role'] === "superadmin") {?>
                            <span class="badge bg-label-success">Superadmin</span>
                          <?php }elseif ($usr['role'] === "reviewer") {?>
                            <span class="badge bg-label-warning">Reviewer</span>
                          <?php } else {?>
                            <span class="badge bg-label-primary">Uploader</span>
                          <?php } ?>
                        </td>
                        <td><?=date('l, d F Y', strtotime($usr["created_at"]));?></td>
                        <td>
                          <div class="d-inline-block">
                            <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                            <a href="index.php?page=ubahuser&id=<?=$usr['id_user'];?>" class="dropdown-item">Ubah User</a>
                              <div class="dropdown-divider"></div>
                              <a href="func/hapususer.php?id=<?=$usr['id_user'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus User Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php $i++;}?>
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Username</th>
                          <th>No Telpon</th>
                          <th>Role</th>
                          <th>Dibuat Pada</th>
                          <th>Aksi</th>
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
          
        </div>
        </div>
        <!-- Content -->
        
        <!-- Footer -->
        <?php
          include 'footer.php';
        ?>
        <!-- / Footer -->
    </div>
    <!-- / Content wrapper -->

    <!-- Add New User -->
    <div class="modal fade" id="addNewUser" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-body">
            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3>Tambah User</h3>
              <p>Tambah User Baru di Sistem WONDER</p>
            </div>
              <form action="func/adduser.php" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Nama</div>
                              <input type="text" class="form-control" name="nama" id="nama">
                          </div>
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Username</div>
                              <input type="text" class="form-control" name="username" id="username">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Password</div>
                              <input type="password" class="form-control" name="password" id="password">
                          </div>
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Konfirmasi Password</div>
                              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Role</div>
                              <select name="role" class="form-control" id="role">
                                <option value="superadmin">Superadmin</option>
                                <option value="reviewer">Reviewer</option>
                                <option value="uploader">Uploader</option>
                              </select>
                          </div>
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Jabatan</div>
                              <input type="text" class="form-control" name="jabatan" id="jabatan">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Jenis Kelamin</div>
                              <select name="jk" class="form-control" id="jk">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                              </select>
                          </div>
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">No Handphone</div>
                              <div class="input-group input-group-merge">
                                <span class="input-group-text">IDN (+62)</span>
                                <input type="number" name="no_hp" class="form-control" placeholder="812 5556 0111" required/>
                              </div>
                              <!-- <input type="text" class="form-control" name="notelp" id="notelp"> -->
                          </div>
                        </div>
                        <div class="form-group mt-4">
                            <div class="form-label">Tanggal Lahir</div>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                        </div>
                        <div class="form-group mt-4">
                            <div class="form-label">Foto User</div>
                            <input type="file" class="form-control" name="gambar" id="gambar">
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
    <!--/ Add New User -->  
          


         
  <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>
