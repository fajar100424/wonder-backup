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

  if (isset($_POST['kelas'])) {
    $id_kelas = $_POST["kelas"];

    $santri = query("SELECT santri.*,kelas_santri.*,kelas.* FROM kelas_santri INNER JOIN santri ON kelas_santri.NIS = santri.NIS INNER JOIN kelas ON kelas_santri.id_kelas = kelas.id_kelas WHERE kelas_santri.id_kelas = '$id_kelas'");
    echo "<option>--Pilih Santri--</option>";
    foreach ($santri as $san) {?>
        <option value="<?=$san['id_santri']?>"><?=ucwords($san['fullname']);?></option>
    <?php }
}
?>
