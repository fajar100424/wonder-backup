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
                          <th>Aksi</th>
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
                            <td><a href="assets/img/prove/<?=$prst['sertif'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat Sertifikat</a></td>
                            <td>
                              <div class="d-inline-block">
                                  <button class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">Pilih <i class="bx bx-dots-vertical-rounded"></i></button>
                                  <div class="dropdown-menu dropdown-menu-end">
                                    <a href="func/hapusprestasi.php?id=<?=$prst['id_prestasi'];?>&idsan=<?=$idsan;?>" onclick="return confirm('Apakah Anda Yakin Menghapus Prestasi Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                                  </div>
                                </div>
                            </td>
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
                          <th>Aksi</th>
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
                      <h5>Tambah Prestasi Santri</h5>
                              <form action="func/addprestasi.php" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                          <input type="hidden" name="id_santri" value="<?=$idsan;?>">
                                            <div class="col-md-6">
                                            <label class="form-label" for="basic-icon-default-phone">Tanggal <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                <input type="date" name="waktu" class="form-control "/>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <label class="form-label" for="basic-icon-default-phone">Lomba yang Diikuti <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-user"></i></span>
                                                <input type="text" name="lomba" class="form-control" placeholder="Misal Lomba MTQ"/>
                                            </div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                            <label class="form-label" for="juara">Juara <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="juara" class="input-group-text"><i class="bx bx-trophy"></i></span>
                                                <input type="text" id="juara" class="form-control" name="juara" placeholder="1">
                                            </div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                            <label class="form-label" for="tingkat">Tingkat <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="tingkat" class="input-group-text"><i class="bx bx-trophy"></i></span>
                                                <input type="text" id="tingkat" class="form-control" name="tingkat" placeholder="Provinsi">
                                            </div>
                                            </div>
                                            
                                            <div class="mb-3 col-md-12">
                                            <label class="form-label" for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span id="keterangan" class="input-group-text"><i class="bx bx-comment"></i></span>
                                                <textarea name="keterangan" id="keterangan" class="form-control" cols="3" rows="3"></textarea>
                                            </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-label" for="sertif">Sertifikat <span class="text-danger">*)</span></label>
                                                <small class="text-light fw-semibold">Gambar dan tulisan yang dikirim harus bisa terbaca</small>
                                                <div class="button-wrapper">
                                                            <label for="sertif" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                            <span class="d-none d-sm-block">Upload Berkas Sertifikat</span>
                                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                                            <input type="file" id="sertif" name="sertif" class="form-control"/>
                                                            </label>
                                                            <p class="text-muted mb-0">Format yang diizinkan PDF,JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                                </div>
                                            </div>
                                            
                                            <span><small><span class="text-danger">*</span>) Hati-hati dalam mengonfirmasi catatan santri.</small></span>
                                            
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary me-2">Simpan &raquo;<i class="bx bx-send"></i></button>
                                            <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></a></button>
                                        </div>
                            </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            </div>
            </div>
        </div>