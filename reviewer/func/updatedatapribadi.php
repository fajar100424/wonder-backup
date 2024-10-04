<?php
session_start();
ob_start();
require ("functions.php");

if (!isset($_SESSION["login"])) {
    echo "<script>swal('Anda Belum Login!', 'Silakan Login Terlebih Dahulu!', 'error').then(function(){
      setTimeout(document.location.href = ../../index.php', 100);
      });</script>";
    exit();
  }
  $id = $_SESSION['id_user'];
  $row = query("SELECT * FROM users WHERE id_user = '$id'")[0];
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
            if (isset($_POST)) {
                $idsantri = $_POST['id_santri'];
                // if (updatedatapribadi($_POST) > 0) {
                //     echo "<script>swal('Ubah Informasi Pribadi Santri Berhasil!', 'Terima Kasih Telah Menggunakan Sistem Informasi Santri Pondok Pesantren!', 'success').then(function(){
                //         setTimeout(document.location.href = '../profsan.php?idsan=$idsantri#informasisantri', 100);
                //         });</script>";
                // }else {
                //     echo "<script>swal('Gagal Mengubah Informasi Pribadi Santri!','Silakan Periksa Kembali !','error').then(function(){
                //         setTimeout(document.location.href = '../profsan.php?idsan=$idsantri#informasisantri', 100);
                //     });</script>";
                // }
                if (validdata($_POST) <= 0) {
                    if (updatedatapribadi($_POST) > 0) {
                        echo "<script>swal('Update Data Santri Berhasil!', 'Terima Kasih Telah Menggunakan Sistem Informasi Santri Pondok Pesantren!', 'success').then(function(){
                            setTimeout(document.location.href = '../profsan.php?idsan=$idsantri#informasisantri', 100);
                            });</script>";
                    }else {
                        echo "<script>swal('Gagal Mengupdate Data Santri!','Silakan Periksa Kembali !','error').then(function(){
                            setTimeout(document.location.href = '../profsan.php?idsan=$idsantri#informasisantri', 100);
                        });</script>";
                    }
                }else {
                    echo "<script>swal('Gagal Mengupdate Data Santri!','Ada $validdata Data yang Belum Diisi!','error').then(function(){
                        setTimeout(document.location.href = '../profsan.php?idsan=$idsantri#informasisantri', 100);
                    });</script>";
                }
            }else {
                echo "<script>swal('Gagal Mengubah Informasi Pribadi Santri!','Silakan Periksa Kembali !','error').then(function(){
                    setTimeout(document.location.href = '../profsan.php?idsan=$idsantri#informasisantri', 100);
                });</script>";
            }
        ?>
    </body>
</html>