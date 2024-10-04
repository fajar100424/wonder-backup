<?php
$pendaftaransantribaru = query("SELECT a.fullname, a.id as id_daftar, b.id as id_akun,b.notelp,c.* 
FROM pendaftaran a, akun b, detail_pendaftaran c 
WHERE a.id=b.id_user 
AND b.role_user=1 
AND c.id_user = a.id
AND c.status_pendaftaran = '0'");
$countpendaftar = query("SELECT COUNT(detail_pendaftaran.Id) AS 'jumpendaftar' FROM detail_pendaftaran WHERE detail_pendaftaran.status_pendaftaran = '0'")[0];
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
                <h5 class="p">Manajemen Pendaftaran Santri</h5>
                </div>
                <div class="card-body">
                <div class="col-xl-12">
                <div class="nav-align-top mb-4">
                  <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Pendaftaran Santri Baru yang Belum Dikonfirmasi<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$countpendaftar['jumpendaftar'];?></span></button>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                    <div class="card-datatable table-responsive">
                    <table id="manpayment" class="table table-responsive table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Pendaftar</th>
                          <th>Kampus/Tingkat</th>
                          <th>Nomor Telepon</th>
                          <th>Status Pendaftar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i =1; foreach ($pendaftaransantribaru as $pendaftar) :?>
                        <tr>
                          <td><?=$i;?></td>
                          <td><?=ucwords($pendaftar['fullname']);?></td>
                          <?php
                          $idregis = $pendaftar['id_daftar'];
                          $rowregis = query("SELECT * FROM pendaftaran WHERE Id = '$idregis'")[0];
                          ?>
                          <td><?=ucwords($rowregis['tingkat'].' ['.$rowregis['kampus'].']')?></td>
                          <td><a href="tel:<?=hportu($pendaftar['notelp']);?>"><?= hportu($pendaftar['notelp']);?></a></td>
                          <td><?php if ($pendaftar['status_pendaftaran'] == 0) {?>
                              <span class="badge bg-label-warning">Belum Dikonfirmasi</span>
                              <?php } else{?>
                              <span class="badge bg-label-danger">Error</span>
                              <?php } ?></td>
                        </tr>
                        <?php $i++; endforeach; ?>
                      </tbody>
                      <tfoot>
                          <tr>
                              <th>No</th>
                              <th>Nama Pendaftar</th>
                              <th>Kampus/Tingkat</th>
                              <th>Nomor Telepon</th>
                              <th>Status Pendaftar</th>
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
          </div>
          <!--/ Header -->
        </div>
        <!-- / Content -->
        <!-- Footer -->
        <?php
        include 'footer.php';
        ?>
        <!-- / Footer -->
    </div>

    <!-- Content wrapper -->

