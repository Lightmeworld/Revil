<?php
include 'header.php';

if (!isset($_SESSION['id_user'])) {
    echo "<p>Anda harus login terlebih dahulu.</p>";
    include 'footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<p>Metode tidak valid.</p>";
    include 'footer.php';
    exit;
}

$id_vila     = (int) ($_POST['id_vila'] ?? 0);
$check_in    = $_POST['check_in'] ?? '';
$check_out   = $_POST['check_out'] ?? '';
$jumlah_tamu = (int) ($_POST['jumlah_tamu'] ?? 1);

// Ambil data vila
$q  = mysqli_query($conn, "SELECT * FROM vila WHERE id_vila=$id_vila");
$v  = mysqli_fetch_assoc($q);

if (!$v) {
    echo "<p>Vila tidak ditemukan.</p>";
    include 'footer.php';
    exit;
}

// Validasi tanggal format
$ci = date_create($check_in);
$co = date_create($check_out);

if (!$ci || !$co || $co <= $ci) {
    echo "<script>alert('Tanggal tidak valid! Check-out harus setelah check-in.'); history.back();</script>";
    exit;
}

// ** Tambahan Validasi: Cek tabrakan tanggal booking **
$qOverlap = mysqli_query($conn, "
    SELECT * FROM booking 
    WHERE id_vila=$id_vila 
    AND status_booking='confirmed'
    AND ('$check_in' < check_out AND '$check_out' > check_in)
");

if (mysqli_num_rows($qOverlap) > 0) {
    echo "<script>alert('Tanggal yang dipilih sudah dibooking orang lain. Silakan pilih tanggal lain.'); history.back();</script>";
    exit;
}

// Hitung total biaya
$diff        = date_diff($ci, $co)->days;
$total_harga = $diff * $v['harga'];

$id_user = $_SESSION['id_user'];
$ciEsc   = mysqli_real_escape_string($conn, $check_in);
$coEsc   = mysqli_real_escape_string($conn, $check_out);

$sql = "INSERT INTO booking (id_user,id_vila,check_in,check_out,jumlah_tamu,total_harga,status_booking)
        VALUES ($id_user,$id_vila,'$ciEsc','$coEsc',$jumlah_tamu,$total_harga,'pending')";

if (mysqli_query($conn, $sql)) {

    echo "<h2 class='section-title'>Booking Berhasil</h2>";
    echo "<p class='section-sub'>Status: <strong>Pending (Menunggu Konfirmasi Admin)</strong></p>";
    echo "<div class='form-card'>";
    echo "<p>Vila: <strong>".htmlspecialchars($v['nama_vila'])."</strong></p>";
    echo "<p>Check-in: $check_in</p>";
    echo "<p>Check-out: $check_out</p>";
    echo "<p>Lama menginap: $diff malam</p>";
    echo "<p>Total: <strong>Rp ".number_format($total_harga,0,',','.')."</strong></p>";
    echo "</div>";

    echo "<a href='riwayat.php' class='btn-primary' style='margin-top:10px;'>Lihat Riwayat Booking</a>";

} else {
    echo "<p>Gagal booking: ".mysqli_error($conn)."</p>";
}

include 'footer.php';
?>
