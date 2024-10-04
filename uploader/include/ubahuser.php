<?php
$iduser = $_GET['id'];
$user = query("SELECT * FROM users WHERE id_user = '$iduser'")[0];
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
                    <h5 class="p">Edit User</h5>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="func/ubahuser.php" id="formAccountSettings" method="POST" enctype="multipart/form-data">
                            <input class="form-control" type="hidden" name="id" value="<?=$user['id_user'];?>">
                            <input class="form-control" type="hidden" name="gambarLama" value="<?= $user['foto']; ?>">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <?php if ($user['foto'] !== NULL) {?>
                                  <img src="assets/img/avatars/<?=$user['foto'];?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                <?php }else { ?>
                                  <img src="assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                <?php }; ?>
                                <div class="button-wrapper">
                                    <label for="gambar" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Foto Baru</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="gambar" name="gambar" class="form-control"/>
                                    </label>
                                    <p class="text-muted mb-0">Format yang diizinkan JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                </div>
                            </div>
                            <br>
                            
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input class="form-control" type="username" id="username" name="username" placeholder="contoh@gmail.com" value="<?=$user['username'];?>" disabled/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama Lengkap" value="<?=$user['nama'];?>" autofocus/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                    <label for="no_hp" class="form-label">No. Telepon (WA) <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="no_hp" name="no_hp" placeholder="Nomor Telepon" value="<?= $user['no_hp'];?>" autofocus/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                    <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="jabatan" name="jabatan" placeholder="Jabatan" value="<?=$user['jabatan'];?>" autofocus/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select name="role" id="role" class="select2 form-select" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="superadmin" <?php if ($user["role"] === 'superadmin') {echo "selected";} else {echo " ";}?>>Superadmin</option>
                                        <option value="reviewer" <?php if ($user["role"] === 'reviewer') {echo "selected";} else {echo " ";}?>>Reviewer</option>
                                        <option value="uploader" <?php if ($user["role"] === 'uploader') {echo "selected";} else {echo " ";}?>>Uploader</option>
                                    </select>
                                    </div>
                                    <span><small><span class="text-danger">*</span>) Kolom wajib diisi.</small></span>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Simpan <i class="bx bx-send"></i></button>
                                    <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></button>
                                </div>
                                </form>
                    
                </div>
                </div>
            </div>
            
            </div>



            <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-12 mb-4">
                <div class="card">
                <div class="card-header">
                    <h5 class="p">Ubah Password</h5>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="func/ubahpass.php" id="formAccountSettings" method="POST" enctype="multipart/form-data">
                            <input class="form-control" type="hidden" name="id" value="<?=$user['id_user'];?>">
                                <div class="row">
                                    <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="password">Password Baru<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    </div>
                                    <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="confirmPassword">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    </div>
                                    
                                    <span><small><span class="text-danger">*</span>) Hati-hati dalam mengubah password user.</small></span>
                                    
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Simpan <i class="bx bx-send"></i></button>
                                    <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></button>
                                </div>
                                </form>
                    
                </div>
                </div>
            </div>
            
            </div>

        <!--/ Header -->
        <!-- Navbar pills -->
        
        <!--/ Navbar pills -->
        </div>

        <!-- Footer -->
        <?php
          include 'footer.php';
        ?>
        <!-- / Footer -->
    </div>
    <!-- / Content -->



  <!-- Core JS -->
  <script src="assets/js/fajar.js"></script>
  <!-- Core JS -->
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/js/bootstrap.js"></script>
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  
  <script src="assets/vendor/libs/hammer/hammer.js"></script>
  <script src="assets/vendor/libs/i18n/i18n.js"></script>
  <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
  
  <script src="assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
  <script src="assets/vendor/libs/select2/select2.js"></script>
  <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
<script src="assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
<script src="assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
<script src="assets/vendor/libs/cleavejs/cleave.js"></script>
<script src="assets/vendor/libs/cleavejs/cleave-phone.js"></script>

<script src="assets/vendor/libs/moment/moment.js"></script>

  <!-- Main JS -->
  <!-- <script src="assets/js/main.js"></script> -->

  <!-- Page JS -->
  <script src="assets/js/dashboards-ecommerce.js"></script>
  <script src="assets/js/pages-account-settings-account.js"></script>
  <script src="assets/js/form-validation.js"></script>