<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../dashboard_content/loginadmin.php");
    exit();
}
$edit_mode = false;
$nama_daerah = '';
$luas_wilayah = '';


// Jika ada parameter 'edit', kita akan mengambil data untuk diedit
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id_daerah = $_GET['edit'];

    // Validasi ID sebelum melakukan query
    if (is_numeric($id_daerah)) {
        $result = mysqli_query($conn, "SELECT * FROM data_daerah WHERE id_daerah=$id_daerah");
        $edit_daerah = mysqli_fetch_assoc($result);

        // Jika data ditemukan, simpan nilai ke variabel
        if ($edit_daerah) {
            $nama_daerah = $edit_daerah['nama_daerah'];
            $luas_wilayah = number_format($edit_daerah['luas_wilayah'], 0, ',', '.');
        }
    }
}

// Handle form submit (baik untuk tambah atau edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_daerah = $_POST['nama_daerah'];
    
    // Hapus pemisah ribuan pada luas wilayah
    $luas_wilayah = str_replace('.', '', $_POST['luas_wilayah']);

    // Jika sedang dalam mode edit, update data
    if (isset($_POST['id_daerah'])) {
        $id_daerah = $_POST['id_daerah'];
        $sql = "UPDATE data_daerah SET nama_daerah='$nama_daerah', luas_wilayah='$luas_wilayah', WHERE id_daerah=$id_daerah";
        mysqli_query($conn, $sql);
    } 
    // Jika tambah data baru
    else {
        $sql = "INSERT INTO data_daerah (nama_daerah, luas_wilayah) VALUES ('$nama_daerah', '$luas_wilayah')";
        mysqli_query($conn, $sql);
    }

    // Redirect kembali ke halaman tabel setelah submit
    header("Location: kelola_data_daerah.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edit_mode ? 'Edit' : 'Tambah'; ?> Data Daerah</title>
    <link rel="stylesheet" href="../css/data_daerah_form.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
</head>
<body>
<h2><?= $edit_mode ? 'Edit' : 'Tambah'; ?> Data Daerah</h2>

<!-- Form Tambah/Edit Daerah -->
<form method="POST">
    <?php if ($edit_mode): ?>
        <input type="hidden" name="id_daerah" value="<?= $id_daerah; ?>">
    <?php endif; ?>
    
    <label for="nama_daerah">Nama Daerah:</label>
    <input type="text" autocomplete="off" name="nama_daerah" placeholder="Nama Daerah" value="<?= $nama_daerah; ?>" required>
    
    <label for="luas_wilayah">Luas Wilayah (km²):</label>
    <input type="text" autocomplete="off" name="luas_wilayah" placeholder="Luas Wilayah" value="<?= $luas_wilayah; ?>" required>
    

    <button type="submit"><?= $edit_mode ? 'Simpan Perubahan' : 'Tambah Daerah'; ?></button>
    
    <!-- Tombol Cancel -->
    <a href="kelola_data_daerah.php" class="cancel-button">Cancel</a>
</form>

<?php include '../includes/adminfooter.php'; ?>

</body>
</html>
