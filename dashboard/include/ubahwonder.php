<?php
$id_wonder = $_GET['id'];
$wonder = query("SELECT * FROM wonder WHERE id_upload = '$id_wonder'")[0];
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
                    <h5 class="p">Edit Data WONDER</h5>
                    <hr>
                </div>
                <div class="card-body">
                <form id="formValidationExamples" action="func/ubahwonder.php" method="POST" enctype="multipart/form-data" class="row g-3">
              <input class="form-control" type="hidden" name="id_upload" value="<?=$wonder['id_upload'];?>">
              <small class="text-light fw-semibold">Input Data Wonder Dengan Baik dan Benar ( <span class="text-danger">*</span> )</small>
                <!-- Account Details -->

                <div class="col-12">
                  <h6 class="fw-semibold">Data Sumur WONDER</h6>
                  <hr class="mt-0" />
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
                <label class="form-label" for="rig">Rig</label>
                <select name="rig" id="rig" class="select2 form-select form-control-sm">
                    <option value="">-- Pilih Rig --</option>
                    <?php $rig = query("SELECT * FROM rig");
                    foreach ($rig as $rig) {?>
                    <option value="<?=$rig['id_rig'];?>"><?=ucwords($rig['rig']);?></option><?php } ?>
                </select>
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="no_rig">Nomor Rig</label>
                <input type="text" class="form-control" name="no_rig" placeholder="Nomor Rig">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="start_miru">Start MIRU</label>
                <input type="datetime-local" class="form-control" name="start_miru" placeholder="Start Miru">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="finish_miru">Finish MIRU</label>
                <input type="datetime-local" class="form-control" name="finish_miru" placeholder="Finish Miru">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="spud_date">SPUD Date</label>
                <input type="date" class="form-control" name="spud_date" placeholder="SPUD Date">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="completion_date">Completion Date</label>
                <input type="date" class="form-control" name="completion_date" placeholder="Completion Date">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="moving_days">Moving Days</label>
                <input type="text" class="form-control" name="moving_days" placeholder="Moving Days">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="operation_days">Operation Days</label>
                <input type="text" class="form-control" name="operation_days" placeholder="Operation Days">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="program_p">Program Jarak Moving</label>
                <input type="text" class="form-control" name="program_p" placeholder="Program Jarak Moving">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="program_r">Program Operasi</label>
                <input type="text" class="form-control" name="program_r" placeholder="Program Operasi">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="budget">Budget</label>
                <input type="text" class="form-control" name="budget" placeholder="Budget">
                </div>
                <div class="col-sm-6">
                <label class="form-label" for="plan_budget">Plan Budget</label>
                <input type="text" class="form-control" name="plan_budget" placeholder="Plan Budget">
                </div>
                <div class="col-sm-12">
                    <label class="form-label" for="keterangan">Keterangan Tambahan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
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