<?php
require_once '../config/database.php';
session_start();
if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}
$q = mysqli_query($conn,"SELECT b.*, u.nama, v.nama_vila 
                        FROM booking b
                        JOIN users u ON b.id_user=u.id_user
                        JOIN vila v ON b.id_vila=v.id_vila
                        ORDER BY b.created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Booking</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-container">
    <h2 class="section-title">Data Booking</h2>
    <table class="table">
        <tr>
            <th>ID</th><th>Pemesan</th><th>Vila</th><th>Check-in</th><th>Check-out</th><th>Total</th><th>Status</th>
        </tr>
        <p style="margin-top:20px;">
        <a href="index.php" class="btn-outline">Kembali ke Dashboard</a>
    </p>
    <br>
        <?php while($b = mysqli_fetch_assoc($q)): ?>
        <tr>
            <td><?php echo $b['id_booking']; ?></td>
            <td><?php echo htmlspecialchars($b['nama']); ?></td>
            <td><?php echo htmlspecialchars($b['nama_vila']); ?></td>
            <td><?php echo $b['check_in']; ?></td>
            <td><?php echo $b['check_out']; ?></td>
            <td>Rp <?php echo number_format($b['total_harga'],0,',','.'); ?></td>
            <td><?php echo $b['status_booking']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    
</div>
</body>
</html>
