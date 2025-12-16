<?php
require_once "../config/database.php";
session_start();

// Cek admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Cek ID vila
if (!isset($_GET['id'])) {
    header("Location: vila_list.php");
    exit;
}

$id = $_GET['id'];

// Ambil data vila dari database
$q = mysqli_query($conn, "SELECT * FROM vila WHERE id_vila = '$id'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "Data vila tidak ditemukan";
    exit;
}

$msg = "";

// Jika form disubmit
if (isset($_POST['submit'])) {

    $nama_vila  = mysqli_real_escape_string($conn, $_POST['nama_vila']);
    $lokasi     = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $harga      = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $fasilitas  = mysqli_real_escape_string($conn, $_POST['fasilitas']);
    $rating     = mysqli_real_escape_string($conn, $_POST['rating']);
    $latitude   = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude  = mysqli_real_escape_string($conn, $_POST['longitude']);

    // -------------------------
    // CEK APAKAH GANTI GAMBAR
    // -------------------------
    $gambarBaru = $data['gambar']; // default: gambar lama

    if (!empty($_FILES['gambar']['name'])) {

    $namaFile = $_FILES['gambar']['name'];
    $tmpFile  = $_FILES['gambar']['tmp_name'];

    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {

        $folder = "../assets/img/";
        $namaBaru = time() . "_" . $namaFile;

        move_uploaded_file($tmpFile, $folder . $namaBaru);

        // hapus cover lama
        if ($data['gambar'] && file_exists($folder . $data['gambar'])) {
            unlink($folder . $data['gambar']);
        }

        // update cover
        $gambarBaru = $namaBaru;

        // 🔥 UPDATE GAMBAR PERTAMA DI GALERI
        mysqli_query($conn, "
            UPDATE vila_gambar
            SET nama_file = '$namaBaru'
            WHERE id_vila = '$id'
            ORDER BY id_gambar ASC
            LIMIT 1
        ");
    }
}


    // -------------------------
    // UPDATE DATABASE
    // -------------------------
    $update = mysqli_query($conn, "
        UPDATE vila SET
            nama_vila = '$nama_vila',
            lokasi = '$lokasi',
            harga = '$harga',
            deskripsi = '$deskripsi',
            fasilitas = '$fasilitas',
            rating = '$rating',
            latitude = '$latitude',
            longitude = '$longitude',
            gambar = '$gambarBaru'
        WHERE id_vila = '$id'
    ");
    logAktivitas($conn, $_SESSION['id_user'], "Mengedit vila: $nama_vila (ID: $id_vila)");


    if ($update) {
        logAktivitas($conn, $_SESSION['id_user'], "Mengedit vila: $nama_vila (ID: $id)");
        header("Location: vila_list.php?updated=1");
        
        exit;
        

    } else {
        $msg = "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Vila</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<!-- <br>
<br>
<br> -->
<div class="vila-edit-container">
    <h2 class="section-title">Edit Vila: <?= $data['nama_vila'] ?></h2>

    <div class="form-card">
        <?php if ($msg): ?>
            <p style="color:#fca5a5;"><?= $msg ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Vila</label>
                <input type="text" name="nama_vila" value="<?= $data['nama_vila'] ?>" required>
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" value="<?= $data['lokasi'] ?>" required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
            </div>

            <div class="form-group">
                <label>Rating</label>
                <input type="number" step="0.1" max="5" min="1" name="rating" value="<?= $data['rating'] ?>" required>
            </div>

            <div class="form-group">
                <label>Fasilitas</label>
                <textarea name="fasilitas" required><?= $data['fasilitas'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" required><?= $data['deskripsi'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Latitude</label>
                <input type="number" name="latitude" step="any" value="<?= $data['latitude']; ?>" required>
            </div>


            <div class="form-group">
                <label>Longitude</label>
                <input type="number" name="longitude" step="any" value="<?= $data['longitude']; ?>" required>
            </div>


            <div class="form-group">
                <label>Gambar Saat Ini</label><br>
                <img src="../assets/img/<?= $data['gambar'] ?>" width="220" style="border-radius:6px;">
            </div>

            <div class="form-group">
                <label>Ganti Gambar (Opsional)</label>
                <input type="file" name="gambar">
                <small style="font-size:0.8rem;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>

            <button type="submit" name="submit" class="btn-primary">Update</button>
            <a href="vila_list.php" class="btn-secondary">Kembali</a>

        </form>
    </div>
    <p style="margin-top:20px;"><a href="../admin/vila_list.php" class="btn-outline">Kembali ke List</a></p>
</div>

</body>
</html>
