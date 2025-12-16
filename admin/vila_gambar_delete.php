<?php
require_once "../config/database.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['vila'])) {
    header("Location: vila_list.php");
    exit;
}

$id_gambar = (int) $_GET['id'];
$id_vila   = (int) $_GET['vila'];

// Ambil nama file
$q = mysqli_query($conn, "
    SELECT nama_file FROM vila_gambar 
    WHERE id_gambar = $id_gambar
");
$data = mysqli_fetch_assoc($q);

if ($data) {
    $file = "../assets/img/" . $data['nama_file'];

    if (file_exists($file)) {
        unlink($file);
    }

    mysqli_query($conn, "
        DELETE FROM vila_gambar 
        WHERE id_gambar = $id_gambar
    ");
}

header("Location: vila_galeri.php?id=$id_vila");
exit;
