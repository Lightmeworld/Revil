<?php
require_once "../config/database.php"; 
session_start();

// Cek apakah user admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$msg = "";

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {

    $nama_vila  = mysqli_real_escape_string($conn, $_POST['nama_vila']);
    $lokasi     = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $harga      = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $fasilitas  = mysqli_real_escape_string($conn, $_POST['fasilitas']);
    $rating     = mysqli_real_escape_string($conn, $_POST['rating']);
    $latitude   = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude  = mysqli_real_escape_string($conn, $_POST['longitude']);

    // --- Upload Gambar ---
    $namaFile = $_FILES['gambar']['name'];
    $tmpFile  = $_FILES['gambar']['tmp_name'];

    // Validasi ekstensi
    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $msg = "Format gambar wajib JPG/PNG.";
    } else {
        // Folder penyimpanan
        $folder = "../assets/img/";

        // Generate nama unik
        $namaBaru = time() . "_" . $namaFile;

        // Pindahkan file
        move_uploaded_file($tmpFile, $folder . $namaBaru);

        // Simpan ke database
        $query = "
        INSERT INTO vila (nama_vila, lokasi, harga, deskripsi, fasilitas, rating, latitude, longitude, gambar)
        VALUES ('$nama_vila', '$lokasi', '$harga', '$deskripsi', '$fasilitas', '$rating', '$latitude', '$longitude', '$namaBaru')
        ";

        

        if (mysqli_query($conn, $query)) {
            // ambil id vila baru
            $id_vila = mysqli_insert_id($conn);

            // masukkan cover ke galeri (1x saja)
            mysqli_query($conn, "
                INSERT INTO vila_gambar (id_vila, nama_file)
                VALUES ('$id_vila', '$namaBaru')
            ");

            logAktivitas($conn, $_SESSION['id_user'], "Menambah vila: $nama_vila");
            header("Location: vila_list.php?success=1");
            exit;
        }else {
            $msg = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Vila</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="vila-add-container">
    <h2 class="section-title">Tambah Vila Baru</h2>

    <div class="form-card">
        <?php if ($msg): ?>
            <p style="color:#fca5a5; font-size:0.85rem;"><?= $msg ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Vila</label>
                <input type="text" name="nama_vila" required>
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" required>
            </div>

            <div class="form-group">
                <label>Harga per Malam</label>
                <input type="number" name="harga" required>
            </div>

            <div class="form-group">
                <label>Rating</label>
                <input type="number" name="rating" step="0.1" max="5" min="1" required>
            </div>

            <div class="form-group">
                <label>Fasilitas</label>
                <textarea name="fasilitas" required></textarea>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" required></textarea>
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="number" name="latitude" step="any" required>
            </div>

            <div class="form-group">
                <label>Longitude</label>
                <input type="number" name="longitude" step="any" required>
            </div>

            <div class="form-group">
                <label>Gambar Vila</label>
                <input type="file" name="gambar" required>
            </div>

            <button type="submit" name="submit" class="btn-primary">Simpan</button>
            <a href="vila_list.php" class="btn-secondary">Kembali</a>

        </form>
        
    </div>
    <p style="margin-top:20px;"><a href="../admin/vila_list.php" class="btn-outline">Kembali ke List</a></p>
</div>

</body>
</html>
