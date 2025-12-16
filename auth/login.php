<?php
require_once '../config/database.php';
session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($email === '' || $pass === '') {
        $err = 'Email dan password wajib diisi.';
    } else {
        $emailEsc = mysqli_real_escape_string($conn, $email);
        $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$emailEsc'");
        $u = mysqli_fetch_assoc($q);
        if ($u && password_verify($pass, $u['password'])) {
            $_SESSION['id_user'] = $u['id_user'];
            $_SESSION['nama']    = $u['nama'];
            $_SESSION['role']    = $u['role'];
            logAktivitas($conn, $_SESSION['id_user'], "Login ke sistem");
            header("Location: ../index.php");
            exit;
        } else {
            $err = 'Email atau password salah.';
        }
    }
}

$success = isset($_GET['success']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SewaVila</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="login-container">
    <h2 class="section-title">Login</h2>
    <div class="form-card">
        <?php if ($success): ?>
            <p style="color:#bbf7d0; font-size:0.85rem; margin-bottom:8px;">Registrasi berhasil, silakan login.</p>
        <?php endif; ?>
        <?php if ($err): ?>
            <p style="color:#fca5a5; font-size:0.85rem; margin-bottom:8px;"><?php echo $err; ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary">Login</button>
            <a href="register.php" style="margin-left:8px; font-size:0.85rem;">Belum punya akun?</a>
        </form>
    </div>
</div>
</body>
</html>
