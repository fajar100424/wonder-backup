<?php
$id_item = $_GET['id'];
$item = query("SELECT * FROM item WHERE id_item = '$id_item'")[0];
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
                    <h5 class="p">Edit Item Bobot</h5>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="func/ubahitem.php" id="formAccountSettings" method="POST">
                            <input class="form-control" type="hidden" name="id" value="<?=$item['id_item'];?>">
                            <br>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                    <label for="item" class="form-label">Item <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="item" name="item" placeholder="Item" value="<?=$item['item'];?>" autofocus/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-3 col-md-3">
                                    <label for="numbering" class="form-label">Priority <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="numbering" name="numbering" placeholder="Priority" value="<?=$item['numbering'];?>" autofocus/>
                                    </div>
                                    <div class="form-group mb-3 col-lg-3 col-md-3">
                                        <div class="form-label">bobot</div>
                                        <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" name="bobot" id="bobot" value="<?=$item['bobot'];?>">
                                        <span class="input-group-text">%</span>
                                        </div>
                                    </div>
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