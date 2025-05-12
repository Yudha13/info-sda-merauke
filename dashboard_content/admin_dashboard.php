<?php
session_start(); // Tambahkan session_start() di sini
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';



// Cek apakah user sudah login atau belum
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Jika belum login, arahkan kembali ke halaman login
    header("Location: ../dashboard_content/loginadmin.php");
    exit();
}
// Query untuk menghitung jumlah sumber daya per daerah
$sql = "SELECT d.nama_daerah, COUNT(h.id_hasil_panen) AS jumlah_sumber_daya
        FROM hasil_panen h
        JOIN data_daerah d ON h.id_daerah = d.id_daerah
        GROUP BY d.nama_daerah
        ORDER BY jumlah_sumber_daya DESC
        LIMIT 20";
$result = mysqli_query($conn, $sql);

// Query untuk menghitung jumlah data di setiap tabel
$query_daerah = "SELECT COUNT(*) AS total_daerah FROM data_daerah";
$result_daerah = $conn->query($query_daerah);
$total_daerah = $result_daerah->fetch_assoc()['total_daerah'];

$query_jenis_panen = "SELECT COUNT(*) AS total_jenis_panen FROM jenis_panen";
$result_jenis_panen = $conn->query($query_jenis_panen);
$total_jenis_panen = $result_jenis_panen->fetch_assoc()['total_jenis_panen'];

$query_hasil_panen = "SELECT COUNT(*) AS total_hasil_panen FROM hasil_panen";
$result_hasil_panen = $conn->query($query_hasil_panen);
$total_hasil_panen = $result_hasil_panen->fetch_assoc()['total_hasil_panen'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<header> 
    <div class="dashboard">
                <div class="dashboard-card" id="cardboard1">
                        <img class="logos" src="../img/daerah.png" alt="Data Daerah" />
                            <div class="text-content">
                                <h3>Data Daerah</h3>
                                <p><?php echo $total_daerah; ?> Daerah</p>
                            </div>
                    </div>
                    <div class="dashboard-card" id="cardboard2">
                        <img class="logos" src="../img/panen.png" alt="Jenis Panen" />
                            <div class="text-content">
                                <h3>Jenis Panen</h3>
                                <p><?php echo $total_jenis_panen; ?> Jenis Panen</p>
                            </div>
                    </div>
                    <div class="dashboard-card" id="cardboard3">
                        <img class="logos" src="../img/hasil_panen.png" alt="Hasil Panen" />
                            <div class="text-content">
                                <h3>Hasil Panen</h3>
                                <p><?php echo $total_hasil_panen; ?> Hasil Panen</p>
                            </div>
                </div>
            </div>    
    </header>
<section class="toptop">
    <h3>Daerah dengan Sumber Daya Terbanyak</h3>
    <div class="scrollable-table">
        
        <table>
            <thead>
                <tr>
                    <th>Daerah</th>
                    <th>Jumlah Sumber Daya</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['nama_daerah']; ?></td>
                    <td><?php echo $row['jumlah_sumber_daya']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
        <?php
        include '../includes/adminfooter.php';
        ?>
<script> feather.replace(); </script>
    </section>
</html>
