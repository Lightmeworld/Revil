
<?php
session_start();
require_once 'config/database.php';
include 'header.php';


if (!isset($_GET['id'])) {
    echo "<p>Vila tidak ditemukan.</p>";
    include 'footer.php';
    exit;
}



$id = (int) $_GET['id'];
$q  = mysqli_query($conn, "SELECT * FROM vila WHERE id_vila=$id");
$v  = mysqli_fetch_assoc($q);

if (isset($_SESSION['id_user'])) {
    logAktivitas($conn, $_SESSION['id_user'], "Melihat detail vila ID: " . $id);
}

$lat = $v['latitude'];
$lng = $v['longitude'];



if (!$v) {
    echo "<p>Vila tidak ditemukan.</p>";
    include 'footer.php';
    exit;
}

$galeri = mysqli_query($conn, "
    SELECT nama_file 
    FROM vila_gambar 
    WHERE id_vila = $id
");
?>



<div class="card" style="margin-top: 10px; overflow:hidden;">
    <div class="villa-slider">
        <div class="slides">
            <?php 
            $isFirst = true;
            while ($g = mysqli_fetch_assoc($galeri)) : ?>
                <img 
                    src="assets/img/<?= $g['nama_file']; ?>" 
                    class="slide <?= $isFirst ? 'active' : '' ?>"
                >
            <?php 
                $isFirst = false;
            endwhile; ?>
        </div>

        <button class="nav prev" onclick="prevSlide()">‹</button>
        <button class="nav next" onclick="nextSlide()">›</button>
    </div>
<div class="card-body">
        <h2 class="card-title"><?php echo htmlspecialchars($v['nama_vila']); ?></h2>
        <div class="card-location"><?php echo htmlspecialchars($v['lokasi']); ?></div>
        <div class="card-meta">
            <span class="price">Rp <?php echo number_format($v['harga'],0,',','.'); ?>/malam</span>
            <span class="rating">★ <?php echo $v['rating']; ?></span>
        </div>
        <p style="margin-top:8px; font-size:0.9rem; color:#d1d5db;">
            <?php echo nl2br(htmlspecialchars($v['deskripsi'])); ?>
        </p>
        <p style="margin-top:8px; font-size:0.85rem; color:#9ca3af;">
            <strong>Fasilitas:</strong> <?php echo htmlspecialchars($v['fasilitas']); ?>
        </p>
        <div class="card-actions" style="margin-top:14px;">
            <a href="booking.php?id=<?php echo $v['id_vila']; ?>" class="btn-primary">Booking Sekarang</a>
        </div>
    </div>
 <?php
// CEK apakah user boleh review
$showReviewForm = false;

if (isset($_SESSION['id_user'])) {
    $idUser = $_SESSION['id_user'];

    $cekBooking = mysqli_query($conn, 
        "SELECT * FROM booking WHERE id_user=$idUser AND id_vila=$id AND status_booking='confirmed'"
    );

    $cekReview = mysqli_query($conn, 
        "SELECT * FROM reviews WHERE id_user=$idUser AND id_vila=$id"
    );

    if (mysqli_num_rows($cekBooking) > 0 && mysqli_num_rows($cekReview) == 0) {
        $showReviewForm = true;
    }
}
?>

<h3>📍 Lokasi Vila</h3>

<div id="map"></div>

<style>
#map {
    width: 100%;
    height: 350px;
    border-radius: 10px;
    margin-top: 20px;
}

</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> -->

<div id="map" style="height:10px; border-radius:10px; margin-top:10px;"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    var lat = <?= $v['latitude']; ?>;
    var lng = <?= $v['longitude']; ?>;

    var map = L.map('map').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors',
        maxZoom: 19
    }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map);

    // 🔎 Reverse Geocoding ke Nominatim
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {

            let alamat = data.display_name 
                ? data.display_name 
                : "Alamat tidak tersedia";

            let popupContent = `
                <strong><?= $v['nama_vila']; ?></strong><br>
                ${alamat}
            `;

            marker.bindPopup(popupContent).openPopup();
        })
        .catch(() => {
            marker.bindPopup("<?= $v['nama_vila']; ?><br>Alamat tidak tersedia").openPopup();
        });

});
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



<?php if ($showReviewForm): ?>
<hr style="margin:15px 0;">
<h3 style="margin-bottom:8px;">Tulis Review</h3>

<form action="submit_review.php" method="post">
    <input type="hidden" name="id_vila" value="<?= $id ?>">

    <label>Rating:</label>
    <div class="rating-stars" id="ratingStars">
        <input type="hidden" name="rating" id="ratingValue" required>
        <span data-value="1">★</span>
        <span data-value="2">★</span>
        <span data-value="3">★</span>
        <span data-value="4">★</span>
        <span data-value="5">★</span>
    </div>


    <textarea name="review" placeholder="Tulis pengalamanmu..." required
        style="width:100%;height:80px;margin-top:8px;"></textarea>

    <button type="submit" class="btn-primary" style="margin-top:10px;">Kirim Review</button>
</form>
<?php endif; ?>
</div>

<hr style="margin:20px 0;">
<h3>Review Pengguna</h3>

<?php
$reviews = mysqli_query($conn, 
    "SELECT r.*, u.nama FROM reviews r 
     JOIN users u ON r.id_user = u.id_user 
     WHERE r.id_vila=$id ORDER BY r.created_at DESC"
);

if (mysqli_num_rows($reviews) == 0) {
    echo "<p>Belum ada review.</p>";
}

while ($rv = mysqli_fetch_assoc($reviews)) {
?>
<div style="margin-top:12px;padding:10px;border:1px solid #374151;border-radius:6px;">
    <strong><?= htmlspecialchars($rv['nama']); ?></strong> — ⭐ <?= $rv['rating']; ?>
    <p style="font-size:0.9rem;"><?= nl2br(htmlspecialchars($rv['review'])); ?></p>
    <small style="color:#9ca3af;"><?= $rv['created_at']; ?></small>
</div>
<?php } ?>

<script>
const stars = document.querySelectorAll('#ratingStars span');
const ratingValue = document.querySelector('#ratingValue');

stars.forEach((star, index) => {
    star.addEventListener('click', () => {
        stars.forEach(s => s.classList.remove('active'));

        for (let i = 0; i <= index; i++) {
            stars[i].classList.add('active');
        }

        ratingValue.value = index + 1;
    });
});

</script>
<?php include 'footer.php'; ?>

<style>
.villa-slider {
    position: relative;
    width: 100%;
    height: 600px;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 15px;
}

.villa-slider .slide {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
}

.villa-slider .slide.active {
    display: block;
}

.villa-slider .nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.45);
    color: #fff;
    border: none;
    font-size: 2rem;
    padding: 4px 10px;
    cursor: pointer;
    border-radius: 50%;
}

.villa-slider .prev { left: 10px; }
.villa-slider .next { right: 10px; }
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {

    let currentSlide = 0;
    const slides = document.querySelectorAll('.villa-slider .slide');

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        slides[index].classList.add('active');
    }

    window.nextSlide = function () {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    window.prevSlide = function () {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

});
</script>
