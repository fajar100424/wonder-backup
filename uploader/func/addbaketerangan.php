<?php
require (dirname(__DIR__, 2) . "/dashboard/func/functions.php");
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
    echo "<script>swal('Anda Belum Login!', 'Silakan Login Terlebih Dahulu!', 'error').then(function(){
      setTimeout(document.location.href = '../../index.php', 100);
      });</script>";
    exit();
  }
    $id = $_SESSION['id_user'];
    $row = query("SELECT * FROM users WHERE id_user = '$id'")[0];
    $role = $row['role'];
    date_default_timezone_set('Asia/Jakarta');
    if ($row['role'] != "uploader") {
            session_unset();
            session_destroy();
            echo "<script>swal('Bukan Otoritas Anda!', 'Anda Tidak Memiliki Akses Ke Halaman Ini!', 'error').then(function(){
            setTimeout(document.location.href = '../index.php', 100);
            });</script>";
            exit();
    }
    $id_wonder = $_POST['id_wonder'];
    $id_ba_keterangan = $_POST['id_ba_keterangan'];
    // $rowberkas = query("SELECT * FROM data_berkas WHERE id_wonder = '$id_wonder'");
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    </head>
    <body>
    <?php
            if (isset($_POST)) {
                $dataToUpdate = array();
                foreach ($_POST as $key => $value) {
                    if (!empty($value)) {
                        $unwantedKeys = ['bamiruwonder_length', 'releaserigdown_length','mulaioperasirelease_length']; // Ganti dengan key yang ingin dihilangkan
                        if (in_array($key, $unwantedKeys)) {
                            continue;
                        }
                        $dataToUpdate[$key] = $value;
                    }
                }

                if (!empty($dataToUpdate)) {
                    
                    if (update_ba_keterangan($dataToUpdate) > 0) {
                        echo "<script>swal('Tambah/Perbarui BA Keterangan Berhasil!', 'Terima Kasih Telah Menggunakan Sistem Informasi WONDER!', 'success').then(function(){
                            setTimeout(document.location.href = '../index.php?page=wonder&idwonder=$id_wonder#pemberkasan', 100);
                            });</script>";
                    } else {
                        echo "<script>swal('Gagal Menambahkan BA Keterangan!','Silakan Periksa Kembali !','error').then(function(){
                            setTimeout(document.location.href = '../index.php?page=wonder&idwonder=$id_wonder#pemberkasan', 100);
                        });</script>";
                    }
                } else {
                    echo "<script>swal('Gagal Menambahkan BA Keterangan!','Silakan Periksa Kembali !','error').then(function(){
                        setTimeout(document.location.href = '../index.php?page=wonder&idwonder=$id_wonder#pemberkasan', 100);
                    });</script>";
                }
                // if (!empty($id_ba_keterangan)) {
                //     if (update_ba_keterangan($_POST) > 0) {
                //         echo "<script>swal('Tambah/Perbarui BA Keterangan Berhasil!', 'Terima Kasih Telah Menggunakan Sistem Informasi WONDER!', 'success').then(function(){
                //             setTimeout(document.location.href = '../index.php?page=wonder&idwonder=$id_wonder#pemberkasan', 100);
                //             });</script>";
                //     }else {
                //         echo "<script>swal('Gagal Menambahkan BA Keterangan!','Silakan Periksa Kembali !','error').then(function(){
                //             setTimeout(document.location.href = '../index.php?page=wonder&idwonder=$id_wonder#pemberkasan', 100);
                //         });</script>";
                //     }
                // }else {
                // echo "<script>swal('Gagal Menambahkan BA Keterangan!','Silakan Periksa Kembali !','error').then(function(){
                //     setTimeout(document.location.href = '../index.php?page=wonder&idwonder=$id_wonder#pemberkasan', 100);
                // });</script>";
                // }
            }
    ?>
    </body>
    </html>