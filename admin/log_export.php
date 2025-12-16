<?php
require_once "../config/database.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak!");
}

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=log_aktivitas.csv");

$output = fopen("php://output", "w");

// Header CSV
fputcsv($output, ["Nama User", "Role", "Aktivitas", "Waktu", "IP Address", "User Agent"]);

$q = mysqli_query($conn,
"SELECT l.*, u.nama AS nama_user, u.role
 FROM log_aktivitas l
 JOIN users u ON l.id_user = u.id_user
 ORDER BY l.waktu DESC");

while($row = mysqli_fetch_assoc($q)) {
    fputcsv($output, [
        $row['nama_user'],
        $row['role'],
        $row['aktivitas'],
        $row['waktu'],
        $row['ip_address'],
        $row['user_agent'],
    ]);
}

fclose($output);
exit;
?>
