<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$q = mysqli_query($conn, "
    SELECT b.*, u.nama AS nama_user, v.nama_vila
    FROM booking b
    JOIN users u ON b.id_user = u.id_user
    JOIN vila v ON b.id_vila = v.id_vila
    ORDER BY b.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Booking</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="main-container">
<h2 class="section-title">Kelola Booking</h2>
<p style="margin-top:20px;"><a href="../index.php" class="btn-outline">Kembali ke Website</a></p>
<table class="admin-table" style="width:90%;margin:auto;">
    <tr>
        <th>Pengguna</th>
        <th>Vila</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($q)): ?>
    <tr>
        <td><?= htmlspecialchars($row['nama_user']) ?></td>
        <td><?= htmlspecialchars($row['nama_vila']) ?></td>
        <td><?= $row['check_in'] ?> → <?= $row['check_out'] ?></td>
        <td>Rp <?= number_format($row['total_harga']); ?></td>
        <td>
            <?php if ($row['status_booking'] == 'pending'): ?>
                <span style="color:#fbbf24;">⏳ Pending</span>
            <?php elseif ($row['status_booking'] == 'confirmed'): ?>
                <span style="color:#22c55e;">✔️ Confirmed</span>
            <?php else: ?>
                <span style="color:#ef4444;">❌ Cancelled</span>
            <?php endif; ?>
        </td>
        <td>
            <?php if ($row['status_booking'] === 'pending'): ?>
                <div class="action-group">
                    <a href="booking_action.php?id=<?= $row['id_booking']; ?>&status=confirmed" 
                    class="action-btn btn-approve">✔ Setujui</a>

                    <a href="booking_action.php?id=<?= $row['id_booking']; ?>&status=cancelled" 
                    class="action-btn btn-cancel">✖ Batalkan</a>
                </div>
            <?php else: ?>
                <span style="font-size:.85rem;color:#9ca3af;">Tidak ada aksi</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</div>

</body>
</html>
