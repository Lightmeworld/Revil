<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'], $_GET['status'])) {
    die("Parameter tidak valid.");
}

$id = (int) $_GET['id'];
$status = $_GET['status'];

$allowed = ['confirmed', 'cancelled'];
if (!in_array($status, $allowed)) {
    die("Status tidak valid.");
}

mysqli_query($conn, "UPDATE booking SET status_booking='$status' WHERE id_booking=$id");

header("Location: booking_list.php?success=1");
exit;
?>
