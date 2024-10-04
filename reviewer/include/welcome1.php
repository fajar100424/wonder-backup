        <div class="alert alert-warning mb-1" role="alert">
            <div class="d-flex gap-3">
                <div class="flex-shrink-0">
                <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2">
                    <i class="bx bx-sm bx-upload fs-4"></i>
                </span>
                </div>
                <div class="flex-grow-1">
                <div class="fw-bold">Santri Belum Melengkapi Data!</div>
                <ul class="list-unstyled mb-0">
                    <li> - Silakan Admin Untuk Menghubungi Santri yang Bersangkutan Untuk Segera Melengkapi Berkas Pendaftaran Atau Lengkapi Berkas Melalui Dashboard Admin ini!
                    </li>
                </ul>
                </div>
            </div>
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                        <h5 class="card-title text-primary">Santri Belum Melengkapi Berkas!🎉</h5>
                        <p class="mb-4">Silakan <span class="fw-bold">Konfirmasi Kelengkapan Berkas Santri yang Bersangkutan Ini!</span>. Setelah dikonfirmasi, maka santri telah dinyatakan lolos semua proses pendaftaran dan dinyatakan lengkap/terverifikasi pada sistem dashboard santri yang bersangkutan ketika login nantinya <span class="text-warning">Harap Berhati-hati dalam melengkapi berkas santri melalui admin karena data akan otomatis terverifikasi! Silakan Hubungi Santri yang bersangkutan.</span></p>

                        <!-- <a href="verifdata.php?idsan=" class="btn btn-warning btn-label-warning">Konfirmasi Kelengkapan Data Santri! &raquo;</a> -->
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                        <img src="../dashboard/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-light-img="illustrations/man-with-laptop-light.png" data-app-dark-img="illustrations/man-with-laptop-dark.html">
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
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
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active"><i class="tf-icons bx bx-trophy"></i> Prestasi Santri</button>
                    </li>
                </ul>
                <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="mb-3 card">
                      <div class="card-body">
                      <div class="card-datatable table-responsive">
                      <table id="manprestasi" class="table table-responsive table-bordered">
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Lomba</th>
                          <th>Juara</th>
                          <th>Tingkat</th>
                          <th>Keterangan</th>
                          <th>Bukti Sertifikat</th>
                      </tr>
                      </thead>
                      <tbody>
                          <?php
                          $i=1;
                          $prestasi = query("SELECT * FROM prestasi WHERE id_santri = '$idsan'");
                          foreach ($prestasi as $prst) :?>
                          <tr>
                            <td><?=$i;?></td>
                            <td><?=date('l, d F Y', strtotime($prst["waktu"]));?></td>
                            <td><?=ucwords($prst['lomba']);?></td>
                            <td><?=ucwords($prst['juara']);?></td>
                            <td><?=ucwords($prst['tingkat']);?></td>
                            <td><?=ucwords($prst['keterangan'])?></td>
                            <td><a href="../dashboard/assets/img/prove/<?=$prst['sertif'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat Sertifikat</a></td>
                          </tr>
                          <?php $i++; endforeach;?>
                      </tbody>
                      <tfoot>
                      <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Lomba</th>
                          <th>Juara</th>
                          <th>Tingkat</th>
                          <th>Keterangan</th>
                          <th>Bukti Sertifikat</th>
                      </tr>
                      </tfoot>
                      </table>
                            <script>
                                  $(document).ready(function() {
                                      $('#manprestasi').DataTable( {
                                          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                          dom: 'Blftipr',
                                          buttons: [
                                              'copy', 'csv', 'excel', 'pdf', 'print'
                                          ]
                                      } );
                                  } );
                          </script> 
                      </div>
                      <hr>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            </div>
            </div>
        </div>