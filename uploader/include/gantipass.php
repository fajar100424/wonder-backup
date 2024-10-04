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
        <div class="card">
            <div class="card-header">
            <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                    <li class="nav-item"><a class="nav-link" href="index.php?page=profile"><i class='bx bx-user'></i> Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=editprof"><i class='bx bx-wrench'></i> Edit</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php?page=gantipass"><i class='bx bx-refresh'></i> Ganti Password</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
            <div class="card mb-4">
                <h5 class="card-header">Ganti Password</h5>
                <div class="card-body">
                    <form action="func/ubahpassprof.php" method="POST">
                    <input class="form-control" type="hidden" name="id" value="<?=$row['id_user'];?>">
                    <div class="row">
                        <div class="mb-3 col-md-6 form-password-toggle">
                        <label class="form-label" for="currentPassword">Password Lama</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control" type="password" name="oldpassword" id="currentPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6 form-password-toggle">
                        <label class="form-label" for="newPassword">Password Baru</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control" type="password" id="newPassword" name="newpassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        </div>

                        <div class="mb-3 col-md-6 form-password-toggle">
                        <label class="form-label" for="confirmPassword">Konfirmasi Password Baru</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        </div>
                        <div class="col-12 mb-4">
                        <p class="fw-semibold mt-2">Persyaratan Password :</p>
                        <ul class="ps-3 mb-0">
                            <li class="mb-1">
                                Minimal 8 karakter, semakin panjang maka lebih baik
                            </li>
                            <li class="mb-1">
                                Setidaknya satu huruf kapital atau variasi
                            </li>
                            <li>
                                Setidaknya memuat satu angka, simbol, atau spesial karakter
                            </li>
                        </ul>
                        </div>
                        <div class="col-12 mt-1">
                        <button type="submit" class="btn btn-primary me-2">Simpan Perubahan <i class="bx bx-send"></i></button>
                        <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
        </div>
        <!-- / Content -->
        <!-- Footer -->
        <?php include 'footer.php'; ?>
        <!-- / Footer -->
      </div>
      <!-- Content wrapper -->