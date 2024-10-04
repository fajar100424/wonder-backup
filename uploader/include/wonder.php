<?php
$id_wonder = $_GET['idwonder'];
// $wonderevidence = query("SELECT * FROM evidence WHERE id_wonder = '$id_wonder';"); 

$relatedEvidence = query("SELECT e.*, i.*

FROM item i
LEFT JOIN (
    SELECT e1.*

    FROM evidence e1

    LEFT JOIN (

        SELECT id_item, MAX(created_at) as MaxCreatedAt
        FROM evidence

        WHERE id_wonder = '$id_wonder'

        GROUP BY id_item
    ) e2 ON e1.id_item = e2.id_item AND e1.created_at = e2.MaxCreatedAt

    WHERE e1.id_wonder = '$id_wonder'

) e ON i.id_item = e.id_item
ORDER BY i.numbering,e.created_at DESC;");


// $baKeterangan = query("SELECT bk.*
//                        FROM ba_keterangan bk
//                        JOIN (
//                            SELECT id_wonder, MAX(created_at) as MaxCreatedAt
//                            FROM ba_keterangan
//                            GROUP BY id_wonder
//                        ) wonder ON bk.id_wonder = wonder.id_wonder AND bk.created_at = wonder.MaxCreatedAt
//                        WHERE bk.id_wonder = '$id_wonder'
//                        ORDER BY bk.id_wonder DESC;");

$ba_keterangan = query("SELECT bk.*
                       FROM ba_keterangan bk
                       WHERE bk.id_wonder = '$id_wonder'
                       ORDER BY bk.created_at DESC;")[0];

$ba_hambatan = query("SELECT bk.*
                       FROM ba_hambatan bk
                       WHERE bk.id_wonder = '$id_wonder'
                       ORDER BY bk.created_at DESC;");


$totitem = query("SELECT COUNT(*) AS total FROM item")[0]['total'];
$totalItemWithSameId = query("SELECT COUNT(DISTINCT evidence.id_item) AS total 
                              FROM evidence 
                              WHERE evidence.id_wonder = '$id_wonder'")[0]['total'];
$totalItemOptionalWithSameId = query("SELECT COUNT(DISTINCT data_berkas_pendukung.id_data_berkas_pendukung) AS total 
                              FROM data_berkas_pendukung 
                              WHERE data_berkas_pendukung.id_wonder = '$id_wonder'")[0]['total'];                              
$missingItems = query("SELECT item.* 
                       FROM item 
                       LEFT JOIN evidence ON item.id_item = evidence.id_item AND evidence.id_wonder = '$id_wonder' 
                       WHERE evidence.id_item IS NULL;");

if (empty($relatedEvidence)) {
    $status = 0;
    $totevidence = 0;
} else {
    $totevidence = count($relatedEvidence);
    $totevidence = $totitem - $totalItemWithSameId;
    if ($totevidence == $totitem) {
        $averageProgress = query("SELECT AVG(progress) AS avg_progress FROM evidence WHERE id_wonder = '$id_wonder'")[0]['avg_progress'];
        if ($averageProgress == 100) {
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

?>
<style>
    .table-warning td, .table-success td {
    padding: 10px;
    border: 1px solid #dee2e6;
    }

    .table-warning td span, .table-success td span {
        font-weight: bold;
    }
</style>
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        
        <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
        <div class="col-12">
            <div class="card mb-4">
            <div class="user-profile-header-banner" style="height:250px; background-image: url('../dashboard/assets/img/backgrounds/bgfix.png'); background-repeat: no-repeat; background-size: cover; background-position: center;">
                
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                <img src="../dashboard/assets/img/illustrations/rocket.png" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img">
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                    <h4><?=ucwords($wonder['nama_sumur'].'-'.$wonder['no_sumur']);?></h4>
                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                        <!-- <li class="list-inline-item fw-semibold">
                        <i class='bx bx-pen'></i> Cabang Bangka
                        </li>
                        <li class="list-inline-item fw-semibold">
                        <i class='bx bx-map'></i> Kota Pangkalpinang
                        </li> -->
                        <li class="list-inline-item fw-semibold">
                        <i class='bx bx-calendar-alt'></i> Data Master WONDER Dibuat Pada <?=date('l, d F Y', strtotime($wonder["created_at"]));?>
                        </li>
                    </ul>
                    </div>
                    <?php if ($status == 0) {?>
                      <a href="javascript:void(0)" class="btn btn-danger">
                        <i class='bx bx-upload'></i> Belum Ada Evidence
                      </a>
                    <?php } elseif ($wonder['progress'] == 0) {?>
                      <a href="javascript:void(0)" class="btn btn-primary">
                        <i class='bx bx-pencil'></i> On Progress
                      </a>
                    <?php } elseif ($wonder['progress'] == 1) {?>
                      <a href="javascript:void(0)" class="btn btn-success">
                        <i class='bx bx-pencil'></i> Telah Terverifikasi Complete
                      </a>
                    <?php } else {?>
                      <a href="javascript:void(0)" class="btn btn-primary">
                        <i class='bx bxs-radiation'></i> Error
                      </a>
                    <?php } ?>
                    <?php if ($wonder['progress'] == 1) {?>
                      <a href="export_wonder.php?id_wonder=<?=$id_wonder;?>" class="btn btn-warning">
                        <i class='bx bx-export'></i> Export Wonder
                      </a>
                      <a href="download_batch_documents.php?id_wonder=<?=$id_wonder;?>" class="btn btn-info">
                        <i class='bx bx-download'></i> Download Batch Dokumen
                      </a>
                    <?php } ?>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <!--/ Header -->
        <!-- Isi -->

        <div class="row">
            <div class="col-lg-12">
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                    <h5 class="card-title text-primary">Selamat Data Sumur <?=$wonder['nama_sumur']?> Telah Dibuat! 🎉</h5>
                    <p class="mb-4">Pastikan penginputan data detail<span class="fw-bold"> Diterima Sistem</span>. Mohon selanjutnya untuk mengecek kembali data yang ada pada profile sumur wonder terkait progressnya!.</p>

                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-label-warning btn-block text-left" type="button" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="icofont-eye-alt"></i> Cek Data! &raquo;
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <h5 class="text-center bg-success text-white">Informasi Data Sumur Evidence</h5>
                                    <div class="row">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Nama Comman:</strong> <span class="badge bg-label-primary"><?= $wonder['nama'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>NO. AFE:</strong> <span><?= $wonder['no_afe'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Sumur Minyak:</strong> <span><?= $wonder['nama_sumur'].' - '.$wonder['no_sumur'];?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Jarak Moving (KM):</strong> <span><?= $wonder['jarak_moving'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Total Hari Moving Plan (Kontrak):</strong> <span><?= $wonder['jatah_moving'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Total Hari Operasi Plan:</strong> <span><?= $wonder['operation_days_plan'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Plan Budget (USD):</strong> <span>$<?= number_format($wonder['plan_budget'], 0, ',', '.') ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Actual Budget (USD):</strong> <span>$<?= number_format($wonder['budget'], 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Tipe Pengerjaan Sumur:</strong> <span><?= $wonder['tipe_pekerjaan'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Tahun Pengerjaan Sumur:</strong> <span><?= $wonder['tahun_pengerjaan'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Nama Rig:</strong> <span><?= $wonder['rig'].' - '.$wonder['kapasitas_rig']; ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Total Hari Moving AFE:</strong> <span><?= $wonder['total_hari_moving_afe'];?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Total Hari Moving Actual:</strong> <span><?= $wonder['moving_days'] ?></span>
                                                    </div>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Total Hari Operasi Actual:</strong> <span><?= $wonder['operation_days'] ?></span>
                                                    </div>
                                                    <?php
                                                    $latestDocument = null;
                                                    // Ambil nilai budget dari database
                                                    $actual_budget = $wonder['budget'];
                                                    $plan_budget = $wonder['plan_budget'];

                                                    // Hitung persentase budget
                                                    if ($plan_budget > 0) {
                                                        $percentage_budget = ($actual_budget / $plan_budget) * 100;
                                                    } else {
                                                        $percentage_budget = 0; // Atau bisa ditangani sesuai kebutuhan
                                                    }
                                                    ?>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>% Budget:</strong> <span><?= number_format($percentage_budget, 2, ',', '.') ?>%</span>
                                                    </div>
                                                    <?php
                                                        $id_wonder = $wonder['id_upload'];
                                                        $progres_wonder = query("SELECT SUM(item.bobot) AS 'sum_bobot' FROM evidence INNER JOIN wonder ON evidence.id_wonder = wonder.id_upload INNER JOIN item ON item.id_item = evidence.id_item WHERE wonder.id_upload = '$id_wonder' AND evidence.status = 1;")[0]['sum_bobot'];

                                                        if (!$progres_wonder) {
                                                            $progres_wonder = "Belum Ada Data";
                                                        } else {
                                                            $progres_wonder = $progres_wonder.'%';
                                                            if ($progres_wonder === null) {
                                                                $progres_wonder = "Belum Ada Data";
                                                            }
                                                        }
                                                    ?>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>Progress WONDER:</strong> <span class="bg-label-danger" style="font-size: large;"><?=$progres_wonder;?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="progress mt-3" style="height: 20px;">
                                    <?php if (!is_null($progres_wonder)): ?>
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progres_wonder ?>%;" aria-valuenow="<?= $progres_wonder ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?= $progres_wonder ?>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                    <img src="../dashboard/assets/img/illustrations/rocket.png" height="140" alt="View Badge User" data-app-light-img="illustrations/rocket.png" data-app-dark-img="illustrations/rocket.png">
                    </div>
                </div> -->
                </div>
            </div>
        </div>
        </div>
        <div class="row" id="informasiwonder">
            
            <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="mb-3 card">
                <div class="card-body">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i> Berkas Evidence Wonder</button>
                    </li>
                </ul>
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#bawonder" aria-controls="bawonder" aria-selected="false"><i class="tf-icons bx bx-data"></i>BA WONDER</button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#berkaswajib" aria-controls="berkaswajib" aria-selected="false"><i class="tf-icons bx bx-data"></i>Data Dokumen Evidence WONDER<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$totalItemWithSameId;?> </span></button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#berkasopsi" aria-controls="berkasopsi" aria-selected="false"><i class="tf-icons bx bx-notepad"></i>Berkas Opsional <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-warning"><?=$totalItemOptionalWithSameId;?> </span></button>
                    </li>
                </ul>
                <div class="tab-content">
                <!-- Tab pane ba wonder -->
                <div class="tab-pane fade show active" id="bawonder" role="tabpanel">
                <?php
                if (empty($relatedEvidence) || $totalItemWithSameId > 0) {?>
                    <div class="alert alert-warning mb-4" role="alert">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                            <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2 text-black text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(100,205,138,1)"><path fill="none" d="M0 0h24v24H0z"></path><path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"></path></svg>
                            </span>
                            </div>
                            <div class="flex-grow-1">
                            <div class="fw-bold">Lengkapi Data Evidence Sumur <?=$wonder['nama_sumur'];?></div>
                            <ul class="list-unstyled mb-0">
                                <li> - Silakan lengkapi form pemberkasan di bawah ini untuk melengkapi data evidence pada Sumur <?=$wonder['nama_sumur'];?>! <br/>Sebelum mengisi data, mohon menyiapkan berkas untuk di foto/scan, berikut adalah daftar berkas atau item Evidence wonder yang belum terdaftar pada sistem dan perlu dilengkapi:
                                </li>
                                <li> - Setelah data anda dikirim, maka admin akan memverifikasi data yang telah anda kirimkan apakah valid </li>
                                <li> -  Mohon untuk melengkapi berkas yang sesuai karena data anda akan dicek kebenarannya oleh sistem</li>
                            </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } else {?> 
                        <div class="alert alert-success mb-4" role="alert">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                                    <i class="bx bx-sm bx-data fs-4"></i>
                                </span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-bold">Perhatikan Berkas Item Evidence dengan saksama, secara keseluruhan, dan secara detail!</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php }?>
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i> BA MIRU (Rig Down Sumur Sebelumnya - Mulai Tajak)</button>
                    </li>
                </ul>
                <div class="card-datatable table-responsive">
                <form action="func/addbaketerangan.php" method="POST">
                    <input type="text" name="id_wonder" value="<?=$id_wonder;?>" hidden>
                    <input type="text" name="id_ba_keterangan" value="<?=$ba_keterangan['id_ba'];?>" hidden>
                    <table id="bamiruwonder" class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>Start</th>
                        <th>End</th>
                        <th>Durasi</th>
                        <th>Total Jam</th>
                        <th>Keterangan BA</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_rig_down']) || !isset($ba_keterangan['end_rig_down'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_rig_down" value="<?= empty($ba_keterangan['start_rig_down']) ? '' : $ba_keterangan['start_rig_down']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_rig_down" value="<?= empty($ba_keterangan['end_rig_down']) ? '' : $ba_keterangan['end_rig_down']; ?>">
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_rig_down"]) || !isset($ba_keterangan["end_rig_down"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_rig_down"]);
                                $end_date = new DateTime($ba_keterangan["end_rig_down"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_rig_down"]) || !isset($ba_keterangan["end_rig_down"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $start_date = new DateTime($ba_keterangan["start_rig_down"]);
                            $end_date = new DateTime($ba_keterangan["end_rig_down"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            $ba_miru_hours = 0;
                            $ba_miru_hours = $ba_miru_hours + $total_hours;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan1" value="<?= empty($ba_keterangan['keterangan1']) ? 'Rig Down dari sumur sebelumnya' : $ba_keterangan['keterangan1']; ?>">
                        </td>
                        </tr>
                        <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_moving']) || !isset($ba_keterangan['end_moving'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_moving" value="<?= empty($ba_keterangan['start_moving']) ? '' : $ba_keterangan['start_moving']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_moving" value="<?= empty($ba_keterangan['end_moving']) ? '' : $ba_keterangan['end_moving']; ?>">
                        </td>
                        <td>
                            <?php if (empty($ba_keterangan) || !isset($ba_keterangan['start_moving']) || !isset($ba_keterangan['end_moving'])) {?>
                                <span>Belum Ada Data</span>
                            <?php }else{?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_moving"]);
                                $end_date = new DateTime($ba_keterangan["end_moving"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_moving"]) || !isset($ba_keterangan["end_moving"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $start_date = new DateTime($ba_keterangan["start_moving"]);
                            $end_date = new DateTime($ba_keterangan["end_moving"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            $ba_miru_hours = $ba_miru_hours + $total_hours;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan2" value="<?= empty($ba_keterangan['keterangan2']) ? 'Moving' : $ba_keterangan['keterangan2']; ?>">
                        </td>
                        </tr>
                        <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_rig_up']) || !isset($ba_keterangan['end_rig_up'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_rig_up" value="<?= empty($ba_keterangan['start_rig_up']) ? '' : $ba_keterangan['start_rig_up']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_rig_up" value="<?= empty($ba_keterangan['end_rig_up']) ? '' : $ba_keterangan['end_rig_up']; ?>">
                        </td>
                        <td>
                            <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_rig_up"]) || !isset($ba_keterangan["end_rig_up"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php }else{?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_rig_up"]);
                                $end_date = new DateTime($ba_keterangan["end_rig_up"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_rig_up"]) || !isset($ba_keterangan["end_rig_up"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $start_date = new DateTime($ba_keterangan["start_rig_up"]);
                            $end_date = new DateTime($ba_keterangan["end_rig_up"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            $ba_miru_hours = $ba_miru_hours + $total_hours;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan3" value="<?= empty($ba_keterangan['keterangan3']) ? 'Rig Up' : $ba_keterangan['keterangan3']; ?>">
                        </td>
                        </tr>
                        <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_icheck']) || !isset($ba_keterangan['end_icheck'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_icheck" value="<?= empty($ba_keterangan['start_icheck']) ? '' : $ba_keterangan['start_icheck']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_icheck" value="<?= empty($ba_keterangan['end_icheck']) ? '' : $ba_keterangan['end_icheck']; ?>">
                        </td>
                        <td>
                            <?php if (empty($ba_keterangan) || !isset($ba_keterangan['start_icheck']) || !isset($ba_keterangan['end_icheck'])) {?>
                                <span>Belum Ada Data</span>
                            <?php }else{?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_icheck"]);
                                $end_date = new DateTime($ba_keterangan["end_icheck"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_icheck"]) || !isset($ba_keterangan["end_icheck"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $start_date = new DateTime($ba_keterangan["start_icheck"]);
                            $end_date = new DateTime($ba_keterangan["end_icheck"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            $ba_miru_hours = $ba_miru_hours + $total_hours;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan4" value="<?= empty($ba_keterangan['keterangan4']) ? 'Icheck' : $ba_keterangan['keterangan4']; ?>">
                        </td>
                        </tr>
                        <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_rscl']) || !isset($ba_keterangan['end_rscl'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_rscl" value="<?= empty($ba_keterangan['start_rscl']) ? '' : $ba_keterangan['start_rscl']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_rscl" value="<?= empty($ba_keterangan['end_rscl']) ? '' : $ba_keterangan['end_rscl']; ?>">
                        </td>
                        <td>
                            <?php if (empty($ba_keterangan) || !isset($ba_keterangan['start_rscl']) || !isset($ba_keterangan['end_rscl'])) {?>
                                <span>Belum Ada Data</span>
                            <?php }else{?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_rscl"]);
                                $end_date = new DateTime($ba_keterangan["end_rscl"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_rscl"]) || !isset($ba_keterangan["end_rscl"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $start_date = new DateTime($ba_keterangan["start_rscl"]);
                            $end_date = new DateTime($ba_keterangan["end_rscl"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            $ba_miru_hours = $ba_miru_hours + $total_hours;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan5" value="<?= empty($ba_keterangan['keterangan5']) ? 'RSCL' : $ba_keterangan['keterangan5']; ?>">
                        </td>
                        </tr>
                        <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_sika_operasi']) || !isset($ba_keterangan['end_sika_operasi'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_sika_operasi" value="<?= empty($ba_keterangan['start_sika_operasi']) ? '' : $ba_keterangan['start_sika_operasi']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_sika_operasi" value="<?= empty($ba_keterangan['end_sika_operasi']) ? '' : $ba_keterangan['end_sika_operasi']; ?>">
                        </td>
                        <td>
                            <?php if (empty($ba_keterangan) || !isset($ba_keterangan['start_sika_operasi']) || !isset($ba_keterangan['end_sika_operasi'])) {?>
                                <span>Belum Ada Data</span>
                            <?php }else{?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_sika_operasi"]);
                                $end_date = new DateTime($ba_keterangan["end_sika_operasi"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_sika_operasi"]) || !isset($ba_keterangan["end_sika_operasi"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $start_date = new DateTime($ba_keterangan["start_sika_operasi"]);
                            $end_date = new DateTime($ba_keterangan["end_sika_operasi"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            $ba_miru_hours = $ba_miru_hours + $total_hours;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan6" value="<?= empty($ba_keterangan['keterangan6']) ? 'SIKA Operasi' : $ba_keterangan['keterangan6']; ?>">
                        </td>
                        </tr>
                    </tbody>
                    
                    </table>
                    <?php if (empty($ba_keterangan)) {?>
                        <button type="submit" class="col-lg-12 mt-2 btn btn-success">Simpan</button>
                    <?php } else { ?>
                        <button type="submit" class="col-lg-12 mt-2 btn btn-warning">Perbarui Data</button>
                    <?php } ?>
                    </form>
                        <script>
                                $(document).ready(function() {
                                    $('#bamiruwonder').DataTable( {
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
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i>BA Hambatan MIRU</button>
                    </li>
                </ul>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewItem"> Tambah Hambatan MIRU + </button>
                <div class="card-datatable table-responsive">
                    <table id="bahambatanmiru" class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>Start</th>
                        <th>End</th>
                        <th>Durasi</th>
                        <th>Total Jam</th>
                        <th>Keterangan BA</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($ba_hambatan)) { ?>
                        <tr class="table-warning">
                            <td colspan="5" class="text-center"> Belum Ada Data Hambatan</td>
                        </tr>
                    <?php } else { ?>
                        <?php $ba_hambatan_hours=0; foreach ($ba_hambatan as $hambatan) : ?>
                        <tr class="table-success">
                            <td><?= date('d M Y H:i', strtotime($hambatan['start'])) ?></td>
                            <td><?= date('d M Y H:i', strtotime($hambatan['end'])) ?></td>
                            <td>
                                <?php
                                $start_date = new DateTime($hambatan['start']);
                                $end_date = new DateTime($hambatan['end']);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            </td>
                            <td>
                                <?php if (empty($hambatan) || !isset($hambatan["start"]) || !isset($hambatan["end"])) { ?>
                                    <span>Belum Ada Data</span>
                                <?php } else { ?>
                                <?php
                                $start_date = new DateTime($hambatan["start"]);
                                $end_date = new DateTime($hambatan["end"]);
                                $interval = $start_date->diff($end_date);
                                $total_hours = ($interval->days * 24) + $interval->h;
                                $ba_hambatan_hours = $ba_hambatan_hours + $total_hours;
                                echo $total_hours . " Jam";
                                ?>
                                <?php } ?>
                            </td>
                            <td><?= htmlspecialchars($hambatan['keterangan_ba']) ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="confirmDeletionHambatan(<?= $hambatan['id_ba_hambatan']; ?>, <?= $hambatan['id_wonder']; ?>)">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php } ?>

                    <script>
                    function confirmDeletionHambatan(idHambatan, id_wonder) {
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Data yang dihapus tidak dapat dipulihkan.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus saja!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'func/hapusbahambatan.php?id_ba_hambatan=' + idHambatan + '&id_wonder=' + id_wonder; // Mengirimkan id_hambatan sebagai parameter
                            }
                        });
                    }
                    </script>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Start</th>
                        <th>End</th>
                        <th>Durasi</th>
                        <th>Total Jam</th>
                        <th>Keterangan BA</th>
                        <th>Action</th>
                    </tr>   
                    </tfoot>
                    </table>
                        <script>
                                $(document).ready(function() {
                                    $('#bahambatanmiru').DataTable( {
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
                
                <hr>
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i>Mulai Operasi - Release</button>
                    </li>
                </ul>
                <div class="card-datatable table-responsive">
                <form action="func/addbaketerangan.php" method="POST">
                    <input type="text" name="id_wonder" value="<?=$id_wonder;?>" hidden>
                    <input type="text" name="id_ba_keterangan" value="<?=$ba_keterangan['id_ba'];?>" hidden>
                    <table id="mulaioperasirelease" class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>Start</th>
                        <th>End</th>
                        <th>Durasi</th>
                        <th>Total Jam</th>
                        <th>Keterangan BA</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_mulai_operasi']) || !isset($ba_keterangan['end_mulai_operasi'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_mulai_operasi" value="<?= empty($ba_keterangan['start_mulai_operasi']) ? '' : $ba_keterangan['start_mulai_operasi']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_mulai_operasi" value="<?= empty($ba_keterangan['end_mulai_operasi']) ? '' : $ba_keterangan['end_mulai_operasi']; ?>">
                        </td>
                        <td>
                            <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_mulai_operasi"]) || !isset($ba_keterangan["end_mulai_operasi"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php }else{?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_mulai_operasi"]);
                                $end_date = new DateTime($ba_keterangan["end_mulai_operasi"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_mulai_operasi"]) || !isset($ba_keterangan["end_mulai_operasi"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $ba_operation_hours = 0;
                            $start_date = new DateTime($ba_keterangan["start_mulai_operasi"]);
                            $end_date = new DateTime($ba_keterangan["end_mulai_operasi"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            $ba_operation_hours = $ba_operation_hours + $total_hours;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan7" value="<?= empty($ba_keterangan['keterangan7']) ? 'Mulai Operasi' : $ba_keterangan['keterangan7']; ?>">
                        </td>
                        </tr>
                    </tbody>
                    
                    </table>
                    <?php if (empty($ba_keterangan)) {?>
                        <button type="submit" class="col-lg-12 mt-2 btn btn-success">Simpan</button>
                    <?php } else { ?>
                        <button type="submit" class="col-lg-12 mt-2 btn btn-warning">Perbarui Data</button>
                    <?php } ?>
                </form>
                        <script>
                                $(document).ready(function() {
                                    $('#mulaioperasirelease').DataTable( {
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
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i>Release Rig Down</button>
                    </li>
                </ul>
                <div class="card-datatable table-responsive">
                <form action="func/addbaketerangan.php" method="POST">
                    <input type="text" name="id_wonder" value="<?=$id_wonder;?>" hidden>
                    <input type="text" name="id_ba_keterangan" value="<?=$ba_keterangan['id_ba'];?>" hidden>
                    <table id="releaserigdown" class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>Start</th>
                        <th>End</th>
                        <th>Durasi</th>
                        <th>Total Jam</th>
                        <th>Keterangan BA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_release_rig_down']) || !isset($ba_keterangan['end_release_rig_down'])) ? 'table-warning' : 'table-success'; ?>">
                        <td>
                            <input type="datetime-local" class="form-control" name="start_release_rig_down" value="<?= empty($ba_keterangan['start_release_rig_down']) ? '' : $ba_keterangan['start_release_rig_down']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="end_release_rig_down" value="<?= empty($ba_keterangan['end_release_rig_down']) ? '' : $ba_keterangan['end_release_rig_down']; ?>">
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_release_rig_down"]) || !isset($ba_keterangan["end_release_rig_down"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php }else{?>
                                <?php
                                $start_date = new DateTime($ba_keterangan["start_release_rig_down"]);
                                $end_date = new DateTime($ba_keterangan["end_release_rig_down"]);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days . " Hari " . $interval->h . " Jam";
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if (empty($ba_keterangan) || !isset($ba_keterangan["start_release_rig_down"]) || !isset($ba_keterangan["end_release_rig_down"])) { ?>
                                <span>Belum Ada Data</span>
                            <?php } else { ?>
                            <?php
                            $start_date = new DateTime($ba_keterangan["start_release_rig_down"]);
                            $end_date = new DateTime($ba_keterangan["end_release_rig_down"]);
                            $interval = $start_date->diff($end_date);
                            $total_hours = ($interval->days * 24) + $interval->h;
                            echo $total_hours . " Jam";
                            ?>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan8" value="<?= empty($ba_keterangan['keterangan8']) ? 'R/D' : $ba_keterangan['keterangan8']; ?>">
                        </td>
                        </tr>
                    </tbody>
                    
                    </table>
                    <?php if (empty($ba_keterangan)) {?>
                        <button type="submit" class="col-lg-12 mt-2 btn btn-success">Simpan</button>
                    <?php } else { ?>
                        <button type="submit" class="col-lg-12 mt-2 btn btn-warning">Perbarui Data</button>
                    <?php } ?>
                </form>
                        <script>
                                $(document).ready(function() {
                                    $('#releaserigdown').DataTable( {
                                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                        dom: 'Blftipr',
                                        buttons: [
                                            'copy', 'csv', 'excel', 'pdf', 'print'
                                        ]
                                    } );
                                } );
                        </script> 
                        
                </div>


                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active btn-success"><i class="tf-icons bx bx-book"></i>Summary</button>
                    </li>
                </ul>
                <div class="card-datatable table-responsive">
                    <table id="calculateDays" class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>Total MIRU Days</th>
                        <th>Total Operation Days</th>
                        <th>Total Obstacles MIRU Days</th>
                        <th>Total Job Days</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="<?= (empty($ba_keterangan) || !isset($ba_keterangan['start_release_rig_down']) || !isset($ba_keterangan['end_release_rig_down'])) ? 'table-warning' : 'table-success'; ?>">
                        <td style="font-size: 1.2rem;text-align: center;">
                            <?php
                            if (empty($ba_miru_hours)) {
                                $ba_miru_hours = 0;
                                echo "Belum ada data";
                            } else {
                                $ba_miru_days = $ba_miru_hours / 24;
                                echo number_format($ba_miru_days, 2) . ' Hari';
                            }
                            ?>
                        </td>
                        <td style="font-size: 1.2rem;text-align: center;">
                        <?php
                            if (empty($ba_operation_hours)) {
                                $ba_operation_hours = 0;
                                echo "Belum ada data";
                            } else {
                                $ba_operation_days = $ba_operation_hours / 24;
                                echo number_format($ba_operation_days, 2) . ' Hari';
                            }
                            ?>
                        </td>
                        <td style="font-size: 1.2rem;text-align: center;">
                        <?php
                            if (empty($ba_hambatan_hours)) {
                                $ba_hambatan_hours = 0;
                                echo "Belum ada data";
                            } else {
                                $ba_hambatan_days = $ba_hambatan_hours / 24;
                                echo number_format($ba_hambatan_days, 2) . ' Hari';
                            }
                            ?>
                        </td>
                        <td style="font-size: 1.2rem;text-align: center;">
                            <?php
                                $total_job_days = $ba_miru_days + $ba_operation_days;
                                echo number_format($total_job_days, 2) . ' Hari';
                            ?>
                        </td>
                        </tr>
                    </tbody>
                    
                    </table>
                        <script>
                                $(document).ready(function() {
                                    $('#calculateDays').DataTable( {
                                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                        dom: 'Blftipr',
                                        buttons: [
                                            'copy', 'csv', 'excel', 'pdf', 'print'
                                        ]
                                    } );
                                } );
                        </script> 
                        
                </div>

                </div>
                <!-- End tab pane ba wonder -->
                <!-- Tab pane berkas wajib item -->
                <div class="tab-pane fade" id="berkaswajib" role="tabpanel">
                
                <div class="card-datatable table-responsive">
                <table id="manberkas" class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dokumen Evidence</th>
                            <th>Item Evidence</th>
                            <th>Status</th>
                            <th>Bobot</th>
                            <th>Remarks Command</th>
                            <th>(Remarks Uploader)</th>
                            <th>Remarks Reviewer</th>
                            <th>Scores</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($relatedEvidence)) {?>
                        <tr>
                            <td colspan="10" class="text-center bg-warning"><span class="badge bg-label-danger">Belum Ada Data</span></td>
                        </tr>
                        <?php } elseif (!empty($relatedEvidence)) { ?>
                        <?php $i=1; foreach ($relatedEvidence as $evidence) { ?>
                            <form action="func/addberkas.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_wonder" value="<?=$id_wonder;?>">
                                <input type="hidden" name="id_user" Value="<?=$_SESSION['id_user'];?>">
                            <tr>
                                <td><?= htmlspecialchars($i++) ?></td>
                                <?php if (is_null($evidence['id_evidence'])): ?>
                                    <td>
                                        <input type="file" name="file" class="form-control">
                                    </td>
                                <?php else: ?>
                                    <?php
                                    $latestDocument = query("SELECT * FROM history_evidence WHERE id_evidence = '{$evidence['id_evidence']}' ORDER BY created_at DESC LIMIT 1")[0];
                                    $id_evidence = $evidence['id_evidence'];
                                    ?>
                                    <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentModal<?=$id_evidence;?>">
                                        Lihat Dokumen
                                    </button>
                                    
                                    <input type="file" name="file" class="form-control mt-2">
                                    <div class="modal fade" id="documentModal<?=$id_evidence;?>" tabindex="-1" aria-labelledby="documentModalLabel<?=$id_evidence;?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="documentModalLabel<?=$id_evidence;?>">Dokumen Evidence</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                            $googleDocsUrl = getGoogleDocsViewerUrl($latestDocument['id_history']);
                                                            ?>
                                                            <iframe src="<?= $googleDocsUrl ?>" width="100%" height="500px"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <a href="<?= $googleDocsUrl ?>" class="btn btn-primary" download>Download Dokumen</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </td>
                                <?php endif; ?>
                                <td>
                                    <?php if (is_null($evidence['id_evidence'])): ?>
                                        <a href="javascript:void(0)" class="btn btn-warning" onclick="showAlert()">
                                            <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars((strlen($evidence['item']) > 50) ? substr($evidence['item'], 0, 50) . '...' : $evidence['item']) ?>
                                        </a>
                                        <input type="text" name="item" value="<?= htmlspecialchars($evidence['id_item']) ?>" hidden>
                                    <?php else: ?>
                                        <a href="index.php?page=evidence&id_item=<?= urlencode($evidence['id_item']) ?>&idwonder=<?= urlencode($id_wonder) ?>&id_evidence=<?= urlencode($evidence['id_evidence']) ?>"
                                        class="btn btn-info" style="transition: transform .2s;">
                                            <i class="fas fa-file-alt"></i> <!-- Ikon dokumen -->
                                            <?= htmlspecialchars((strlen($evidence['item']) > 50) ? substr($evidence['item'], 0, 50) . '...' : $evidence['item']) ?>
                                        </a>
                                        <input type="text" name="item" value="<?= htmlspecialchars($evidence['id_item']) ?>" hidden>
                                    <?php endif; ?>
                                </td>

                                <script>
                                    function showAlert() {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Peringatan',
                                            text: 'Dokumen belum diupload!',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                </script>
                                <td>
                                    <?php if ($evidence['status'] == 1): ?>
                                        <span class="badge bg-success">Sudah Valid</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Belum Valid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($evidence['bobot']) ?>%
                                </td>
                                <td colspan="2">
                                    <textarea name="remarks_uploader" class="form-control" rows="3">
                                        <?php if (!is_null($evidence['id_evidence'])): ?>
                                            <?= htmlspecialchars($evidence['remarks_uploader']) ?>
                                        <?php endif; ?>
                                    </textarea>
                                </td>
                                <td>
                                    <?php
                                    if (empty($wonder['updated_by'])) {
                                        echo "Belum Diperbarui";
                                    } else {
                                        if (is_null($latestDocument['remarks'])) {
                                            $latestDocument['remarks']="";
                                        }
                                        echo htmlspecialchars($latestDocument['remarks']);
                                    } 
                                    $latestDocument['remarks']="";
                                    ?>
                                </td>
                                <td>
                                <?php
                                if (!is_null($evidence['progress'])) {
                                    $score = $evidence['progress'];
                                    $scoreClass = '';
                                    if ($score >= 80) {
                                        $scoreClass = 'bg-success';
                                    } elseif ($score >= 50) {
                                        $scoreClass = 'bg-warning';
                                    } else {
                                        $scoreClass = 'bg-danger';
                                    }
                                ?>
                                    <div class="progress" style="height: 20px; position: relative;">
                                        <div class="progress-bar <?= $scoreClass ?>" role="progressbar" style="width: <?= $score ?>%;" aria-valuenow="<?= $score ?>" aria-valuemin="0" aria-valuemax="100">
                                            <span style="position: absolute; width: 100%; left: 0; top: 0; text-align: center; color: #fff;"><?= $score ?>%</span>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                    echo "Belum ada score";
                                }
                                ?>
                                </td>
                                <td>
                                    <?php if (is_null($evidence['id_evidence'])): ?>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
                                        <button type="button" class="btn btn-danger" onclick="confirmDeletion(<?= $evidence['id_evidence']; ?>)">Hapus</button>
                                    <?php endif; ?>
                                </td>

                                <script>
                                function confirmDeletion(idEvidence) {
                                    Swal.fire({
                                        title: 'Apakah Anda yakin?',
                                        text: "Data yang dihapus tidak dapat dipulihkan.",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, hapus saja!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = 'func/hapusevidence.php?id_evidence=' + idEvidence; // Mengirimkan id_evidence sebagai parameter
                                        }
                                    });
                                }
                                </script>
                            </tr>
                            </form>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center bg-danger"><span class="badge bg-label-danger">Error</span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Dokumen Evidence</th>
                            <th>Item Evidence</th>
                            <th>Status</th>
                            <th>Bobot</th>
                            <th>Remarks Command</th>
                            <th>(Remarks Uploader)</th>
                            <th>Remarks Reviewer</th>
                            <th>Scores</th>
                            <th>Action</th>
                        </tr>   
                    </tfoot>
                </table>
            <script>
                $(document).ready(function() {
                    $('#manberkas').DataTable( {
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        dom: 'Blftipr',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                });
            </script>
                        
                </div>
                <hr>


                </div>
                <!-- End tab pane berkas item wajib wonder -->

                <div class="tab-pane fade" id="berkasopsi" role="tabpanel">
                <?php
                $rowberkasopsi = query("SELECT * FROM data_berkas_pendukung WHERE id_wonder = '$id_wonder'");
                ?>
                <div class="alert alert-success mb-4" role="alert">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                        <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                            <i class="bx bx-sm bx-data fs-4"></i>
                        </span>
                        </div>
                        <div class="flex-grow-1">
                        <div class="fw-bold">Ini adalah halaman untuk melengkapi berkas yang ingin anda tambahkan! Berkas ini tidak wajib/pilihan anda sendiri untuk melengkapinya!</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="manberkasopsi" class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>Jenis Berkas</th>
                        <th>Berkas</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if ($rowberkasopsi == NULL) {?>
                        <tr>
                            <td colspan="4" class="text-center bg-warning"><span class="badge bg-label-danger">Belum Ada Data</span></td>
                        </tr>
                        <?php }elseif ($rowberkasopsi !== NULL) {?>
                            <?php foreach ($rowberkasopsi as $rbk) :?>
                                <tr>
                                <td><?=ucwords($rbk['jenis_berkas']);?></td>
                                <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentModalOpsi<?=$rbk['id_data_berkas_pendukung'];?>">
                                        <i class='bx bxs-file-blank'></i> Lihat Dokumen
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="documentModalOpsi<?=$rbk['id_data_berkas_pendukung'];?>" tabindex="-1" aria-labelledby="documentModalLabel<?=$rbk['id_data_berkas_pendukung'];?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="documentModalLabel<?=$rbk['id_data_berkas_pendukung'];?>">Dokumen Evidence</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    $googleDocsUrl = getGoogleDocsViewerUrlOpsi($rbk['id_data_berkas_pendukung']);
                                                    if ($googleDocsUrl) {
                                                    ?>
                                                        <iframe src="<?= $googleDocsUrl ?>" width="100%" height="500px"></iframe>
                                                    <?php
                                                    } else {
                                                        echo "Dokumen tidak ditemukan.";
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <?php if ($googleDocsUrl) { ?>
                                                        <a href="<?= $googleDocsUrl ?>" class="btn btn-primary" download>Download Dokumen</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?=date('l, d F Y', strtotime($rbk["created_at"]));?></td>
                                <td>
                                    <button class="btn btn-danger" onclick="confirmDeletionOptional(<?=$rbk['id_data_berkas_pendukung'];?>, <?=$id_wonder;?>)">Hapus</button>
                                </td>
                                <script>
                                function confirmDeletionOptional(idDataBerkasPendukung, id_wonder) {
                                    Swal.fire({
                                        title: 'Apakah Anda yakin?',
                                        text: "Data yang dihapus tidak dapat dipulihkan.",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, hapus saja!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = 'func/hapusberkasopsi.php?id_data_berkas_pendukung=' + idDataBerkasPendukung + '&id_wonder=' + id_wonder; // Mengirimkan id_data_berkas_pendukung sebagai parameter
                                        }
                                    });
                                }
                                </script>
                                </tr>
                            <?php endforeach;?>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Jenis Berkas</th>
                        <th>Berkas</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
                    </table>
                        <script>
                                $(document).ready(function() {
                                    $('#manberkasopsi').DataTable( {
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
                <h5>Tambah Berkas Opsional WONDER</h5>
                <form action="func/addberkasopsi.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="id_wonder" value="<?=$id_wonder;?>">
                            <div class="col-sm-6 mb-2">
                            <label class="form-label" for="jenis_berkas">Jenis Berkas <span class="text-danger">*)</span></label>
                            <select class="select2 form-control" name="jenis_berkas" id="jenis_berkas" onchange="toggleInput(this)">
                                <option value="">Pilih Jenis Berkas</option>
                                <option value="Form PPP Excel">Form PPP Excel</option>
                                <option value="PPP Form III A11 signed">PPP Form III A11 signed</option>
                                <option value="PPP Form III A12 signed">PPP Form III A12 signed</option>
                                <option value="Invoice scanned RIg">Invoice scanned RIg</option>
                                <option value="Invoice scanned PSPU">Invoice scanned PSPU</option>
                                <option value="Invoice scanned EWLPP">Invoice scanned EWLPP</option>
                                <option value="Invoice Tenaga Ahli">Invoice Tenaga Ahli</option>
                                <option value="Invoice repair Redress Packer">Invoice repair Redress Packer</option>
                                <option value="Invoice repair pompa">Invoice repair pompa</option>
                                <option value="Invoice perbaikan wellhead">Invoice perbaikan wellhead</option>
                                <option value="other">Lainnya</option>
                            </select>
                            <input type="text" class="form-control mt-2" name="jenis_berkas_lainnya" id="jenis_berkas_lainnya" placeholder="Masukkan jenis berkas lainnya" style="display: none;">
                        </div>
                        <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih atau tambahkan jenis berkas",
                allowClear: true
            });
        });

        function toggleInput(select) {
            var input = document.getElementById('jenis_berkas_lainnya');
            if (select.value === 'other') {
                input.style.display = 'block';
            } else {
                input.style.display = 'none';
            }
        }
    </script>
                            <div class="col-sm-12">
                                <label class="form-label" for="file">File Berkas <span class="text-danger">*)</span></label>
                                <small class="text-light fw-semibold">Gambar dan tulisan yang dikirim harus bisa terbaca</small>
                                <div class="button-wrapper">
                                            <label for="file" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload File Berkas</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="file" name="file" class="form-control"/>
                                            </label>
                                            <p class="text-muted mb-0">Format yang diizinkan PDF,JPG,JPEG,atau PNG. Ukuran Maksimal Gambar 10MB <span class="text-danger">*</span></p>
                                </div>
                            </div>
                            
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
            </div>
            </div>
        </div>

        <!-- End Isi -->
        </div>
        <!-- / Content -->

          
          

        <!-- Footer -->
        <?php
        include 'footer.php';
        ?>
        <!-- / Footer -->

        <!-- Add New Sumur -->
        <div class="modal fade" id="addNewItem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
            <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                <h3>Tambah Data Hambatan</h3>
                <p>Tambah Data Hambatan MIRU di Sistem WONDER</p>
                </div>
                <form action="func/addbahambatan.php" method="POST">
                <input type="hidden" name="id_wonder" value="<?=$id_wonder;?>">
                        <div class="card-body">
                            <div class="row">
                            <div class="form-group mt-4 col-lg-12">
                                <div class="form-label">Keterangan BA</div>
                                <input type="text" class="form-control" name="keterangan_ba" id="keterangan_ba">
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group mt-4 col-lg-6">
                                <div class="form-label">Start</div>
                                <input type="datetime-local" class="form-control" name="start" id="start">
                            </div>
                            <div class="form-group mt-4 col-lg-6">
                                <div class="form-label">End</div>
                                <input type="datetime-local" class="form-control" name="end" id="end">
                            </div>
                            <!-- <div class="form-group mt-4 col-lg-6">
                                <div class="form-label">bobot</div>
                                <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="bobot" id="bobot">
                                <span class="input-group-text">%</span>
                                </div>
                            </div> -->
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                </form>
            </div>
            </div>
        </div>
        </div>
        <!--/ Add New Sumur -->


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


    <!-- Page JS -->
    <script src="../dashboard/assets/js/dashboards-ecommerce.js"></script>
    <script src="../dashboard/assets/js/pages-account-settings-account.js"></script>

