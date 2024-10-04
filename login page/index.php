<?php
require('../dashboard/func/functions.php');
ob_start();
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>WONDER | Login Page</title>
    <meta name="description" content="Sistem Informasi WONDER">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../asset/1.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="font/flaticon.css">
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
</head>

<body>
<?php
if (isset($_SESSION["login"])) {
    if ($_SESSION["role"] == "superadmin") {
        echo "<script>swal('Anda Sudah Login!', 'Selamat Datang di Sistem WONDER!', 'info').then(function(){
            setTimeout(document.location.href = '../dashboard/index.php', 100);
            });</script>";
        exit();
    }elseif ($_SESSION["role"] == "reviewer") {
        echo "<script>swal('Anda Sudah Login!', 'Selamat Datang di Sistem WONDER!', 'info').then(function(){
            setTimeout(document.location.href = '../reviewer/', 100);
            });</script>";
        exit();
    }elseif ($_SESSION['role'] == "uploader") {
        echo "<script>swal('Anda Sudah Login!', 'Selamat Datang di Sistem WONDER!', 'info').then(function(){
            setTimeout(document.location.href = '../uploader/', 100);
            });</script>";
        exit();
    } else{
        echo "<script>swal('Anda Tidak Memiliki Akses!', 'Silakan login kembali dengan akses yang baru!', 'error').then(function(){
            setTimeout(document.location.href = '../dashboard/logout.php', 400);
            });</script>";
        exit();
    }
}

if (isset($_POST["login"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$result = mysqli_query($conn,"SELECT * FROM users WHERE
							username = '$username'");
                            // var_dump($result);
                            // die;
	// cek username 
	if (mysqli_num_rows($result) == 1) {
		// cek password
		$row = mysqli_fetch_assoc($result);
		 if (password_verify($password, $row["password"])) {
		 	if ($row['role'] == "superadmin") {
                    // set session 
                    $_SESSION["login"] = true;
                    $_SESSION["id_user"] = $row["id_user"];
                    $_SESSION["user"] = $row["username"];
                    $_SESSION["role"] = $row["role"];
                    login_validate();
                    echo "<script>swal('Login Berhasil!', 'Selamat Datang di Sistem Wonder!', 'success').then(function(){
                        setTimeout(document.location.href = '../dashboard/index.php', 100);
                    });</script>";
                    exit;
                }elseif ($row['role'] == "reviewer") {
                        // set session 
                        $_SESSION["login"] = true;
                        $_SESSION["id_user"] = $row["id_user"];
                        $_SESSION["user"] = $row["username"];
                        $_SESSION["role"] = $row["role"];
                        login_validate();
                        echo "<script>swal('Login Berhasil!', 'Selamat Datang di Sistem Wonder!', 'success').then(function(){
                            setTimeout(document.location.href = '../reviewer/', 100);
                        });</script>";
                        exit;
                }elseif ($row['role'] == "uploader") {
                    // set session 
                    $_SESSION["login"] = true;
                    $_SESSION["id_user"] = $row["id_user"];
                    $_SESSION["user"] = $row["username"];
                    $_SESSION["role"] = $row["role"];
                    login_validate();
                    echo "<script>swal('Login Berhasil!', 'Selamat Datang di Sistem Wonder!', 'success').then(function(){
                        setTimeout(document.location.href = '../uploader/', 100);
                    });</script>";
                    exit;
            }
		 }
	}
    elseif (mysqli_num_rows($result) == 0) {
            echo "<script>swal('Login Gagal!', 'Email/Password Salah!', 'error');</script>";
            }
    else {
            echo "<script>swal('Login Gagal!', 'User Tidak Terdaftar!', 'error');</script>";
        }
$error = true;
}
?>
    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
    <section class="fxt-template-animation fxt-template-layout33">
        <div class="fxt-content-wrap">
            <div class="fxt-heading-content">
                <div class="fxt-inner-wrap fxt-transformX-R-50 fxt-transition-delay-3">
                    <div class="fxt-transformX-R-50 fxt-transition-delay-10">
                        <a href="index.html" class="fxt-logo"><img src="../asset/1.png" alt="Logo" style="width: 70px;background-color:transparent;"></a>
                    </div>
                    <div class="fxt-transformX-R-50 fxt-transition-delay-10">
                        <div class="fxt-middle-content">
                            <div class="fxt-sub-title">WELCOME TO</div>
                            <h1 class="fxt-main-title">WORKOVER NECESSARY DOCUMENT EVIDENCE REVIEW (WONDER)</h1>
                            <p class="fxt-description">Silakan login dengan akun yang sudah diberikan oleh admin untuk melanjutkan.</p>
                        </div>
                    </div>
                    <div class="fxt-transformX-R-50 fxt-transition-delay-10">
                        <div class="fxt-switcher-description">Belum Punya Akun?<a href="../index.php" class="fxt-switcher-text" target="_blank">Daftar &raquo;</a></div>
                    </div>
                </div>
            </div>
            <div class="fxt-form-content">
                <div class="fxt-main-form">
                    <div class="fxt-inner-wrap fxt-opacity fxt-transition-delay-13">
                        <h2 class="fxt-page-title">Log In</h2>
                        <p class="fxt-description">Silakan login dengan akun anda</p>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username" class="fxt-label">Username</label>
                                <input type="username" id="username" class="form-control" name="username" placeholder="Masukkan Username Anda" required="required">
                            </div>
                            <div class="form-group">
                                <label for="password" class="fxt-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan Password" required="required">
                            </div>
                            <div class="form-group">
                                <a href="https://wa.me/6281278564865?text=Permisi%20...%0ASaya%20salah%20satu%20dari%20Petugas%20yang%20ingin%20mereset%20password%20dari%20akun%20Sistem%20Informasi%20WONDER%20...%20%F0%9F%99%8F" class="fxt-switcher-text">Lupa Password</a>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="login" class="fxt-btn-fill">Log in</button>
                            </div>
                        </form>
                        <div class="fxt-divider-text">- Atau -</div>
                        <div id="fxt-login-option" class="fxt-login-option">
                            <ul>
                                <li class="fxt-google active">
                                    <a href="../index.php" target="_blank">
                                        <span class="fxt-option-icon"><i class="fab fa-whatsapp"> </i></span>
                                        <span class="fxt-option-text ml-2"> Daftar Akun Baru &raquo;</span>
                                    </a>
                                </li>
                                
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- jquery-->
    <script src="js/jquery-3.5.0.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Imagesloaded js -->
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <!-- Validator js -->
    <script src="js/validator.min.js"></script>
    <!-- Custom Js -->
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

</body>
</html>