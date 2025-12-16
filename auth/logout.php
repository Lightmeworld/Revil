<?php
session_start();
require_once '../config/database.php';

// ⬇ Log aktivitas logout (sebelum session hilang)
if (isset($_SESSION['id_user'])) {
    logAktivitas($conn, $_SESSION['id_user'], "Logout dari sistem");
}

session_unset();
session_destroy();
header("Location: ../index.php");
exit;
