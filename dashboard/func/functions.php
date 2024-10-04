<?php
//koneksi ke database
$conn = mysqli_connect("localhost","wond3714_wonder","w0nd3r112401","wond3714_wonder");
// $conn = mysqli_connect("localhost","root","","psb");

function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}


function login_validate(){
	$timeout = 30;
	$_SESSION["expires_by"] = time() + $timeout;
}
function login_check(){
	$exp_time = $_SESSION["expires_by"];
	if (time() < $exp_time ) {
		login_validate();
		return true;
	}else {
		unset($_SESSION["expires_by"]);
		return false;
	}
}

function hp($nohp) {
    // kadang ada penulisan no hp 0811 239 345
    $nohp = str_replace(" ","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace("(","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace(")","",$nohp);
    // kadang ada penulisan no hp 0811.239.345
    $nohp = str_replace(".","",$nohp);
	$nohp = str_replace("-","",$nohp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($nohp))){
        // cek apakah no hp karakter 1-3 adalah +62
        if(substr(trim($nohp), 0, 3)=='+62'){
            $hp = trim($nohp);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($nohp), 0, 1)=='0'){
            $hp = '+62'.substr(trim($nohp), 1);
        }
    }
    print $hp;
}

function hportu($nohp) {
    // kadang ada penulisan no hp 0811 239 345
    $nohp = str_replace(" ","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace("(","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace(")","",$nohp);
    // kadang ada penulisan no hp 0811.239.345
    $nohp = str_replace(".","",$nohp);
	$nohp = str_replace("-","",$nohp);
	$hp = '';
    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($nohp))){
        // cek apakah no hp karakter 1-3 adalah +62
        if(substr(trim($nohp), 0, 3)=='+62'){
            $hp = trim($nohp);
			return $hp;
        }
		if(substr(trim($nohp), 0, 2) == '62'){
            $hp = '+'.substr(trim($nohp),0);
			return $hp;
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($nohp), 0, 1)=='0'){
            $hp = '+62'.substr(trim($nohp), 1);
			return $hp;
        }
		elseif(substr(trim($nohp),0,1) !== '0') {
			$hp = '+62'.substr(trim($nohp),0);
			return $hp;
		}
    }
	
}

function tambahcashout($data){
	global $conn;
	// $idcab = htmlspecialchars($data["idcab"]);
	$jenis = htmlspecialchars($data["jenis"]);
	$keterangan = htmlspecialchars($data["keterangan"]);
	$nominal = htmlspecialchars($data["nominal"]);
    $prove = uploadprove();
	if (!$prove) {
		return false;
	}

	// masukkan data prove ke database 
	mysqli_query($conn, "INSERT INTO `pengeluaran` (`jenis_pengeluaran`,`keterangan`,`nominal`,`bukti`,`created_at`) VALUES ('$jenis','$keterangan','$nominal','$prove',current_timestamp());");
	return mysqli_affected_rows($conn);
}

function uploadprove(){
	$namafile = $_FILES['bukti']['name'];
	$ukuranFile = $_FILES['bukti']['size'];
	$error = $_FILES['bukti']['error'];
	$tmpName = $_FILES['bukti']['tmp_name'];
	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo "
			<script>
			alert('Pilih File terlebih dahulu!');
			</script>
		";
		return false;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiFileValid = ['jpg','jpeg','png','pdf'];
	$ekstensiFile = explode('.', $namafile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan File!');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranFile > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;
	move_uploaded_file($tmpName, '../assets/img/prove/' .$namaFileBaru);
	return $namaFileBaru;
}

function tambahuser($data){
	global $conn;
	$username = htmlspecialchars($data["username"]);
	$nama = htmlspecialchars($data["nama"]);
	$no_hp = htmlspecialchars($data["no_hp"]);
	$no_hp = hportu($no_hp);
    $jabatan = htmlspecialchars($data["jabatan"]);
	$tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);
	$role = strtolower($data["role"]);
    $jk = strtolower($data["jk"]);
    $gambar = uploadgambar();
	if (!$gambar) {
		return false;
	}
	// $timestamp = date('Y-m-d H:i:s');
	// cek email sudah ada atau belum
	$cekuser = mysqli_query($conn , "SELECT username FROM users WHERE username ='$username'");
	if (mysqli_fetch_assoc($cekuser)) {
		echo "<script>
            alert('Username Sudah Ada!');
                </script>";
		return false;
	}

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	// masukkan data userbaru ke database 
	mysqli_query($conn, "INSERT INTO `users` (`id_user`,`nama`, `username`, `password`, `role`, `jabatan`, `jk`,`no_hp`,`foto`,`tanggal_lahir`,`created_at`) VALUES (NULL,'$nama', '$username', '$password', '$role', '$jabatan', '$jk','$no_hp','$gambar', '$tanggal_lahir', current_timestamp());");
	return mysqli_affected_rows($conn);
}




function addwonder($data){
	global $conn;
	$id_user = htmlspecialchars($data["id_user"]);
	$no_afe = htmlspecialchars($data["no_afe"]);
	$tahun_pengerjaan = htmlspecialchars($data["tahun_pengerjaan"]);
	$id_sumur = htmlspecialchars($data["sumur"]);
	$no_sumur = htmlspecialchars($data["no_sumur"]);
	$tipe_pekerjaan = htmlspecialchars($data["tipe_pekerjaan"]);
	$id_rig = htmlspecialchars($data["rig"]);
	$kapasitas_rig = htmlspecialchars($data["kapasitas_rig"]);
	$jarak_moving = htmlspecialchars($data["jarak_moving"]);
	$total_hari_moving_afe = htmlspecialchars($data["total_hari_moving_afe"]);
	$jatah_moving = htmlspecialchars($data["jatah_moving"]);
	$moving_days = htmlspecialchars($data["moving_days"]);
	$operation_days_plan = htmlspecialchars($data["operation_days_plan"]);
	$operation_days = htmlspecialchars($data["operation_days"]);
	$budget = htmlspecialchars($data["budget"]);
	$plan_budget = htmlspecialchars($data["plan_budget"]);
	// $keterangan = htmlspecialchars($data["keterangan"]); // Pastikan keterangan diambil dari data

	// Mulai transaksi
	mysqli_begin_transaction($conn);

	try {
		// Insert ke tabel wonder
		$result = mysqli_query($conn, "INSERT INTO `wonder` (`id_user`, `no_afe`, `tahun_pengerjaan`, `id_sumur`, `no_sumur`, `tipe_pekerjaan`, `id_rig`, `kapasitas_rig`, `jarak_moving`, `total_hari_moving_afe`, `jatah_moving`, `moving_days`, `operation_days_plan`, `operation_days`, `budget`, `plan_budget`, `created_at`, `updated_at`,`updated_by`) VALUES ('$id_user', '$no_afe', '$tahun_pengerjaan', '$id_sumur', '$no_sumur', '$tipe_pekerjaan', '$id_rig', '$kapasitas_rig', '$jarak_moving', '$total_hari_moving_afe', '$jatah_moving', '$moving_days', '$operation_days_plan', '$operation_days', '$budget', '$plan_budget', current_timestamp(), current_timestamp(), '$id_user')");
		if (!$result) {
			throw new Exception('Query Error: ' . mysqli_errno($conn) . ' - ' . mysqli_error($conn));
		}

		// Mendapatkan id_wonder yang baru saja diinsert
		$id_wonder = mysqli_insert_id($conn);

		// Insert ke tabel ba_keterangan
		$keterangan_result = mysqli_query($conn, "INSERT INTO `ba_keterangan` (`id_wonder`, `created_at`) VALUES ('$id_wonder', current_timestamp())");
		if (!$keterangan_result) {
			throw new Exception('Query Error (ba_keterangan): ' . mysqli_errno($conn) . ' - ' . mysqli_error($conn));
		}

		// Commit transaksi
		mysqli_commit($conn);
		return true;
	} catch (Exception $e) {
		// Rollback transaksi jika terjadi error
		mysqli_rollback($conn);
		die($e->getMessage());
	}
}

function adddeadline($data){
	global $conn;
	$id_wonder= htmlspecialchars($data["id_wonder"]);
	$deadline= htmlspecialchars($data["deadline"]);
	$progress = htmlspecialchars($data["progress"]);

	$query = "UPDATE wonder SET
				progress = '$progress',
				deadline = '$deadline'
				WHERE id_upload = $id_wonder";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahwonder($data){
	global $conn;
	$id = $data["id"];
	$id_user = htmlspecialchars($data["id_user"]);
	$id_sumur = htmlspecialchars($data["sumur"]);
	$no_sumur = htmlspecialchars($data["no_sumur"]);
	$id_rig = htmlspecialchars($data["rig"]);
	$no_rig = htmlspecialchars($data["no_rig"]);
	$start_miru = htmlspecialchars($data["start_miru"]);
	$finish_miru = htmlspecialchars($data["finish_miru"]);
	$spud_date = htmlspecialchars($data["spud_date"]);
	$completion = htmlspecialchars($data["completion_date"]);
	$moving_days = htmlspecialchars($data["moving_days"]);
	$operation_days = htmlspecialchars($data["operation_days"]);
	$program_p = htmlspecialchars($data["program_p"]);
	$program_r = htmlspecialchars($data["program_r"]);
	$budget = htmlspecialchars($data["budget"]);
	$plan_budget = htmlspecialchars($data["plan_budget"]);
	$keterangan = htmlspecialchars($data["keterangan"]);

	// $query = "UPDATE `wonder` SET
	// 			`role` = '$role',
	// 			`nama` = '$nama',
	// 			`role` = '$role',
	// 			`jabatan` = '$jabatan',
	// 			`no_hp` = '$no_hp',
	// 			`foto` = '$gambar'
	// 			WHERE id_user = '$id'";
	// mysqli_query($conn,$query);
	// return mysqli_affected_rows($conn);
}




function addsumur($data){
	global $conn;
	$sumur = htmlspecialchars($data["nama_sumur"]);
	$ceksumur = mysqli_query($conn , "SELECT nama_sumur FROM sumur WHERE nama_sumur ='$sumur'");
	if (mysqli_fetch_assoc($ceksumur)) {
		echo "<script>
            alert('Sumur Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `sumur` (`id_sumur`, `nama_sumur`) VALUES (NULL, '$sumur');");
	return mysqli_affected_rows($conn);
}
function ubahsumur($data){
	global $conn;
	$id = $data["id"];
	$sumur= htmlspecialchars($data["nama_sumur"]);

	$query = "UPDATE sumur SET
				nama_sumur = '$sumur'
				WHERE id_sumur = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}
function hapussumur($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM sumur WHERE id_sumur = $id");
	return mysqli_affected_rows($conn);
}
function hapuswonder($id_wonder){
    global $conn;
    // Mulai transaksi
    mysqli_begin_transaction($conn);

    try {
        // Cek apakah ada data di tabel evidence yang berkaitan dengan id_wonder
        $checkEvidence = "SELECT id_evidence FROM evidence WHERE id_wonder = $id_wonder";
        $result = mysqli_query($conn, $checkEvidence);
        if (mysqli_num_rows($result) > 0) {
            // Jika ada, hapus data dari tabel history_evidence yang berkaitan dengan id_evidence
            $deleteHistory = "DELETE history_evidence FROM history_evidence JOIN evidence ON history_evidence.id_evidence = evidence.id_evidence WHERE evidence.id_wonder = $id_wonder";
            mysqli_query($conn, $deleteHistory);

            // Hapus data dari tabel evidence yang berkaitan dengan id_wonder
            $deleteEvidence = "DELETE FROM evidence WHERE id_wonder = $id_wonder";
            mysqli_query($conn, $deleteEvidence);
            if (mysqli_affected_rows($conn) == 0) {
                throw new Exception("Gagal menghapus data dari evidence.");
            }
        }

        // Hapus data dari tabel wonder
        $deleteWonder = "DELETE FROM wonder WHERE id_upload = $id_wonder";
        mysqli_query($conn, $deleteWonder);
        if (mysqli_affected_rows($conn) == 0) {
            throw new Exception("Gagal menghapus data dari wonder.");
        }

        // Jika semua operasi berhasil, commit transaksi
        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        // Jika ada error, rollback transaksi
        mysqli_rollback($conn);
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        return false;
    }
}

function hapusevidence($id){
    global $conn;
    // Mulai transaksi
    mysqli_begin_transaction($conn);

    try {
        // Hapus data dari tabel history_evidence terlebih dahulu
        $deleteHistory = "DELETE FROM history_evidence WHERE id_evidence = $id";
        mysqli_query($conn, $deleteHistory);
        if (mysqli_affected_rows($conn) == 0) {
            throw new Exception("Gagal menghapus data dari history_evidence.");
        }

        // Hapus data dari tabel evidence
        $deleteEvidence = "DELETE FROM evidence WHERE id_evidence = $id";
        mysqli_query($conn, $deleteEvidence);
        if (mysqli_affected_rows($conn) == 0) {
            throw new Exception("Gagal menghapus data dari evidence.");
        }

        // Jika kedua operasi berhasil, commit transaksi
        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        // Jika ada error, rollback transaksi
        mysqli_rollback($conn);
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        return false;
    }
}



function addrig($data){
	global $conn;
	$rig = htmlspecialchars($data["rig"]);
	$cekrig = mysqli_query($conn , "SELECT rig FROM rig WHERE rig ='$rig'");
	if (mysqli_fetch_assoc($cekrig)) {
		echo "<script>
            alert('Data Rig Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `rig` (`id_rig`, `rig`) VALUES (NULL, '$rig');");
	return mysqli_affected_rows($conn);
}
function hapusrig($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM rig WHERE id_rig = $id");
	return mysqli_affected_rows($conn);
}
function ubahrig($data){
	global $conn;
	$id = $data["id"];
	$rig= htmlspecialchars($data["rig"]);

	$query = "UPDATE rig SET
				rig = '$rig'
				WHERE id_rig = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function additem($data){
	global $conn;
	$numbering = htmlspecialchars($data['numbering']);
	$item = htmlspecialchars($data['item']);
	$bobot = htmlspecialchars($data["bobot"]);
	$ceknumbering = mysqli_query($conn , "SELECT numbering FROM item WHERE numbering ='$numbering'");
	if (mysqli_fetch_assoc($ceknumbering)) {
		echo "<script>
            alert('Data Item dengan Priority Tersebut Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `item` (`id_item`, `numbering`,`item`,`bobot`,`created_at`) VALUES (NULL, '$numbering','$item','$bobot',current_timestamp());");
	return mysqli_affected_rows($conn);
}

function ubahitem($data){
	global $conn;
	$id = $data["id"];
	$item= htmlspecialchars($data["item"]);
	$numbering = htmlspecialchars($data['numbering']);
	$bobot = htmlspecialchars($data['bobot']);
	$ceknumbering = mysqli_query($conn , "SELECT numbering FROM item WHERE numbering ='$numbering' AND id_item != '$id'");
	if (mysqli_fetch_assoc($ceknumbering)) {
		echo "<script>
            alert('Data Item dengan Priority Tersebut Sudah Ada!');
                </script>";
		return false;
	}

	$query = "UPDATE item SET
				numbering = '$numbering',
				item = '$item',
				bobot = '$bobot'
				WHERE id_item = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}
function hapusitem($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM item WHERE id_item = $id");
	return mysqli_affected_rows($conn);
}









// Santri Function

function addsantri($data){
	global $conn;
	$nis = htmlspecialchars($data["NIS"]);
	$fullname = htmlspecialchars($data["fullname"]);
	$tl = htmlspecialchars($data["tl"]);
	$jk = htmlspecialchars($data["jk"]);
	$ttl = htmlspecialchars($data["ttl"]);
	$waortu = htmlspecialchars($data["waortu"]);
    $alamat = htmlspecialchars($data["alamat"]);
	$password = mysqli_real_escape_string($conn, $data["formValidationPass"]);
	$password2 = mysqli_real_escape_string($conn,$data["formValidationConfirmPass"]);
    $status = strtolower($data["status"]);
	$hobi = htmlspecialchars($data["hobi"]);
	$skills = htmlspecialchars($data["skills"]);
	$kelas = htmlspecialchars($data["kelas"]);
	$tahun = htmlspecialchars($data["thnajar"]);
	$semester = htmlspecialchars($data["semester"]);
	$kamar = htmlspecialchars($data["kamar"]);
	$kategori = htmlspecialchars($data["kategori"]);
	$ibu = htmlspecialchars($data["ibu"]);
	$ayah = htmlspecialchars($data["ayah"]);
    $gambar = uploadgambar();
	if (!$gambar) {
		return false;
	}
	// $timestamp = date('Y-m-d H:i:s');
	// cek email sudah ada atau belum
	$ceksantri = mysqli_query($conn , "SELECT NIS FROM santri WHERE NIS ='$nis'");
	if (mysqli_fetch_assoc($ceksantri)) {
		echo "<script>
            alert('Santri dengan NIS $nis Sudah Ada!');
                </script>";
		return false;
	}

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	// masukkan data userbaru ke database 
	$result = mysqli_multi_query($conn, "INSERT INTO `santri` (`id_santri`,`id_kategori`, `id_kamar`,`NIS`,`password`, `fullname`, `jk`, `tl`,`ttl`,`alamat`,`keterampilan`,`hobi`,`status`,`gambar`,`ibu`,`ayah`,`waortu`,`created_At`) VALUES (NULL,'$kategori', '$kamar','$nis','$password', '$fullname', '$jk','$tl','$ttl','$alamat','$skills','$hobi','$status','$gambar','$ibu','$ayah','$waortu', current_timestamp());INSERT INTO `kelas_santri` (`id_kelas_santri`,`NIS`,`id_kelas`,`id_tahun`,`semester`,`status`) VALUES (NULL,'$nis','$kelas','$tahun','$semester',0);");
	if (!$result) {
		die('Query Error : '.mysqli_errno($conn). 
		' - '.mysqli_error($conn));
	}
	return mysqli_affected_rows($conn);
}


function addsantribaru($data){
	global $conn;
	$nohp = htmlspecialchars($data["nohp"]);
	$kampus = htmlspecialchars($data["kampus"]);
	$tingkat = htmlspecialchars($data["tingkat"]);
	$namalengkap = htmlspecialchars($data["namalengkap"]);
	$tempatlahir = htmlspecialchars($data["tempatlahir"]);
	$ttl = htmlspecialchars($data["ttl"]);
	$jk = htmlspecialchars($data["jk"]);
	$status = htmlspecialchars($data["status"]);
	$goldar = htmlspecialchars($data["goldar"]);
	$form_prov = htmlspecialchars($data["form_prov"]);
	$form_kab = htmlspecialchars($data["form_kab"]);
	$form_kec = htmlspecialchars($data["form_kec"]);
	$form_des = htmlspecialchars($data["form_des"]);
	$alamat = htmlspecialchars($data["alamat"]);
	// $password = mysqli_real_escape_string($conn, $data["password"]);
	// $password2 = mysqli_real_escape_string($conn,$data["konfirmpassword"]);
	$prov = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_prov'")[0]['nama'];
	$kab = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_kab'")[0]['nama'];
	$kec = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_kec'")[0]['nama'];
	$des = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_des'")[0]['nama'];
	
	// cek no hp sudah ada atau belum
	$ceksantri = mysqli_query($conn , "SELECT notelp FROM akun WHERE notelp ='$nohp'");
	if (mysqli_fetch_assoc($ceksantri)) {
		echo "<script>
            alert('Santri dengan Nomor Telpon $nohp Sudah Ada!');
                </script>";
		return false;
	}

		$sql= "INSERT INTO `pendaftaran` (`Id`,`fullname`,`kampus`,`tingkat`,`tempat_lahir`,`tanggal_lahir`,`jenis_kelamin`,`status`,`goldar`,`provinsi`,`kabupaten`,`kecamatan`,`desa`,`alamat`) VALUES (null,'$namalengkap','$kampus','$tingkat','$tempatlahir','$ttl','$jk','$status', '$goldar','$prov','$kab','$kec','$des','$alamat')";
		$exec 	= mysqli_query($conn,$sql);
		if ($exec) {
			$id 		= $conn->insert_id;
			//echo $id;
			$query 		= "INSERT INTO akun VALUES(null, '$nohp', '12345678910', '',1, $id)";

			$exec_akun 	=  mysqli_query($conn, $query);

			$date_regis	= date("Y-m-d");

			$query2		= "INSERT INTO `detail_pendaftaran` (`id_user`,`tanggal_daftar`,`status_pendaftaran`) VALUES ('$id', '$date_regis', 0)";

			$exec_detil	= mysqli_query($conn, $query2);

			if ($exec_akun && $exec_detil) {
				session_destroy();
				return mysqli_affected_rows($conn);
			}else{
				die('Query Error : '.mysqli_errno($conn). 
				' - '.mysqli_error($conn));
			}

		}else{
			echo mysqli_error($conn);
		}
	return mysqli_affected_rows($conn);
}

function conregis($data){
	global $conn;
	$ida = htmlspecialchars($data["id_akun"]);
	$idd = htmlspecialchars($data["id_detail"]);
	$idregis = htmlspecialchars($data["id_daftar"]);
	$idadmin = htmlspecialchars($data["id_admin"]);
	$nohp = htmlspecialchars($data["notelp"]);
	$kampus = htmlspecialchars($data["kampus"]);
	$tingkat = htmlspecialchars($data["tingkat"]);
	$namalengkap = htmlspecialchars($data["fullname"]);
	$tempatlahir = htmlspecialchars($data["tempat_lahir"]);
	$tanggallahir = htmlspecialchars($data["tanggal_lahir"]);
	$jk = htmlspecialchars($data["jenis_kelamin"]);
	$status = htmlspecialchars($data["status"]);
	$goldar = htmlspecialchars($data["goldar"]);
	$form_prov = htmlspecialchars($data["provinsi"]);
	$form_kab = htmlspecialchars($data["kabupaten"]);
	$form_kec = htmlspecialchars($data["kecamatan"]);
	$form_des = htmlspecialchars($data["desa"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$nova = htmlspecialchars($data["nova"]);
	$biayaregis = htmlspecialchars($data["biayaregis"]);
	$statuspembayaran = htmlspecialchars($data["status_pembayaran"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);
	$conregis = htmlspecialchars($data["conregis"]);
	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
			alert('Konfirmasi Password Tidak Sesuai!');
				</script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
		$sql= "UPDATE `pendaftaran` SET 
		`fullname` = '$namalengkap',
		`kampus` = '$kampus',
		`tingkat` = '$tingkat',
		`tempat_lahir` = '$tempatlahir',
		`tanggal_lahir` = '$tanggallahir',
		`jenis_kelamin` = '$jk',
		`status` = '$status',
		`goldar` = '$goldar',
		`provinsi` = '$form_prov',
		`kabupaten` = '$form_kab',
		`kecamatan` = '$form_kec',
		`desa` = '$form_des',
		`alamat` = '$alamat' WHERE `Id` = '$idregis';";

		$exec 	= mysqli_query($conn,$sql);

		if ($exec) {
			$query 		= "UPDATE `akun` SET 
			`notelp` = '$nohp', 
			`password` = '$password' 
			WHERE Id = '$ida';";
			
			$exec_akun 	=  mysqli_query($conn, $query);
			if ($conregis === '1') {
				$query2		= "UPDATE `detail_pendaftaran` SET 
				`id_admin` = '$idadmin',
				`metode_pembayaran_pendaftaran` = '$statuspembayaran',
				`status_pendaftaran` = '$conregis',
				`biaya_regis` = '$biayaregis',
				`nomor_va` = '$nova' WHERE `Id` = '$idd';INSERT INTO `santri` (`id_akun`,`fullname`,`jk`,`tl`,`ttl`,`alamat`,`status`,`gambar`,`point`,`waortu`) VALUES ('$ida','$namalengkap','$jk','$tempatlahir','$tanggallahir','$alamat','aktif','default.jpg','100','$nohp');";
				$exec_detil	= mysqli_multi_query($conn, $query2);
				if ($exec_akun && $exec_detil) {
					// session_destroy();
					return mysqli_affected_rows($conn);
				}else{
					die('Query Error : '.mysqli_errno($conn). 
					' - '.mysqli_error($conn));
				}
			}else if($conregis === '0'){
				$query2		= "UPDATE `detail_pendaftaran` SET 
				`id_admin` = '$idadmin',
				`metode_pembayaran_pendaftaran` = '$statuspembayaran',
				`status_pendaftaran` = '-1',
				`biaya_regis` = '$biayaregis',
				`nomor_va` = '$nova' WHERE `Id` = '$idd';";
				$exec_detil	= mysqli_multi_query($conn, $query2);
				if ($exec_akun && $exec_detil) {
					// session_destroy();
					return mysqli_affected_rows($conn);
				}else{
					die('Query Error : '.mysqli_errno($conn). 
					' - '.mysqli_error($conn));
				}
			}
		}else{
			echo mysqli_error($conn);
		}
	return mysqli_affected_rows($conn);

}


function verifdata($data){
	global $conn;
	$id_santri = $data["id_santri"];
	$rowsan = query("SELECT * FROM santri WHERE id_santri = '$id_santri'")[0];
	$ida = $rowsan['id_akun'];
	$rowall = query("SELECT akun.Id, pendaftaran.Id AS 'idp', detail_pendaftaran.Id AS 'idd' FROM akun INNER JOIN pendaftaran ON akun.id_user = pendaftaran.Id INNER JOIN detail_pendaftaran ON pendaftaran.Id = detail_pendaftaran.id_user WHERE akun.Id = '$ida'")[0];
	$idd = $rowall['idd'];
	$anakke = htmlspecialchars($data["anakke"]);
	$jumlahsaudara = htmlspecialchars($data["jumlahsaudara"]);
	$status_dalam_keluarga = htmlspecialchars($data["status_dalam_keluarga"]);
	$nis = htmlspecialchars($data["nis"]);
	$nik = htmlspecialchars($data["nik"]);
	$status_ayah = htmlspecialchars($data["status_ayah"]);
	$status_ibu = htmlspecialchars($data["status_ibu"]);
	$status_sekolah = htmlspecialchars($data["status_sekolah"]);
	$jenis_sekolah = htmlspecialchars($data["jenis_sekolah"]);
	$nama_sekolah = htmlspecialchars($data["nama_sekolah"]);
	$alamat_sekolah = htmlspecialchars($data["alamat_sekolah"]);
	$tahun_lulus = htmlspecialchars($data["tahun_lulus"]);
	$nama_ayah = htmlspecialchars($data["nama_ayah"]);
	$nika = htmlspecialchars($data["nika"]);
	$ayah_status = htmlspecialchars($data["ayah_status"]);
	$pendidikan_ayah = htmlspecialchars($data["pendidikan_ayah"]);
	$pekerjaan_ayah = "";
	for ($i=0; $i < count($data['pekerjaan_ayah']);$i++) { 
		if ($i == count($data['pekerjaan_ayah']) - 1) {
			$pekerjaan_ayah .= $data['pekerjaan_ayah'][$i];	
		}else {
			$pekerjaan_ayah .= $data['pekerjaan_ayah'][$i].",";
		}
	}
	$penghasilan_ayah = htmlspecialchars($data["penghasilan_ayah"]);
	$notelpa = htmlspecialchars($data["notelp"]);
	$nik_ibu = htmlspecialchars($data["nik_ibu"]);
	$nama_ibu = htmlspecialchars($data["nama_ibu"]);
	$ibu_status = htmlspecialchars($data["ibu_status"]);
	$pendidikan_ibu = htmlspecialchars($data["pendidikan_ibu"]);
	$pekerjaan_ibu = "";
	for ($i=0; $i < count($data['pekerjaan_ibu']);$i++) { 
		if ($i == count($data['pekerjaan_ibu']) - 1) {
			$pekerjaan_ibu .= $data['pekerjaan_ibu'][$i];	
		}else {
			$pekerjaan_ibu .= $data['pekerjaan_ibu'][$i].",";
		}
	}
	$penghasilan_ibu = htmlspecialchars($data["penghasilan_ibu"]);
	$notelpi = htmlspecialchars($data["notelp_ibu"]);

	// data alamat
	$form_prov = htmlspecialchars($data["form_prov"]);
	$form_kab = htmlspecialchars($data["form_kab"]);
	$form_kec = htmlspecialchars($data["form_kec"]);
	$form_des = htmlspecialchars($data["form_des"]);
	$rtrw = htmlspecialchars($data["rtrw"]);
	$jalan = htmlspecialchars($data["jalan"]);
	$kodepos = htmlspecialchars($data["kodepos"]);
	$transport = "";
	for ($i=0; $i < count($data['transport']);$i++) { 
		if ($i == count($data['transport']) - 1) {
			$transport .= $data['transport'][$i];	
		}else {
			$transport .= $data['transport'][$i].",";
		}
	}
	$penyakit = htmlspecialchars($data["penyakit"]);
	$bahasa = "";
	for ($i=0; $i < count($data['bahasa']);$i++) { 
		if ($i == count($data['bahasa']) - 1) {
			$bahasa .= $data['bahasa'][$i];	
		}else {
			$bahasa .= $data['bahasa'][$i].",";
		}
	}
	$hafalan = htmlspecialchars($data["hafalan"]);
	$hobi = "";
	for ($i=0; $i < count($data['hobi']);$i++) { 
		if ($i == count($data['hobi']) - 1) {
			$hobi .= $data['hobi'][$i];	
		}else {
			$hobi .= $data['hobi'][$i].",";
		}
	}
	$info = htmlspecialchars($data['info']);
	// $password = mysqli_real_escape_string($conn, $data["password"]);
	// $password2 = mysqli_real_escape_string($conn,$data["konfirmpassword"]);
	$prov = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_prov'")[0]['nama'];
	$kab = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_kab'")[0]['nama'];
	$kec = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_kec'")[0]['nama'];
	$des = query("SELECT * FROM wilayah_2020 WHERE kode = '$form_des'")[0]['nama'];
	
	// cek santri sudah ada atau belum
	$ceksantri = mysqli_query($conn , "SELECT id_santri FROM santri WHERE id_santri ='$id_santri'");
	if (!$ceksantri) {
		echo "<script>
			alert('Santri Tidak Ditemukan Dalam Sistem!');
				</script>";
		return false;
	}
	$ceksantri2 = mysqli_query($conn,"SELECT id_santri FROM data_ayah WHERE id_santri = '$id_santri'");
	$ceksantri3 = query("SELECT status_pendaftaran FROM detail_pendaftaran WHERE Id = '$idd'")[0];
	$status_pend = $ceksantri3['status_pendaftaran'];
	if ($ceksantri2 && $status_pend == '2') {
		echo "<script>
			alert('Santri Sudah Melakukan Verifikasi Data, Mohon Hubungi Admin!');
				</script>";
		return false;
	}
	
	$sql= "INSERT INTO `data_alamat` (
		`id_santri`,
		`provinsi`,
		`kabupaten`,
		`kecamatan`,
		`kelurahan`,
		`rt`,
		`rw`,
		`kode_pos`,
		`jalan`) 
	VALUES (
		'$id_santri',
		'$prov',
		'$kab',
		'$kec',
		'$des',
		'$rtrw',
		'$rtrw',
		'$kodepos',
		'$jalan');INSERT INTO `data_ayah` (
		`id_santri`,
		`nama_ayah`,
		`nik`,
		`status`,
		`status_kandung`,
		`pendidikan_terakhir`,
		`pekerjaan`,
		`penghasilan`,
		`notelp`)
		VALUES (
		'$id_santri',
		'$nama_ayah',
		'$nika',
		'$status_ayah',
		'$ayah_status',
		'$pendidikan_ayah',
		'$pekerjaan_ayah',
		'$penghasilan_ayah',
		'$notelpa');INSERT INTO `data_ibu` (
		`id_santri`,
		`nama_ibu`,
		`nik`,
		`status`,
		`status_kandung`,
		`pendidikan_terakhir`,
		`pekerjaan`,
		`penghasilan`,
		`notelp`)
		VALUES (
		'$id_santri',
		'$nama_ibu',
		'$nik_ibu',
		'$status_ibu',
		'$ibu_status',
		'$pendidikan_ibu',
		'$pekerjaan_ibu',
		'$penghasilan_ibu',
		'$notelpi');INSERT INTO `data_sekolah` (
		`id_santri`,
		`jenis_sekolah`,
		`nama_sekolah`,
		`status_sekolah`,
		`alamat_sekolah`,
		`tahun_lulus`)
		VALUES (
		'$id_santri',
		'$jenis_sekolah',
		'$nama_sekolah',
		'$status_sekolah',
		'$alamat_sekolah',
		'$tahun_lulus');INSERT INTO `data_penunjang` (
		`id_santri`,
		`anakke`,
		`jumlah_saudara`,
		`transport`,
		`penyakit`,
		`bahasa`,
		`hafalan`,
		`hobi`,
		`info`)
		VALUES (
		'$id_santri',
		'$anakke',
		'$jumlahsaudara',
		'$transport',
		'$penyakit',
		'$bahasa',
		'$hafalan',
		'$hobi',
		'$info');UPDATE `detail_pendaftaran` 
		SET 
		`status_pendaftaran` = '2' 
		WHERE Id = '$idd';UPDATE `santri` 
		SET
			`NIS` = '$nis',
			`NIK` = '$nik' WHERE id_santri = '$id_santri';";
		$exec 	= mysqli_multi_query($conn,$sql);
		if ($exec) {
			return mysqli_affected_rows($conn);
		}else {
			die('Query Error : '.mysqli_errno($conn). 
				' - '.mysqli_error($conn));
		}
}

// Function UpdateDataPribadi
function updatedatapribadi($data){
global $conn;
$id_santri = $data["id_santri"];
$anakke = htmlspecialchars($data["anakke"]);
$jumlahsaudara = htmlspecialchars($data["jumlahsaudara"]);
// $status_dalam_keluarga = htmlspecialchars($data["status_dalam_keluarga"]);
$nis = htmlspecialchars($data["nis"]);
$nik = htmlspecialchars($data["nik"]);
$status_ayah = htmlspecialchars($data["status_ayah"]);
$status_ibu = htmlspecialchars($data["status_ibu"]);

	$sql = "UPDATE `santri` 
		SET
			`NIS` = '$nis',
			`NIK` = '$nik' WHERE id_santri = '$id_santri';UPDATE `data_penunjang`
		SET 
			`anakke` = '$anakke',
			`jumlah_saudara` = '$jumlahsaudara' WHERE id_santri = '$id_santri';UPDATE `data_ayah`
		SET
			`status` = '$status_ayah' WHERE id_santri = '$id_santri';UPDATE `data_ibu`
		SET
			`status` = '$status_ibu' WHERE id_santri = '$id_santri';";
		$exec 	= mysqli_multi_query($conn,$sql);
		if ($exec) {
			return true;
		}else {
			die('Query Error : '.mysqli_errno($conn). 
				' - '.mysqli_error($conn));
		}
}
// Function UpdateDataPribadi

// Function UpdateDataSekolah
function updatedataschool($data){
	global $conn;
	$id_santri = $data["id_santri"];
	$status_sekolah = htmlspecialchars($data["status_sekolah"]);
	$jenis_sekolah = htmlspecialchars($data["jenis_sekolah"]);
	$nama_sekolah = htmlspecialchars($data["nama_sekolah"]);
	$alamat_sekolah = htmlspecialchars($data["alamat_sekolah"]);
	$tahun_lulus = htmlspecialchars($data["tahun_lulus"]);
	
		$sql = "UPDATE `data_sekolah` 
			SET
				`jenis_sekolah` = '$jenis_sekolah',
				`nama_sekolah` = '$nama_sekolah',
				`status_sekolah` = '$status_sekolah',
				`alamat_sekolah` = '$alamat_sekolah',
				`tahun_lulus` = '$tahun_lulus' WHERE id_santri = '$id_santri';";
			$exec 	= mysqli_multi_query($conn,$sql);
			if ($exec) {
				return true;
			}else {
				die('Query Error : '.mysqli_errno($conn). 
					' - '.mysqli_error($conn));
			}
}
// Function UpdateDataSekolah

// Function UpdateDataAyah
function updatedataayah($data){
	global $conn;
	$id_santri = $data["id_santri"];
	$nama_ayah = htmlspecialchars($data["nama_ayah"]);
	$nika = htmlspecialchars($data["nika"]);
	$ayah_status = htmlspecialchars($data["ayah_status"]);
	$pendidikan_ayah = htmlspecialchars($data["pendidikan_ayah"]);
	$pekerjaan_ayah = "";
	for ($i=0; $i < count($data['pekerjaan_ayah']);$i++) { 
		if ($i == count($data['pekerjaan_ayah']) - 1) {
			$pekerjaan_ayah .= $data['pekerjaan_ayah'][$i];	
		}else {
			$pekerjaan_ayah .= $data['pekerjaan_ayah'][$i].",";
		}
	}
	$penghasilan_ayah = htmlspecialchars($data["penghasilan_ayah"]);
	$notelp = htmlspecialchars($data["notelp"]);
	
		$sql = "UPDATE `data_ayah` 
			SET
				`nama_ayah` = '$nama_ayah',
				`nik` = '$nika',
				`status_kandung` = '$ayah_status',
				`pendidikan_terakhir` = '$pendidikan_ayah',
				`pekerjaan` = '$pekerjaan_ayah',
				`penghasilan` = '$penghasilan_ayah',
				`notelp` = '$notelp' WHERE id_santri = '$id_santri';";
			$exec 	= mysqli_multi_query($conn,$sql);
			if ($exec) {
				return true;
			}else {
				die('Query Error : '.mysqli_errno($conn). 
					' - '.mysqli_error($conn));
			}
}
// Function UpdateDataAyah

// Function UpdateDataIbu
function updatedataibu($data){
	global $conn;
	$id_santri = $data["id_santri"];
	$nama_ibu = htmlspecialchars($data["nama_ibu"]);
	$nik_ibu = htmlspecialchars($data["nik_ibu"]);
	$ibu_status = htmlspecialchars($data["ibu_status"]);
	$pendidikan_ibu = htmlspecialchars($data["pendidikan_ibu"]);
	$pekerjaan_ibu = "";
	for ($i=0; $i < count($data['pekerjaan_ibu']);$i++) { 
		if ($i == count($data['pekerjaan_ibu']) - 1) {
			$pekerjaan_ibu .= $data['pekerjaan_ibu'][$i];	
		}else {
			$pekerjaan_ibu .= $data['pekerjaan_ibu'][$i].",";
		}
	}
	$penghasilan_ibu = htmlspecialchars($data["penghasilan_ibu"]);
	$notelp = htmlspecialchars($data["notelp"]);
	
		$sql = "UPDATE `data_ibu` 
			SET
				`nama_ibu` = '$nama_ibu',
				`nik` = '$nik_ibu',
				`status_kandung` = '$ibu_status',
				`pendidikan_terakhir` = '$pendidikan_ibu',
				`pekerjaan` = '$pekerjaan_ibu',
				`penghasilan` = '$penghasilan_ibu',
				`notelp` = '$notelp' WHERE id_santri = '$id_santri';";
			$exec 	= mysqli_multi_query($conn,$sql);
			if ($exec) {
				return true;
			}else {
				die('Query Error : '.mysqli_errno($conn). 
					' - '.mysqli_error($conn));
			}
}
// Function UpdateDataIbu

// Function UpdateDataPenunjang
function updatedatapenunjang($data){
	global $conn;
	$id_santri = $data["id_santri"];
	// data alamat
	$form_prov = htmlspecialchars($data["form_prov"]);
	$form_kab = htmlspecialchars($data["form_kab"]);
	$form_kec = htmlspecialchars($data["form_kec"]);
	$form_des = htmlspecialchars($data["form_des"]);
	$rtrw = htmlspecialchars($data["rtrw"]);
	$jalan = htmlspecialchars($data["jalan"]);
	$kodepos = htmlspecialchars($data["kodepos"]);
	$transport = "";
	for ($i=0; $i < count($data['transport']);$i++) { 
		if ($i == count($data['transport']) - 1) {
			$transport .= $data['transport'][$i];	
		}else {
			$transport .= $data['transport'][$i].",";
		}
	}
	$penyakit = htmlspecialchars($data["penyakit"]);
	$bahasa = "";
	for ($i=0; $i < count($data['bahasa']);$i++) { 
		if ($i == count($data['bahasa']) - 1) {
			$bahasa .= $data['bahasa'][$i];	
		}else {
			$bahasa .= $data['bahasa'][$i].",";
		}
	}
	$hafalan = htmlspecialchars($data["hafalan"]);
	$hobi = "";
	for ($i=0; $i < count($data['hobi']);$i++) { 
		if ($i == count($data['hobi']) - 1) {
			$hobi .= $data['hobi'][$i];	
		}else {
			$hobi .= $data['hobi'][$i].",";
		}
	}
	$info = htmlspecialchars($data['info']);
	
	
		$sql = "UPDATE `data_alamat` 
			SET
				`provinsi` = '$form_prov',
				`kabupaten` = '$form_kab',
				`kecamatan` = '$form_kec',
				`kelurahan` = '$form_des',
				`rt` = '$rtrw',
				`rw` = '$rtrw',
				`kode_pos` = '$kodepos',
				`jalan` = '$jalan' WHERE id_santri = '$id_santri';UPDATE `data_penunjang`
			SET
				`transport` = '$transport',
				`penyakit` = '$penyakit',
				`bahasa` = '$bahasa',
				`hafalan` = '$hafalan',
				`hobi` = '$hobi',
				`info` = '$info' WHERE id_santri = '$id_santri';";
			$exec 	= mysqli_multi_query($conn,$sql);
			if ($exec) {
				return true;
			}else {
				die('Query Error : '.mysqli_errno($conn). 
					' - '.mysqli_error($conn));
			}
}
// Function UpdateDataPenunjang

// Santri Function

function tambahdonasi($data){
	global $conn;
	$produk = htmlspecialchars($data["produk"]);
	$kategori = htmlspecialchars($data["kategori"]);
	$deskripsi = htmlspecialchars($data["deskripsi"]);

    $target = htmlspecialchars($data["target"]);
	$deadline = htmlspecialchars($data["deadline"]);
	$admin = htmlspecialchars($data["admin"]);
    $status = strtolower($data["status"]);
    $gambar = uploadgambardonasi();
	if (!$gambar) {
		return false;
	}
	// $timestamp = date('Y-m-d H:i:s');
	// cek email sudah ada atau belum
	$cekproduk = mysqli_query($conn , "SELECT * FROM produk WHERE nama_produk ='$produk' AND id_kategori = '$kategori'");
	if (mysqli_fetch_assoc($cekproduk)) {
		echo "<script>
            alert('Donasi Sudah Terdaftar !');
                </script>";
		return false;
	}
	// masukkan data donasi baru ke database 
		mysqli_query($conn, "INSERT INTO `produk` (`id_kategori`, `manager`, `nama_produk`, `deskripsi`,`target`,`deadline`,`gambar`,`status`,`created_at`,`updated_at`) VALUES ('$kategori', '$admin', '$produk', '$deskripsi','$target','$deadline','$gambar','$status', current_timestamp(), current_timestamp());");
		return mysqli_affected_rows($conn);
}

function tambahdermawan($data){
	global $conn;
	$fullname = htmlspecialchars($data["namalengkap"]);
	$notelp = htmlspecialchars($data["notelp"]);
    $alamat = htmlspecialchars($data["alamat"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);
	$relawan_id = $data["relawan_id"];
    $status = strtolower($data["status"]);
    $gambar = uploadgambar();
	if (!$gambar) {
		return false;
	}
	// $timestamp = date('Y-m-d H:i:s');
	// cek email sudah ada atau belum
	$cekdermawan = mysqli_query($conn , "SELECT notelp FROM dermawan WHERE notelp ='$notelp'");
	if (mysqli_fetch_assoc($cekdermawan)) {
		echo "<script>
            alert('Nomor Telepon Sudah Terdaftar !');
                </script>";
		return false;
	}

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	// masukkan data userbaru ke database 
	if ($relawan_id == '0') {
		mysqli_query($conn, "INSERT INTO `dermawan` (`id_user`, `namalengkap`,`password`, `notelp`, `alamat`,`status`,`relawan_id`,`gambar`,`created_at`,`last_login`) VALUES (NULL, '$fullname', '$password', '$notelp', '$alamat','$status',NULL,'$gambar', current_timestamp(), current_timestamp());");
		return mysqli_affected_rows($conn);
	}else{
		mysqli_query($conn, "INSERT INTO `dermawan` (`id_user`, `namalengkap`, `password`, `notelp`, `alamat`,`status`,`relawan_id`,`gambar`,`created_at`,`last_login`) VALUES (NULL, '$fullname', '$password', '$notelp', '$alamat','$status','$relawan_id','$gambar', current_timestamp(), current_timestamp());");
		return mysqli_affected_rows($conn);
	}
}


function tambahrelawan($data){
	global $conn;
	$nik = htmlspecialchars($data["nik"]);
	$namalengkap = htmlspecialchars($data["namalengkap"]);
	$nohp = htmlspecialchars($data["nohp"]);
    $id_cabang = htmlspecialchars($data["cabang"]);
	$id_kota = htmlspecialchars($data["kota"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);
	$status = strtolower($data["status"]);
    $stats = strtolower($data["stats"]);
    $gambar = uploadgambar();
	if (!$gambar) {
		return false;
	}
	// $timestamp = date('Y-m-d H:i:s');
	// cek email sudah ada atau belum
	$cekrelawan = mysqli_query($conn , "SELECT NIK FROM relawan WHERE NIK ='$nik'");
	if (mysqli_fetch_assoc($cekrelawan)) {
		echo "<script>
            alert('NIK Relawan Sudah Terdaftar!');
                </script>";
		return false;
	}

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	// masukkan data userbaru ke database 
	mysqli_query($conn, "INSERT INTO `relawan` (`NIK`, `password`, `namalengkap`, `id_cabang`, `id_kota`, `nohp`,`status_relawan`,`stats`,`gambar`,`created_at`) VALUES ('$nik', '$password', '$namalengkap', '$id_cabang', '$id_kota', '$nohp','$status','$stats','$gambar', current_timestamp());");
	return mysqli_affected_rows($conn);
}

function addkategori($data){
	global $conn;
	$kategori = htmlspecialchars($data["kategori"]);
	$cekkat = mysqli_query($conn , "SELECT kategori FROM kategori WHERE kategori ='$kategori'");
	if (mysqli_fetch_assoc($cekkat)) {
		echo "<script>
            alert('Kategori Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES (NULL, '$kategori');");
	return mysqli_affected_rows($conn);
}

function addclass($data){
	global $conn;
	$kelas = htmlspecialchars(mysqli_real_escape_string($conn,$data["class"]));
	$tingkat = htmlspecialchars($data["tingkat"]);
	$idwali = htmlspecialchars($data['wali']);

	$cekclass = mysqli_query($conn , "SELECT * FROM kelas WHERE kelas ='$kelas' AND tingkat ='$tingkat' AND id_wali = '$idwali'");
	if (mysqli_fetch_assoc($cekclass)) {
		echo "<script>
            alert('Kelas Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `kelas` (`id_kelas`,`id_wali`,`kelas`,`tingkat`) VALUES (NULL,'$idwali', '$kelas','$tingkat');");
	return mysqli_affected_rows($conn);
}

function addkelompok($data){
	global $conn;
	$kelompok = htmlspecialchars(mysqli_real_escape_string($conn,$data["kelompok"]));
	$pj = htmlspecialchars($data['pj']);

	$cekkelompok = mysqli_query($conn , "SELECT * FROM kelompok WHERE kelompok ='$kelompok' AND pj = '$pj'");
	if (mysqli_fetch_assoc($cekkelompok)) {
		echo "<script>
            alert('Kelompok Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `kelompok` (`id_kelompok`,`kelompok`,`pj`) VALUES (NULL,'$kelompok','$pj');");
	return mysqli_affected_rows($conn);
}

function addmapel($data){
	global $conn;
	$guru = htmlspecialchars($data["pengajar"]);
	$kode = htmlspecialchars($data["kode_mapel"]);
	$mapel = htmlspecialchars($data["mapel"]);


	$cekmapel = mysqli_query($conn , "SELECT * FROM mapel WHERE kode_mapel ='$kode' AND mapel ='$mapel'");
	if (mysqli_fetch_assoc($cekmapel)) {
		echo "<script>
            alert('Mapel Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `mapel` (`id_mapel`,`id_pengajar`, `kode_mapel`,`mapel`) VALUES (NULL,'$guru','$kode','$mapel');");
	return mysqli_affected_rows($conn);
}

function addpayment($data){
	global $conn;
	$pembayaran = htmlspecialchars(mysqli_real_escape_string($conn,$data["pembayaran"]));
	$id_tahun = htmlspecialchars($data["id_tahun"]);
	$type = htmlspecialchars($data["tipe"]);

	$cekpayment = mysqli_query($conn , "SELECT * FROM payment WHERE pembayaran ='$pembayaran' AND id_tahun ='$id_tahun'");
	if (mysqli_fetch_assoc($cekpayment)) {
		echo "<script>
            alert('Jenis Pembayaran Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `payment` (`payment_id`,`payment_type`, `id_tahun`,`pembayaran`,`created_at`) VALUES (NULL,'$type','$id_tahun','$pembayaran',NOW());");
	return mysqli_affected_rows($conn);
}

function addcashschool($data){
	global $conn;
	$id_santri = htmlspecialchars($data["santri"]);
	$saldo = htmlspecialchars($data["saldo"]);

	$cekcashschool = mysqli_query($conn , "SELECT * FROM cashschool WHERE id_santri ='$id_santri'");
	if (mysqli_fetch_assoc($cekcashschool)) {
		echo "<script>
            alert('Tabungan Pondok Santri Sudah Ada!');
                </script>";
		return false;
	}
	// masukkan data tabungan Pondok baru ke database 
	mysqli_query($conn, "INSERT INTO `cashschool` (`id_santri`,`saldo`,`created_at`) VALUES ('$id_santri','$saldo',NOW());");
	return mysqli_affected_rows($conn);
}

function massalcashschool($data){
	global $conn;
	$saldo = htmlspecialchars($data["saldo"]);
	$kelas = htmlspecialchars($data["id_kelas"]);
	
	$queryfix = "";

	for ($i=0; $i < count($data['chkbox']);$i++) { 
    $id_santri = $data['chkbox'][$i];
	$cekcashschool = mysqli_query($conn , "SELECT * FROM cashschool WHERE id_santri ='$id_santri'");
	if (mysqli_fetch_assoc($cekcashschool)) {
		echo "<script>
            alert('Tabungan Pondok Santri Sudah Ada!');
                </script>";
		return false;
	}

	$query = "INSERT INTO `cashschool` (`id_santri`,`saldo`,`created_at`) VALUES ('$id_santri','$saldo',NOW());";
	$queryfix .= $query;
	}
	mysqli_multi_query($conn,$queryfix);
	return mysqli_affected_rows($conn);
}


function addcashbank($data){
	global $conn;
	$id_santri = htmlspecialchars($data["santri"]);
	$saldo = htmlspecialchars($data["saldo"]);

	$cekcashbank = mysqli_query($conn , "SELECT * FROM cashbank WHERE id_santri ='$id_santri'");
	if (mysqli_fetch_assoc($cekcashbank)) {
		echo "<script>
            alert('Tabungan Bank Santri Sudah Ada!');
                </script>";
		return false;
	}
	// masukkan data tabungan bank baru ke database 
	mysqli_query($conn, "INSERT INTO `cashbank` (`id_santri`,`saldo`,`created_at`) VALUES ('$id_santri','$saldo',NOW());");
	return mysqli_affected_rows($conn);
}

function tambahprove($data){
	global $conn;
	$id_bebas_pay = htmlspecialchars($data["id_bebas_pay"]);
	$id_santri = htmlspecialchars($data["id_santri"]);
	$notelp = htmlspecialchars($data["notelp"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$bebaspay = query("SELECT * FROM bebas_pay WHERE id_bebas_pay = '$id_bebas_pay'")[0];
	$status = "Lunas";
    $prove = uploadprove();
	if (!$prove) {
		return false;
	}

	if ($status === 'Lunas') {
		$query1 = "INSERT INTO `bebas_payment` (`id_bebas_pay`,`id_santri`,`notelp`,`nominal`,`buktibayar`,`status`,`tglbyr`,`created_at`) VALUES ('$id_bebas_pay','$id_santri','$notelp','$nominal','$prove','$status',current_timestamp(), current_timestamp());";
		$terbayar = $nominal + $bebaspay['dana'];
		if ($terbayar >= $bebaspay['bebas_bill']) {
			$dana = $bebaspay['dana'];
			$bayar = $dana + $nominal;
			$query2 = "UPDATE `bebas_pay` SET `status` = 'Lunas', `dana` = '$bayar' WHERE `id_bebas_pay` = $id_bebas_pay;";
		}else{
			$dana = $bebaspay['dana'];
			$bayar = $dana + $nominal;
			$query2 = "UPDATE `bebas_pay` SET `status` = 'proses', `dana` = '$bayar' WHERE `id_bebas_pay` = $id_bebas_pay;";
		}
		$query = $query1.$query2;
		mysqli_multi_query($conn,$query);
		return mysqli_affected_rows($conn);
	}else{
	mysqli_query($conn, "INSERT INTO `bebas_payment` (`id_bebas_pay`,`id_santri`,`notelp`,`nominal`,`buktibayar`,`status`,`tglbyr`,`created_at`) VALUES ('$id_bebas_pay','$id_santri','$notelp','$nominal','$prove','$status',current_timestamp(), current_timestamp());");
	return mysqli_affected_rows($conn);
	}
	
}

function tambahprovebulan($data){
	global $conn;
	$id_bulan_pay = htmlspecialchars($data["id_bulan_pay"]);
	$id_santri = htmlspecialchars($data["id_santri"]);
	$notelp = htmlspecialchars($data["notelp"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$status = "Lunas";
	$status2 = 1;
    $prove = uploadprove();
	if (!$prove) {
		return false;
	}

	// masukkan data prove ke database 
	mysqli_multi_query($conn, "INSERT INTO `bulan_payment` (`id_bulan_pay`,`id_santri`,`notelp`,`nominal`,`buktibayar`,`status`,`tglbyr`,`created_at`) VALUES ('$id_bulan_pay','$id_santri','$notelp','$nominal','$prove','$status',current_timestamp(), current_timestamp());UPDATE `bulan_pay` SET `status` = '$status2' WHERE id_bulan_pay = '$id_bulan_pay';");
	return mysqli_affected_rows($conn);
}

function massalcashbank($data){
	global $conn;
	$saldo = htmlspecialchars($data["saldo"]);
	$kelas = htmlspecialchars($data["id_kelas"]);
	
	$queryfix = "";

	for ($i=0; $i < count($data['chkbox']);$i++) { 
    $id_santri = $data['chkbox'][$i];
	$cekcashbank = mysqli_query($conn , "SELECT * FROM cashbank WHERE id_santri ='$id_santri'");
	if (mysqli_fetch_assoc($cekcashbank)) {
		echo "<script>
            alert('Tabungan Bank Santri Sudah Ada!');
                </script>";
		return false;
	}

	$query = "INSERT INTO `cashbank` (`id_santri`,`saldo`,`created_at`) VALUES ('$id_santri','$saldo',NOW());";
	$queryfix .= $query;
	}
	mysqli_multi_query($conn,$queryfix);
	return mysqli_affected_rows($conn);
}

function addsetor($data){
	global $conn;
	$tgl = htmlspecialchars($data["tgl"]);
	$id_santri = htmlspecialchars($data["idsan"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$catatan = htmlspecialchars(mysqli_real_escape_string($conn,$data["catatan"]));
	$id_cashbank = htmlspecialchars($data["id_cashbank"]);
	// cek cashbank
	$cashbank = query("SELECT saldo FROM cashbank WHERE id_cashbank = '$id_cashbank'")[0];
	$saldo = $cashbank["saldo"] + $nominal;
	// masukkan data tabungan bank baru ke database 
	mysqli_multi_query($conn, "INSERT INTO `transaksi_bank` (`id_cashbank`,`nominal`,`jenis`,`catatan`,`created_at`) VALUES ('$id_cashbank','$nominal','setoran','$catatan','$tgl');UPDATE cashbank SET saldo = '$saldo' WHERE id_cashbank = '$id_cashbank';");
	return mysqli_affected_rows($conn);
}
function addsetorschool($data){
	global $conn;
	$tgl = htmlspecialchars($data["tgl"]);
	$id_santri = htmlspecialchars($data["idsan"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$catatan = htmlspecialchars(mysqli_real_escape_string($conn,$data["catatan"]));
	$id_cashschool = htmlspecialchars($data["id_cashschool"]);
	// cek cashschool
	$cashschool = query("SELECT saldo FROM cashschool WHERE id_cashschool = '$id_cashschool'")[0];
	$saldo = $cashschool["saldo"] + $nominal;
	// masukkan data tabungan bank baru ke database 
	mysqli_multi_query($conn, "INSERT INTO `transaksi_pondok` (`id_cashschool`,`nominal`,`jenis`,`catatan`,`created_at`) VALUES ('$id_cashschool','$nominal','setoran','$catatan','$tgl');UPDATE cashschool SET saldo = '$saldo' WHERE id_cashschool = '$id_cashschool';");
	return mysqli_affected_rows($conn);
}

function addtarik($data){
	global $conn;
	$tgl = htmlspecialchars($data["tgl"]);
	$id_santri = htmlspecialchars($data["idsan"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$catatan = htmlspecialchars(mysqli_real_escape_string($conn,$data["catatan"]));
	$id_cashbank = htmlspecialchars($data["id_cashbank"]);
	// cek cashbank
	$cashbank = query("SELECT saldo FROM cashbank WHERE id_cashbank = '$id_cashbank'")[0];
	$saldo = $cashbank["saldo"] - $nominal;
	// masukkan data tabungan bank baru ke database 
	mysqli_multi_query($conn, "INSERT INTO `transaksi_bank` (`id_cashbank`,`nominal`,`jenis`,`catatan`,`created_at`) VALUES ('$id_cashbank','$nominal','penarikan','$catatan','$tgl');UPDATE cashbank SET saldo = '$saldo' WHERE id_cashbank = '$id_cashbank';");
	return mysqli_affected_rows($conn);
}

function addtarikschool($data){
	global $conn;
	$tgl = htmlspecialchars($data["tgl"]);
	$id_santri = htmlspecialchars($data["idsan"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$catatan = htmlspecialchars(mysqli_real_escape_string($conn,$data["catatan"]));
	$id_cashschool = htmlspecialchars($data["id_cashschool"]);
	// cek cashschool
	$cashschool = query("SELECT saldo FROM cashschool WHERE id_cashschool = '$id_cashschool'")[0];
	$saldofix = $cashschool["saldo"];
	$saldo = $cashschool["saldo"] - $nominal;
	// cek saldo 0 atau tidak
	if ($saldofix <= 0) {
		echo "<script>
		alert('Saldo Santri Tidak Mencukupi Untuk Melakukan Penarikan!');
			</script>";
		return false;
	}
	// masukkan data tabungan pondok baru ke database 
	mysqli_multi_query($conn, "INSERT INTO `transaksi_pondok` (`id_cashschool`,`nominal`,`jenis`,`catatan`,`created_at`) VALUES ('$id_cashschool','$nominal','penarikan','$catatan','$tgl');UPDATE cashschool SET saldo = '$saldo' WHERE id_cashschool = '$id_cashschool';");
	return mysqli_affected_rows($conn);
}

function hapustransbank($id){
	global $conn;
	$trans = query("SELECT * FROM transaksi_bank WHERE id_trans_bank = '$id'")[0];
	$id_cashbank = $trans["id_cashbank"];
	// cek cashbank
	$cashbank = query("SELECT saldo FROM cashbank WHERE id_cashbank = '$id_cashbank'")[0];
	$nominal = $trans["nominal"];
	if ($trans['jenis'] == 'setoran') {
		$saldo = $cashbank["saldo"] - $nominal;
	}elseif ($trans['jenis'] == 'penarikan') {
		$saldo = $cashbank["saldo"] + $nominal;
	}else {
		$saldo = $cashbank["saldo"];
	}
	// masukkan data tabungan bank baru ke database 
	mysqli_multi_query($conn, "DELETE FROM `transaksi_bank` WHERE id_trans_bank = '$id';UPDATE cashbank SET saldo = '$saldo' WHERE id_cashbank = '$id_cashbank';");
	return mysqli_affected_rows($conn);
}

function validdata($data){
	global $validdata;
	$validdata = 0;
	foreach ($data as $key => $value) {
		if ($value === '0' || $value === NULL || $value === "") {
			$validdata += 1;
		}
	}
	return $validdata;
}

function hapustransschool($id){
	global $conn;
	$trans = query("SELECT * FROM transaksi_pondok WHERE id_trans_pondok = '$id'")[0];
	$id_cashschool = $trans["id_cashschool"];
	// cek cashschool
	$cashschool = query("SELECT saldo FROM cashschool WHERE id_cashschool = '$id_cashschool'")[0];
	$nominal = $trans["nominal"];
	if ($trans['jenis'] == 'setoran') {
		$saldo = $cashschool["saldo"] - $nominal;
	}elseif ($trans['jenis'] == 'penarikan') {
		$saldo = $cashschool["saldo"] + $nominal;
	}else {
		$saldo = $cashschool["saldo"];
	}
	// masukkan data tabungan bank baru ke database 
	mysqli_multi_query($conn, "DELETE FROM `transaksi_pondok` WHERE id_trans_pondok = '$id';UPDATE cashschool SET saldo = '$saldo' WHERE id_cashschool = '$id_cashschool';");
	return mysqli_affected_rows($conn);
}

function hapusberkasopsi($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM data_berkas_pendukung WHERE id_data_berkas_pendukung = '$id'");
	return mysqli_affected_rows($conn);
}

function hapusbahambatan($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM ba_hambatan WHERE id_ba_hambatan = '$id'");
	return mysqli_affected_rows($conn);
}

function hapusprestasi($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM prestasi WHERE id_prestasi = $id");
	return mysqli_affected_rows($conn);
}

function hapuscashbank($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM cashbank WHERE id_cashbank = $id");
	return mysqli_affected_rows($conn);
}

function hapuscashschool($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM cashschool WHERE id_cashschool = $id");
	return mysqli_affected_rows($conn);
}

function hapusgroupsan($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kelompok_santri WHERE id_kelompok_santri = $id");
	return mysqli_affected_rows($conn);
}

function addtarifsantri($data){
	global $conn;
	$pembayaran = htmlspecialchars($data["pembayaran"]);
	$id_kelas = htmlspecialchars($data["kelas"]);
	$id_santri = htmlspecialchars($data["santri"]);
	$bill = htmlspecialchars($data["billsama"]);

	$cekpayment = mysqli_query($conn , "SELECT * FROM bulan_pay WHERE payment_id ='$pembayaran' AND id_santri ='$id_santri'");
	if (mysqli_fetch_assoc($cekpayment)) {
		echo "<script>
            alert('Tarif Pembayaran Santri Sudah Ada, Silakan Edit Data Santri Tersebut!');
                </script>";
		return false;
	}

	$queryfix = "";
	for ($i=0; $i < count($data['chkbox']);$i++) { 
    $id_bulan = $data['chkbox'][$i];
	$query = "INSERT INTO `bulan_pay` (`payment_id`,`id_santri`,`id_bulan`,`bulan_pay`,`created_at`) VALUES ('$pembayaran','$id_santri','$id_bulan','$bill',NOW());";
	$queryfix .= $query;
	}
	
	mysqli_multi_query($conn,$queryfix);
	return mysqli_affected_rows($conn);
}


function addtarifkelas($data){
	global $conn;
	$pembayaran = htmlspecialchars($data["pembayaran"]);
	$id_kelas = htmlspecialchars($data["kelas"]);
	// $id_santri = htmlspecialchars($data["santri"]);
	$bill = htmlspecialchars($data["billsama"]);
	$payment = query("SELECT * FROM payment WHERE payment_id = '$pembayaran'")[0];
	$tahun = $payment['id_tahun'];
	
	
	$santri = query("SELECT santri.*,kelas_santri.* FROM kelas_santri INNER JOIN santri ON kelas_santri.NIS = santri.NIS WHERE kelas_santri.id_kelas = '$id_kelas' AND kelas_santri.status = '0' AND kelas_santri.id_tahun = '$tahun';");
	$queryfix = "";
	foreach ($santri as $san) {
		$id_santri = $san['id_santri'];
		for ($i=0; $i < count($data['chkbox']);$i++) { 
		$id_bulan = $data['chkbox'][$i];
		// cek payment ada atau tidak 
		$cekpayment = mysqli_query($conn , "SELECT * FROM bulan_pay WHERE payment_id ='$pembayaran' AND id_santri ='$id_santri' AND id_bulan = '$id_bulan'");
		if (mysqli_fetch_assoc($cekpayment)) {
			$query = "";
			$queryfix .= $query;
		}else{
			$query = "INSERT INTO `bulan_pay` (`payment_id`,`id_santri`,`id_bulan`,`bulan_pay`,`created_at`) VALUES ('$pembayaran','$id_santri','$id_bulan','$bill',NOW());";
			$queryfix .= $query;
			}
		}
	}
	// var_dump($queryfix);
	// die;
	mysqli_multi_query($conn,$queryfix);
	return mysqli_affected_rows($conn);
}

function addtarifbebaskelas($data){
	global $conn;
	$pembayaran = htmlspecialchars($data["pembayaran"]);
	$id_kelas = htmlspecialchars($data["kelas"]);
	// $id_santri = htmlspecialchars($data["santri"]);
	$bill = htmlspecialchars($data["billsama"]);
	$payment = query("SELECT * FROM payment WHERE payment_id = '$pembayaran'")[0];
	$tahun = $payment['id_tahun'];
	
	
	$santri = query("SELECT santri.*,kelas_santri.* FROM kelas_santri INNER JOIN santri ON kelas_santri.NIS = santri.NIS WHERE kelas_santri.id_kelas = '$id_kelas' AND kelas_santri.status = '0' AND kelas_santri.id_tahun = '$tahun';");
	$queryfix = "";
	foreach ($santri as $san) {
		$id_santri = $san['id_santri'];
		// cek payment ada atau tidak 
		$cekpayment = mysqli_query($conn , "SELECT * FROM bebas_pay WHERE payment_id ='$pembayaran' AND id_santri ='$id_santri'");
		if (mysqli_fetch_assoc($cekpayment)) {
			$query = "";
			$queryfix .= $query;
		}else{
			$query = "INSERT INTO `bebas_pay` (`id_santri`,`payment_id`,`bebas_bill`,`created_at`) VALUES ('$id_santri','$pembayaran','$bill',NOW());";
			$queryfix .= $query;
			}
	}
	// var_dump($queryfix);
	// die;
	mysqli_multi_query($conn,$queryfix);
	return mysqli_affected_rows($conn);
}

function addtarifbebassantri($data){
	global $conn;
	$pembayaran = htmlspecialchars($data["pembayaran"]);
	$id_kelas = htmlspecialchars($data["kelas"]);
	$id_santri = htmlspecialchars($data["santri"]);
	$bill = htmlspecialchars($data["billsama"]);

	$cekpayment = mysqli_query($conn , "SELECT * FROM bebas_pay WHERE payment_id ='$pembayaran' AND id_santri ='$id_santri'");
	if (mysqli_fetch_assoc($cekpayment)) {
		echo "<script>
            alert('Tarif Pembayaran Santri Sudah Ada, Silakan Edit Data Santri yang Sudah Ada Tersebut!');
                </script>";
		return false;
	}

	$query = "INSERT INTO `bebas_pay` (`id_santri`,`payment_id`,`bebas_bill`,`created_at`) VALUES ('$id_santri','$pembayaran','$bill',NOW());";
	
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}



function addevent($data){
	global $conn;
	$kegiatan   = htmlspecialchars(mysqli_real_escape_string($conn,$data['kegiatan']));
    $mulai      = htmlspecialchars($data['mulai']);
    $selesai    = htmlspecialchars($data['selesai']);
	mysqli_query($conn, "INSERT INTO calendar set kegiatan='$kegiatan', mulai='$mulai', selesai='$selesai'");
	return mysqli_affected_rows($conn);
}

function addmateri($data){
	global $conn;
	$id_mapel = htmlspecialchars($data["id_mapel"]);
	$kode = htmlspecialchars($data["kd_materi"]);
	$judul = htmlspecialchars($data["judul"]);
	$keterangan = htmlspecialchars($data["keterangan"]);


	$cekmateri = mysqli_query($conn , "SELECT * FROM materi WHERE id_mapel ='$id_mapel' AND kd_materi ='$kode'");
	if (mysqli_fetch_assoc($cekmateri)) {
		echo "<script>
            alert('Materi Sudah Ada!');
                </script>";
		return false;
	}

	mysqli_query($conn, "INSERT INTO `materi` (`id_materi`,`id_mapel`, `kd_materi`,`bab`,`keterangan`) VALUES (NULL,'$id_mapel','$kode','$judul','$keterangan');");
	return mysqli_affected_rows($conn);
}

function addjadwal($data){
	global $conn;
	$id_kelas = htmlspecialchars($data["id_kelas"]);
	$id_hari = htmlspecialchars($data['hari']);
	$id_mapel = htmlspecialchars($data['mapel']);
	$id_pengajar = htmlspecialchars($data['guru']);
	$jam_start = htmlspecialchars($data['jam_start']);
	$jam_end = htmlspecialchars($data['jam_end']);
	$semester = htmlspecialchars($data['semester']);
	$id_tahun = htmlspecialchars($data['id_tahun']);
	$cekjadwal = mysqli_query($conn , "SELECT * FROM jadwal WHERE id_hari ='$id_hari' AND id_kelas ='$id_kelas' AND id_mapel = '$id_mapel' AND id_tahun = '$id_tahun' AND semester = '$semester'");
	if (mysqli_fetch_assoc($cekjadwal)) {
		echo "<script>
            alert('Jadwal Sudah Ada!');
                </script>";
		return false;
	}

	mysqli_query($conn, "INSERT INTO `jadwal` (`id_jadwal`,`id_tahun`,`id_pengajar`,`id_mapel` ,`id_kelas`,`id_hari`,`jam_awal`,`jam_akhir`,`semester`) VALUES (NULL,'$id_tahun','$id_pengajar','$id_mapel','$id_kelas','$id_hari','$jam_start','$jam_end','$semester');");
	return mysqli_affected_rows($conn);
}


function addpoint($data){
	global $conn;
	$ket = htmlspecialchars($data["keterangan"]);
	$point = htmlspecialchars($data["point"]);

	$cekpoint = mysqli_query($conn , "SELECT * FROM point WHERE keterangan ='$ket' AND point ='$point'");
	if (mysqli_fetch_assoc($cekpoint)) {
		echo "<script>
            alert('Point Sudah Ada!');
                </script>";
		return false;
	}
	// masukkan data Point Baru ke database 
	mysqli_query($conn, "INSERT INTO `point` (`id_point`, `point`,`keterangan`) VALUES (NULL, '$point','$ket');");
	return mysqli_affected_rows($conn);
}

function addmahram($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$posisi = htmlspecialchars($data["posisi"]);
	$nama = htmlspecialchars($data["nama"]);

	$cekmahram = mysqli_query($conn , "SELECT * FROM mahram WHERE nama ='$nama' AND id_santri ='$idsan' AND posisi = '$posisi'");
	if (mysqli_fetch_assoc($cekmahram)) {
		echo "<script>
            alert('Mahram Sudah Ada!');
                </script>";
		return false;
	}
	// masukkan data Point Baru ke database 
	mysqli_query($conn, "INSERT INTO `mahram` (`id_mahram`, `id_santri`,`nama`,`posisi`) VALUES (NULL, '$idsan','$nama','$posisi');");
	return mysqli_affected_rows($conn);
}

function addprestasi($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$waktu = htmlspecialchars($data['waktu']);
	$lomba = htmlspecialchars($data["lomba"]);
	$juara = htmlspecialchars($data["juara"]);
	$tingkat = htmlspecialchars($data["tingkat"]);
	$keterangan = htmlspecialchars($data["keterangan"]);
	$sertif = uploadsertif();
	if (!$sertif) {
		return false;
	}

	$cekprestasi = mysqli_query($conn , "SELECT * FROM prestasi WHERE lomba ='$lomba' AND id_santri ='$idsan' AND juara = '$juara' AND tingkat = '$tingkat'");
	if (mysqli_fetch_assoc($cekprestasi)) {
		echo "<script>
            alert('Prestasi Sudah Ada!');
                </script>";
		return false;
	}
	// masukkan data Prestasi Baru ke database 
	mysqli_query($conn, "INSERT INTO `prestasi` (`id_prestasi`, `id_santri`,`lomba`,`juara`,`tingkat`,`waktu`,`keterangan`,`sertif`) VALUES (NULL, '$idsan','$lomba','$juara','$tingkat','$waktu','$keterangan','$sertif');");
	return mysqli_affected_rows($conn);
}

function addcatatan($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$nis = htmlspecialchars($data['nis']);
	$tgl = htmlspecialchars($data['tgl']);
	$id_point = htmlspecialchars($data["point"]);
	$keterangan = htmlspecialchars(mysqli_real_escape_string($conn,$data["keterangan"]));
	$result = mysqli_query($conn, "INSERT INTO `catatan` (`id_catatan`, `id_santri`,`id_point`,`tanggal`,`keterangan`) VALUES (NULL, '$idsan','$id_point','$tgl','$keterangan');");
	if ($result) {
	$points = query("SELECT point FROM point WHERE id_point = '$id_point'")[0];
	$santri = query("SELECT * FROM santri WHERE id_santri = '$idsan'")[0];
	$point = $santri['point'] + $points['point'];
	mysqli_query($conn,"UPDATE santri SET point = '$point' WHERE id_santri = '$idsan'");
	}
	return mysqli_affected_rows($conn);
}


function addcatatanngaji($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$nis = htmlspecialchars($data['nis']);
	$idkelompoksantri = htmlspecialchars($data['idkelompoksantri']);
	$tgl = htmlspecialchars($data['tgl']);
	$jum_hafalan = htmlspecialchars(mysqli_real_escape_string($conn,$data["jum_hafalan"]));
	$juz = htmlspecialchars(mysqli_real_escape_string($conn,$data["juz"]));
	$ayat = htmlspecialchars(mysqli_real_escape_string($conn,$data["ayat"]));
	$catatan = htmlspecialchars(mysqli_real_escape_string($conn,$data["catatan"]));
	$result = mysqli_query($conn, "INSERT INTO `riwayat_ngaji` (`id_riwayat_ngaji`, `id_kelompok_santri`,`tanggal`,`jum_hafalan`,`juz`,`ayat`,`catatan`) VALUES (NULL, '$idkelompoksantri','$tgl','$jum_hafalan','$juz','$ayat','$catatan');");
	
	return mysqli_affected_rows($conn);
}

function addkesehatan($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$tgl = htmlspecialchars($data['tgl']);
	$sakit = htmlspecialchars(mysqli_real_escape_string($conn,$data["sakit"]));
	$penanganan = htmlspecialchars(mysqli_real_escape_string($conn,$data["penanganan"]));
	$keterangan = htmlspecialchars(mysqli_real_escape_string($conn,$data["keterangan"]));
	mysqli_query($conn, "INSERT INTO `penyakit` (`id_riwayat_penyakit`, `id_santri`,`penyakit`,`tanggal`,`penanganan`,`keterangan`) VALUES (NULL, '$idsan','$sakit','$tgl','$penanganan','$keterangan');");
	return mysqli_affected_rows($conn);
}

function addsuluk($data){
	global $conn;
	$id_user = htmlspecialchars($data['id_user']);
	$idsan = htmlspecialchars($data['id_santri']);
	$tahun = htmlspecialchars($data['tahun']);
	$semester = htmlspecialchars($data['semester']);
	$adab = htmlspecialchars($data["adab"]);
	$disiplin = htmlspecialchars($data["disiplin"]);
	$inisiatif = htmlspecialchars($data["inisiatif"]);
	$kreatif = htmlspecialchars($data["kreatif"]);
	$kebersihan = htmlspecialchars($data["kebersihan"]);
	$komunikasi = htmlspecialchars($data["komunikasi"]);
	$kerapian = htmlspecialchars($data["kerapian"]);
	$ceksuluk = mysqli_query($conn , "SELECT * FROM suluk WHERE id_tahun ='$tahun' AND id_santri = '$idsan' AND semester = '$semester' AND id_user = '$id_user'");
	if (mysqli_fetch_assoc($ceksuluk)) {
		echo "<script>
            alert('Anda sudah memberikan penilaian pada tahun ajaran dan semester ini!');
                </script>";
		return false;
	}
	mysqli_query($conn, "INSERT INTO `suluk` (`id_suluk`,`id_tahun`,`id_santri`,`id_user`,`semester`,`adab`,`disiplin`,`inisiatif`,`kreatif`,`kebersihan`,`komunikasi`,`kerapian`,`created_at`) VALUES (NULL,'$tahun', '$idsan','$id_user','$semester','$adab','$disiplin','$inisiatif','$kreatif','$kebersihan','$komunikasi','$kerapian',NOW());");
	return mysqli_affected_rows($conn);
}

function addtahfidz($data){
	global $conn;
	$idsan = htmlspecialchars($data['idsan']);
	$nis = htmlspecialchars($data['nis']);
	$id_jadwal = htmlspecialchars($data['id_jadwal']);
	$id_mapel = htmlspecialchars($data["id_mapel"]);
	$tgl = htmlspecialchars($data['tgl']);
	$materi = htmlspecialchars($data['materi']);
	$jumlah = htmlspecialchars($data['jumlah']);
	$remedial1 = htmlspecialchars($data['remedial1']);
	$remedial2 = htmlspecialchars($data['remedial2']);
	$remedial3 = htmlspecialchars($data['remedial3']);
	$semester = query("SELECT semester FROM semester WHERE status = '1'")[0];
	$semester = $semester['semester'];
	$tahun = query("SELECT * FROM thn_ajaran WHERE status = '1'")[0];
	$id_tahun = $tahun['id_thn'];
	
	mysqli_query($conn, "INSERT INTO `tahfidz` (`id_tahfidz`,`id_tahun`,`id_santri`,`id_jadwal`,`id_materi`,`semester`,`tanggal`,`jum_hafalan`,`remed1`,`remed2`,`remed3`) VALUES (NULL,'$id_tahun', '$idsan','$id_jadwal','$materi','$semester','$tgl','$jumlah','$remedial1','$remedial2','$remedial3');");
	return mysqli_affected_rows($conn);
}

function addnilai($data){
	global $conn;
	$idsan = htmlspecialchars($data['idsan']);
	$nis = htmlspecialchars($data['nis']);
	$id_mapel = htmlspecialchars($data['mapel']);
	$id_kelas = htmlspecialchars($data['id_kelas']);
	$tahun = htmlspecialchars($data['tahun']);
	$semester = htmlspecialchars($data['semester']);
	$nt1 = htmlspecialchars($data['nt1']);
	$nt2 = htmlspecialchars($data['nt2']);
	$nt3 = htmlspecialchars($data['nt3']);
	$uh1 = htmlspecialchars($data['uh1']);
	$uh2 = htmlspecialchars($data['uh2']);
	$uh3 = htmlspecialchars($data['uh3']);
	$uts = htmlspecialchars($data['uts']);
	$uas = htmlspecialchars($data['uas']);


	mysqli_query($conn, "INSERT INTO `nilai` (`id_nilai`,`id_santri`,`id_kelas`,`id_mapel`,`id_tahun`,`semester`,`harian1`,`harian2`,`harian3`,`tugas1`,`tugas2`,`tugas3`,`uts`,`uas`,`created_at`) VALUES (NULL,'$idsan','$id_kelas','$id_mapel','$tahun','$semester','$uh1','$uh2','$uh3','$nt1','$nt2','$nt3','$uts','$uas',NOW());");
	return mysqli_affected_rows($conn);
}

function addkunjungan($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$tgl = htmlspecialchars($data["tgl"]);
	$pukul = htmlspecialchars($data["pukul"]);
	$mahram = htmlspecialchars(implode(", ", $_POST['mahram']));
	mysqli_query($conn, "INSERT INTO `kunjungan` (`id_kunjungan`, `id_santri`,`tgl`,`pukul`,`pengunjung`) VALUES (NULL, '$idsan','$tgl','$pukul','$mahram');");
	return mysqli_affected_rows($conn);
}
function addizinkeluar($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$tgl = htmlspecialchars($data["tgl"]);
	$jam_start = htmlspecialchars($data["jam_start"]);
	$jam_end = htmlspecialchars($data["jam_end"]);
	$keterangan = htmlspecialchars($data['keterangan']);

	mysqli_query($conn, "INSERT INTO `izin_keluar` (`id_izin_keluar`, `id_santri`,`tgl`,`jam_start`,`jam_end`,`keterangan`) VALUES (NULL, '$idsan','$tgl','$jam_start','$jam_end','$keterangan');");
	return mysqli_affected_rows($conn);
}
function addizinpulang($data){
	global $conn;
	$idsan = htmlspecialchars($data['id_santri']);
	$tgl = htmlspecialchars($data["tgl"]);
	$jumlah = htmlspecialchars($data["jumlah"]);
	$keterangan = htmlspecialchars($data['keterangan']);

	mysqli_query($conn, "INSERT INTO `izin_pulang` (`id_izin_pulang`, `id_santri`,`tgl`,`jumlah`,`keterangan`) VALUES (NULL, '$idsan','$tgl','$jumlah','$keterangan');");
	return mysqli_affected_rows($conn);
}

function addtahun($data){
	global $conn;
	$start = htmlspecialchars($data["thn_ajaran_start"]);
	$end = htmlspecialchars($data["thn_ajaran_end"]);
	$status = 0;
	$cektahun = mysqli_query($conn , "SELECT * FROM thn_ajaran WHERE thn_ajaran_start ='$start' AND thn_ajaran_end = '$end'");
	if (mysqli_fetch_assoc($cektahun)) {
		echo "<script>
            alert('Tahun Ajaran Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	$result = mysqli_query($conn, "INSERT INTO `thn_ajaran` (`id_thn`, `thn_ajaran_start`,`thn_ajaran_end`,`status`) VALUES (NULL, '$start','$end','$status');");
	if (!$result) {
		die('Query Error : '.mysqli_errno($conn). 
		' - '.mysqli_error($conn));
	}
	return mysqli_affected_rows($conn);
}

function statstahun($id){
	global $conn;
	$tahun = mysqli_query($conn, "SELECT * FROM thn_ajaran WHERE id_thn = $id");
	$status = mysqli_fetch_assoc($tahun);
	$stats = $status['status'];
	if ($stats == '0') {
		$stats = '1';
		$onperiod = mysqli_query($conn, "SELECT * FROM thn_ajaran WHERE status = '1'");
		if ($onperiod) {
			$query1 = "UPDATE thn_ajaran SET status = '0' WHERE status = '1';";
			mysqli_query($conn,$query1);
		}
		$query2 = "UPDATE thn_ajaran SET
					status = '$stats'
					WHERE id_thn = $id;";
		mysqli_query($conn,$query2);
		return mysqli_affected_rows($conn);
	}else{
		$stats = '0';
			$query = "UPDATE thn_ajaran SET
					status = '$stats'
					WHERE id_thn = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}
}


function statssemester($id){
	global $conn;
	$semester = mysqli_query($conn, "SELECT * FROM semester WHERE id_semester = $id");
	$status = mysqli_fetch_assoc($semester);
	$stats = $status['status'];
	if ($stats == '0') {
		$stats = '1';
		$onperiod = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'");
		if ($onperiod) {
			$query1 = "UPDATE semester SET status = '0' WHERE status = '1';";
			mysqli_query($conn,$query1);
		}
		$query2 = "UPDATE semester SET
					status = '$stats'
					WHERE id_semester = $id;";
		mysqli_query($conn,$query2);
		return mysqli_affected_rows($conn);
	}else{
		$stats = '0';
			$query = "UPDATE semester SET
					status = '$stats'
					WHERE id_semester = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}
}

function addroom($data){
	global $conn;
	$kamar = htmlspecialchars($data["kamar"]);

	$cekroom = mysqli_query($conn , "SELECT kamar FROM kamar WHERE kamar ='$kamar'");
	if (mysqli_fetch_assoc($cekroom)) {
		echo "<script>
            alert('Kamar Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `kamar` (`id_kamar`, `kamar`) VALUES (NULL, '$kamar');");
	return mysqli_affected_rows($conn);
}


function tambahcab($data){
	global $conn;
	$cabang = htmlspecialchars($data["cabang"]);
	$cekcabang = mysqli_query($conn , "SELECT cabang FROM cabang WHERE cabang ='$cabang'");
	if (mysqli_fetch_assoc($cekcabang)) {
		echo "<script>
            alert('Cabang Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `cabang` (`id_cabang`, `cabang`) VALUES (NULL, '$cabang');");
	return mysqli_affected_rows($conn);
}

function tambahkot($data){
	global $conn;
	$kota = htmlspecialchars($data["kota"]);
	$singkatan = htmlspecialchars($data["singkatan"]);
	$idcab = $data["idcab"];
	$cekkota = mysqli_query($conn , "SELECT kota FROM kota WHERE kota ='$kota' AND id_cabang ='$idcab'");
	if (mysqli_fetch_assoc($cekkota)) {
		echo "<script>
            alert('Kota Sudah Ada!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `kota` (`id_kota`,`id_cabang`,`kota`,`singkatan`) VALUES (NULL, '$idcab','$kota','$singkatan');");
	return mysqli_affected_rows($conn);
}


function tambahrek($data){
	global $conn;
	$norek = htmlspecialchars($data["norek"]);
	$rekening = htmlspecialchars($data["rekening"]);
	$bank = htmlspecialchars($data["bank"]);
	$cekrek = mysqli_query($conn , "SELECT * FROM rekening WHERE atasnama ='$rekening' AND bank ='$bank'");
	if (mysqli_fetch_assoc($cekrek)) {
		echo "<script>
            alert('Rekening Sudah Terdaftar!');
                </script>";
		return false;
	}

	// masukkan data jenis baru ke database 
	mysqli_query($conn, "INSERT INTO `rekening` (`id_rekening`,`norek`,`atasnama`,`bank`) VALUES (NULL,'$norek','$rekening','$bank');");
	return mysqli_affected_rows($conn);
}
function tambahinfo($data){
	global $conn;
	$heading = htmlspecialchars($data["heading"]);
	$keterangan = htmlspecialchars($data["keterangan"]);
    $gambar = uploadgambarinfo();
	if (!$gambar) {
		return false;
	}
	// $trunc = mysqli_query($conn, "TRUNCATE info;");
	// if ($trunc) {
	// 	mysqli_query($conn, "INSERT INTO `info` (`heading`, `teks1`, `teks2`, `teks3`, `teks4`, `gambar`) VALUES ('$heading', '$teks1', '$teks2', '$teks3', '$teks4','$gambar');");
	mysqli_query($conn, "INSERT INTO `info` (`heading`, `keterangan`, `gambar`) VALUES ('$heading', '$keterangan','$gambar');");
	return mysqli_affected_rows($conn);
}

function addberkas($data){
	global $conn;

	$id_user = htmlspecialchars($data['id_user']);
    $id_wonder = htmlspecialchars($data['id_wonder']);
	$item = htmlspecialchars($data['item']);
	$remarks_uploader = htmlspecialchars($data['remarks_uploader']);
    $berkas = uploadberkas();
	if (!$berkas) {
		return false;
	}

	$cekberkaswonder = mysqli_query($conn , "SELECT * FROM evidence WHERE id_wonder ='$id_wonder' AND id_item = '$item'");
	if (mysqli_fetch_assoc($cekberkaswonder)) {
		echo "<script>
            alert('Data Berkas WONDER Sudah Ada!');
                </script>";
		return false;
	}

	// Start transaction
	mysqli_begin_transaction($conn);

	try {
		// Pertama, masukkan data ke tabel `evidence`
		$queryEvidence = "INSERT INTO `evidence` (`id_evidence`, `id_wonder`, `id_item`, `remarks_uploader`) VALUES (NULL, '$id_wonder', '$item', '$remarks_uploader');";
		if (!mysqli_query($conn, $queryEvidence)) {
			throw new Exception('Error in queryEvidence: ' . mysqli_error($conn));
		}
		$lastInsertedId = mysqli_insert_id($conn); // Mendapatkan ID dari data yang baru saja dimasukkan

		// Jika data berhasil dimasukkan ke tabel `evidence`, masukkan data ke tabel `history_evidence`
		$queryHistory = "INSERT INTO `history_evidence` (`id_history`, `id_evidence`, `document`,`uploader`) VALUES (NULL, '$lastInsertedId', '$berkas', '$id_user');";
		if (!mysqli_query($conn, $queryHistory)) {
			throw new Exception('Error in queryHistory: ' . mysqli_error($conn));
		}

		// Update tabel `wonder`
		$queryUpdateWonder = "UPDATE `wonder` SET `updated_at` = NOW(), `updated_by` = (SELECT `nama` FROM `users` WHERE `id_user` = '$id_user') WHERE `id_upload` = '$id_wonder';";
		if (!mysqli_query($conn, $queryUpdateWonder)) {
			throw new Exception('Error in queryUpdateWonder: ' . mysqli_error($conn));
		}

		// Commit transaction
		mysqli_commit($conn);
		return true;
	} catch (Exception $e) {
		// Jika ada error, rollback transaction
		mysqli_rollback($conn);
		echo "<script>alert('Gagal melakukan operasi: " . $e->getMessage() . "');</script>";
		return false;
	}
}



function getGoogleDocsViewerUrl($id_history) {
    global $conn; // Menggunakan koneksi database global

    // Ambil data file dari database
    $query = query("SELECT * FROM history_evidence WHERE id_history = $id_history")[0];

    if ($query) {
        $filePath = '/dashboard/assets/wonder/' . $query['document'];
        $fileUrl = 'https://wonderppp.my.id/' . $filePath; // Ganti dengan URL yang sesuais
        return "https://docs.google.com/viewer?url=" . urlencode($fileUrl) . "&embedded=true";
    } else {
        return null;
    }
}

function getGoogleDocsViewerUrlOpsi($id_data_berkas_pendukung) {
    global $conn; // Menggunakan koneksi database global

    // Ambil data file dari database
    $query = query("SELECT * FROM data_berkas_pendukung WHERE id_data_berkas_pendukung = $id_data_berkas_pendukung")[0];

    if ($query) {
        $filePath = '/dashboard/assets/wonder/' . $query['nama_berkas'];
        $fileUrl = 'https://wonderppp.my.id/' . $filePath; // Ganti dengan URL yang sesuais
        return "https://docs.google.com/viewer?url=" . urlencode($fileUrl) . "&embedded=true";
    } else {
        return null;
    }
}

function confirmberkas($data){
	global $conn;
	$id_user = htmlspecialchars($data['id_user']);
    $id_wonder = htmlspecialchars($data['id_wonder']);
	$item = htmlspecialchars($data['id_item']);
	$status = htmlspecialchars($data['status']);
	$progress = 100;
	// $remarks = htmlspecialchars($data['remarks']);
	// Start transaction
	mysqli_begin_transaction($conn);

	try {
		// Pertama, masukkan data ke tabel `evidence`
		$queryEvidence = "INSERT INTO `evidence` (`id_evidence`, `id_wonder`, `id_item`, `status`, `progress`) VALUES (NULL, '$id_wonder', '$item', '$status', '$progress');";
		if (!mysqli_query($conn, $queryEvidence)) {
			throw new Exception('Error in queryEvidence: ' . mysqli_error($conn));
		}
		$lastInsertedId = mysqli_insert_id($conn); // Mendapatkan ID dari data yang baru saja dimasukkan

		// Jika data berhasil dimasukkan ke tabel `evidence`, masukkan data ke tabel `history_evidence`
		$queryHistory = "INSERT INTO `history_evidence` (`id_history`, `id_evidence`, `document`,`uploader`) VALUES (NULL, '$lastInsertedId', 'Auto Confirm Berkas', '$id_user');";
		if (!mysqli_query($conn, $queryHistory)) {
			throw new Exception('Error in queryHistory: ' . mysqli_error($conn));
		}

		// Update tabel `wonder`
		$queryUpdateWonder = "UPDATE `wonder` SET `updated_at` = NOW(), `updated_by` = (SELECT `nama` FROM `users` WHERE `id_user` = '$id_user') WHERE `id_upload` = '$id_wonder';";
		if (!mysqli_query($conn, $queryUpdateWonder)) {
			throw new Exception('Error in queryUpdateWonder: ' . mysqli_error($conn));
		}

		// Commit transaction
		mysqli_commit($conn);
		return true;
	} catch (Exception $e) {
		// Jika ada error, rollback transaction
		mysqli_rollback($conn);
		echo "<script>alert('Gagal melakukan operasi: " . $e->getMessage() . "');</script>";
		return false;
	}
}


function updateberkas($data){
	global $conn;
	
	$id_user = htmlspecialchars($data['id_user']);
    $id_wonder = htmlspecialchars($data['id_wonder']);
	$item = htmlspecialchars($data['item']);
	$remarks_uploader = htmlspecialchars($data['remarks_uploader']);
    
	$rowberkas = query("SELECT id_evidence FROM evidence WHERE id_wonder = '$id_wonder' AND id_item = '$item';");
	if ($rowberkas !== NULL) {
		$id_evidence = $rowberkas[0]['id_evidence'];
	}else {
		echo "
			<script>
			alert('Data Berkas WONDER Tidak Ditemukan!');
			</script>
		";
		return false;
	}
	
	$file = uploadberkas();

    if (!$file) {
        echo "<script>alert('Gagal Memperbarui Data Wonder!');</script>";
        return false;
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Update berkas pada tabel `evidence`
        $updateEvidence = "UPDATE `evidence` SET `remarks_uploader` = '$remarks_uploader', `created_at` = NOW() WHERE id_evidence = '$id_evidence'";
        mysqli_query($conn, $updateEvidence);
        if (mysqli_affected_rows($conn) > 0) {
			$queryHistory = "INSERT INTO `history_evidence` (`id_history`, `id_evidence`, `document`,`uploader`) VALUES (NULL, '$id_evidence', '$file', '$id_user');";
			mysqli_query($conn, $queryHistory);

            // Update tabel `wonder`
            $updateWonder = "UPDATE `wonder` SET `updated_at` = NOW(), `updated_by` = (SELECT `nama` FROM `users` WHERE `id_user` = '$id_user') WHERE `id_upload` = (SELECT `id_wonder` FROM `evidence` WHERE `id_evidence` = '$id_evidence')";
            mysqli_query($conn, $updateWonder);

            // Commit transaction
            mysqli_commit($conn);
            // echo "<script>alert('Data Berkas berhasil diperbarui.');</script>";
            return true;
        } else {
            throw new Exception('Tidak ada perubahan pada data.');
        }
    } catch (Exception $e) {
        // Jika ada error, rollback transaction
        mysqli_rollback($conn);
        // echo "<script>alert('Gagal Memperbarui Data Berkas WONDER: " . $e->getMessage() . "');</script>";
        return false;
    }
	return mysqli_affected_rows($conn);
}

function update_ba_keterangan($data) {
    global $conn;
    $fieldsToUpdate = [];
    foreach ($data as $key => $value) {
        if (!empty($value) && $key != 'id_ba_keterangan' && $key != 'id_wonder') {
            if (is_array($value)) {
                throw new Exception("Unexpected array value for key: $key");
            }
            $fieldsToUpdate[] = "`$key` = '" . htmlspecialchars($value) . "'";
        }
    }
    $fieldsToUpdateString = implode(', ', $fieldsToUpdate);
	// var_dump($fieldsToUpdateString);
	// die;
    $id_ba_keterangan = htmlspecialchars($data['id_ba_keterangan']);
    $id_wonder = htmlspecialchars($data['id_wonder']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Update data pada tabel `ba_keterangan`
        $updateBAKeterangan = "UPDATE `ba_keterangan` SET $fieldsToUpdateString, `created_at` = NOW() WHERE `id_ba` = '$id_ba_keterangan'";
        mysqli_query($conn, $updateBAKeterangan);
        if (mysqli_affected_rows($conn) > 0) {
            // Commit transaction
            mysqli_commit($conn);
            return true;
        } else {
            throw new Exception('Tidak ada perubahan pada data.');
        }
    } catch (Exception $e) {
        // Jika ada error, rollback transaction
        mysqli_rollback($conn);
        die($e->getMessage());
    }
}


function updateberkas2($data){
	global $conn;
	
	$id_user = htmlspecialchars($data['id_user']);
    $id_wonder = htmlspecialchars($data['id_wonder']);
    $validity = htmlspecialchars($data['validity']);
	$item = htmlspecialchars($data['item']);
	$progress = htmlspecialchars($data['progress']);
    
	$rowberkas = query("SELECT id_evidence FROM evidence WHERE id_wonder = '$id_wonder' AND id_item = '$item';");
	if ($rowberkas !== NULL) {
		$id_evidence = $rowberkas[0]['id_evidence'];
	}else {
		echo "
			<script>
			alert('Data Berkas WONDER Tidak Ditemukan!');
			</script>
		";
		return false;
	}
	
	$file = uploadberkas();

    if (!$file) {
        echo "<script>alert('Gagal Memperbarui Data Wonder!');</script>";
        return false;
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Update berkas pada tabel `evidence`
        $updateEvidence = "UPDATE `evidence` SET `validity` = '$validity', `progress` = '$progress', `created_at` = NOW() WHERE id_evidence = '$id_evidence'";
        mysqli_query($conn, $updateEvidence);
        if (mysqli_affected_rows($conn) > 0) {
            // Update berkas pada tabel `history_evidence`
            $updateHistory = "UPDATE `history_evidence` SET `document` = '$file', `reviewer` = '$id_user', `created_at` = NOW() WHERE id_evidence = '$id_evidence'";
            mysqli_query($conn, $updateHistory);

            // Update tabel `wonder`
            $updateWonder = "UPDATE `wonder` SET `updated_at` = NOW(), `updated_by` = (SELECT `nama` FROM `users` WHERE `id_user` = '$id_user') WHERE `id_wonder` = (SELECT `id_wonder` FROM `evidence` WHERE `id_evidence` = '$id_evidence')";
            mysqli_query($conn, $updateWonder);

            // Commit transaction
            mysqli_commit($conn);
            echo "<script>alert('Data Berkas berhasil diperbarui.');</script>";
            return true;
        } else {
            throw new Exception('Tidak ada perubahan pada data.');
        }
    } catch (Exception $e) {
        // Jika ada error, rollback transaction
        mysqli_rollback($conn);
        echo "<script>alert('Gagal Memperbarui Data Berkas WONDER: " . $e->getMessage() . "');</script>";
        return false;
    }
	return mysqli_affected_rows($conn);
}


function addreview($data){
	global $conn;
	
	$id_user = htmlspecialchars($data['id_user']);
    $id_wonder = htmlspecialchars($data['id_wonder']);
	$id_evidence = htmlspecialchars($data['id_evidence']);
	$id_item = htmlspecialchars($data['id_item']);
	$id_history = query("SELECT id_history FROM history_evidence WHERE id_evidence = '$id_evidence' ORDER BY id_history DESC")[0]['id_history'];

	$progress = htmlspecialchars($data['progress']);
	$remarks = htmlspecialchars($data['remarks']);
	$status = htmlspecialchars($data['status']);
	$deadline = htmlspecialchars($data['deadline']);

	$rowberkas = query("SELECT id_evidence FROM evidence WHERE id_evidence = '$id_evidence' AND id_wonder = '$id_wonder' AND id_item = '$id_item';");
	if ($rowberkas !== NULL) {
		$id_evidence = $rowberkas[0]['id_evidence'];
	}else {
		echo "
			<script>
			alert('Data Berkas WONDER Tidak Ditemukan!');
			</script>
		";
		return false;
	}
    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Update berkas pada tabel `evidence`
        $updateEvidence = "UPDATE `evidence` SET `progress` = '$progress',`status` = '$status', `created_at` = NOW() WHERE id_evidence = '$id_evidence'";
        mysqli_query($conn, $updateEvidence);
        if (mysqli_affected_rows($conn) > 0) {
            // Update berkas pada tabel `history_evidence`
            $updateHistory = "UPDATE `history_evidence` SET `remarks` = '$remarks',`created_at` = NOW(),`reviewer` = '$id_user',`deadline` = '$deadline' WHERE id_history = '$id_history'";
            mysqli_query($conn, $updateHistory);

            // Update tabel `wonder`
            $updateWonder = "UPDATE `wonder` SET `updated_at` = NOW(), `updated_by` = (SELECT `nama` FROM `users` WHERE `id_user` = '$id_user') WHERE `id_upload` = (SELECT `id_wonder` FROM `evidence` WHERE `id_evidence` = '$id_evidence')";
            mysqli_query($conn, $updateWonder);

            // Commit transaction
            mysqli_commit($conn);
            // echo "<script>alert('Data Berkas berhasil diperbarui.');</script>";
            return true;
        } else {
            throw new Exception('Tidak ada perubahan pada data.');
        }
    } catch (Exception $e) {
        // Jika ada error, rollback transaction
        mysqli_rollback($conn);
        // echo "<script>alert('Gagal Mereview Data Berkas WONDER: " . $e->getMessage() . "');</script>";
        return false;
    }
	return mysqli_affected_rows($conn);
}


function addbahambatan($data){
	global $conn;
	$id_wonder = htmlspecialchars($data['id_wonder']);
	$keterangan_ba = htmlspecialchars($data["keterangan_ba"]);
	$start = htmlspecialchars($data['start']);
	$end = htmlspecialchars($data['end']);
	// masukkan data Berkas Baru ke database 
	mysqli_query($conn, "INSERT INTO `ba_hambatan` (`id_ba_hambatan`, `id_wonder`,`start`,`end`,`keterangan_ba`,`created_at`) VALUES (NULL, '$id_wonder','$start','$end','$keterangan_ba',NOW());");
	return mysqli_affected_rows($conn);
}

function addberkasopsi($data){
	global $conn;
	$id_wonder = htmlspecialchars($data['id_wonder']);
	$jenis_berkas = htmlspecialchars($data['jenis_berkas']);
    $jenis_berkas_lainnya = htmlspecialchars($data['jenis_berkas_lainnya']);

    // Prioritaskan input text jika opsi "Lainnya" dipilih
    if (!empty($jenis_berkas_lainnya)) {
        $jenis_berkas = $jenis_berkas_lainnya;
    }
	$berkas = $jenis_berkas;
	$file = uploadberkas();
	if (!$file) {
		return false;
	}
	// masukkan data Berkas Baru ke database 
	mysqli_query($conn, "INSERT INTO `data_berkas_pendukung` (`id_data_berkas_pendukung`, `id_wonder`,`jenis_berkas`,`nama_berkas`) VALUES (NULL, '$id_wonder','$berkas','$file');");
	return mysqli_affected_rows($conn);
}

function uploadberkas(){
	$namafile = $_FILES['file']['name'];
	$ukuranFile = $_FILES['file']['size'];
	$error = $_FILES['file']['error'];
	$tmpName = $_FILES['file']['tmp_name'];
	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo "
			<script>
			alert('Pilih File terlebih dahulu!');
			</script>
		";
		return false;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiFileValid = ['jpg','jpeg','png','pdf','doc','docx','xls','xlsx'];
	$ekstensiFile = explode('.', $namafile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan File Dokumen !');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranFile > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;
	move_uploaded_file($tmpName, (dirname(__DIR__, 2) . "/dashboard/assets/wonder/") .$namaFileBaru);
	return $namaFileBaru;
}

function uploadgambar(){
	$namaGambar = $_FILES['gambar']['name'];
	$ukuranGambar = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		$gambar = "logo.jpeg";
		return $gambar;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.', $namaGambar);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan Gambar!');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranGambar > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, (dirname(__DIR__, 2) . "/dashboard/assets/img/avatars/") .$namaFileBaru);
	return $namaFileBaru;
}

function uploadsertif(){
	$namaGambar = $_FILES['sertif']['name'];
	$ukuranGambar = $_FILES['sertif']['size'];
	$error = $_FILES['sertif']['error'];
	$tmpName = $_FILES['sertif']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		echo "<script>
			alert('Upload Sertifikat Terlebih Dahulu !');
			</script>";
		return false;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png','pdf'];
	$ekstensiGambar = explode('.', $namaGambar);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan Gambar!');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranGambar > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/img/prove/' .$namaFileBaru);
	return $namaFileBaru;
}

function uploadgambarinfo(){
	$namaGambar = $_FILES['gambar']['name'];
	$ukuranGambar = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		$gambar = "logo.jpeg";
		return $gambar;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.', $namaGambar);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan Gambar!');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranGambar > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/img/info/' .$namaFileBaru);
	return $namaFileBaru;
}
function uploadgambardonasi(){
	$namaGambar = $_FILES['gambar']['name'];
	$ukuranGambar = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		echo "<script>
			alert('Upload Gambar Terlebih Dahulu !');
			</script>";
		return false;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.', $namaGambar);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan Gambar!');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranGambar > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/img/donasi/' .$namaFileBaru);
	return $namaFileBaru;
}

function tambahkom($data){
	global $conn;
	$nama = htmlspecialchars($data['nama']);
	$jabatan = htmlspecialchars($data['jabatan']);
	$tingkatan = htmlspecialchars($data['tingkat']);
	$idkab = htmlspecialchars($data['idkab']);
	// $foto = uploadfotkom();

	$cekuser = mysqli_query($conn , "SELECT nama FROM komisaris WHERE nama ='$nama' AND tingkat ='$tingkatan'");
	if (mysqli_fetch_assoc($cekuser)) {
		echo "<script>
            alert('Data Komisaris Sudah Ada!');
                </script>";
		return false;
	}
	mysqli_query($conn, "INSERT INTO `komisaris` (`id_komisaris`,`id_kab`,`nama`,`jabatan`,`tingkat`,`created_at`) VALUES (NULL,'$idkab','$nama','$jabatan','$tingkatan',current_timestamp())");
	return mysqli_affected_rows($conn);
}

function inputrekapkec($data){
	global $conn;
	$user = $_POST['iduser'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	switch ($bulan) {
		case 'January':
			$triwulan = 1;
			break;
		case 'February':
			$triwulan = 1;
			break;
		case 'March':
			$triwulan = 1;
			break;
		case 'April':
			$triwulan = 2;
			break;
		case 'May':
			$triwulan = 2;
			break;
		case 'June':
			$triwulan = 2;
			break;
		case 'July':
			$triwulan = 3;
			break;
		case 'August':
			$triwulan = 3;
			break;
		case 'September':
			$triwulan = 3;
			break;
		case 'October':
			$triwulan = 4;
			break;
		case 'November':
			$triwulan = 4;
			break;
		case 'December':
			$triwulan = 4;
			break;
		default:
			$triwulan = NULL;
			break;
	}
	$idkec = intval(htmlspecialchars($_POST['idkec']));
	$jumdpbsl = intval(htmlspecialchars($_POST["jumdpbsl"]));
	$jumdpbsp = intval(htmlspecialchars($_POST["jumdpbsp"]));
	$jumdpbs = $jumdpbsl + $jumdpbsp;
	// akhir jumdpbs
	$jumdes = intval(htmlspecialchars($_POST["jumdes"]));
	$jumtps = intval(htmlspecialchars($_POST["jumtps"]));
	$jumtpsbb = intval(htmlspecialchars($_POST["jumtpsbb"]));
	// Pemilih pemula
	$pempemulal = intval(htmlspecialchars($_POST["pempemulal"]));
	$pempemulap = intval(htmlspecialchars($_POST["pempemulap"]));
	$pphpl = intval(htmlspecialchars($_POST["pphpl"]));
	$pphpp = intval(htmlspecialchars($_POST["pphpp"]));
	$pbstnil = intval(htmlspecialchars($_POST["pbstnil"]));
	$pbstnip = intval(htmlspecialchars($_POST["pbstnip"]));
	$pbspolril = intval(htmlspecialchars($_POST["pbspolril"]));
	$pbspolrip = intval(htmlspecialchars($_POST["pbspolrip"]));
	$ppml = intval(htmlspecialchars($_POST["ppml"]));
	$ppmp = intval(htmlspecialchars($_POST["ppmp"]));
	$jumpempemula = $pempemulal + $pempemulap + $pphpl + $pphpp + $pbstnil + $pbstnip + $pbspolril + $pbspolrip + $ppml + $ppmp;
	//akhir pemilih pemula 
	// TMS
	$pkl = intval(htmlspecialchars($_POST["pkl"]));
	$pkp = intval(htmlspecialchars($_POST["pkp"]));
	$meninggall = intval(htmlspecialchars($_POST["meninggall"]));
	$meninggalp = intval(htmlspecialchars($_POST["meninggalp"]));
	$gandal = intval(htmlspecialchars($_POST["gandal"]));
	$gandap = intval(htmlspecialchars($_POST["gandap"]));
	$dbul = intval(htmlspecialchars($_POST["dbul"]));
	$dbup = intval(htmlspecialchars($_POST["dbup"]));
	$tdkl = intval(htmlspecialchars($_POST["tdkl"]));
	$tdkp = intval(htmlspecialchars($_POST["tdkp"]));
	$tnil = intval(htmlspecialchars($_POST["tnil"]));
	$tnip = intval(htmlspecialchars($_POST["tnip"]));
	$polril = intval(htmlspecialchars($_POST["polril"]));
	$polrip = intval(htmlspecialchars($_POST["polrip"]));
	$hpdl = intval(htmlspecialchars($_POST["hpdl"]));
	$hpdp = intval(htmlspecialchars($_POST["hpdp"]));
	$bpl = intval(htmlspecialchars($_POST["bpl"]));
	$bpp = intval(htmlspecialchars($_POST["bpp"]));
	$bktpl = intval(htmlspecialchars($_POST["bktpl"]));
	$bktpp = intval(htmlspecialchars($_POST["bktpp"]));
	$jumtms = $pkl + $pkp + $meninggall + $meninggalp + $gandal + $gandap + $dbul + $dbup + $tdkl + $tdkp + $tnil + $tnip + $polril + $polrip + $hpdl + $hpdp + $bpl + $bpp + $bktpl + $bktpp;
	// Akhir TMS
	$uedl = intval(htmlspecialchars($_POST["uedl"]));
	$uedp = intval(htmlspecialchars($_POST["uedp"]));
	$uaal = intval(htmlspecialchars($_POST["uaal"]));
	$uaap = intval(htmlspecialchars($_POST["uaap"]));
	$uatl = intval(htmlspecialchars($_POST["uatl"]));
	$uatp = intval(htmlspecialchars($_POST["uatp"]));
	$keterangan = htmlspecialchars($_POST["keterangan"]);
	// $ = intval(htmlspecialchars($_POST["check"]));
	// Jumlah Pemilih Bulan Berjalan
	$jumpbb = ($jumdpbs + $jumpempemula) - $jumtms;

	$cekvalid = mysqli_query($conn , "SELECT * FROM rekapitulasi_kec WHERE id_kec ='$idkec' AND tahun = '$tahun' AND bulan = '$bulan'");
	// var_dump($cekvalid);
	// die;
	if (mysqli_fetch_assoc($cekvalid)) {
		echo "<script>
            alert('Data Rekapitulasi Sudah Ada!');
                </script>";
		return false;
	}

	mysqli_query($conn, "INSERT INTO `rekapitulasi_kec` (
		`id_rekapkec`, 
		`id_kec`, 
		`jumlah_kel`, 
		`jumlah_tps`, 
		`jumlah_dpb_sebelum_L`, 
		`jumlah_dpb_sebelum_p`, 
		`pemilih_pemula_L`, 
		`pemilih_pemula_P`, 
		`pemilih_pencabutan_hak_pilih_L`, 
		`pemilih_pencabutan_hak_pilih_P`, 
		`pemilih_berubah_status_tni_L`, 
		`pemilih_berubah_status_tni_P`, 
		`pemilih_berubah_status_polri_P`, 
		`pemilih_berubah_status_polri_L`, 
		`pemilih_pindah_masuk_L`, 
		`pemilih_pindah_masuk_P`, 
		`pindah_keluar_P`, 
		`pindah_keluar_L`, 
		`meninggal_L`, 
		`meninggal_P`, 
		`ganda_L`, 
		`ganda_P`, 
		`dibawah_umur_ganda_L`, 
		`dibawah_umur_ganda_P`, 
		`tidak_dikenal_L`, 
		`tidak_dikenal_P`, 
		`tni_L`, 
		`tni_P`, 
		`polri_L`, 
		`polri_P`, 
		`hak_pilih_dicabut_L`, 
		`hak_pilih_dicabut_P`, 
		`bukan_penduduk_L`, 
		`bukan_penduduk_P`, 
		`belum_ktp_L`, 
		`belum_ktp_P`, 
		`ubah_elemen_data_L`, 
		`ubah_elemen_data_P`, 
		`ubah_alamat_asal_L`, 
		`ubah_alamat_asal_P`, 
		`ubah_alamat_tujuan_L`, 
		`ubah_alamat_tujuan_P`, 
		`jum_tps_bulan_berjalan`, 
		`jum_pemilih_bulan_berjalan`, 
		`keterangan`, 
		`last_edited`, 
		`tahun`, 
		`bulan`,`triwulan`,
		`created_at`) VALUES (
			NULL, 
			'$idkec', 
			'$jumdes', 
			'$jumtps', 
			'$jumdpbsl', 
			'$jumdpbsp', 
			'$pempemulal', 
			'$pempemulap', 
			'$pphpl', 
			'$pphpp', 
			'$pbstnil', 
			'$pbstnip', 
			'$pbspolrip', 
			'$pbspolril', 
			'$ppml', 
			'$ppmp', 
			'$pkp', 
			'$pkl', 
			'$meninggall', 
			'$meninggalp', 
			'$gandal', 
			'$gandap', 
			'$dbul', 
			'$dbup', 
			'$tdkl', 
			'$tdkp', 
			'$tnil', 
			'$tnip', 
			'$polril', 
			'$polrip', 
			'$hpdl', 
			'$hpdp', 
			'$bpl', 
			'$bpp', 
			'$bktpl', 
			'$bktpp', 
			'$uedl', 
			'$uedp', 
			'$uaal', 
			'$uaap', 
			'$uatl', 
			'$uatp', 
			'$jumtpsbb', 
			'$jumpbb', 
			'$keterangan', 
			'$user', 
			'$tahun', 
			'$bulan','$triwulan',
			current_timestamp());");
	return mysqli_affected_rows($conn);

}




function ubahrekapkec($data){
	global $conn;
	$user = $_POST['iduser'];
	$idrekec = $_POST['idrekec'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	switch ($bulan) {
		case 'January':
			$triwulan = 1;
			break;
		case 'February':
			$triwulan = 1;
			break;
		case 'March':
			$triwulan = 1;
			break;
		case 'April':
			$triwulan = 2;
			break;
		case 'May':
			$triwulan = 2;
			break;
		case 'June':
			$triwulan = 2;
			break;
		case 'July':
			$triwulan = 3;
			break;
		case 'August':
			$triwulan = 3;
			break;
		case 'September':
			$triwulan = 3;
			break;
		case 'October':
			$triwulan = 4;
			break;
		case 'November':
			$triwulan = 4;
			break;
		case 'December':
			$triwulan = 4;
			break;
		default:
			$triwulan = NULL;
			break;
	}
	$idkec = intval(htmlspecialchars($_POST['idkec']));
	$jumdpbsl = intval(htmlspecialchars($_POST["jumdpbsl"]));
	$jumdpbsp = intval(htmlspecialchars($_POST["jumdpbsp"]));
	$jumdpbs = $jumdpbsl + $jumdpbsp;
	// akhir jumdpbs
	$jumdes = intval(htmlspecialchars($_POST["jumdes"]));
	$jumtps = intval(htmlspecialchars($_POST["jumtps"]));
	$jumtpsbb = intval(htmlspecialchars($_POST["jumtpsbb"]));
	// Pemilih pemula
	$pempemulal = intval(htmlspecialchars($_POST["pempemulal"]));
	$pempemulap = intval(htmlspecialchars($_POST["pempemulap"]));
	$pphpl = intval(htmlspecialchars($_POST["pphpl"]));
	$pphpp = intval(htmlspecialchars($_POST["pphpp"]));
	$pbstnil = intval(htmlspecialchars($_POST["pbstnil"]));
	$pbstnip = intval(htmlspecialchars($_POST["pbstnip"]));
	$pbspolril = intval(htmlspecialchars($_POST["pbspolril"]));
	$pbspolrip = intval(htmlspecialchars($_POST["pbspolrip"]));
	$ppml = intval(htmlspecialchars($_POST["ppml"]));
	$ppmp = intval(htmlspecialchars($_POST["ppmp"]));
	$jumpempemula = $pempemulal + $pempemulap + $pphpl + $pphpp + $pbstnil + $pbstnip + $pbspolril + $pbspolrip + $ppml + $ppmp;
	//akhir pemilih pemula 
	// TMS
	$pkl = intval(htmlspecialchars($_POST["pkl"]));
	$pkp = intval(htmlspecialchars($_POST["pkp"]));
	$meninggall = intval(htmlspecialchars($_POST["meninggall"]));
	$meninggalp = intval(htmlspecialchars($_POST["meninggalp"]));
	$gandal = intval(htmlspecialchars($_POST["gandal"]));
	$gandap = intval(htmlspecialchars($_POST["gandap"]));
	$dbul = intval(htmlspecialchars($_POST["dbul"]));
	$dbup = intval(htmlspecialchars($_POST["dbup"]));
	$tdkl = intval(htmlspecialchars($_POST["tdkl"]));
	$tdkp = intval(htmlspecialchars($_POST["tdkp"]));
	$tnil = intval(htmlspecialchars($_POST["tnil"]));
	$tnip = intval(htmlspecialchars($_POST["tnip"]));
	$polril = intval(htmlspecialchars($_POST["polril"]));
	$polrip = intval(htmlspecialchars($_POST["polrip"]));
	$hpdl = intval(htmlspecialchars($_POST["hpdl"]));
	$hpdp = intval(htmlspecialchars($_POST["hpdp"]));
	$bpl = intval(htmlspecialchars($_POST["bpl"]));
	$bpp = intval(htmlspecialchars($_POST["bpp"]));
	$bktpl = intval(htmlspecialchars($_POST["bktpl"]));
	$bktpp = intval(htmlspecialchars($_POST["bktpp"]));
	$jumtms = $pkl + $pkp + $meninggall + $meninggalp + $gandal + $gandap + $dbul + $dbup + $tdkl + $tdkp + $tnil + $tnip + $polril + $polrip + $hpdl + $hpdp + $bpl + $bpp + $bktpl + $bktpp;
	// Akhir TMS
	$uedl = intval(htmlspecialchars($_POST["uedl"]));
	$uedp = intval(htmlspecialchars($_POST["uedp"]));
	$uaal = intval(htmlspecialchars($_POST["uaal"]));
	$uaap = intval(htmlspecialchars($_POST["uaap"]));
	$uatl = intval(htmlspecialchars($_POST["uatl"]));
	$uatp = intval(htmlspecialchars($_POST["uatp"]));
	$keterangan = htmlspecialchars($_POST["keterangan"]);
	// $ = intval(htmlspecialchars($_POST["check"]));
	// Jumlah Pemilih Bulan Berjalan
	$jumpbb = ($jumdpbs + $jumpempemula) - $jumtms;

	// $cekvalid = mysqli_query($conn , "SELECT * FROM rekapitulasi_kec WHERE id_kec ='$idkec' AND tahun = '$tahun' AND bulan = '$bulan'");
	// // var_dump($cekvalid);
	// // die;
	// if (mysqli_fetch_assoc($cekvalid)) {
	// 	echo "<script>
    //         alert('Data Rekapitulasi Sudah Ada!');
    //             </script>";
	// 	return false;
	// }

	mysqli_query($conn, "UPDATE `rekapitulasi_kec` SET
		`id_kec` = '$idkec', 
		`jumlah_kel` = '$jumdes', 
		`jumlah_tps` = '$jumtps', 
		`jumlah_dpb_sebelum_L` = '$jumdpbsl', 
		`jumlah_dpb_sebelum_p` = '$jumdpbsp', 
		`pemilih_pemula_L` = '$pempemulal', 
		`pemilih_pemula_P` = '$pempemulap', 
		`pemilih_pencabutan_hak_pilih_L` = '$pphpl', 
		`pemilih_pencabutan_hak_pilih_P` = '$pphpp', 
		`pemilih_berubah_status_tni_L` = '$pbstnil', 
		`pemilih_berubah_status_tni_P` = '$pbstnip', 
		`pemilih_berubah_status_polri_P` = '$pbspolrip', 
		`pemilih_berubah_status_polri_L` = '$pbspolril', 
		`pemilih_pindah_masuk_L` = '$ppml', 
		`pemilih_pindah_masuk_P` = '$ppmp', 
		`pindah_keluar_P` = '$pkp', 
		`pindah_keluar_L` = '$pkl', 
		`meninggal_L` = '$meninggall', 
		`meninggal_P` = '$meninggalp', 
		`ganda_L` = '$gandal', 
		`ganda_P` = '$gandap', 
		`dibawah_umur_ganda_L` = '$dbul', 
		`dibawah_umur_ganda_P` = '$dbup', 
		`tidak_dikenal_L` = '$tdkl', 
		`tidak_dikenal_P` = '$tdkp', 
		`tni_L` = '$tnil', 
		`tni_P` = '$tnip', 
		`polri_L` = '$polril', 
		`polri_P` = '$polrip', 
		`hak_pilih_dicabut_L` = '$hpdl', 
		`hak_pilih_dicabut_P` = '$hpdp', 
		`bukan_penduduk_L` = '$bpl', 
		`bukan_penduduk_P` = '$bpp', 
		`belum_ktp_L` = '$bktpl', 
		`belum_ktp_P` = '$bktpp', 
		`ubah_elemen_data_L` = '$uedl', 
		`ubah_elemen_data_P` = '$uedp', 
		`ubah_alamat_asal_L` = '$uaal', 
		`ubah_alamat_asal_P` = '$uaap', 
		`ubah_alamat_tujuan_L` = '$uatl', 
		`ubah_alamat_tujuan_P` = '$uatp', 
		`jum_tps_bulan_berjalan` = '$jumtpsbb', 
		`jum_pemilih_bulan_berjalan` = '$jumpbb', 
		`keterangan` = '$keterangan', 
		`last_edited` = '$user' 
		WHERE id_rekapkec = $idrekec;");

	return mysqli_affected_rows($conn);

}


function tambahfile($data){
	global $conn;
	$idkab = htmlspecialchars($data['id_kab']);
	$nama = htmlspecialchars($data['namafile']);
	$jenis = htmlspecialchars($data['jenis']);
	$file = uploadfile();

	mysqli_query($conn, "INSERT INTO `file` (`id_file`,`id_kab`,`file`,`nama_file`,`jenis`,`created_at`) VALUES (NULL,'$idkab','$file','$nama','$jenis',current_timestamp())");
	return mysqli_affected_rows($conn);
}

function uploadfile(){
	$namaFile = $_FILES['file']['name'];
	$ukuranFile = $_FILES['file']['size'];
	$error = $_FILES['file']['error'];
	$tmpName = $_FILES['file']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		echo "
			<script>
			alert('Pilih file terlebih dahulu!');
			</script>
		";
		return false;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['pdf','docx','doc'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if ( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan File!');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranFile > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            window.location = 'upload.php';
                </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, 'file/' .$namaFileBaru);
	return $namaFileBaru;
}

function hapususer($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM users WHERE id_user = $id");
	return mysqli_affected_rows($conn);
}

function hapussantri($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM santri WHERE id_santri = $id");
	return mysqli_affected_rows($conn);
}

function hapuspoint($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM point WHERE id_point = $id");
	return mysqli_affected_rows($conn);
}

function hapusinfo($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM info WHERE id_info = $id");
	return mysqli_affected_rows($conn);
}


function hapuskategori($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kategori WHERE id_kategori = $id");
	return mysqli_affected_rows($conn);
}


function hapuskamar($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kamar WHERE id_kamar = $id");
	return mysqli_affected_rows($conn);
}

function hapustahun($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM thn_ajaran WHERE id_thn = $id");
	return mysqli_affected_rows($conn);
}
function hapusevent($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM calendar WHERE id_calendar = $id");
	return mysqli_affected_rows($conn);
}

function hapusclass($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kelas WHERE id_kelas = $id");
	return mysqli_affected_rows($conn);
}

function hapusmapel($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM mapel WHERE id_mapel = $id");
	return mysqli_affected_rows($conn);
}

function hapuskelompok($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kelompok WHERE id_kelompok = $id");
	return mysqli_affected_rows($conn);
}

function hapuspayment($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM payment WHERE payment_id = $id");
	return mysqli_affected_rows($conn);
}

function hapusconpaymentbebas($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM bebas_payment WHERE id_bebas_payment = $id");
	return mysqli_affected_rows($conn);
}

function hapusconpaymentbul($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM bulan_payment WHERE id_bulan_payment = $id");
	return mysqli_affected_rows($conn);
}

function hapusbebaspay($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM bebas_pay WHERE id_bebas_pay = $id");
	return mysqli_affected_rows($conn);
}

function hapussuluk($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM suluk WHERE id_suluk = $id");
	return mysqli_affected_rows($conn);
}

function hapuskunjungan($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kunjungan WHERE id_kunjungan = $id");
	return mysqli_affected_rows($conn);
}

function hapusizinpulang($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM izin_pulang WHERE id_izin_pulang = $id");
	return mysqli_affected_rows($conn);
}

function hapusizinkeluar($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM izin_keluar WHERE id_izin_keluar = $id");
	return mysqli_affected_rows($conn);
}

function hapuskesehatan($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM penyakit WHERE id_riwayat_penyakit = $id");
	return mysqli_affected_rows($conn);
}

function hapuscatatan($id){
	global $conn;
	$catatan = query("SELECT santri.id_santri,santri.point AS 'sanpnt' ,catatan.*,point.point AS 'pnt' FROM catatan INNER JOIN santri ON catatan.id_santri = santri.id_santri INNER JOIN point ON catatan.id_point = point.id_point WHERE id_catatan = '$id'")[0];
	$point = $catatan['sanpnt'] - ($catatan['pnt']);
	$idsan = $catatan['id_santri'];
	$result = mysqli_query($conn,"UPDATE santri SET point = $point WHERE id_santri = '$idsan'");
	if ($result) {
		mysqli_query($conn,"DELETE FROM catatan WHERE id_catatan = $id");
	}
	return mysqli_affected_rows($conn);
}

function hapuscatatanngaji($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM riwayat_ngaji WHERE id_riwayat_ngaji = $id");
	return mysqli_affected_rows($conn);
}

function hapusjadwal($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM jadwal WHERE id_jadwal = $id");
	return mysqli_affected_rows($conn);
}

function hapusgradesan($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM nilai WHERE id_nilai = $id");
	return mysqli_affected_rows($conn);
}

function hapuscashout($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM pengeluaran WHERE id_pengeluaran = $id");
	return mysqli_affected_rows($conn);
}
function hapusdontil($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM produk WHERE id_produk = $id");
	return mysqli_affected_rows($conn);
}
function hapusdermawan($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM dermawan WHERE id_user = $id");
	return mysqli_affected_rows($conn);
}
function hapusjen($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kategori WHERE id_kategori = $id");
	return mysqli_affected_rows($conn);
}

function hapuscab($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM cabang WHERE id_cabang = $id");
	return mysqli_affected_rows($conn);
}

function hapuskot($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kota WHERE id_kota = $id");
	return mysqli_affected_rows($conn);
}

function hapusrek($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM rekening WHERE id_rekening = $id");
	return mysqli_affected_rows($conn);
}

function hapusfile($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM file WHERE id_file = $id");
	return mysqli_affected_rows($conn);
}

function hapusrekec($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM rekapitulasi_kec WHERE id_rekapkec = $id");
	return mysqli_affected_rows($conn);
}

function hapuskomisaris($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM komisaris WHERE id_komisaris = $id");
	return mysqli_affected_rows($conn);
}

function statsuser($id){
	global $conn;
	$user = mysqli_query($conn, "SELECT status FROM users WHERE id_user = $id");
	$status = mysqli_fetch_assoc($user);
	$stats = $status['status'];
	if ($stats == 'aktif') {
		$stats = 'nonaktif';
			$query = "UPDATE users SET
					status = '$stats'
					WHERE id_user = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}else{
		$stats = 'aktif';
			$query = "UPDATE users SET
					status = '$stats'
					WHERE id_user = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}
}

function naikkelas($data){
	global $conn;
	$id_kelas = htmlspecialchars($data['id_kelas']);
	$kelaspil = htmlspecialchars($data['kelaspil']);
	$semester = htmlspecialchars($data['semester']);
	$queryfix = "";
	for ($i=0; $i < count($data['chkbox']);$i++) { 
    $id_kelas_santri = $data['chkbox'][$i];
	$query = "UPDATE kelas_santri SET
					id_kelas = '$kelaspil',
					semester = '$semester'
	 				WHERE id_kelas_santri = $id_kelas_santri;";
	$queryfix .= $query;
	}
	
		mysqli_multi_query($conn,$queryfix);
		return mysqli_affected_rows($conn);
}

function grouping($data){
	global $conn;
	$id_kelas = htmlspecialchars($data['id_kelas']);
	$grouppil = htmlspecialchars($data['grouppil']);
	$queryfix = "";
	for ($i=0; $i < count($data['chkbox']);$i++) { 
    $id_santri = $data['chkbox'][$i];
	$query = "INSERT INTO `kelompok_santri` (`id_kelompok_santri`,`id_kelompok`,`id_santri`) VALUES (NULL,'$grouppil','$id_santri');";
	$queryfix .= $query;
	}
		mysqli_multi_query($conn,$queryfix);
		return mysqli_affected_rows($conn);
}

function conpayment($data){
	global $conn;
	$id_santri = htmlspecialchars($data['id_santri']);
	$id_bebas_payment = htmlspecialchars($data['id_bebas_payment']);
	$bebaspayment = query("SELECT * FROM bebas_payment WHERE id_bebas_payment = '$id_bebas_payment'")[0];
	$id_bebas_pay = $bebaspayment['id_bebas_pay'];
	$bebaspay = query("SELECT * FROM bebas_pay WHERE id_bebas_pay = '$id_bebas_pay'")[0];
	$notelp = htmlspecialchars($data['notelp']);
	$nominal = htmlspecialchars($data['nominal']);
	$status = htmlspecialchars($data['status']);
	if ($status === 'Lunas') {
		$query1 = "UPDATE bebas_payment SET
		notelp = '$notelp',
		nominal = '$nominal',
		status = '$status'
		WHERE id_bebas_payment = $id_bebas_payment;";
		$terbayar = $nominal + $bebaspay['dana'];
		if ($terbayar >= $bebaspay['bebas_bill']) {
			$dana = $bebaspay['dana'];
			$bayar = $dana + $nominal;
			$query2 = "UPDATE `bebas_pay` SET `status` = 'Lunas', `dana` = '$bayar' WHERE `id_bebas_pay` = $id_bebas_pay;";
		}else{
			$dana = $bebaspay['dana'];
			$bayar = $dana + $nominal;
			$query2 = "UPDATE `bebas_pay` SET `status` = 'proses', `dana` = '$bayar' WHERE `id_bebas_pay` = $id_bebas_pay;";
		}
		$query = $query1.$query2;
		mysqli_multi_query($conn,$query);
		return mysqli_affected_rows($conn);
	}else{
		$query = "UPDATE bebas_payment SET
					notelp = '$notelp',
					nominal = '$nominal',
					status = '$status'
	 				WHERE id_bebas_payment = $id_bebas_payment;";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}
	
}

function conpaymentbul($data){
	global $conn;
	$id_santri = htmlspecialchars($data['id_santri']);
	$id_bulan_payment = htmlspecialchars($data['id_bulan_payment']);
	$id_bulan_pay = query("SELECT id_bulan_pay FROM bulan_payment WHERE id_bulan_payment = '$id_bulan_payment';")[0];
	$id_bulan_pay = $id_bulan_pay['id_bulan_pay'];
	$notelp = htmlspecialchars($data['notelp']);
	$nominal = htmlspecialchars($data['nominal']);
	$status = htmlspecialchars($data['status']);
	$status2 = 1;
	$query = "UPDATE bulan_payment SET
					notelp = '$notelp',
					nominal = '$nominal',
					status = '$status'
	 				WHERE id_bulan_payment = $id_bulan_payment;UPDATE `bulan_pay` SET `status` = '$status2' WHERE id_bulan_pay = '$id_bulan_pay';";
		mysqli_multi_query($conn,$query);
		return mysqli_affected_rows($conn);
}


function graduate($data){
	global $conn;
	$id_kelas = htmlspecialchars($data['id_kelas']);
	// $kelaspil = htmlspecialchars($data['kelaspil']);
	$queryfix = "";
	for ($i=0; $i < count($data['chkbox']);$i++) { 
    $id_kelas_santri = $data['chkbox'][$i];
	$query = "UPDATE kelas_santri SET
					status = 1
	 				WHERE id_kelas_santri = $id_kelas_santri;";
	$queryfix .= $query;
	}
	
		mysqli_multi_query($conn,$queryfix);
		return mysqli_affected_rows($conn);
}

function batallulus($data){
	global $conn;
	$id_kelas = htmlspecialchars($data['id_kelas']);
	// $kelaspil = htmlspecialchars($data['kelaspil']);
	$queryfix = "";
	for ($i=0; $i < count($data['chkbox']);$i++) { 
    $id_kelas_santri = $data['chkbox'][$i];
	$query = "UPDATE kelas_santri SET
					status = 0
	 				WHERE id_kelas_santri = $id_kelas_santri;";
	$queryfix .= $query;
	}
	
		mysqli_multi_query($conn,$queryfix);
		return mysqli_affected_rows($conn);
}

function statsdermawan($id){
	global $conn;
	$dermawan = mysqli_query($conn, "SELECT status FROM dermawan WHERE id_user = $id");
	$status = mysqli_fetch_assoc($dermawan);
	$stats = $status['status'];
	if ($stats == 'aktif') {
		$stats = 'nonaktif';
			$query = "UPDATE dermawan SET
					status = '$stats'
					WHERE id_user = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}else{
		$stats = 'aktif';
			$query = "UPDATE dermawan SET
					status = '$stats'
					WHERE id_user = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}
}

function statsrelawan($id){
	global $conn;
	$relawan = mysqli_query($conn, "SELECT stats FROM relawan WHERE id_relawan = $id");
	$status = mysqli_fetch_assoc($relawan);
	$stats = $status['stats'];
	if ($stats == 'aktif') {
		$stats = 'nonaktif';
			$query = "UPDATE relawan SET
					stats = '$stats'
					WHERE id_relawan = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}else{
		$stats = 'aktif';
			$query = "UPDATE relawan SET
					stats = '$stats'
					WHERE id_relawan = $id";
		mysqli_query($conn,$query);
		return mysqli_affected_rows($conn);
	}
}

function ubahsantri($data){
	global $conn;
	$id = $data["id"];
	$gambarLama = htmlspecialchars($data["gambarLama"]);
	$fullname = htmlspecialchars($data["fullname"]);
	$waortu = htmlspecialchars($data["waortu"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $status = strtolower($data["status"]);
	$hobi = htmlspecialchars($data["hobi"]);
	$skills = htmlspecialchars($data["skills"]);
	$kategori = htmlspecialchars($data["kategori"]);
	$ibu = htmlspecialchars($data["ibu"]);
	$ayah = htmlspecialchars($data["ayah"]);

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgambar();
	}

	// $gambar = htmlspecialchars($data["gambar"]);
	$query = "UPDATE santri SET
				id_kategori = '$kategori',
				fullname = '$fullname',
				alamat = '$alamat',
				keterampilan = '$skills',
				hobi = '$hobi',
				status = '$status',
				gambar = '$gambar',
				ibu = '$ibu',
				ayah = '$ayah',
				waortu = '$waortu'
				WHERE id_santri = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}


function ubahuser($data){
	global $conn;
	$id = $data["id"];
	$nama= htmlspecialchars($data["nama"]);
	$no_hp = htmlspecialchars($data["no_hp"]);
	$no_hp = hportu($no_hp);
	$jabatan = htmlspecialchars($data["jabatan"]);
	$role = strtolower(stripslashes($data["role"]));
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgambar();
	}

	// $gambar = htmlspecialchars($data["gambar"]);
	$query = "UPDATE `users` SET
				`role` = '$role',
				`nama` = '$nama',
				`role` = '$role',
				`jabatan` = '$jabatan',
				`no_hp` = '$no_hp',
				`foto` = '$gambar'
				WHERE id_user = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function conproveder($data){
	global $conn;
	$id = $data["id"];
	$idus = $data["idus"];
	$proveby = mysqli_query($conn,"SELECT relawan_id FROM dermawan WHERE id_user ='$idus'");
	$proveby = mysqli_fetch_assoc($proveby);
	$proveby = $proveby['relawan_id'];
	$sumber = htmlspecialchars($data["sumber"]);
	$rektuj = htmlspecialchars($data["rektuj"]);
	$payment = htmlspecialchars($data["payment"]);
	$totaldonate = htmlspecialchars($data["totaldonate"]);
	// $role = strtolower(stripslashes($data["role"]));
	$status_prove = strtolower(stripslashes($data["status_prove"]));
	// $jk = ucwords((htmlspecialchars($data["jk"])));
	// $timestamp = date('Y-m-d H:i:s');
	// $tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
	
	$query = "UPDATE prove SET
				sumber = '$sumber',
				payment = '$payment',
				tujuan = '$rektuj',
				totaldonate = '$totaldonate',
				status_prove = '$status_prove',
				prove_by = '$proveby',
				date_prove = current_timestamp()
				WHERE id_prove = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahprovetil($data){
	global $conn;
	$id_payment = $data["id_payment"];
	$idcart = $data["id_cart"];
	$idprod = $data["produk"];
	$donprev = $data["donprev"];
	$sumber = htmlspecialchars($data["sumber"]);
	$rektuj = htmlspecialchars($data["rektuj"]);
	$nominal = htmlspecialchars($data["totaldonate"]);
	$pesan = htmlspecialchars($data["deskripsi"]);
	$jumproduk = query("SELECT COUNT(detailorder.detailid) AS 'jum',detailorder.*,produk.*,cart.* FROM detailorder INNER JOIN cart ON detailorder.orderid = cart.orderid INNER JOIN produk ON detailorder.id_produk = produk.id_produk WHERE cart.idcart = '$idcart'");
	$buktiLama = htmlspecialchars($data["buktiLama"]);
	$stats = query("SELECT status FROM cart WHERE idcart = '$idcart'")[0];

	// cek apakah user pilih bukti baru atau tidak
	if ( $_FILES['bukti']['error'] === 4 ) {
		$bukti = $buktiLama;
	}else {
		$bukti = uploadprove();
	}


	// $nom = query("SELECT dana FROM produk WHERE id_produk = '$idprod'")[0];
	// $dana = $nom['dana'];
		if ($nominal < $donprev) {
		$donprevnom = $donprev/$jumproduk[0]['jum'];
		$nominaldonate = $nominal/$jumproduk[0]['jum'];
		$query4 = "";
		$produk = query("SELECT detailorder.*,produk.*,cart.* FROM detailorder INNER JOIN cart ON detailorder.orderid = cart.orderid INNER JOIN produk ON detailorder.id_produk = produk.id_produk WHERE cart.idcart = '$idcart'");
		foreach ($produk as $prod) {
			$idprodcart = $prod['id_produk'];
			$nom = query("SELECT dana FROM produk WHERE id_produk = '$idprodcart'")[0];
			$don = $donprevnom - $nominaldonate;
			$dana = $nom['dana'];
			// $nominal = $nominaldonate + $dana;
			$danareal = $dana - $don;
			$query3 = "UPDATE produk SET dana = '$danareal' WHERE id_produk = '$idprodcart';";
			$query4 .= $query3;
		}
		// $nominal = $nominal + $dana;
		// $query3 = "UPDATE produk SET dana = '$dana' WHERE id_produk = '$idprod'";
		// echo $id_payment;
		// die;
		// $pay = mysqli_multi_query($conn,$query4);
		if (isset($query4)) {
			$querypay1 = "UPDATE payment SET
				tujuan = '$rektuj',
				sumber = '$sumber',
				pesan = '$pesan',
				totalharga = '$nominal',
				bukti_bayar = '$bukti',
				updated_at = current_timestamp()
				WHERE id_payment = '$id_payment'";
			$query4.= $querypay1;
			mysqli_multi_query($conn,$query4);
		}
		}elseif ($nominal > $donprev) {
			$donprevnom = $donprev/$jumproduk[0]['jum'];
			$nominaldonate = $nominal/$jumproduk[0]['jum'];
			$query4 = "";
			$produk = query("SELECT detailorder.*,produk.*,cart.* FROM detailorder INNER JOIN cart ON detailorder.orderid = cart.orderid INNER JOIN produk ON detailorder.id_produk = produk.id_produk WHERE cart.idcart = '$idcart'");
			foreach ($produk as $prod) {
				$idprodcart = $prod['id_produk'];
				$nom = query("SELECT dana FROM produk WHERE id_produk = '$idprodcart'")[0];
				$don = $nominaldonate - $donprevnom;
				$dana = $nom['dana'];
				// $nominal = $nominaldonate + $dana;
				$danareal = $dana + $don;
				$query3 = "UPDATE produk SET dana = '$danareal' WHERE id_produk = '$idprodcart';";
				$query4 .= $query3;
			}
			// $don = $nominal - $donprev;
			// $dana = $dana + $don;
			// echo $nominal,$id_payment;
			// die;
			// $pay = mysqli_multi_query($conn,$query4);
		if (isset($query4)) {
			$querypay = "UPDATE payment SET
				tujuan = '$rektuj',
				sumber = '$sumber',
				pesan = '$pesan',
				totalharga = '$nominal',
				bukti_bayar = '$bukti',
				updated_at = current_timestamp()
				WHERE id_payment = '$id_payment';";
				$query4.= $querypay;
				mysqli_multi_query($conn,$query4);
		}
		}elseif($nominal = $donprev){
		// $query3 = "UPDATE produk SET dana = '$dana' WHERE id_produk = '$idprod'";
		// $pay = mysqli_query($conn,$query3);
			$query = "UPDATE payment SET
				tujuan = '$rektuj',
				sumber = '$sumber',
				pesan = '$pesan',
				totalharga = '$nominal',
				bukti_bayar = '$bukti',
				updated_at = current_timestamp()
				WHERE id_payment = '$id_payment'";
				mysqli_query($conn,$query);
		}
		return mysqli_affected_rows($conn);
}

function conprovetil($data){
	global $conn;
	$id = $data["id"];
	$idus = $data["idus"];
	$idcart = $data["idcart"];
	$idprod = $data["idprod"];
	$sumber = htmlspecialchars($data["sumber"]);
	$rektuj = htmlspecialchars($data["rektuj"]);
	$payment = htmlspecialchars($data["payment"]);
	$nominal = htmlspecialchars($data["totaldonate"]);
	$status = strtolower(stripslashes($data["status_prove"]));
	$jumproduk = query("SELECT COUNT(detailorder.detailid) AS 'jum',detailorder.*,produk.*,cart.* FROM detailorder INNER JOIN cart ON detailorder.orderid = cart.orderid INNER JOIN produk ON detailorder.id_produk = produk.id_produk WHERE cart.idcart = '$idcart'");
	$query = "UPDATE payment SET
				tujuan = '$rektuj',
				sumber = '$sumber',
				payment = '$payment',
				totalharga = '$nominal',
				updated_at = current_timestamp()
				WHERE id_payment = '$id'";
	$pay = mysqli_query($conn,$query);

	if ($pay) {
		$query2 = "UPDATE cart SET
		status = '$status'
		WHERE idcart = '$idcart'";
		$pay2 = mysqli_query($conn,$query2);
		if ($pay2 && $status == 'confirm') {
		$nominaldonate = $nominal/$jumproduk[0]['jum'];
		$query4 = "";
		$produk = query("SELECT detailorder.*,produk.*,cart.* FROM detailorder INNER JOIN cart ON detailorder.orderid = cart.orderid INNER JOIN produk ON detailorder.id_produk = produk.id_produk WHERE cart.idcart = '$idcart'");
		foreach ($produk as $prod) {
			$idprodcart = $prod['id_produk'];
			$nom = query("SELECT dana FROM produk WHERE id_produk = '$idprodcart'")[0];
			$dana = $nom['dana'];
			$nominal = $nominaldonate + $dana;
			$query3 = "UPDATE produk SET dana = '$nominal' WHERE id_produk = '$idprodcart';";
			$query4 .= $query3;
		}
		// echo $query4;
		// die;
		mysqli_multi_query($conn,$query4);
		}
	}
	return mysqli_affected_rows($conn);
}

function conprovetilman($data){
	global $conn;
	//Deklarasi  variabel
	// $id = $data["id"];
	$idus = $data["dermawan"];
	$idprod = $data["id_prod"];
	$sumber = htmlspecialchars($data["sumber"]);
	$rektuj = htmlspecialchars($data["rektuj"]);
	$payment = htmlspecialchars($data["payment"]);
	$nominal = htmlspecialchars($data["totaldonate"]);
	$status = strtolower(stripslashes($data["status_prove"]));
	$pesan = htmlspecialchars($data["deskripsi"]);
	$gambar = uploadprove();
	if (!$gambar) {
		return false;
		}
	// $jumproduk = query("SELECT COUNT(detailorder.detailid) AS 'jum',detailorder.*,produk.*,cart.* FROM detailorder INNER JOIN cart ON detailorder.orderid = cart.orderid INNER JOIN produk ON detailorder.id_produk = produk.id_produk WHERE cart.idcart = '$idcart'");

			//Buat ulang order id nya
				$oi = crypt(rand(22,999),time());
				
				$bikincart = mysqli_query($conn,"insert into cart (orderid, id_user) values('$oi','$idus')");
				
				if($bikincart){
					$tambahuser = mysqli_query($conn,"insert into detailorder (orderid,id_produk) values('$oi','$idprod')");
					if ($tambahuser){
						$veriforderid = mysqli_query($conn,"SELECT * FROM cart WHERE orderid='$oi'");
                		$fetch = mysqli_fetch_array($veriforderid);
						if ($fetch > 0) {
							$idcart = $fetch['idcart'];
							$iduser = $fetch['id_user'];
							$kon = mysqli_query($conn,"INSERT INTO payment (idcart, id_user,tujuan,sumber,payment,totalharga,pesan, bukti_bayar, created_at, updated_at) 
							VALUES('$idcart','$iduser','$rektuj','$sumber','$payment','$nominal','$pesan','$gambar',NOW(),NOW())");
							if ($kon){
							$up = mysqli_query($conn,"UPDATE cart SET `status` = '$status' WHERE orderid='$oi'");
								if ($up) {
									$produk = query("SELECT detailorder.*,produk.*,cart.* FROM detailorder INNER JOIN cart ON detailorder.orderid = cart.orderid INNER JOIN produk ON detailorder.id_produk = produk.id_produk WHERE cart.idcart = '$idcart'");
									$idprodcart = $produk[0]['id_produk'];
									$nom = query("SELECT dana FROM produk WHERE id_produk = '$idprodcart'")[0];
									$dana = $nom['dana'];
									$nominall = $nominal + $dana;
									$queryfix = mysqli_query($conn,"UPDATE produk SET dana = '$nominall' WHERE id_produk = '$idprodcart';");
									if ($queryfix) {
									echo "<script>swal('Berhasil Berdonasi!', 'Silakan Cek Donasi Dermawan Anda!', 'success').then(function(){
										setTimeout(document.location.href = '../dontil.php', 100);
										});</script>";
									}
								}
							} else { 
								echo "<script>swal('Gagal!', 'Silakan Cek Kembali Konfirmasi Pembayaran Donasi Anda!', 'error').then(function(){
									setTimeout(document.location.href= 'dontil.php',100);
								});</script>";
							}
						}
						
					} else { 
						echo "<script>swal('Gagal!', 'Gagal Menambahkan Donasi!', 'error').then(function(){
							setTimeout(document.location.href= '../dontil.php',100);
						});</script>";
					}
				} else {
					echo "<script>swal('Gagal!', 'Gagal Menambahkan Donasi!', 'error').then(function(){
						setTimeout(document.location.href= '../dontil.php',100);
					});</script>";
				}
	return mysqli_affected_rows($conn);
}

function ubahdonder($data){
	global $conn;
	$id = $data["id_prove"];
	$id_user = htmlspecialchars($data["dermawan"]);
	$sumber = htmlspecialchars($data["sumber"]);
	$rektuj = htmlspecialchars($data["rektuj"]);
	$payment = htmlspecialchars($data["payment"]);
	$totaldonate = htmlspecialchars($data["totaldonate"]);
	// $proveby = mysqli_query($conn,"SELECT relawan_id FROM dermawan WHERE id_user ='$id_user'");
	// $proveby = mysqli_fetch_assoc($proveby);
	// $proveby = $proveby['relawan_id'];
	$status_prove = strtolower(stripslashes($data["status_prove"]));
    $deskripsi = htmlspecialchars($data["deskripsi"]);
	$buktiLama = htmlspecialchars($data["buktiLama"]);

	// cek apakah user pilih bukti baru atau tidak
	if ( $_FILES['bukti']['error'] === 4 ) {
		$bukti = $buktiLama;
	}else {
		$bukti = uploadprove();
	}

	$query = "UPDATE prove SET
				id_user = '$id_user',
				sumber = '$sumber',
				payment = '$payment',
				tujuan = '$rektuj',
				keterangan = '$deskripsi',
				totaldonate = '$totaldonate',
				prove = '$bukti',
				status_prove = '$status_prove',
				date_prove = current_timestamp()
				WHERE id_prove = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahdontil($data){
	global $conn;
	$id = $data["id_dontil"];
	$produk = htmlspecialchars($data["produk"]);
	$kategori = htmlspecialchars($data["kategori"]);
	$deskripsi = htmlspecialchars($data["deskripsi"]);

    $target = htmlspecialchars($data["target"]);
	$deadline = htmlspecialchars($data["deadline"]);
	$deadline = date('Y-m-d',strtotime($deadline));
	$admin = htmlspecialchars($data["admin"]);
    $status = strtolower($data["status"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih bukti baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgambardonasi();
	}

	$query = "UPDATE produk SET
				id_kategori = '$kategori',
				manager = '$admin',
				nama_produk = '$produk',
				deskripsi = '$deskripsi',
				target = '$target',
				deadline = '$deadline',
				gambar = '$gambar',
				status = '$status'
				WHERE id_produk = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahdermawan($data){
	global $conn;
	$id = $data["id"];
	$nama= htmlspecialchars($data["namalengkap"]);
	$no_hp = htmlspecialchars($data["notelp"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$relawan_id = htmlspecialchars($data["relawan_id"]);
	$status = strtolower(stripslashes($data["status"]));
	$gambarLama = htmlspecialchars($data["gambarLama"]);
	$cekuser = mysqli_query($conn , "SELECT notelp FROM dermawan WHERE notelp ='$no_hp' AND id_user != $id");
	if (mysqli_fetch_assoc($cekuser)) {
		echo "
		<script>
		alert('Nomor Telepon Sudah Terdaftar!');
		</script>
		";
		return false;
	}
	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgambar();
	}

	// $gambar = htmlspecialchars($data["gambar"]);
	$query = "UPDATE dermawan SET
				namalengkap = '$nama',
				notelp = '$no_hp',
				alamat = '$alamat',
				status = '$status',
				relawan_id = '$relawan_id',
				gambar = '$gambar'
				WHERE id_user = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}


function ubahrelawan($data){
	global $conn;
	$id = $data["id_relawan"];
	$nama= htmlspecialchars($data["namalengkap"]);
	$no_hp = htmlspecialchars($data["nohp"]);
	$id_cabang =$data["id_cabang"]; 
	$id_kota = $data["id_kota"];
	$status = strtolower(stripslashes($data["status"]));
	$stats = strtolower(stripslashes($data["stats"]));
	
	// $jk = ucwords((htmlspecialchars($data["jk"])));
	// $timestamp = date('Y-m-d H:i:s');
	// $tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgambar();
	}

	// $gambar = htmlspecialchars($data["gambar"]);
	$query = "UPDATE relawan SET
				namalengkap = '$nama',
				nohp = '$no_hp',
				id_cabang = '$id_cabang',
				id_kota = '$id_kota',
				status_relawan = '$status',
				stats = '$stats',
				gambar = '$gambar'
				WHERE id_relawan = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahuserprof($data){
	global $conn;
	$id = $data["id"];
	$no_hp = hportu(htmlspecialchars($data["no_hp"]));
	$jabatan = htmlspecialchars($data["jabatan"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgambar();
	}

	// $gambar = htmlspecialchars($data["gambar"]);
	$query = "UPDATE users SET
				no_hp = '$no_hp',
				jabatan = '$jabatan',
				foto = '$gambar'
				WHERE id_user = '$id'";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahakun($data){
	global $conn;
	$id = $data["id"];
	$nama= htmlspecialchars($data["nama"]);
	$no_hp = htmlentities($data["no_hp"]);
	$gambarLama = htmlspecialchars($data["fotoLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['foto']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgam();
	}

	// $gambar = htmlspecialchars($data["gambar"]);

	$query = "UPDATE user SET
				nama = '$nama',
				no_hp = '$no_hp',
				foto = '$gambar'
				WHERE id_user = $id
	";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahpassadmin($data){
	global $conn;
	$id = $data["id"];
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	$query = "UPDATE users SET
				password = '$password'
				WHERE id_user = $id";
				mysqli_query($conn,$query);
				$hasil = mysqli_affected_rows($conn);
				if (!$hasil) {
					die('Query Error: '.mysqli_errno($conn).'-'.mysqli_error($conn));
				}
				return mysqli_affected_rows($conn);
}

function ubahpasssantri($data){
	global $conn;
	$id = $data["id"];
	$row = query("SELECT * FROM santri WHERE id_santri = '$id'")[0];
	$idakun = $row['id_akun'];
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	$query = "UPDATE akun SET
				password = '$password'
				WHERE Id = $idakun";
				mysqli_query($conn,$query);
				$hasil = mysqli_affected_rows($conn);
				if (!$hasil) {
					die('Query Error: '.mysqli_errno($conn).'-'.mysqli_error($conn));
				}
				return mysqli_affected_rows($conn);
}

function ubahpassderadmin($data){
	global $conn;
	$id = $data["id"];
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	$query = "UPDATE dermawan SET
				password = '$password'
				WHERE id_user = $id";
				mysqli_query($conn,$query);
				$hasil = mysqli_affected_rows($conn);
				if (!$hasil) {
					die('Query Error: '.mysqli_errno($conn).'-'.mysqli_error($conn));
				}
				return mysqli_affected_rows($conn);
}

function ubahpassreladmin($data){
	global $conn;
	$id = $data["id_relawan"];
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);
	$query = "UPDATE relawan SET
				password = '$password'
				WHERE id_relawan = $id";
				mysqli_query($conn,$query);
				$hasil = mysqli_affected_rows($conn);
				if (!$hasil) {
					die('Query Error: '.mysqli_errno($conn).'-'.mysqli_error($conn));
				}
				return mysqli_affected_rows($conn);
}

function ubahpassprof($data){
	global $conn;
	$id = $data["id"];
	$oldpass = mysqli_real_escape_string($conn, $data["oldpassword"]);
	$password = mysqli_real_escape_string($conn, $data["newpassword"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "<script>
            alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
		return false;
	}


	$result = mysqli_query($conn,"SELECT * FROM users WHERE
							id_user = '$id'");
	// cek email 
	if (mysqli_num_rows($result) == 1) {
		// cek password
		$row = mysqli_fetch_assoc($result);
		 if (password_verify($oldpass, $row["password"])) {
		 	if ($row) {
                // enkripsi password 
				$password = password_hash($password, PASSWORD_DEFAULT);
				$query = "UPDATE users SET
							password = '$password'
							WHERE id_user = $id";
							mysqli_query($conn,$query);
							$hasil = mysqli_affected_rows($conn);
							if (!$hasil) {
								die('Query Error: '.mysqli_errno($conn).'-'.mysqli_error($conn));
							}
							return mysqli_affected_rows($conn);
            }
            else {
				echo "<script>
					alert('Password Lama Anda Tidak Sesuai!');
						</script>";
				return false;
            }
		 }
	}

	
}

function ubahpas($data){
	global $conn;
	$id = $data["id"];
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["password2"]);
	$password3 = mysqli_real_escape_string($conn,$data["password3"]);
	$password = md5($password);

	// cek username sudah ada atau belum

	$data = mysqli_query($conn, "SELECT * from user where password='$password'");
	$cek = mysqli_num_rows($data);
	if ($cek > 0){
        $row = mysqli_fetch_assoc($data);
        // cek konfirmasi password 
		if ($password2 !== $password3) {
			echo "<script>
	            alert('Konfirmasi Password Tidak Sesuai!');
	                </script>";
			return false;
		}else{
			// enkripsi password 
			$password2 = md5($password2);
				$query = "UPDATE user SET
				password = '$password2'
				WHERE id_user = $id";
				mysqli_query($conn,$query);
				$hasil = mysqli_affected_rows($conn);
				if (!$hasil) {
					die('Query Error: '.mysqli_errno($conn).'-'.mysqli_error($conn));
				}
				return mysqli_affected_rows($conn);
		}
    }

}

function ubahup($data){
  global $conn;
  $idus = htmlspecialchars($data["idus"]);
  $id_upload = htmlspecialchars($data["id"]);
  $waktu = $data['tanggal']." ".$data['waktu'];
  $sumur = htmlspecialchars($data["sumur"]);
  $no_sumur = htmlspecialchars($data["no_sumur"]);
  $kategori = htmlspecialchars($data["kategori"]);
  $keterangan = htmlspecialchars($data["keterangan"]);
  $tools = htmlspecialchars($data["tools"]);
  $timestamp = date('Y-m-d H:i:s',strtotime($waktu));
  $now = date('Y-m-d H:i:s');
  // $tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
	$gambarLama = htmlspecialchars($data["fotoLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgam();
	}
	$user = query("SELECT username FROM user WHERE id_user = '$idus'")[0];
	$username = $user['username'];
	$query = "UPDATE uploadan SET
				id_sumur = '$sumur',
				no_sumur = '$no_sumur',
				id_tools = '$tools',
				id_kategori = '$kategori',
				foto = '$gambar',
				waktu = '$timestamp',
				updated_at = '$now',
				updated_by = '$username',
				keterangan = '$keterangan'
				WHERE id_upload = $id_upload
	";
	$result = mysqli_query($conn,$query);
	$hasil = mysqli_affected_rows($conn);
	if (!$result) {
		die('Query Error: '.mysqli_errno($conn).'-'.mysqli_error($conn));
	}
	return mysqli_affected_rows($conn);
}

function uploadgam(){
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload

	if ($error === 4) {

		// echo "
		// 	<script>
		// 	alert('pilih gambar terlebih dahulu!');
		// 	</script>
		// ";
		$fotodef = "logo.png";
		return $fotodef;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if ( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan Gambar!');
			</script>";
			return false;

	}
	// Cek jika ukurannya terlalu besar
	if ($ukuranFile > (1024 * 10000)) {
		echo "<script>
            alert('Ukuran File Terlalu Besar (Maks 10MB)!');
            window.location = 'mansumur.php';
                </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, 'assets/images/uploadan/'. $namaFileBaru);
	return $namaFileBaru;
}



function ubahjenis($data){
	global $conn;
	$id = $data["id"];
	$kategori= htmlspecialchars($data["jenis"]);

	$query = "UPDATE kategori SET
				kategori = '$kategori'
				WHERE id_kategori = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahcab($data){
	global $conn;
	$id = $data["id"];
	$cabang= htmlspecialchars($data["cabang"]);

	$query = "UPDATE cabang SET
				cabang = '$cabang'
				WHERE id_cabang = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahpoint($data){
	global $conn;
	$id = $data["id"];
	$point = $data["point"];
	$keterangan = htmlspecialchars(mysqli_real_escape_string($conn,$data["keterangan"]));

	$query = "UPDATE point SET
				point = '$point',
				keterangan = '$keterangan'
				WHERE id_point = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahkategori($data){
	global $conn;
	$id = $data["id"];
	$kategori = htmlspecialchars(mysqli_real_escape_string($conn,$data["kategori"]));

	$query = "UPDATE kategori SET
				kategori = '$kategori'
				WHERE id_kategori = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahclass($data){
	global $conn;
	$id = $data["id"];
	$kelas = htmlspecialchars(mysqli_real_escape_string($conn,$data["kelas"]));
	$tingkat = htmlspecialchars($data['tingkat']);
	$id_wali = $data["wali"];
	$cekkelas = mysqli_query($conn , "SELECT * FROM kelas WHERE kelas ='$kelas' AND tingkat = '$tingkat' AND id_wali = '$id_wali'");
	if (mysqli_fetch_assoc($cekkelas)) {
		echo "
		<script>
		alert('kelas sudah ada!');
		</script>
		";
		return false;
	}
	$query = "UPDATE kelas SET
				id_wali = '$id_wali',
				kelas = '$kelas',
				tingkat = '$tingkat'
				WHERE id_kelas = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahmapel($data){
	global $conn;
	$id = $data["idmapel"];
	$mapel = htmlspecialchars(mysqli_real_escape_string($conn,$data["mapel"]));
	$kode_mapel = htmlspecialchars(mysqli_real_escape_string($conn,$data['kode_mapel']));
	$id_pengajar = $data["pengajar"];
	$cekmapel = mysqli_query($conn , "SELECT * FROM mapel WHERE mapel ='$mapel' AND kode_mapel = '$kode_mapel'");
	if (mysqli_fetch_assoc($cekmapel)) {
		echo "
		<script>
		alert('Mapel sudah ada!');
		</script>
		";
		return false;
	}
	$query = "UPDATE mapel SET
				id_pengajar = '$id_pengajar',
				kode_mapel = '$kode_mapel',
				mapel = '$mapel'
				WHERE id_mapel = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahkelompok($data){
	global $conn;
	$id = $data["id"];
	$kelompok = htmlspecialchars(mysqli_real_escape_string($conn,$data["kelompok"]));
	$pj = $data["pj"];
	$cekkelompok = mysqli_query($conn , "SELECT * FROM kelompok WHERE kelompok ='$kelompok' AND pj = '$pj'");
	if (mysqli_fetch_assoc($cekkelompok)) {
		echo "
		<script>
		alert('Kelompok sudah ada!');
		</script>
		";
		return false;
	}
	$query = "UPDATE kelompok SET
				kelompok = '$kelompok',
				pj = '$pj'
				WHERE id_kelompok = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}


function ubahkamar($data){
	global $conn;
	$id = $data["id"];
	$kamar = htmlspecialchars(mysqli_real_escape_string($conn,$data["kamar"]));
	$cekkamar = mysqli_query($conn , "SELECT * FROM kamar WHERE kamar ='$kamar'");
	if (mysqli_fetch_assoc($cekkamar)) {
		echo "
		<script>
		alert('kamar sudah ada!');
		</script>
		";
		return false;
	}
	$query = "UPDATE `kamar` SET `kamar` = '$kamar' WHERE `kamar`.`id_kamar` = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahrek($data){
	global $conn;
	$id = $data["id"];
	$rekening= htmlspecialchars($data["rekening"]);
	$bank = htmlspecialchars($data["bank"]);

	$query = "UPDATE rekening SET
				atasnama = '$rekening',
				bank = '$bank'
				WHERE id_rekening = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function ubahtools($data){
	global $conn;
	$id = $data["id_tools"];
	$tools= htmlspecialchars($data["tools"]);

	$query = "UPDATE tools SET
				tools = '$tools'
				WHERE id_tools = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}
function ubahwell($data){
	global $conn;
	$id = $data["id_sumur"];
	$sumur= htmlspecialchars($data["nama_sumur"]);

	$query = "UPDATE sumur SET
				nama_sumur = '$sumur'
				WHERE id_sumur = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}




function registrasi($data){
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$nama = strtolower(stripslashes($data["nama"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["password2"]);
	$level = strtolower(stripslashes($data["level"]));
	// cek username sudah ada atau belum
	$cekuser = mysqli_query($conn , "SELECT username FROM user WHERE username ='$username'");
	if (mysqli_fetch_assoc($cekuser)) {
		echo "
		<script>
		alert('username sudah ada!');
		</script>
		";
		return false;
	}

	// cek konfirmasi password 
	if ($password !== $password2) {
		echo "
		<script>
			alert('konfirmasi password tidak sesuai !');
		</script>
		";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);

	// masukkan data userbaru ke database 

	mysqli_query($conn, "
					INSERT INTO user VALUES('','$username','$password','$nama','$level')
		");
	return mysqli_affected_rows($conn);
}

function tanggal_indonesia($tanggal){
	$bulan = array (
	1 =>   'Januari',
	'Februari',
	'Maret',
	'April',
	'Mei',
	'Juni',
	'Juli',
	'Agustus',
	'September',
	'Oktober',
	'November',
	'Desember'
	);
	
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
	 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " triliun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}
 
function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     
    return $hasil;
}

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}

function validasi_admin(){
	
}

function kirimwa($data){
	global $conn;
	$id = $data["id_santri"];
	$nomor = htmlspecialchars($data['nomor']);
	$nowa = hportu($nomor);
	$isipesan = htmlspecialchars($data["pesan"]);
	
	return mysqli_affected_rows($conn);
}


function findage($dob)
{
    
   	$dob = strtotime($dob);
	$current_time = time();

	$age_years = date('Y',$current_time) - date('Y',$dob);
	$age_months = date('m',$current_time) - date('m',$dob);
	$age_days = date('d',$current_time) - date('d',$dob);

	if ($age_days<0) {
	    $days_in_month = date('t',$current_time);
	    $age_months--;
	    $age_days= $days_in_month+$age_days;
	}

	if ($age_months<0) {
	    $age_years--;
	    $age_months = 12+$age_months;
	}

	$age = $age_years."-".$age_months;

	if ($age_years > 6 && $age_months > 6) {
		$kelas = "B";
	}else{
		$kelas = "A";
	}

	return $kelas;
}

function getAge($dob){
	$dob = strtotime($dob);
	$current_time = time();

	$age_years = date('Y',$current_time) - date('Y',$dob);
	$age_months = date('m',$current_time) - date('m',$dob);
	$age_days = date('d',$current_time) - date('d',$dob);

	if ($age_days<0) {
	    $days_in_month = date('t',$current_time);
	    $age_months--;
	    $age_days= $days_in_month+$age_days;
	}

	if ($age_months<0) {
	    $age_years--;
	    $age_months = 12+$age_months;
	}

	$age = $age_years." tahun ".$age_months." bulan";

	return $age;
}


?>

