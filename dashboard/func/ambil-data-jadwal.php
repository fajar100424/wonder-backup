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

    $mapel = query("SELECT mapel.*,kelas.*,jadwal.* FROM jadwal INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas INNER JOIN mapel ON jadwal.id_mapel = mapel.id_mapel WHERE jadwal.id_kelas = '$id_kelas' GROUP BY mapel.mapel;");
    echo "<option>--Pilih Mapel--</option>";
    foreach ($mapel as $mpl) {?>
        <option value="<?=$mpl['id_mapel']?>"><?=ucwords($mpl['mapel']);?></option>
    <?php }
}
?>
