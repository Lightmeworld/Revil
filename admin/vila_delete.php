<?php
require_once '../config/database.php';
session_start();

// proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak! Anda bukan admin.");
}

$id = (int) $_GET['id'];

// ambil nama vila untuk keperluan log
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_vila, gambar FROM vila WHERE id_vila=$id"));
$nama_vila = $data['nama_vila'];
$gambar = $data['gambar'];

// hapus gambar (jika ada)
if ($gambar && file_exists("../assets/img/$gambar")) {
    unlink("../assets/img/$gambar");
}

// hapus booking
mysqli_query($conn, "DELETE FROM booking WHERE id_vila = $id");

// hapus review
mysqli_query($conn, "DELETE FROM reviews WHERE id_vila = $id");

// hapus vila
mysqli_query($conn, "DELETE FROM vila WHERE id_vila = $id");

// logging
logAktivitas($conn, $_SESSION['id_user'], "Menghapus vila: $nama_vila (ID: $id)");

header("Location: vila_list.php?msg=deleted");
exit;
?>
