<?php
include 'header.php';

if (!isset($_SESSION['id_user'])) {
    echo "<p>Silakan <a href='auth/login.php'>login</a> terlebih dahulu.</p>";
    include 'footer.php';
    exit;
}

$id_user = $_SESSION['id_user'];

$q = mysqli_query($conn, "
SELECT b.*, v.nama_vila, v.lokasi, v.harga 
FROM booking b 
JOIN vila v ON b.id_vila = v.id_vila
WHERE b.id_user = $id_user
ORDER BY b.created_at DESC
");
?>

<h2 class="section-title">Riwayat Booking Saya</h2>

<table class="admin-table" style="width:90%;margin:auto;">
    <tr>
        <th>Vila</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($q)) { ?>
    <tr>
        <td><?= htmlspecialchars($row['nama_vila']); ?></td>
        <td><?= $row['check_in']; ?></td>
        <td><?= $row['check_out']; ?></td>
        <td>Rp <?= number_format($row['total_harga'],0,',','.'); ?></td>
        <td>
            <?php 
                $status_color = [
                    "pending" => "#fbbf24",
                    "confirmed" => "#10b981",
                    "cancelled" => "#ef4444"
                ];
            ?>
            <span style="color:<?= $status_color[$row['status_booking']] ?>">
                <?= ucfirst($row['status_booking']); ?>
            </span>
        </td>
        <td>
            <a href="invoice.php?id=<?= $row['id_booking']; ?>" class="btn-primary">Invoice</a>
        </td>
    </tr>
    <?php } ?>
</table>

<?php include 'footer.php'; ?>
