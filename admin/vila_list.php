<?php
require_once '../config/database.php';
session_start();
if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
$vila = mysqli_query($conn, "SELECT * FROM vila ORDER BY id_vila ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Vila</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-container">
    <h2 class="section-title">Kelola Vila</h2>
    <a href="vila_add.php" class="btn-primary" style="margin-bottom:10px; display:inline-block;">+ Tambah Vila</a>
    <table class="table">
        <tr>
            <th>ID</th><th>Nama</th><th>Lokasi</th><th>Harga</th><th>Rating</th><th>Latitude</th><th>Longitude</th><th>Aksi</th>
        </tr>
        <?php while($v = mysqli_fetch_assoc($vila)): ?>
            <tr>
                <td><?php echo $v['id_vila']; ?></td>
                <td><?php echo htmlspecialchars($v['nama_vila']); ?></td>
                <td><?php echo htmlspecialchars($v['lokasi']); ?></td>
                <td>Rp <?php echo number_format($v['harga'],0,',','.'); ?></td>
                <td><?php echo $v['rating']; ?></td>
                <td><?php echo htmlspecialchars($v['latitude'],0); ?></td>
                <td><?php echo htmlspecialchars($v['longitude'],0); ?></td>
                <td>
                    <a href="vila_edit.php?id=<?php echo $v['id_vila']; ?>">Edit</a> |
                    <a href="vila_galeri.php?id=<?= $v['id_vila']; ?>">Galeri</a> |
                    <a href="vila_delete.php?id=<?php echo $v['id_vila']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    
    <p style="margin-top:20px;"><a href="../admin/index.php" class="btn-outline">Kembali ke Dashboard</a></p>

    
</div>
</body>
</html>
