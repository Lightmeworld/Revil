<?php
require_once "../config/database.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: vila_list.php");
    exit;
}

$id_vila = (int) $_GET['id'];

// Ambil data vila
$vila = mysqli_query($conn, "SELECT * FROM vila WHERE id_vila = $id_vila");
$dataVila = mysqli_fetch_assoc($vila);

if (!$dataVila) {
    echo "Vila tidak ditemukan";
    exit;
}

// Ambil gambar vila
$gambar = mysqli_query($conn, "
    SELECT * FROM vila_gambar 
    WHERE id_vila = $id_vila
");
if (isset($_POST['upload'])) {

    $allowed = ['jpg','jpeg','png'];
    $folder  = "../assets/img/";

    foreach ($_FILES['gambar']['name'] as $i => $namaFile) {

        $tmpFile = $_FILES['gambar']['tmp_name'][$i];
        $ext     = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        // Validasi ekstensi
        if (!in_array($ext, $allowed)) {
            continue;
        }

        // Nama file unik
        $namaBaru = uniqid("vila_", true) . "." . $ext;

        // Pindahkan file
        move_uploaded_file($tmpFile, $folder . $namaBaru);

        // Simpan ke database
        mysqli_query($conn, "
            INSERT INTO vila_gambar (id_vila, nama_file)
            VALUES ($id_vila, '$namaBaru')
        ");
    }

    // Refresh halaman
    header("Location: vila_galeri.php?id=$id_vila");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Galeri Vila</title>
<link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="main-container">

    <h2 class="section-title">
        Galeri Vila: <?= htmlspecialchars($dataVila['nama_vila']); ?>
    </h2>

    <!-- UPLOAD SECTION -->
    <div class="galeri-upload-top">
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="gambar[]" multiple required>
            <button type="submit" name="upload" class="btn-primary">
                + Tambah Gambar
            </button>
        </form>
    </div>

    <!-- GRID GALERI -->
    <div class="galeri-grid">
        <?php while ($g = mysqli_fetch_assoc($gambar)) : ?>
            <div class="galeri-item">
                <img src="../assets/img/<?= $g['nama_file']; ?>" alt="">
                <a href="vila_gambar_delete.php?id=<?= $g['id_gambar']; ?>&vila=<?= $id_vila; ?>"
                   onclick="return confirm('Hapus gambar ini?')"
                   class="btn-delete">
                    Hapus
                </a>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- KEMBALI -->
    <div class="galeri-footer">
        <a href="vila_list.php" class="btn-outline">
            Kembali ke List
        </a>
    </div>

</div>


</body>
</html>
