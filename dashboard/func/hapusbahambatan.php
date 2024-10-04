<?php
require ("functions.php");
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
    if ($row['role'] != "superadmin") {
            session_unset();
            session_destroy();
            echo "<script>swal('Bukan Otoritas Anda!', 'Anda Tidak Memiliki Akses Ke Halaman Ini!', 'error').then(function(){
            setTimeout(document.location.href = '../index.php', 100);
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
        $id_ba_hambatan = $_GET['id_ba_hambatan'];
        $id_wonder = $_GET['id_wonder'];
                if (hapusbahambatan($id_ba_hambatan) > 0) {
                        echo "<script>swal('Hapus BA Hambatan MIRU Berhasil!', 'Terima Kasih Telah Menggunakan Sistem Informasi WONDER!', 'success').then(function(){
                        setTimeout(document.location.href = '../index.php?page=wonder&idwonder=' + '$id_wonder', 100);
                        });</script>";
                }else {
                    echo "<script>swal('Gagal Menghapus BA Hambatan MIRU!','Silakan Hubungi Developer Sistem Informasi WONDER!','error').then(function(){
                        setTimeout(document.location.href = '../index.php?page=wonder&idwonder=' + '$id_wonder', 100);
                    });</script>";
                }
        ?>
    </body>
</html>