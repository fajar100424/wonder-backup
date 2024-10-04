      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
        <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
        <div class="col-12">
            <div class="card mb-4">
            <div class="user-profile-header-banner">
                <img src="../dashboard/assets/img/pages/header.png" alt="Banner image" class="rounded-top" width="100%">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto" style="width: 10%;">
                <?php
                if ($row['foto'] != NULL) {?>
                <img src="../dashboard/assets/img/avatars/<?=$row['foto'];?>" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img" width="100%">
                <?php }else {?>
                <img src="../dashboard/assets/img/avatars/1.png" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img" width="100%">
                <?php } ?>
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                    <h4><?=ucwords($row['nama']);?> (<?=ucwords($row['username']);?>)</h4>
                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                        <li class="list-inline-item fw-semibold">
                        <i class='bx bx-calendar-alt'></i> Joined <?=date('l, d F Y', strtotime($row["created_at"]));?>
                        </li>
                    </ul>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                    <i class='bx bx-user-check'></i> <?=ucwords($row['role']);?>
                    </a>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <!--/ Header -->
        <!-- Navbar pills -->
        <div class="card">
            <div class="card-header">
            <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                    <li class="nav-item"><a class="nav-link" href="index.php?page=profile"><i class='bx bx-user'></i> Profile</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php?page=editprof"><i class='bx bx-wrench'></i> Edit</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=gantipass"><i class='bx bx-refresh'></i> Ganti Password</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-home"></i> Data Pribadi</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                    <div class="mb-4">
                        <h5 class="card-header">Profile Details</h5>
                        <!-- Account -->
                        <div class="card-body">
                        <form action="func/ubahuserprof.php" method="POST" enctype="multipart/form-data">
                        <input class="form-control" type="hidden" name="id" value="<?=$row['id_user'];?>">
                        <input class="form-control" type="hidden" name="gambarLama" value="<?= $row['foto']; ?>">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <?php
                        if ($row['foto'] != NULL) {?>
                        <img src="../dashboard/assets/img/avatars/<?=$row['foto'];?>" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img" width="100">
                        <?php }else {?>
                        <img src="../dashboard/assets/img/avatars/1.png" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img" width="100">
                        <?php } ?>
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload Foto Baru</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="gambar" class="form-control"/>
                                </label>
                                <p class="text-muted mb-0">Format yang diizinkan JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                            </div>
                        </div>
                        <br>
                        
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="username" name="username" placeholder="contoh@gmail.com" value="<?=$row['username'];?>" disabled/>
                                </div>
                                <div class="mb-3 col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama Lengkap" value="<?=$row['nama'];?>" disabled autofocus/>
                                </div>
                                <div class="mb-3 col-md-6">
                                <label for="no_hp" class="form-label">No. Telepon (WA) <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="no_hp" name="no_hp" placeholder="Nomor Telepon" value="<?= $row['no_hp'];?>" autofocus/>
                                </div>
                                <div class="mb-3 col-md-6">
                                <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="jabatan" name="jabatan" placeholder="Alamat" value="<?=$row['jabatan'];?>" autofocus/>
                                </div>
                                <span><small><span class="text-danger">*</span>) Kolom wajib diisi.</small></span>
                                
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan <i class="bx bx-send"></i></button>
                                <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></button>
                            </div>
                            </form>
                
              </div>
                        <!-- /Account -->
                        </div>
                       
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!--/ Navbar pills -->




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
