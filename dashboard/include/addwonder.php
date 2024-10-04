
      

    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        
        <div class="container flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row clearfix">
          <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card">
              <div class="card-header">
                <h5 class="p">Tambah Data WONDER</h5>
                <hr>
              </div>
              <div class="card-body">
              <form id="formValidationExamples" action="func/addwonder.php" method="POST" enctype="multipart/form-data" class="row g-3">
              <input class="form-control" type="hidden" name="id_user" value="<?=$row['id_user'];?>">
              <small class="text-light fw-semibold">Input Data Wonder Dengan Baik dan Benar ( <span class="text-danger">*</span> )</small>
                <!-- Account Details -->

                <div class="col-12">
                  <h6 class="fw-semibold">Data Sumur WONDER</h6>
                  <hr class="mt-0" />
                </div>
                <!-- <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload Foto Santri</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="gambar" class="form-control"/>
                                </label>
                                <p class="text-muted mb-0">Format yang diizinkan JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                            </div>
                        </div>
                        <br> -->
                
                <!-- <div class="col-sm-6"></div> -->
                <div class="col-sm-6">
                <label class="form-label" for="no_afe">No. AFE</label>
                <input type="text" class="form-control" name="no_afe" placeholder="No. AFE">
                </div>
                <div class="col-sm-6">
                                    <label class="form-label" for="tahun_pengerjaan">Tahun Pengerjaan</label>
                                    <input type="text" class="form-control" id="tahun_pengerjaan" name="tahun_pengerjaan" placeholder="Tahun Pengerjaan">
                                </div>
                <div class="col-sm-6">
                <label class="form-label" for="sumur">Sumur Minyak</label>
                <select class="select2" id="sumur" name="sumur">
                    <option value="">--Pilih Sumur--</option>
                    <?php
                        $sumur = query("SELECT * FROM sumur");
                        foreach ($sumur as $smr) :?>
                        <option value="<?=$smr['id_sumur'];?>"><?=ucwords($smr['nama_sumur']);?></option>
                        <?php endforeach;?>
                </select>
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="no_sumur">Nomor Sumur Minyak</label>
                <input type="text" class="form-control" name="no_sumur" placeholder="Nomor Sumur">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="tipe_pekerjaan">Tipe Pekerjaan Sumur</label>
                <select name="tipe_pekerjaan" id="tipe_pekerjaan" class="select2 form-select form-control-sm">
                    <option value="">-- Pilih Tipe Pekerjaan --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="Unbundling">Unbundling</option>
                </select>
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                <label class="form-label" for="rig">Rig</label>
                <select name="rig" id="rig" class="select2 form-select form-control-sm">
                    <option value="">-- Pilih Rig --</option>
                    <?php $rig = query("SELECT * FROM rig");
                    foreach ($rig as $rig) {?>
                    <option value="<?=$rig['id_rig'];?>"><?=ucwords($rig['rig']);?></option><?php } ?>
                </select>
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="kapasitas_rig">Kapasitas Rig (HP)</label>
                <input type="text" class="form-control" name="kapasitas_rig" placeholder="Kapasitas Rig (HP)">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="jarak_moving">Jarak Moving (KM)
                <span class="switch-label">Jika bilangan desimal ganti tanda koma (,) menggunakan tanda titik (.) ( <span class="text-danger">*</span> )</span>
                </label>
                <input type="text" class="form-control" name="jarak_moving" placeholder="Jarak Moving">
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                <label class="form-label" for="total_hari_moving_afe">Total Hari Moving AFE (RM,RU,RD)
                <span class="switch-label">Jika bilangan desimal ganti tanda koma (,) menggunakan tanda titik (.) ( <span class="text-danger">*</span> )</span>
                </label>
                <input type="text" class="form-control" name="total_hari_moving_afe" placeholder="Total Hari Moving AFE">
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                <label class="form-label" for="jatah_moving">Total Hari Moving Plan Kontrak (Hari)
                <span class="switch-label">Jumlah Hari ( <span class="text-danger">*</span> )</span>
                </label>
                <input type="text" class="form-control" name="jatah_moving" placeholder="Total Hari Moving Plan Kontrak">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="moving_days">Total Hari Moving Actual</label>
                <input type="text" class="form-control" name="moving_days" placeholder="Total Hari Moving Actual">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="operation_days_plan">Total Hari Operasi Plan</label>
                <input type="text" class="form-control" name="operation_days_plan" placeholder="Total Hari Operasi Plan">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="operation_days">Total Hari Operasi Actual</label>
                <input type="text" class="form-control" name="operation_days" placeholder="Total Hari Operasi Actual">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="plan_budget">Plan Budget</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">USD ($)</span>
                    <input type="text" class="form-control" name="plan_budget" placeholder="Plan Budget">
                  </div>
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="budget">Actual Budget</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">USD ($)</span>
                    <input type="text" class="form-control" name="budget" placeholder="Actual Budget">
                  </div>
                </div>
                <!-- Choose Your Plan -->

                <div class="col-12">
                  <label class="switch switch-primary">
                    <input type="checkbox" class="switch-input" name="formValidationSwitch" />
                    <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                    </span>
                    <span class="switch-label">Saya dengan yakin mengisi data sumur dengan benar dan sadar ( <span class="text-danger">*</span> )</span>
                  </label>
                </div>
                <div class="col-12">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="formValidationCheckbox" name="formValidationCheckbox" />
                    <label class="form-check-label" for="formValidationCheckbox">Setuju dengan syarat dan ketentuan Sistem Wonder</label>
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" name="submitButton" class="btn btn-primary">Simpan &raquo;</button>
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
      <script>
      $(document).ready(function() {
          $('#tahun_pengerjaan').datepicker({
              changeYear: true,
              showButtonPanel: true,
              dateFormat: 'yy',
              onClose: function(dateText, inst) {
                  var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                  $(this).datepicker('setDate', new Date(year, 1));
              }
          });

          $("#tahun_pengerjaan").focus(function () {
              $(".ui-datepicker-month").hide();
              $(".ui-datepicker-calendar").hide();
          });
      });
      </script>
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
  <!-- <script src="assets/js/dashboards-ecommerce.js"></script> -->
  <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>
  <!-- <script src="assets/js/pages-account-settings-account.js"></script> -->
  <script src="assets/js/form-validation.js"></script>