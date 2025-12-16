<?php
// require_once 'config/database.php';
// session_start();

// if (!isset($_SESSION['id_user'])) {
//     die("Akses ditolak. Harus login.");
// }

// $id_vila = intval($_POST['id_vila']);
// $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
// $review = isset($_POST['review']) ? mysqli_real_escape_string($conn, $_POST['review']) : '';
// $id_user = intval($_SESSION['id_user']);

// // Validasi rating
// if ($rating < 1 || $rating > 5) {
//     die("Rating tidak valid. Silakan pilih bintang 1–5.");
// }

// // Validasi review
// if (empty($review)) {
//     die("Review tidak boleh kosong.");
// }

// // Cek apakah user sudah pernah review vila ini
// $cek = mysqli_query($conn, "SELECT * FROM reviews WHERE id_vila=$id_vila AND id_user=$id_user");
// if (mysqli_num_rows($cek) > 0) {
//     die("Anda sudah memberikan review sebelumnya.");
// }

// // Insert review
// $sql = "
// INSERT INTO reviews (id_user, id_vila, rating, review, created_at)
// VALUES ($id_user, $id_vila, $rating, '$review', NOW())";

// if (!mysqli_query($conn, $sql)) {
//     die("Gagal menyimpan review: " . mysqli_error($conn));
// }

// // Update rating rata-rata vila
// mysqli_query($conn, "
// UPDATE vila 
// SET rating = (SELECT AVG(rating) FROM reviews WHERE id_vila=$id_vila)
// WHERE id_vila=$id_vila
// ");

// logAktivitas($conn, $_SESSION['id_user'], "Memberi review untuk vila ID: $id_vila");


// header("Location: detail_vila.php?id=$id_vila&review_success=1");
// var_dump($_POST);
// exit;

require_once 'config/database.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    die("Akses ditolak. Harus login.");
}

$id_vila = intval($_POST['id_vila']);
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$review = isset($_POST['review']) ? mysqli_real_escape_string($conn, $_POST['review']) : '';
$id_user = intval($_SESSION['id_user']);

if ($rating < 1 || $rating > 5) {
    die("Rating tidak valid. Silakan pilih bintang 1–5.");
}

if (empty($review)) {
    die("Review tidak boleh kosong.");
}

$cek = mysqli_query($conn, "SELECT * FROM reviews WHERE id_vila=$id_vila AND id_user=$id_user");
if (mysqli_num_rows($cek) > 0) {
    die("Anda sudah memberikan review sebelumnya.");
}

$sql = "
INSERT INTO reviews (id_user, id_vila, rating, review, created_at)
VALUES ($id_user, $id_vila, $rating, '$review', NOW())
";
if (!mysqli_query($conn, $sql)) {
    die("Gagal menyimpan review: " . mysqli_error($conn));
}

mysqli_query($conn, "
UPDATE vila 
SET rating = (SELECT AVG(rating) FROM reviews WHERE id_vila=$id_vila)
WHERE id_vila=$id_vila
");

logAktivitas($conn, $_SESSION['id_user'], "Memberi review untuk vila ID: $id_vila");

header("Location: detail_vila.php?id=$id_vila&review_success=1");
exit;

?>
