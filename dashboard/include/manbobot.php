<?php
$item = query("SELECT * FROM item");
$countitem = query("SELECT COUNT(id_item) AS 'jumitem' FROM item");
$countrig = query("SELECT COUNT(id_rig) AS 'jumrig' FROM rig");
$rig = query("SELECT * FROM rig");
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
              <h5 class="p">Manajemen Data Bobot Item</h5>
              <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewItem"> Tambah Bobot Item + </button>
              </div>
              <div class="card-body">
              <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Daftar Bobot Item<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countitem[0]['jumitem'];?></span></button>
                  </li>
                </ul>
                
                <div class="">
                  <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                  <div class="card-datatable table-responsive">
                  <table id="manitem" class="table table-responsive table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Priority</th>
                        <th>Item</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;
                      foreach ($item as $itm) {?>
                      <tr>
                        <td><?=$i;?></td>
                        <td><?=ucwords($itm['numbering']);?></td>
                        <td><?=ucwords($itm['item']);?></td>
                        <td><span class="badge bg-label bg-success"><?=ucwords($itm['bobot']);?>%</span></td>
                        <td>
                          <div class="d-inline-block">
                            <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                            <a href="index.php?page=ubahitem&id=<?=$itm['id_item'];?>" class="dropdown-item">Ubah Item</a>
                              <div class="dropdown-divider"></div>
                              <a href="func/hapusitem.php?id=<?=$itm['id_item'];?>" onclick="return confirm('Apakah Anda Yakin Menghapus Bobot Item Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php $i++;}?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Priority</th>
                        <th>Item</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
                  <script>
                                $(document).ready(function() {
                                      $('#manitem').DataTable( {
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
    <div class="modal fade" id="addNewItem" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-body">
            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3>Tambah Item Bobot</h3>
              <p>Tambah Data Item Baru di Sistem WONDER</p>
            </div>
              <form action="func/additem.php" method="POST">
                    <div class="card-body">
                        <div class="row">
                          <div class="form-group mt-4 col-lg-12">
                              <div class="form-label">Nama Item</div>
                              <input type="text" class="form-control" name="item" id="item">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">Priority</div>
                              <input type="number" class="form-control" name="numbering" id="numbering">
                          </div>
                          <div class="form-group mt-4 col-lg-6">
                              <div class="form-label">bobot</div>
                              <div class="input-group input-group-merge">
                              <input type="text" class="form-control" name="bobot" id="bobot">
                              <span class="input-group-text">%</span>
                              </div>
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