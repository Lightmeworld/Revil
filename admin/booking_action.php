<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak! Anda bukan admin.");
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Parameter tidak valid.");
}

$id = (int) $_GET['id'];
$status = $_GET['status'];

$allowed = ['confirmed', 'cancelled'];

if (!in_array($status, $allowed)) {
    die("Status tidak valid.");
}

// update database
// update status booking
mysqli_query($conn, "UPDATE booking SET status_booking='$status' WHERE id_booking=$id");

// Tentukan kalimat sesuai status
if ($status === 'confirmed') {
    $aksi = "Menyetujui booking ID: $id";
} else {
    $aksi = "Membatalkan booking ID: $id";
}

// Catat ke log aktivitas
logAktivitas($conn, $_SESSION['id_user'], $aksi);

header("Location: booking_list.php?update=success");
exit;

?>
