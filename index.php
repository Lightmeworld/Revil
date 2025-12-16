<?php 
include 'header.php'; 
// session_start();
require_once 'config/database.php';
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    $pref = mysqli_query($conn, "
        SELECT 
            AVG(v.harga) AS avg_harga,
            (SELECT lokasi FROM booking b2 
             JOIN vila v2 ON b2.id_vila = v2.id_vila
             WHERE b2.id_user = $id_user
             GROUP BY lokasi
             ORDER BY COUNT(*) DESC
             LIMIT 1) AS lokasi_fav
        FROM booking b
        JOIN vila v ON b.id_vila = v.id_vila
        WHERE b.id_user = $id_user
    ");

    $dataPref = mysqli_fetch_assoc($pref);
    $avgHarga = (int) $dataPref['avg_harga'];
    $lokasiFav = $dataPref['lokasi_fav'];

    // Range harga yang disukai
    $minHarga = $avgHarga - 300000;
    $maxHarga = $avgHarga + 300000;

    // Query rekomendasi utama
    $rekom = mysqli_query($conn, "
        SELECT * FROM vila
        WHERE lokasi = '$lokasiFav'
        ORDER BY ABS(harga - $avgHarga) ASC
        LIMIT 3
    ");


    // Fallback kalau hasil kosong
    if (mysqli_num_rows($rekom) == 0) {
        $rekom = mysqli_query($conn, "
            SELECT * FROM vila ORDER BY rating DESC LIMIT 3
        ");
    }
}
?>

<section class="hero">
    <div>
        <div class="hero-badges">
            <span class="badge">UAS Web Dinamis</span>
            <span class="badge">Festival Hari Keamanan Komputer</span>
        </div>
        <h1 class="hero-title">Booking Vila Mewah, Aman & Cepat.</h1>
        <p class="hero-sub">
            Platform simulasi sewa vila dengan sistem login, booking, dan dashboard.
        </p>
        
        <a href="vila.php" class="btn-primary">Lihat Semua Vila</a>
    </div>
    <div>
        <img src="assets/img/2.jpg" alt="Hero Vila">
    </div>
</section>

<?php if (isset($_SESSION['id_user'])): ?>
<h2 class="section-title">🎯 Rekomendasi untuk Anda</h2>
<div class="card-grid">
    <?php while ($v = mysqli_fetch_assoc($rekom)): ?>
        <div class="card">
            <img src="assets/img/<?= $v['gambar']; ?>" class="villa-img">
            <div class="card-body">
                <div class="card-title"><?= $v['nama_vila']; ?></div>
                <div class="card-location"><?= $v['lokasi']; ?></div>
                <div class="card-meta">
                    <span class="price">Rp <?= number_format($v['harga'],0,',','.'); ?>/malam</span>
                    <span class="rating">★ <?= round($v['rating'],1); ?></span>
                </div>
                <div class="card-actions">
                    <a href="detail_vila.php?id=<?= $v['id_vila']; ?>" class="btn-outline">Detail</a>
                    <a href="booking.php?id=<?= $v['id_vila']; ?>" class="btn-primary">Booking</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<hr style="margin:40px 0;">
<?php endif; ?>



<!-- FILTER -->
<h2 class="section-title">Cari Vila</h2>

<form method="GET" class="filter-container">

    <select name="lokasi" class="form-input">
        <option value="">Semua Lokasi</option>
        <?php 
        $lokasiQuery = mysqli_query($conn, "SELECT DISTINCT lokasi FROM vila");
        while($row = mysqli_fetch_assoc($lokasiQuery)) {
            $selected = ($_GET['lokasi'] ?? '') == $row['lokasi'] ? "selected" : "";
            echo "<option value='{$row['lokasi']}' $selected>{$row['lokasi']}</option>";
        }
        ?>
    </select>

    <input type="number" name="min" placeholder="Harga Min" value="<?= $_GET['min'] ?? '' ?>" class="form-input">
    <input type="number" name="max" placeholder="Harga Max" value="<?= $_GET['max'] ?? '' ?>" class="form-input">

    <select name="sort" class="form-input">
        <option value="">Urutkan</option>
        <option value="harga_asc" <?= ($_GET['sort'] ?? '')=="harga_asc" ? "selected" : "" ?>>Harga Termurah</option>
        <option value="harga_desc" <?= ($_GET['sort'] ?? '')=="harga_desc" ? "selected" : "" ?>>Harga Termahal</option>
        <option value="rating" <?= ($_GET['sort'] ?? '')=="rating" ? "selected" : "" ?>>Rating Tertinggi</option>
    </select>
    <select name="fasilitas" class="form-input">
        <option value="">Semua Fasilitas</option>
        <option value="wifi" <?= (@$_GET['fasilitas']=="wifi") ? "selected" : "" ?>>WiFi</option>
        <option value="kolam" <?= (@$_GET['fasilitas']=="kolam") ? "selected" : "" ?>>Kolam Renang</option>
        <option value="parkir" <?= (@$_GET['fasilitas']=="parkir") ? "selected" : "" ?>>Parkir</option>
        <option value="dapur" <?= (@$_GET['fasilitas']=="dapur") ? "selected" : "" ?>>Dapur</option>
        <option value="bbq" <?= (@$_GET['fasilitas']=="bbq") ? "selected" : "" ?>>BBQ</option>
        <option value="balkon" <?= (@$_GET['fasilitas']=="balkon") ? "selected" : "" ?>>Balkon</option>
        <option value="tv" <?= (@$_GET['fasilitas']=="tv") ? "selected" : "" ?>>TV</option>
    </select>



    <button type="submit" class="btn-primary">Filter</button>
    <a href="vila.php" class="btn-outline">Reset</a>
</form>

<?php
$query = "SELECT * FROM vila WHERE 1";

// Filter lokasi
if (!empty($_GET['lokasi'])) {
    $lokasi = mysqli_real_escape_string($conn, $_GET['lokasi']);
    $query .= " AND lokasi = '$lokasi'";
}

// Filter harga min + max
if (!empty($_GET['min'])) $query .= " AND harga >= ".intval($_GET['min']);
if (!empty($_GET['max'])) $query .= " AND harga <= ".intval($_GET['max']);

// Filter fasilitas  ⚠ harus sebelum ORDER BY
if (!empty($_GET['fasilitas'])) {
    $fasilitas = mysqli_real_escape_string($conn, $_GET['fasilitas']);
    $query .= " AND fasilitas LIKE '%$fasilitas%'";
}

// Sorting  ⚠ TARUH PALING TERAKHIR
if (!empty($_GET['sort'])) {
    $sort = $_GET['sort'];
    if ($sort == "harga_asc") $query .= " ORDER BY harga ASC";
    elseif ($sort == "harga_desc") $query .= " ORDER BY harga DESC";
    elseif ($sort == "rating") $query .= " ORDER BY rating DESC";
} else {
    $query .= " ORDER BY id_vila DESC";
}


$result = mysqli_query($conn, $query);
?>

<h2 class="section-title">Daftar Vila</h2>

<div id="villaList" class="card-grid">

<?php
if(mysqli_num_rows($result) == 0){
    echo "<p>❌ Tidak ada vila sesuai filter.</p>";
}

while ($v = mysqli_fetch_assoc($result)): ?>
    <div class="card">
        <img src="<?= dirname($_SERVER['PHP_SELF']) === '/vila' 
        ? '../assets/img/' . $v['gambar'] 
        : 'assets/img/' . $v['gambar'] ?>" 
     class="villa-img"><div class="card-body"></div>
        <!-- <img src="assets/img/<?= urlencode($v['gambar']); ?>" alt="<?= $v['nama_vila']; ?>"> -->
        <div class="card-body">
            <div class="card-title"><?= $v['nama_vila']; ?></div>
            <div class="card-location"><?= $v['lokasi']; ?></div>
            <div class="card-meta">
                <span class="price">Rp <?= number_format($v['harga'],0,',','.'); ?>/malam</span>
                <span class="rating">★ <?= round($v['rating'],1); ?></span>
            </div>
            <div class="card-actions">
                <a href="detail_vila.php?id=<?= $v['id_vila']; ?>" class="btn-outline">Detail</a>
                <a href="booking.php?id=<?= $v['id_vila']; ?>" class="btn-primary">Booking</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>
</div>



<script>
if (window.location.search.length > 0) {
    document.getElementById("villaList").scrollIntoView({ behavior: 'smooth' });
}
</script>

<?php include 'footer.php'; ?>

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