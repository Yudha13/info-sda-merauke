<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../dashboard_content/loginadmin.php");
    exit();
}
// Handle Hapus Data Daerah
if (isset($_GET['hapus'])) {
    $id_daerah = $_GET['hapus'];
    // Validasi ID sebelum melakukan query
    if (is_numeric($id_daerah)) {
        mysqli_query($conn, "DELETE FROM data_daerah WHERE id_daerah=$id_daerah");
        header("Location: kelola_data_daerah.php"); // Redirect setelah hapus
        exit;
    }
}

// Pagination setup
$limit = 10;  // Jumlah data per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data daerah untuk ditampilkan
$query = "SELECT * FROM data_daerah LIMIT $limit OFFSET $offset";
$daerahs = mysqli_query($conn, $query);

// Menghitung jumlah total data
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_daerah");
$row = mysqli_fetch_assoc($result);
$total_data = $row['total'];
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Data Daerah</title>
    <link rel="stylesheet" href="../css/kelola_data_daerah.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
</head>
<body>

<div class="container_1">
  <h2>Daftar Data Daerah</h2>
  <div class="button-group1">
  <a href="data_daerah_form.php" class="tambah-button1">Tambah Data</a>
  <!-- Print Button -->
  <button onclick="printTable()" class="print-button1">Print Data</button>
  </div>
</div>

<!-- Tabel Daftar Daerah -->
<table class="data-daerah-table1" border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Daerah</th>
            <th>Luas Wilayah (km²)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no = $offset + 1;  // Penomoran dimulai dari 1 di setiap halaman
            while ($row = mysqli_fetch_assoc($daerahs)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_daerah']; ?></td>
                <td><?= number_format($row['luas_wilayah'], 0, ',', '.'); ?> km² </td>
                <td>
                    <a href="data_daerah_form.php?edit=<?= $row['id_daerah']; ?>" class="edit-button">Edit</a>
                    <a href="?hapus=<?= $row['id_daerah']; ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1) { ?>
        <a href="?page=<?= $page - 1; ?>">Previous</a>
    <?php } ?>
    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="?page=<?= $i; ?>" <?= ($i == $page) ? 'class="active"' : ''; ?>><?= $i; ?></a>
    <?php } ?>
    <?php if ($page < $total_pages) { ?>
        <a href="?page=<?= $page + 1; ?>">Next</a>
    <?php } ?>
</div>


<?php include '../includes/adminfooter.php'; ?>

<script>
feather.replace();
function printTable() {
    var printContent = document.querySelector('table').outerHTML;
    var newWindow = window.open('', '', 'height=600,width=800');
    newWindow.document.write('<html><head><title>Print Data Daerah</title>');
    newWindow.document.write('<style>body{font-family: Arial, sans-serif;}</style>');
    newWindow.document.write('</head><body>');
    newWindow.document.write(printContent);
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}
</script>

</body>
</html>
