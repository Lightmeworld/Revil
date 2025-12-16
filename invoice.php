<?php
include 'header.php';

if (!isset($_SESSION['id_user'])) {
    echo "<p>Silakan <a href='auth/login.php'>login</a> terlebih dahulu.</p>";
    include 'footer.php';
    exit;
}

if (!isset($_GET['id'])) {
    echo "<p>Invoice tidak ditemukan.</p>";
    include 'footer.php';
    exit;
}

$id_booking = (int)$_GET['id'];

$q = mysqli_query($conn, "
SELECT b.*, v.nama_vila, v.lokasi, v.harga, u.nama 
FROM booking b 
JOIN vila v ON b.id_vila = v.id_vila
JOIN users u ON b.id_user = u.id_user
WHERE b.id_booking=$id_booking
");

$data = mysqli_fetch_assoc($q);

if (!$data) { echo "<p>Data tidak ditemukan.</p>"; include 'footer.php'; exit; }

?>

<div class="booking-card" style="max-width:700px;margin:auto;margin-top:20px;">
    <h2 style="margin-bottom:10px;">Invoice Booking</h2>
    <hr>
    <p><strong>Nama Pemesan:</strong> <?= $data['nama']; ?></p>
    <p><strong>Vila:</strong> <?= $data['nama_vila']; ?> (<?= $data['lokasi']; ?>)</p>
    <p><strong>Check-in:</strong> <?= $data['check_in']; ?></p>
    <p><strong>Check-out:</strong> <?= $data['check_out']; ?></p>
    <p><strong>Jumlah Tamu:</strong> <?= $data['jumlah_tamu']; ?></p>
    <p><strong>Total Pembayaran:</strong> 
        <span style="color:#4ade80;">Rp <?= number_format($data['total_harga'],0,',','.'); ?></span>
    </p>
    <p><strong>Status:</strong> <?= ucfirst($data['status_booking']); ?></p>
</div>

<?php include 'footer.php'; ?>
