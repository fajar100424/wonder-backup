<?php
$sumur = query("SELECT * FROM sumur");
$countsumur = query("SELECT COUNT(id_sumur) AS 'jumsumur' FROM sumur");
$countrig = query("SELECT COUNT(id_rig) AS 'jumrig' FROM rig");
$rig = query("SELECT * FROM rig");
?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        
        <div class="container flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-6 mb-4">
            <div class="card">
              <div class="card-header">
              <h5 class="p">Manajemen Data Sumur</h5>
              <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewSumur"> Tambah Sumur + </button>
              </div>
              <div class="card-body">
              <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Daftar Summur<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countsumur[0]['jumsumur'];?></span></button>
                  </li>
                </ul>
                
                <div class="">
                  <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                  <div class="card-datatable table-responsive">
                  <table id="mansumur" class="table table-responsive table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Sumur</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;
                      foreach ($sumur as $smr) {?>
                      <tr>
                        <td><?=$i;?></td>
                        <td><?=ucwords($smr['nama_sumur']);?></td>
                        <td>
                          <div class="d-inline-block">
                            <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                            <a href="index.php?page=ubahsumur&id=<?=$smr['id_sumur'];?>" class="dropdown-item">Ubah Sumur</a>
                              <div class="dropdown-divider"></div>
                              <a href="func/hapussumur.php?id=<?=$smr['id_sumur'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Sumur Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php $i++;}?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Nama Sumur</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
                  <script>
                                $(document).ready(function() {
                                      $('#mansumur').DataTable( {
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

        <div class="col-lg-6 col-md-6 col-6 mb-4">
            <div class="card">
              <div class="card-header">
              <h5 class="p">Manajemen Data Rig</h5>
              <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewRig"> Tambah Rig + </button>
              </div>
              <div class="card-body">
              <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Daftar Rig<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countrig[0]['jumrig'];?></span></button>
                  </li>
                </ul>
                <div class="tab-11ontent">
                  <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                  <div class="card-datatable table-responsive">
                  <table id="manrig" class="table table-responsive table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Rig</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;
                      foreach ($rig as $rg) {?>
                      <tr>
                        <td><?=$i;?></td>
                        <td><span class="badge bg-label-success"><?=ucwords($rg['rig']);?></span></td>
                        <td>
                          <div class="d-inline-block">
                            <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                            <a href="index.php?page=ubahrig&id=<?=$rg['id_rig'];?>" class="dropdown-item">Ubah Rig</a>
                              <div class="dropdown-divider"></div>
                              <a href="func/hapusrig.php?id=<?=$rg['id_rig'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Rig Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php $i++;}?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Rig</th>
                        </tr>
                    </tfoot>
                  </table>
                  <script>
                                $(document).ready(function() {
                                      $('#manrig').DataTable( {
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

    <!-- Add New Sumur -->
    <div class="modal fade" id="addNewSumur" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-body">
            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3>Tambah Sumur</h3>
              <p>Tambah Data Sumur Baru di Sistem WONDER</p>
            </div>
              <form action="func/addsumur.php" method="POST">
                    <div class="card-body">
                        <div class="row">
                          <div class="form-group mt-4 col-lg-12">
                              <div class="form-label">Nama Sumur</div>
                              <input type="text" class="form-control" name="nama_sumur" id="nama_sumur">
                          </div>
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
    <!--/ Add New Sumur -->
    <!-- Add New Rig -->
    <div class="modal fade" id="addNewRig" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-body">
            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3>Tambah Rig</h3>
              <p>Tambah Data Rig Baru di Sistem WONDER</p>
            </div>
              <form action="func/addrig.php" method="POST">
                    <div class="card-body">
                        <div class="row">
                          <div class="form-group mt-4 col-lg-12">
                              <div class="form-label">Nama Rig</div>
                              <input type="text" class="form-control" name="rig" id="rig">
                          </div>
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
    <!--/ Add New Rig -->
  <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>