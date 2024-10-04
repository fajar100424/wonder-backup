<?php
//koneksi ke database
$conn = mysqli_connect("localhost","wond3714_wonder","w0nd3r112401","wond3714_wonder");

function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

function tambahkat($data){
	global $conn;

	$kategori = htmlspecialchars($data["kategori"]);
	$cekkat = mysqli_query($conn , "SELECT kategori FROM kategori WHERE kategori ='$kategori'");
	if (mysqli_fetch_assoc($cekkat)) {
		echo "<script>
            alert('kategori Sudah Ada!');
                </script>";
		return false;
	}

	mysqli_query($conn, "INSERT INTO kategori (`kategori`,`created_at`) VALUES ('$kategori',NOW())");
	return mysqli_affected_rows($conn);
}


function hapususer($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM users WHERE id_user = $id");
	return mysqli_affected_rows($conn);
}
function hapuspro($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM produk WHERE id_produk = $id");
	return mysqli_affected_rows($conn);
}

function hapuskat($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM kategori WHERE id_kategori = $id");
	return mysqli_affected_rows($conn);
}



function ubah($data){
	global $conn;
	$id = $data["id_user"];
	$nama= htmlspecialchars($data["namalengkap"]);
	$no_hp = htmlentities($data["notelp"]);
	$alamat = htmlentities($data["alamat"]);
	// $role = strtolower(stripslashes($data["role"]));
	// $timestamp = date('Y-m-d H:i:s');
	// $tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ($_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = upload();
	}
	
	// $gambar = htmlspecialchars($data["gambar"]);

	$query = "UPDATE users SET
				namalengkap = '$nama',
				notelp = '$no_hp',
				alamat = '$alamat',
				gambar = '$gambar'
				WHERE id_user = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}
function ubahuser($data){
	global $conn;
	$id = $data["id"];
	$nama= htmlspecialchars($data["namalengkap"]);
	$no_hp = htmlspecialchars($data["notelp"]);
	$email = htmlspecialchars($data["email"]);
	$role = htmlspecialchars($data["role"]);
	// $timestamp = date('Y-m-d H:i:s');
	// $tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ($_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = upload();
	}
	
	// $gambar = htmlspecialchars($data["gambar"]);

	$query = "UPDATE users SET
				namalengkap = '$nama',
				email = '$email',
				notelp = '$no_hp',
				role = '$role',
				gambar = '$gambar'
				WHERE id_user = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function upload(){
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
		$fotodef = "kodingkito.png";
		return $fotodef;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png','svg'];
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
            window.location = 'user/settings.php';
                </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	$result = move_uploaded_file($tmpName, '../images/users/'. $namaFileBaru);
	if ($result) {
		return $namaFileBaru;
	}else{
		var_dump($_FILES);
		var_dump($result);
		die;
		return false;
	}
}



function ubahpas($data){
	global $conn;
	$id = $data["id_user"];
	$password = mysqli_real_escape_string($conn, $data["passwordLama"]);
	$password2 = mysqli_real_escape_string($conn,$data["password"]);
	$password3 = mysqli_real_escape_string($conn,$data["password2"]);
	// $password = md5($password);
	$result = mysqli_query($conn,"SELECT * FROM users WHERE id_user = '$id'");
	// cek email
	if (mysqli_num_rows($result) == 1) {
		// cek password
		$row = mysqli_fetch_assoc($result);
		
		if (password_verify($password, $row["password"])) {
			if ($password2 !== $password3) {
				echo "<script>
					alert('Konfirmasi Password Tidak Sesuai!');
						</script>";
				return false;
			}else{
				// enkripsi password 
					$password = password_hash($password2, PASSWORD_DEFAULT);
					$query = "UPDATE users SET
					`password` = '$password'
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

}

function ubahpro($data){
  global $conn;
  $idus = htmlspecialchars($data["idus"]);
  $idpro = htmlspecialchars($data["id"]);
//   $waktu = $data['tanggal']." ".$data['waktu'];
  $produk = htmlspecialchars($data["nama_produk"]);
  $kategori = htmlspecialchars($data["kategori"]);
  $deskripsi = htmlspecialchars($data["deskripsi"]);
  $harganormal = htmlspecialchars($data["harganormal"]);
  $hargadiskon = htmlspecialchars($data["hargadiskon"]);
  $rate = htmlspecialchars($data["rate"]);
  $status = htmlspecialchars($data["status"]);

//   $timestamp = date('Y-m-d H:i:s',strtotime($waktu));
//   $now = date('Y-m-d H:i:s');
  // $tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	}else {
		$gambar = uploadgam();
	}
	// $user = query("SELECT username FROM user WHERE id_user = '$idus'")[0];
	// $username = $user['username'];
	$query = "UPDATE produk SET
				id_kategori = '$kategori',
				nama_produk = '$produk',
				deskripsi = '$deskripsi',
				rate = '$rate',
				harganormal = '$harganormal',
				hargadiskon = '$hargadiskon',
				gambar = '$gambar',
				status = '$status',
				created_at = NOW(),
				updated_at = NOW()
				WHERE id_produk = $idpro
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
		$fotodef = "kodingkito.png";
		return $fotodef;
	}
	// Cek kevalidan gambbar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png','svg'];
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
            window.location = 'manproduk.php';
                </script>";
			return false;
	}

	// Lolos pengecekan , maka gambar masuk ke tahap penguploadan
	// Generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../images/produk/'. $namaFileBaru);
	return $namaFileBaru;
}



function ubahkat($data){
	global $conn;
	$id = $data["id"];
	$kategori= htmlspecialchars($data["kategori"]);
	$query = "UPDATE kategori SET `kategori` = '$kategori' WHERE id_kategori = $id";
	mysqli_query($conn,$query);
	return mysqli_affected_rows($conn);
}

function konfirm($data){
	global $conn;
	$id = $data["orderid"];
	// $kategori= htmlspecialchars($data["kategori"]);
	$query = "UPDATE cart SET `status` = 'confirm' WHERE orderid = '$id'";
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

	$namalengkap = strtolower(stripslashes($data["namalengkap"]));
	$email = strtolower(stripslashes($data["email"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn,$data["password2"]);
	// $level = strtolower(stripslashes($data["level"]));
	// cek username sudah ada atau belum
	$cekuser = mysqli_query($conn , "SELECT email FROM users WHERE email ='$email'");
	if (mysqli_fetch_assoc($cekuser)) {
		// echo "
		// <script>
		// alert('username sudah ada!');
		// </script>
		// ";
		return -101;
	}

	// cek konfirmasi password 
	if ($password !== $password2) {
		// echo "
		// <script>
		// 	alert('konfirmasi password tidak sesuai !');
		// </script>
		// ";
		return -100;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);

	// masukkan data userbaru ke database 

	mysqli_query($conn, "INSERT INTO users (`namalengkap`,`email`,`password`,`role`,`gambar`,`created_at`) VALUES ('$namalengkap','$email','$password','customer','kodingkito.png',NOW())");
	
    return mysqli_affected_rows($conn);
}

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}






?>

