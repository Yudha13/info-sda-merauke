<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';


// Handle Hapus Admin
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (is_numeric($id)) {
        mysqli_query($conn, "DELETE FROM admin WHERE id_admin=$id");
        header("Location: admin_list.php");
        exit;
    }
}

// Ambil data admin untuk ditampilkan
$admins = mysqli_query($conn, "SELECT * FROM admin");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
    <link rel="stylesheet" href="../css/admin_list.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
</head>
<body>

        <h2>Daftar Admin</h2>
        <div classs="buttontambah">
        <a href="admin_form.php" class="add-button">Tambah Admin</a>
        </div>
    <!-- Tabel Daftar Admin -->
    <table border="1">
        <tr>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($admins)) { ?>
        <tr>
            <td><?= $row['nama_lengkap']; ?></td>
            <td><?= $row['username']; ?></td>
            <td>
                <a href="admin_form.php?edit=<?= $row['id_admin']; ?>" class="edit-button">Edit</a>
                <a href="admin_list.php?hapus=<?= $row['id_admin']; ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php include '../includes/adminfooter.php'; ?>
</body>
</html>
