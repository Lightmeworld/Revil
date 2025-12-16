<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sewa_vila";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function logAktivitas($conn, $id_user, $aktivitas) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $agent = $_SERVER['HTTP_USER_AGENT'];

    $id_user = intval($id_user);
    $aktivitas = mysqli_real_escape_string($conn, $aktivitas);

    mysqli_query($conn, 
        "INSERT INTO log_aktivitas (id_user, aktivitas, ip_address, user_agent)
         VALUES ($id_user, '$aktivitas', '$ip', '$agent')");
}

function getRekomendasi($conn, $id_user) {
    // Cari lokasi yang paling sering dipilih user
    $lokasiFav = mysqli_query($conn,
        "SELECT lokasi, COUNT(*) AS total 
         FROM booking 
         JOIN vila ON vila.id_vila = booking.id_vila
         WHERE id_user = $id_user
         GROUP BY lokasi
         ORDER BY total DESC
         LIMIT 1"
    );

    if ($lokasiFav && mysqli_num_rows($lokasiFav) > 0) {
        $lokasi = mysqli_fetch_assoc($lokasiFav)['lokasi'];

        // Ambil vila sesuai lokasi favorit
        return mysqli_query($conn,
            "SELECT * FROM vila 
             WHERE lokasi = '$lokasi'
             ORDER BY rating DESC
             LIMIT 3"
        );
    }

    // Jika user belum pernah booking → fallback rekomendasi: rating tertinggi
    return mysqli_query($conn,
        "SELECT * FROM vila ORDER BY rating DESC LIMIT 3"
    );
}

?>
