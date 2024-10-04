<?php
$id_wonder = $_GET['idwonder'];
$id_evidence = $_GET['id_evidence'];
$id_item = $_GET['id_item'];
// $wonderevidence = query("SELECT * FROM evidence WHERE id_wonder = '$id_wonder';"); 

$relatedEvidence = query("SELECT evidence.*, item.*, history_evidence.*
                          FROM evidence 
                          JOIN item ON evidence.id_item = item.id_item 
                          JOIN history_evidence ON evidence.id_evidence = history_evidence.id_evidence 
                          WHERE evidence.id_wonder = '$id_wonder' AND evidence.id_evidence = '$id_evidence'
                          ORDER BY evidence.id_evidence DESC;")[0];

$totitem = query("SELECT COUNT(*) AS total FROM item")[0]['total'];
$totalItemWithSameId = query("SELECT COUNT(DISTINCT evidence.id_item) AS total 
                              FROM evidence 
                              WHERE evidence.id_wonder = '$id_wonder' AND evidence.id_evidence = '$id_evidence'")[0]['total'];
$missingItems = query("SELECT item.* 
                       FROM item 
                       LEFT JOIN evidence ON item.id_item = evidence.id_item AND evidence.id_wonder = '$id_wonder' AND evidence.id_evidence = '$id_evidence'
                       WHERE evidence.id_item IS NULL;");

if (empty($relatedEvidence)) {
    $status = 0;
    $totevidence = 0;
} else {
    $totevidence = count($relatedEvidence);
    $totevidence = $totitem - $totalItemWithSameId;
    if ($totevidence == $totitem) {
        $progress = query("SELECT progress FROM evidence WHERE id_wonder = '$id_wonder' AND id_evidence = '$id_evidence'")[0]['progress'];
        if ($progress == 100) {
            $status = 2;
        } else {
            $status = 1;
        }
    } else {
        $status = 1;
    }
    // $status = 1; // asumsi status 1 jika ada data
}

// if (isset($relatedEvidence[0])) {
    
//     $totevidence = query("SELECT COUNT('id_evidence') AS 'totevidence' FROM evidence WHERE id_wonder = '$id_wonder' AND `status` = '0'")[0]['totevidence'];    
//     if ($totevidence == 0) {
//         $status = 1;
//     }else {
//         $status = 0;
//     }
// }else {
//     $status = 0;
//     $totevidence = 0;
// }
$wonder = query("SELECT sumur.*,rig.*,wonder.*,users.nama FROM wonder INNER JOIN sumur ON wonder.id_sumur = sumur.id_sumur INNER JOIN rig ON wonder.id_rig = rig.id_rig INNER JOIN users ON wonder.id_user = users.id_user WHERE wonder.id_upload = '$id_wonder'")[0];

// $totevidence = query("SELECT COUNT('id_evidence') AS 'totevidence' FROM evidence WHERE id_wonder = '$id_wonder' AND `status` = '0'")[0];
// $totprogress = query("SELECT SUM('progress') AS 'jumprogress' FROM evidence")[0]['jumprogress'];

$historyEvidences = query("SELECT history_evidence.*, history_evidence.created_at AS updated_at, evidence.*, item.*, users.nama AS reviewer_name
FROM history_evidence 
JOIN evidence ON history_evidence.id_evidence = evidence.id_evidence 
JOIN item ON evidence.id_item = item.id_item
JOIN users ON history_evidence.uploader = users.id_user
WHERE evidence.id_evidence = '$id_evidence' AND history_evidence.reviewer IS NOT NULL
ORDER BY history_evidence.created_at DESC;");

?>
<!-- Content wrapper -->
<div class="content-wrapper">

<!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row overflow-hidden">
    <div class="col-12">
    <div class="card">
    <div class="card-body">
        <div class="row" id="informasiwonder">
            <!-- Review Evidence -->
            <div class="col-xl-12 col-lg-12 col-md-12">
                    
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i> Review Evidence</button>
                        </li>
                    </ul>
                
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Evidence WONDER</h5>
                        <p>Nama Evidence : <?=$relatedEvidence['item'];?></p>
                        <form action="func/addreview.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="id_wonder" value="<?=$id_wonder;?>">
                            <input type="hidden" name="id_evidence" value="<?=$id_evidence;?>">
                            <input type="hidden" name="id_user" Value="<?=$_SESSION['id_user'];?>">
                            <input type="hidden" name="id_history" value="<?=$relatedEvidence['id_history'];?>">
                            <input type="hidden" name="id_item" Value="<?=$id_item;?>">
                            <div class="col-sm-12">
                                <label class="form-label" for="file">File Berkas <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Silakan Klik tombol di bawah ini untuk melihat dan download file yang akan direview</small>
                                <div class="button-wrapper mb-2">
                                            <a href="../dashboard/assets/wonder/<?=$relatedEvidence['document'];?>" target="_blank" class="btn btn-primary">
                                                <i class="bx bx-file"></i> Lihat Dokumen
                                            </a>
                                            <!-- <label for="file" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload File Berkas</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="file" name="file" class="form-control"/>
                                            </label>
                                            <p class="text-muted mb-0">Format yang diizinkan PDF,JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p> -->
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="form-label" for="item">Item Evidence <span class="text-danger">*)</span></label>
                                <select class="select2" id="item" name="item" required>
                                <?php
                                $items = query("SELECT * FROM item WHERE id_item = '$id_item'");
                                foreach ($items as $item) {
                                    echo "<option selected value='" . htmlspecialchars($item['id_item']) . "'>" . htmlspecialchars($item['item']) . "</option>";
                                }
                                ?>
                                </select>
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6 mb-2">
                                <label class="form-label" for="validity">Nilai Validity <span class="text-danger">*)</span></label>
                                <input type="number" class="form-control" id="validity" name="validity" value="<?=$relatedEvidence['validity'];?>" required oninput="validateNumber(this)">
                                <span class="text-danger" id="validity-error" style="display: none;">Harus berupa angka!</span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="form-label" for="progress">Nilai Progress <span class="text-danger">*)</span></label>
                                <input type="number" class="form-control" id="progress" name="progress" value="<?=$relatedEvidence['progress'];?>" required oninput="validateNumber(this)">
                                <span class="text-danger" id="progress-error" style="display: none;">Harus berupa angka!</span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="form-label" for="deadline">Deadline <span class="text-danger">*)</span></label>
                                <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="<?=$relatedEvidence['deadline'];?>" required>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <label class="form-label" for="remarks">Remarks <span class="text-danger">*)</span></label>
                                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="10"><?=$relatedEvidence['remarks'];?></textarea>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="form-label" for="status">Status Validitas <span class="text-danger">*)</span></label>
                                <select class="form-control select2" id="status" name="status" required>
                                    <option value="0" <?php if($relatedEvidence['status'] == "0"){echo "selected";}?>>Belum Valid</option>
                                    <option value="1" <?php if($relatedEvidence['status'] == "1"){echo "selected";}?>>Valid</option>
                                </select>
                            </div>
                            <script>
                            function validateNumber(input) {
                                const errorId = input.id + '-error'; // Mendapatkan ID untuk elemen error
                                const errorElement = document.getElementById(errorId);
                                if (input.value && isNaN(input.value)) {
                                    errorElement.style.display = 'block'; // Tampilkan pesan error jika input bukan angka
                                } else {
                                    errorElement.style.display = 'none'; // Sembunyikan pesan error jika input adalah angka
                                }
                            }
                            </script>

                            
                            
                            <span><small><span class="text-danger">*</span>) Hati-hati dalam memilih berkas yang diupload, tolong baca ketentuannya.</small></span>
                            
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan &raquo;<i class="bx bx-send"></i></button>
                            <button type="reset" class="btn btn-label-secondary">Batal <i class="bx bx-refresh"></i></a></button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- End Review Evidence -->

            <div class="col-xl-12 col-lg-12 col-md-12">
                
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i> History Berkas Evidence Wonder</button>
                        </li>
                    </ul>
                
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Evidence WONDER</h5>
                        <p>Nama Evidence : <?=$relatedEvidence['item'];?></p>
                        <?php if (!empty($historyEvidences)): ?>
                        <ul class="timeline timeline-center mt-12">
                        <?php

                        foreach ($historyEvidences as $historyEvidence) {
                        ?>
                            <li class="timeline-item">
                                <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in" data-aos-delay="200">
                                    <i class="ri-file-fill ri-20px"></i>
                                </span>
                                <div class="timeline-event card p-0" data-aos="fade-right">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="card-title mb-0"><?= $historyEvidence['item']; ?></h6>
                                        <hr>
                                        <div class="meta">
                                        <span class="badge rounded-pill <?= $historyEvidence['status'] == "1" ? 'bg-label-success' : 'bg-label-danger'; ?> me-1">
                                            <?= $historyEvidence['status'] == "0" ? "Belum Valid" : ($historyEvidence['status'] == "1" ? "Valid" : $historyEvidence['status']); ?>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4 w-100">
                                            <div class="progress bg-label-light" style="height: 6px;">
                                                <div class="progress-bar <?= ($historyEvidence['progress'] < 50) ? 'bg-danger' : (($historyEvidence['progress'] < 100) ? 'bg-warning' : 'bg-success'); ?>" role="progressbar" style="width: <?= $historyEvidence['progress']; ?>%" aria-valuenow="<?= $historyEvidence['progress']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small>Progress</small>
                                        </div>
                                        <p class="mb-2"><?= $historyEvidence['remarks']; ?></p>
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex flex-wrap flex-sm-row flex-column">
                                                <div class="mb-sm-0 mb-4 me-12">
                                                    <p class="text-muted mb-2">Reviewer</p>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-xs me-2">
                                                            <img src="../dashboard/assets/img/avatars/1.png" alt="Reviewer" class="rounded-circle" style="width: 100%; height: auto;">
                                                        </div>
                                                        <p class="mb-0"><?= $historyEvidence['reviewer_name']; ?></p>
                                                    </div>
                                                </div>
                                                <div class="mb-sm-0 mb-4 me-12">
                                                    <p class="text-muted mb-2">Deadline</p>
                                                    <p class="mb-0"><?= date('jS F Y, H:i', strtotime($historyEvidence['deadline'])); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?= $historyEvidence['id_history']; ?>" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="ri-file-fill ri-20px"></i> Tampilkan Dokumen
                                        </button>
                                        <hr>
                                        <div class="collapse" id="collapseExample<?= $historyEvidence['id_history']; ?>">
                                            <a href="../dashboard/assets/wonder/<?= $historyEvidence['document']; ?>" target="_blank"><?= $historyEvidence['document']; ?></a>
                                        </div>
                                    </div>
                                    <div class="timeline-event-time"><?= date('jS F Y', strtotime($historyEvidence['updated_at'])); ?></div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                                                    
                        </ul>
                        <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                Belum ada data review.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>



        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
<!-- / Content -->

          
          

<!-- Footer -->
<?php include 'footer.php';?>
<!-- / Footer -->

</div>
<!-- Content wrapper -->
    
    <!-- Core JS -->
    <script src="../dashboard/assets/js/fajar.js"></script>
    <!-- build:js ../dashboard/assets/vendor/js/core.js -->
    <!-- <script src="../dashboard/assets/vendor/libs/jquery/jquery.js"></script> -->
    <script src="../dashboard/assets/vendor/libs/popper/popper.js"></script>
    <script src="../dashboard/assets/vendor/js/bootstrap.js"></script>
    <script src="../dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    
    <script src="../dashboard/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../dashboard/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../dashboard/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    
    <script src="../dashboard/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../dashboard/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../dashboard/assets/vendor/libs/select2/select2.js"></script>
    <script src="../dashboard/assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="../dashboard/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../dashboard/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../dashboard/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="../dashboard/assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../dashboard/assets/vendor/libs/cleavejs/cleave-phone.js"></script>

    <script src="../dashboard/assets/vendor/libs/moment/moment.js"></script>

    <script src="../dashboard/assets/vendor/libs/animate-on-scroll/animate-on-scroll.js"></script>
    <!-- Page JS -->
    
    <script src="../dashboard/assets/js/dashboards-ecommerce.js"></script>
    <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>
    

