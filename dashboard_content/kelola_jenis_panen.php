<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../dashboard_content/loginadmin.php");
    exit();
}
// Handle Hapus Jenis Panen
if (isset($_GET['hapus'])) {
    $id_jenis_panen = $_GET['hapus'];
    // Validasi ID sebelum melakukan query
    if (is_numeric($id_jenis_panen)) {
        mysqli_query($conn, "DELETE FROM jenis_panen WHERE id_jenis_panen=$id_jenis_panen");
        header("Location: kelola_jenis_panen.php"); // Redirect setelah hapus
        exit;
    }
}

// Pagination setup
$limit = 10;  // Jumlah data per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data jenis panen untuk ditampilkan
$query = "SELECT * FROM jenis_panen LIMIT $limit OFFSET $offset";
$jenis_panen = mysqli_query($conn, $query);

// Menghitung jumlah total data
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM jenis_panen");
$row = mysqli_fetch_assoc($result);
$total_data = $row['total'];
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/kelola_jenis_panen.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

<div class="container_2">
  <h2>Daftar Jenis Panen</h2>
  <div class="button-group2">
  <a href="jenis_panen_form.php" class="tambah-button2">Tambah Data</a>
  <!-- Print Button -->
  <button onclick="printTable()" class="print-button2">Print Data</button>
  </div>
</div>
<!-- Tabel Daftar Jenis Panen -->
<table class="data-panen-table" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Jenis Panen</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no = $offset + 1;  // Penomoran dimulai dari nomor urut sesuai halaman
            while ($row = mysqli_fetch_assoc($jenis_panen)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_jenis_panen']; ?></td>
                <td>
                    <a href="jenis_panen_form.php?edit=<?= $row['id_jenis_panen']; ?>" class="edit-button">Edit</a>
                    <a href="?hapus=<?= $row['id_jenis_panen']; ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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

    // Fungsi Print Tabel
    function printTable() {
        var printContent = document.querySelector('table').outerHTML;
        var newWindow = window.open('', '', 'height=600,width=800');
        newWindow.document.write('<html><head><title>Print Data Jenis Panen</title>');
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
