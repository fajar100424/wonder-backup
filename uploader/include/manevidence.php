<?php
// if (isset($_POST['cari'])) {
//   // $kelas = $_POST['kelas'];
//   // $kamar = $_POST['kamar'];
//   $status = $_POST['stats'];
  
//   $wonder = query("SELECT pendaftaran.*, akun.*,detail_pendaftaran.*,santri.*,santri.status AS 'stats_santri', santri.created_At AS 'joined' FROM akun INNER JOIN pendaftaran ON akun.id_user = pendaftaran.Id INNER JOIN detail_pendaftaran ON pendaftaran.Id = detail_pendaftaran.id_user INNER JOIN santri ON santri.id_akun = akun.Id WHERE detail_pendaftaran.status_pendaftaran LIKE '%$status%'");
// }else {
//   // $wonder = query("SELECT santri.*,santri.status AS 'stats_santri' FROM santri;"); 
//   $wonder = query("SELECT evidence.*, wonder.*, history_evidence.*, item.*, evidence.status AS 'stats_evidence', evidence.created_at AS 'dibuat' FROM evidence INNER JOIN wonder ON evidence.id_wonder = wonder.id_upload INNER JOIN history_evidence ON history_evidence.id_history = evidence.id_evidence INNER JOIN item ON item.id_item = evidence.id_item"); 
// }
$wndrdence = query("SELECT evidence.*, wonder.*, history_evidence.*, item.*, evidence.status AS 'stats_evidence', evidence.created_at AS 'dibuat' FROM evidence INNER JOIN wonder ON evidence.id_wonder = wonder.id_upload INNER JOIN history_evidence ON history_evidence.id_history = evidence.id_evidence INNER JOIN item ON item.id_item = evidence.id_item"); 

$wonder = query("SELECT sumur.*,rig.*,wonder.*,users.nama FROM wonder INNER JOIN sumur ON wonder.id_sumur = sumur.id_sumur INNER JOIN rig ON wonder.id_rig = rig.id_rig INNER JOIN users ON wonder.id_user = users.id_user");

$totwonder = query("SELECT COUNT(id_upload) AS 'totwonder' FROM wonder")[0];

?>




      

    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        
        <div class="container flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row clearfix">


        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card">
              <div class="card-body">
              <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i>Daftar Data Evidence Persumur<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$totwonder['totwonder'];?></span></button>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                  <a href="index.php?page=addwonder" class="btn btn-warning text-nowrap">
                    + Tambah Data Evidence Sumur
                  </a>  
                  <hr/>
                  <div class="card-datatable table-responsive">
                  <table id="manwonder" class="table table-responsive table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Sumur</th>
                        <th>Rig</th>
                        <th>% Progress</th>
                        <th>User</th>
                        <th>Terakhir Update</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;
                      foreach ($wonder as $wndr) {?>
                      <tr>
                        <?php
                        $id_wonder = $wndr['id_upload']; // Pastikan variabel ini mendapatkan id_wonder yang benar dari konteksnya
                        $progres_wonder = query("SELECT SUM(item.bobot) AS 'sum_bobot' FROM evidence INNER JOIN wonder ON evidence.id_wonder = wonder.id_upload INNER JOIN item ON item.id_item = evidence.id_item WHERE wonder.id_upload = '$id_wonder' AND evidence.status = 1;")[0]['sum_bobot'];

                        if (!$progres_wonder) {
                            $progres_wonder = "Belum Ada Data";
                        } else {
                            $progres_wonder = $progres_wonder.'%';
                            if ($progres_wonder === null) {
                                $progres_wonder = "Belum Ada Data";
                            }
                        }
                        ?>
                        <td><?=$i;?></td>
                        <td><span class="badge bg-label-success" style="font-size: large;">
                          <a href="index.php?page=wonder&idwonder=<?=$wndr['id_upload'];?>" class="btn btn-success"><?=ucwords($wndr['nama_sumur'].'-'.$wndr['no_sumur']);?></a>
                        </span></td>
                        <td><span class="badge bg-label-warning"><?=$wndr['rig'].'-'.$wndr['kapasitas_rig'];?></span></td>
                        <td>
                          <span class="badge <?= ($progres_wonder < 50) ? 'bg-label-danger' : (($progres_wonder < 100) ? 'bg-label-warning' : 'bg-label-success'); ?>" style="font-size: large;">
                              <?= ucwords($progres_wonder); ?>
                          </span>
                        </td>
                        <td><span class="badge bg-label-danger"><?=ucwords($wndr['nama']);?></span></td>
                        <td><?=date('l, d F Y', strtotime($wndr["updated_at"]));?></td>
                        <td>
                          <div class="dropdown d-flex justify-content-center">
                              <button class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">Aksi<i class="bx bx-dots-vertical-rounded"></i></button>
                              <div class="dropdown-menu">
                                    <a href="index.php?page=ubahwonder&id=<?= $wndr['id_upload']; ?>" class="dropdown-item">
                                        <button class="btn btn-info">Ubah Data WONDER</button>
                                    </a>
                                    <!-- <div class="dropdown-divider"></div> -->
                                    <a href="#" class="dropdown-item">
                                        <button class="btn btn-danger" onclick="confirmDeletion(<?= $wndr['id_upload']; ?>)">Hapus</button>
                                    </a>
                                </div>
                            </div>
                        </td>

<script>
function confirmDeletion(idWonder) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dipulihkan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus saja!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'func/hapuswonder.php?id=' + idWonder; // Mengirimkan id_wonder sebagai parameter
        }
    });
}
</script>
                      </tr>
                      <?php $i++;}?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th>No</th>
                        <th>Sumur</th>
                        <th>Rig</th>
                        <th>% Progress</th>
                        <th>User</th>
                        <th>Terakhir Update</th>
                        <th>Aksi</th>
                        </tr>
                    </tfoot>
                  </table>
                  <script>
                                $(document).ready(function() {
                                      $('#manwonder').DataTable( {
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
      <!-- Content -->
      <!-- Footer -->
      <?php
        include 'footer.php';
      ?>
      <!-- / Footer -->
    </div>

    <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>