<?php include 'header.php'; ?>

<h2 class="section-title">Semua Vila</h2>
<p class="section-sub">Daftar lengkap vila yang tersedia pada sistem.</p>

<div class="card-grid">
<?php
$q = mysqli_query($conn, "SELECT * FROM vila ORDER BY harga ASC");
while ($v = mysqli_fetch_assoc($q)): ?>
    <div class="card">
        <img src="<?= dirname($_SERVER['PHP_SELF']) === '/vila' 
        ? '../assets/img/' . $v['gambar'] 
        : 'assets/img/' . $v['gambar'] ?>" 
     class="villa-img">

        <div class="card-body">
            <div class="card-title"><?php echo htmlspecialchars($v['nama_vila']); ?></div>
            <div class="card-location"><?php echo htmlspecialchars($v['lokasi']); ?></div>
            <div class="card-meta">
                <span class="price">Rp <?php echo number_format($v['harga'],0,',','.'); ?>/malam</span>
                <span class="rating">★ <?php echo $v['rating']; ?></span>
            </div>
            <div class="card-actions">
                <a href="detail_vila.php?id=<?php echo $v['id_vila']; ?>" class="btn-outline">Detail</a>
                <a href="booking.php?id=<?php echo $v['id_vila']; ?>" class="btn-primary">Booking</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>
