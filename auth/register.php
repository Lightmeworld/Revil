<?php
require_once '../config/database.php';
session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $pass2 = $_POST['password2'] ?? '';

    if ($nama === '' || $email === '' || $pass === '') {
        $err = 'Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = 'Format email tidak valid.';
    } elseif ($pass !== $pass2) {
        $err = 'Konfirmasi password tidak sama.';
    } else {
        $emailEsc = mysqli_real_escape_string($conn, $email);
        $cek = mysqli_query($conn, "SELECT id_user FROM users WHERE email='$emailEsc'");
        if (mysqli_num_rows($cek) > 0) {
            $err = 'Email sudah terdaftar.';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $namaEsc = mysqli_real_escape_string($conn, $nama);
            $sql = "INSERT INTO users (nama,email,password,role) 
                    VALUES ('$namaEsc','$emailEsc','$hash','user')";
            if (mysqli_query($conn, $sql)) {
                header("Location: login.php?success=1");
                exit;
            } else {
                $err = 'Gagal registrasi: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - SewaVila</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="register-container">
    <h2 class="section-title">Daftar Akun</h2>
    <div class="form-card">
        <?php if ($err): ?>
            <p style="color:#fca5a5; font-size:0.85rem; margin-bottom:8px;"><?php echo $err; ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Ulangi Password</label>
                <input type="password" name="password2" required>
            </div>
            <button type="submit" class="btn-primary">Daftar</button>
            <a href="login.php" style="margin-left:8px; font-size:0.85rem;">Sudah punya akun?</a>
        </form>
    </div>
</div>
</body>
</html>
