<?php include 'header.php'; ?>

<?php
if (!isset($_SESSION['id_user'])) {
    echo "<p>Silakan <a href='auth/login.php'>login</a> terlebih dahulu.</p>";
    include 'footer.php';
    exit;
}

if (!isset($_GET['id'])) {
    echo "<p>Vila tidak ditemukan.</p>";
    include 'footer.php';
    exit;
}

$id = (int) $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM vila WHERE id_vila=$id");
$v = mysqli_fetch_assoc($q);

if (!$v) {
    echo "<p>Vila tidak ditemukan.</p>";
    include 'footer.php';
    exit;
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="booking-wrapper">
    <h2 class="section-title">Booking <?= htmlspecialchars($v['nama_vila']); ?></h2>

    <div class="booking-card">
        <form action="proses_booking.php" method="post">

            <input type="hidden" name="id_vila" value="<?= $v['id_vila']; ?>">

            <div class="form-group">
                <label>Check-in</label>
                <input type="text" id="check_in" name="check_in" required>
            </div>

            <div class="form-group">
                <label>Check-out</label>
                <input type="text" id="check_out" name="check_out" required>
            </div>

            <div class="form-group">
                <label>Jumlah Tamu</label>
                <input type="number" name="jumlah_tamu" min="1" value="2" required>
            </div>

            <p style="font-size:.85rem;color:#9ca3af;margin-bottom:10px;">
                Harga per malam: <strong>Rp <?= number_format($v['harga']); ?></strong><br>
                Total biaya akan dihitung berdasarkan lama menginap.
            </p>

            <button type="submit" class="btn-primary">Konfirmasi Booking</button>
        </form>
    </div>
</div>
<script>
// harga per malam
const hargaPerMalam = <?= $v['harga']; ?>;

let output = document.createElement("p");
output.style.color = "#4ADE80";
output.style.fontSize = "0.9rem";
output.style.marginTop = "10px";
document.querySelector(".booking-card").appendChild(output);

// tanggal yang sudah dibooking user lain
let bookedRanges = <?= json_encode($bookedRanges ?? []); ?>;

// fungsi disable tanggal
function disableDates(date) {
    for (let range of bookedRanges) {
        let start = new Date(range.start);
        let end   = new Date(range.end);

        if (date >= start && date <= end) return true;
    }
    return false;
}

// Init flatpickr input
const checkInPicker = flatpickr("#check_in", {
    minDate: "today",
    dateFormat: "Y-m-d",
    disable: [disableDates],
    onChange: function(selectedDates) {
        checkOutPicker.set("minDate", selectedDates[0]);
        hitungTotal();
    }
});

const checkOutPicker = flatpickr("#check_out", {
    minDate: "today",
    dateFormat: "Y-m-d",
    disable: [disableDates],
    onChange: function() {
        hitungTotal();
    }
});

// fungsi hitung total
function hitungTotal() {
    let checkInDate = checkInPicker.selectedDates[0];
    let checkOutDate = checkOutPicker.selectedDates[0];

    if (!checkInDate || !checkOutDate) return;

    let diff = (checkOutDate - checkInDate) / (1000 * 3600 * 24);

    if (diff <= 0) {
        output.innerHTML = `<span style="color:#EF4444">Tanggal tidak valid.</span>`;
        return;
    }

    output.innerHTML = `Total: <strong>Rp ${(diff * hargaPerMalam).toLocaleString('id-ID')}</strong>`;
}
</script>


<?php include 'footer.php'; ?>
