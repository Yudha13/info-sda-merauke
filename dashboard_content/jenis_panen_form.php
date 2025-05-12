<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../dashboard_content/loginadmin.php");
    exit();
}
// Variabel untuk menyimpan pesan error/sukses
$msg = '';

// Cek jika ada ID untuk edit
if (isset($_GET['edit'])) {
    $id_jenis_panen = $_GET['edit'];
    $query = "SELECT * FROM jenis_panen WHERE id_jenis_panen = $id_jenis_panen";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        // Jika data tidak ditemukan
        $msg = "Jenis Panen tidak ditemukan.";
    }
}

// Proses form saat disubmit (Tambah/Edit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_jenis_panen = mysqli_real_escape_string($conn, $_POST['nama_jenis_panen']);

    if (isset($_GET['edit'])) {
        // Edit data
        $id_jenis_panen = $_GET['edit'];
        $query = "UPDATE jenis_panen SET nama_jenis_panen = '$nama_jenis_panen' WHERE id_jenis_panen = $id_jenis_panen";
        if (mysqli_query($conn, $query)) {
            $msg = "Jenis Panen berhasil diperbarui.";
            header("Location: kelola_jenis_panen.php"); // Redirect ke halaman CRUD setelah berhasil
            exit;
        } else {
            $msg = "Gagal memperbarui data.";
        }
    } else {
        // Tambah data
        $query = "INSERT INTO jenis_panen (nama_jenis_panen) VALUES ('$nama_jenis_panen')";
        if (mysqli_query($conn, $query)) {
            $msg = "Jenis Panen berhasil ditambahkan.";
            header("Location: kelola_jenis_panen.php"); // Redirect ke halaman CRUD setelah berhasil
            exit;
        } else {
            $msg = "Gagal menambahkan data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Jenis Panen</title>
    <link rel="stylesheet" href="../css/form_jenis_panen.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

<h2><?= isset($_GET['edit']) ? "Edit" : "Tambah" ?> Jenis Panen</h2>

<!-- Pesan jika ada error atau sukses -->
<?php if ($msg) { ?>
    <div class="message"><?= $msg; ?></div>
<?php } ?>

<!-- Form untuk menambah atau mengedit data -->
<form method="POST" action="">
    <label for="nama_jenis_panen">Nama Jenis Panen:</label>
    <input autocomplete="off" type="text" id="nama_jenis_panen" name="nama_jenis_panen" value="<?= isset($data['nama_jenis_panen']) ? $data['nama_jenis_panen'] : ''; ?>" required>
    <button type="submit" class="tambah-button"><?= isset($_GET['edit']) ? "Update" : "Tambah" ?> Jenis Panen</button>
    <a href="kelola_jenis_panen.php" class="cancel-button">Cancel</a>

</form>

<?php include '../includes/adminfooter.php'; ?>

<script> 
    feather.replace(); 
</script>

</body>
</html>
