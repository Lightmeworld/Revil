<?php
require_once '../config/database.php';
session_start();
if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}
$u = mysqli_query($conn,"SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data User</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-container">
    <h2 class="section-title">Data User</h2>
    <table class="table">
        <tr>
            <th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Tanggal Daftar</th>
        </tr>
        <p style="margin-top:20px;"><a href="../admin/index.php" class="btn-outline">Kembali ke Dashboard</a></p>
        <br>
        <?php while($x = mysqli_fetch_assoc($u)): ?>
        <tr>
            <td><?php echo $x['id_user']; ?></td>
            <td><?php echo htmlspecialchars($x['nama']); ?></td>
            <td><?php echo htmlspecialchars($x['email']); ?></td>
            <td><?php echo $x['role']; ?></td>
            <td><?php echo $x['created_at']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    
</div>
</body>
</html>
