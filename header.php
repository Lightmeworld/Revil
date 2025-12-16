<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sewa Vila</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="navbar">
    <div class="nav-container">
        <a href="index.php" class="logo">
            <img src="assets/logo/logo.png" alt="Logo SewaVila">
            <span>Revil.ID</span>
        </a>
        <!-- 🔥 TOMBOL HAMBURGER (versi Android) -->
        <div class="hamburger" onclick="toggleMenu(this)">☰</div>

        <!-- 🔥 MENU dibungkus agar bisa muncul/hidden -->
        <nav class="navbar-links">
            <a href="vila.php">Daftar Vila</a>

            <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin/index.php">Admin</a>
            <?php endif; ?>

            <?php if(isset($_SESSION['id_user'])): ?>
                <a href="riwayat.php">Riwayat Booking</a>
            <?php endif; ?>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin/booking_list.php">Kelola Booking</a>
            <?php endif; ?>

            <?php if (!empty($_SESSION['id_user'])): ?>
                <span class="nav-user">Hi, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                <a href="auth/logout.php" class="btn-outline">Logout</a>
            <?php else: ?>
                <a href="auth/login.php" class="btn-outline">Login</a>
                <a href="auth/register.php" class="btn-primary">Daftar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<script>
function toggleMenu(btn) {
    document.querySelector('.navbar-links').classList.toggle('show');
    btn.textContent = btn.textContent === "☰" ? "✖" : "☰";
}

</script>

<main class="main-container">
