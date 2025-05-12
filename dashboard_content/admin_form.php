<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';


// Handle Tambah Admin
if (isset($_POST['tambah_admin'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO admin (nama_lengkap, username, password) VALUES ('$nama_lengkap', '$username', '$password')";
    mysqli_query($conn, $sql);
    header("Location: admin_list.php");
    exit;
}

// Handle Edit Admin
if (isset($_POST['edit_admin'])) {
    $id = $_POST['id'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];

    // Cek apakah password diisi atau tidak
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE admin SET nama_lengkap='$nama_lengkap', username='$username', password='$password' WHERE id_admin=$id";
    } else {
        $sql = "UPDATE admin SET nama_lengkap='$nama_lengkap', username='$username' WHERE id_admin=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: admin_list.php");
    exit;
}

// Jika ingin mengedit data
$edit_admin = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    if (is_numeric($id)) {
        $result = mysqli_query($conn, "SELECT * FROM admin WHERE id_admin=$id");
        $edit_admin = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Admin</title>
    <link rel="stylesheet" href="../css/admin_form.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
</head>
<body>

<h2><?= $edit_admin ? 'Edit Admin' : 'Tambah Admin'; ?></h2>

<!-- Form Tambah/Edit Admin -->
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_admin ? $edit_admin['id_admin'] : ''; ?>">
    <input autocomplete="off" type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= $edit_admin ? $edit_admin['nama_lengkap'] : ''; ?>" required>
    <input autocomplete="off" type="text" name="username" placeholder="Username" value="<?= $edit_admin ? $edit_admin['username'] : ''; ?>" required>
    
    <!-- Kolom Password hanya wajib diisi saat menambah admin baru -->
    <input type="password" name="password" placeholder="Password" <?= $edit_admin ? '' : 'required'; ?>>

    <p><?= $edit_admin ? 'Kosongkan password jika tidak ingin mengubahnya.' : ''; ?></p>

    <button type="submit" name="<?= $edit_admin ? 'edit_admin' : 'tambah_admin'; ?>">
        <?= $edit_admin ? 'Simpan Perubahan' : 'Tambah Admin'; ?>
    </button>

    <!-- Tombol Batal dengan JavaScript -->
    <button type="button" class="back-button" onclick="window.location.href='admin_list.php';">Batal</button>
</form>
<?php include '../includes/adminfooter.php'; ?>
</body>
</html>

