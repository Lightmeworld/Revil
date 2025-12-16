<?php
require_once "../config/database.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak! Anda bukan admin.");
}

$where = " WHERE 1 "; // default

if (!empty($_GET['keyword'])) {
    $key = mysqli_real_escape_string($conn, $_GET['keyword']);
    $where .= " AND (u.nama LIKE '%$key%' OR l.aktivitas LIKE '%$key%') ";
}

if (!empty($_GET['role'])) {
    $role = mysqli_real_escape_string($conn, $_GET['role']);
    $where .= " AND u.role = '$role' ";
}

if (!empty($_GET['start'])) {
    $start = $_GET['start'];
    $where .= " AND DATE(l.waktu) >= '$start' ";
}

if (!empty($_GET['end'])) {
    $end = $_GET['end'];
    $where .= " AND DATE(l.waktu) <= '$end' ";
}

$q = mysqli_query($conn,
"SELECT l.*, u.nama AS nama_user, u.role
 FROM log_aktivitas l
 JOIN users u ON l.id_user = u.id_user
 $where
 ORDER BY l.waktu DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Aktivitas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>


<div class="main-container">

    <h2 class="section-title">Log Aktivitas Pengguna</h2>
    <form method="GET" class="filter-container">
        <input type="text" name="keyword" placeholder="Cari nama / aktivitas..."
        value="<?= $_GET['keyword'] ?? '' ?>" class="form-input" style="width:200px;">

        <select name="role" class="form-input" style="width:150px;">
            <option value="">Semua Role</option>
            <option value="admin" <?= ($_GET['role'] ?? '')=='admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= ($_GET['role'] ?? '')=='user' ? 'selected' : '' ?>>User</option>
        </select>

        <input type="date" name="start" placeholder="start" value="<?= $_GET['start'] ?? '' ?>" class="form-input">
        <input type="date" name="end" placeholder="end" value="<?= $_GET['end'] ?? '' ?>" class="form-input">

        <button class="btn-primary">Filter</button>
        <a href="log_aktivitas.php" class="btn-outline">Reset</a>
    </form>
    <br>
    <a href="log_export.php" class="btn-primary" style="margin-bottom:15px; display:inline-block;">
        📥 Download CSV
    </a>
    <p style="margin-top:20px;">
        <a href="index.php" class="btn-outline">Kembali ke Dashboard</a>
    </p>


    <table class="table" style="margin-top:16px;">
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Aktivitas</th>
            <th>Waktu</th>
            <th>IP</th>
            <th>Device / Browser</th>
        </tr>

        <?php
        $no = 1;
        while($row = mysqli_fetch_assoc($q)) : ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_user']); ?></td>
            <td><?= htmlspecialchars($row['aktivitas']); ?></td>
            <td><?= $row['waktu']; ?></td>
            <td><?= $row['ip_address']; ?></td>
            <td style="font-size: .75rem;"><?= htmlspecialchars($row['user_agent']); ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

    
</div>
</body>
<style>
    
.filter-container {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.filter-container select,
.filter-container input {
    background: #111827; /* dark */
    color: white;
    border: 1px solid #374151;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 14px;
    width: 160px;
}

.filter-container select:hover,
.filter-container input:hover {
    border-color: #4f82ff;
}

.filter-container button,
.filter-container a.btn-outline {
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
}


</style>

</html>
