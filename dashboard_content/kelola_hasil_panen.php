<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../dashboard_content/loginadmin.php");
    exit();
}

// Handle Hapus Data
if (isset($_GET['hapus'])) {
    $id_hasil_panen = $_GET['hapus'];
    if (is_numeric($id_hasil_panen)) {
        $delete_query = "DELETE FROM hasil_panen WHERE id_hasil_panen = ?";
        $stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($stmt, "i", $id_hasil_panen);
        mysqli_stmt_execute($stmt);
        header("Location: kelola_hasil_panen.php");
        exit();
    }
}

// Konfigurasi Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting
$allowed_columns = ['nama_jenis_panen', 'nama_daerah', 'tahun_panen', 'luas_lahan_panen', 'kuantitas'];
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_columns) ? $_GET['sort'] : 'tahun_panen';
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'ASC' : 'DESC';

// Hitung Total Data
$total_query = "SELECT COUNT(*) AS total FROM hasil_panen";
$total_result = mysqli_query($conn, $total_query);
$total_data = mysqli_fetch_assoc($total_result)['total'];

// Hitung Total Halaman
$total_pages = ceil($total_data / $limit);

// Ambil Data Hasil Panen
$data_query = "
    SELECT hasil_panen.*, jenis_panen.nama_jenis_panen, data_daerah.nama_daerah
    FROM hasil_panen
    JOIN jenis_panen ON hasil_panen.id_jenis_panen = jenis_panen.id_jenis_panen
    JOIN data_daerah ON hasil_panen.id_daerah = data_daerah.id_daerah
    ORDER BY $sort_column $order
    LIMIT ? OFFSET ?
";
$stmt = mysqli_prepare($conn, $data_query);
mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Hasil Panen</title>
    <link rel="stylesheet" href="../css/kelola_hasil_panen.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
<div class="container_3">
    <h2>Daftar Hasil Panen</h2>
    <div class="button-group3">
        <a href="hasil_panen_form.php" class="tambah-button3">Tambah Data</a>
        <button onclick="printTable()" class="print-button3">Print Data</button>
    </div>
</div>

<!-- Tabel Data -->
<table class="tabelhasilpanen" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>
                Jenis Panen
                <a href="?sort=nama_jenis_panen&order=asc" class="sort-icon"><i class="fa fa-arrow-up"></i></a>
                <a href="?sort=nama_jenis_panen&order=desc" class="sort-icon"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>
                Daerah
                <a href="?sort=nama_daerah&order=asc" class="sort-icon"><i class="fa fa-arrow-up"></i></a>
                <a href="?sort=nama_daerah&order=desc" class="sort-icon"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>
                Tahun Panen
                <a href="?sort=tahun_panen&order=asc" class="sort-icon"><i class="fa fa-arrow-up"></i></a>
                <a href="?sort=tahun_panen&order=desc" class="sort-icon"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>
                Luas Lahan Panen (ha)
                <a href="?sort=luas_lahan_panen&order=asc" class="sort-icon"><i class="fa fa-arrow-up"></i></a>
                <a href="?sort=luas_lahan_panen&order=desc" class="sort-icon"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>
                Produksi (ton)
                <a href="?sort=kuantitas&order=asc" class="sort-icon"><i class="fa fa-arrow-up"></i></a>
                <a href="?sort=kuantitas&order=desc" class="sort-icon"><i class="fa fa-arrow-down"></i></a>
            </th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $nomor = $offset + 1;
        while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= htmlspecialchars($row['nama_jenis_panen']); ?></td>
            <td><?= htmlspecialchars($row['nama_daerah']); ?></td>
            <td><?= htmlspecialchars($row['tahun_panen']); ?></td>
            <td><?= number_format($row['luas_lahan_panen'], 2, ',', '.'); ?> ha</td>
            <td><?= number_format($row['kuantitas'], 2, ',', '.'); ?> ton</td>
            
            <td>
                <a href="hasil_panen_form.php?edit=<?= $row['id_hasil_panen']; ?>" class="edit-button">Edit</a>
                <a href="?hapus=<?= $row['id_hasil_panen']; ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1; ?>&sort=<?= $sort_column; ?>&order=<?= strtolower($order); ?>">&laquo; Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i; ?>&sort=<?= $sort_column; ?>&order=<?= strtolower($order); ?>" class="<?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1; ?>&sort=<?= $sort_column; ?>&order=<?= strtolower($order); ?>">Next &raquo;</a>
    <?php endif; ?>
</div>

<?php include '../includes/adminfooter.php'; ?>
<script>
feather.replace();

function printTable() {
    var printContent = document.querySelector('table').outerHTML;
    var newWindow = window.open('', '', 'height=600,width=800');
    newWindow.document.write('<html><head><title>Print Data</title></head><body>');
    newWindow.document.write(printContent);
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}
</script>
</body>
</html>