
<?php
require_once '../config/database.php';
session_start();

if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$totalVila = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM vila"))[0];
$totalUser = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];
$totalBook = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM booking"))[0];
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-container">
    <h2 class="section-title">Dashboard Admin</h2>
    <p class="section-sub">Ringkasan data pada sistem.</p>

    <!-- ==== CARD SUMMARY ==== -->
    <div class="card-grid">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Total Vila</div>
                <p class="value"><?php echo $totalVila; ?></p>
                <a href="vila_list.php" class="btn-outline">Kelola Vila</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card-title">Total User</div>
                <p class="value"><?php echo $totalUser; ?></p>
                <a href="users.php" class="btn-outline">Lihat User</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card-title">Total Booking</div>
                <p class="value"><?php echo $totalBook; ?></p>
                <a href="booking.php" class="btn-outline">Lihat Booking</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card-title">Log Aktivitas</div>
                <p class="value"><?php echo $totalBook; ?></p>
                <a href="log_aktivitas.php" class="btn-outline">Lihat Aktivitas</a>
            </div>
        </div>
    </div>

    <!-- ==== CHART SECTION ==== -->
    <div class="chart-section">

        <div class="chart-container">
            <h3 class="chart-title">Statistik Booking Per Bulan</h3>
            <canvas id="bookingChart"></canvas>
        </div>

        <div class="chart-container">
            <h3 class="chart-title">Status Booking</h3>
            <canvas id="statusChart"></canvas>
        </div>

        <div class="chart-container">
            <h3 class="chart-title">Rating Vila</h3>
            <canvas id="ratingChart"></canvas>
        </div>

    </div>

    <p style="margin-top:25px; text-align:center;">
        <a href="../index.php" class="btn-outline">Kembali ke Website</a>
    </p>
</div>

<?php
// 1. Booking per bulan
$bulan = [];
$jumlahBooking = [];

$result = mysqli_query($conn, "
    SELECT MONTH(check_in) AS bulan, COUNT(*) AS total
    FROM booking
    GROUP BY MONTH(check_in)
");

while ($row = mysqli_fetch_assoc($result)) {
    $bulan[] = $row['bulan'];
    $jumlahBooking[] = $row['total'];
}

// 2. Status booking
$status = [];
$statusCount = [];

$res2 = mysqli_query($conn, "
    SELECT status_booking, COUNT(*) AS total
    FROM booking
    GROUP BY status_booking
");

while ($row = mysqli_fetch_assoc($res2)) {
    $status[] = $row['status_booking'];
    $statusCount[] = $row['total'];
}

// 3. Rating Vila
$vilaNames = [];
$vilaRating = [];

$res3 = mysqli_query($conn, "
    SELECT nama_vila, rating FROM vila ORDER BY rating DESC
");

while ($row = mysqli_fetch_assoc($res3)) {
    $vilaNames[] = $row['nama_vila'];
    $vilaRating[] = $row['rating'];
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const bookingChart = new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [{
            label: 'Booking Per Bulan',
            data: <?= json_encode($jumlahBooking) ?>,
            backgroundColor: '#60A5FA'
        }]
    }
});

const statusChart = new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: <?= json_encode($status) ?>,
        datasets: [{
            data: <?= json_encode($statusCount) ?>,
            backgroundColor: ['#22c55e', '#ef4444', '#fbbf24']
        }]
    }
});

const ratingChart = new Chart(document.getElementById('ratingChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($vilaNames) ?>,
        datasets: [{
            label: 'Rating Vila',
            data: <?= json_encode($vilaRating) ?>,
            borderColor: '#3b82f6',
            borderWidth: 3
        }]
    }
});
</script>

</body>
</html>
