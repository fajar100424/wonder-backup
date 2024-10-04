<?php
//koneksi ke database
$conn = mysqli_connect("localhost","root","","simak");

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


function tambahuser($data){
	global $conn;
	$email = htmlspecialchars($data["email"]);
	$fullname = htmlspecialchars($data["fullname"]);
	$notelp = htmlspecialchars($data["notelp"]);
    $alamat = htmlspecialchars($data["alamat"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["confirmPassword"]);
	$role = strtolower($data["role"]);
    $status = strtolower($data["status"]);
    $gambar = uploadgambar();
	$timestamp = date('Y-m-d H:i:s');
	// cek email sudah ada atau belum
	$cekuser = mysqli_query($conn , "SELECT email FROM users WHERE email ='$email'");
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
	mysqli_query($conn, "INSERT INTO `users` (`id_user`, `email`, `password`, `fullname`, `notelp`, `alamat`,`status`,`gambar`,`role`,`created_at`,`last_login`) VALUES (NULL, '$email', '$password', '$fullname', '$notelp', '$alamat','$status','$gambar','$role', current_timestamp(), current_timestamp());");
	return mysqli_affected_rows($conn);
}


function uploadgambar(){
	$namaGambar = $_FILES['gambar']['name'];
	$ukuranGambar = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		echo "
			<script>
			alert('Pilih Gambar terlebih dahulu!');
			</script>
		";
		return false;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.', $namaGambar);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
			alert('Yang anda Upload Bukan File!');
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
	move_uploaded_file($tmpName, 'assets/' .$namaFileBaru);
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


function ubah($data){
	global $conn;
	$id = $data["id"];
	$nama= htmlspecialchars($data["nama"]);
	$no_hp = htmlentities($data["no_hp"]);
	$role = strtolower(stripslashes($data["role"]));
	$jabatan = ucwords((htmlspecialchars($data["jabatan"])));
	$jk = ucwords((htmlspecialchars($data["jk"])));
	$timestamp = date('Y-m-d H:i:s');
	$tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
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
				role = '$role',
				jabatan = '$jabatan',
				jk = '$jk',
				foto = '$gambar',
				tanggal_lahir = '$tanggal_lahir'
				WHERE id_user = $id
	";
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



function ubahkat($data){
	global $conn;
	$id = $data["id_kategori"];
	$kategori= htmlspecialchars($data["kategori"]);

	$query = "UPDATE kategori SET
				kategori = '$kategori'
				WHERE id_kategori = $id";
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





?>

