<?php
session_start();
ob_start();
require ("functions.php");
if (!isset($_SESSION["login"])) {
    echo "<script>swal('Anda Belum Login!', 'Silakan Login Terlebih Dahulu!', 'error').then(function(){
      setTimeout(document.location.href = '../../index.php', 100);
      });</script>";
    exit();
  }
  $id = $_SESSION['id_user'];
  $row = query("SELECT * FROM users WHERE id_user = '$id'")[0];
  $idunt = $row['id_unit'];
  $unit = query("SELECT * FROM unit WHERE id_unit = '$idunt'")[0];
  date_default_timezone_set('Asia/Jakarta');
  if ($row['id_unit'] != "1") {
          session_unset();
          session_destroy();
          echo "<script>swal('Bukan Otoritas Anda!', 'Anda Tidak Memiliki Akses Ke Halaman Ini!', 'error').then(function(){
            setTimeout(document.location.href = '../../index.php', 100);
            });</script>";
          exit();
  }
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
        $id_cashbank = $_POST['id_cashbank'];
        $idsan = $_POST['idsan'];
        $nis = $_POST['nis'];
            if (isset($_POST)) {
                if (addsetor($_POST) > 0) {
                    echo "<script>swal('Tambah Setoran Berhasil!', 'Terima Kasih Telah Menggunakan Sistem Informasi Santri Pondok Trendi!', 'success').then(function(){
                        setTimeout(document.location.href = '../banking.php?id_cashbank=$id_cashbank&idsan=$idsan&nis=$nis', 100);
                        });</script>";
                }else {
                    echo "<script>swal('Gagal Menambahkan Setoran','Silakan Periksa Kembali !','error').then(function(){
                        setTimeout(document.location.href = '../banking.php?id_cashbank=$id_cashbank&idsan=$idsan&nis=$nis', 100);
                    });</script>";
                }
            }else {
                echo "<script>swal('Gagal Menambahkan Setoran','Silakan Periksa Kembali !','error').then(function(){
                    setTimeout(document.location.href = '../banking.php?id_cashbank=$id_cashbank&idsan=$idsan&nis=$nis', 100);
                });</script>";
            }
        ?>
    </body>
</html>