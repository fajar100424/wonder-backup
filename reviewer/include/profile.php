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
                        <!-- <li class="list-inline-item fw-semibold">
                        <i class='bx bx-pen'></i> Cabang Bangka
                        </li>
                        <li class="list-inline-item fw-semibold">
                        <i class='bx bx-map'></i> Kota Pangkalpinang
                        </li> -->
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
                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class='bx bx-user'></i> Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=editprof"><i class='bx bx-wrench'></i> Edit</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=gantipass"><i class='bx bx-refresh'></i> Ganti Password</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <!-- Profile Overview -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <small class="text-muted text-uppercase">Detail Profile</small>
                            <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user-check"></i><span class="fw-semibold mx-2">Username :</span> <span><?=ucwords($row['username']);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span class="fw-semibold mx-2">Nama Lengkap:</span> <span><?=ucwords($row['nama']);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class='bx bx-phone'></i><span class="fw-semibold mx-2">No. Telpon:</span> <span><?=$row['no_hp'];?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-home-alt"></i><span class="fw-semibold mx-2">Role:</span> <span><?=ucwords($row['role']);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span class="fw-semibold mx-2">Jabatan:</span> <span><?=ucwords($row['jabatan']);?></span></li>
                            
                            </ul>
                            
                        </div>
                    </div>
                    <!--/ Profile Overview -->
                </div>
                </div> 
            </div>
        </div>
        </div>
        <!-- / Content -->
        <!-- Footer -->
        <?php
          include 'footer.php';
        ?>
        <!-- / Footer -->
      </div>
      <!-- Content wrapper -->