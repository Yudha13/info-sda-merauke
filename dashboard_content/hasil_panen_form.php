<?php
include '../config.php';
include '../includes/adminsidebar.php';
include '../includes/adminheader.php';

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../dashboard_content/loginadmin.php");
    exit();
}

// Fungsi untuk konversi format angka
function formatAngka($angka) {
    // Hilangkan pemisah ribuan dan ubah koma menjadi titik
    return str_replace(',', '.', str_replace('.', '', $angka));
}

// Handle Hapus Hasil Panen
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM hasil_panen WHERE id_hasil_panen = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: kelola_hasil_panen.php");
    exit();
}

// Handle Tambah/Edit Hasil Panen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hasil_panen = isset($_POST['id_hasil_panen']) ? intval($_POST['id_hasil_panen']) : null;
    $id_jenis_panen = intval($_POST['id_jenis_panen']);
    $id_daerah = intval($_POST['id_daerah']);
    $tahun_panen = intval($_POST['tahun_panen']);
    $luas_lahan_panen = formatAngka($_POST['luas_lahan_panen']);
    $kuantitas = formatAngka($_POST['kuantitas']);
    

    // Validasi input angka
    if (!is_numeric($kuantitas) || !is_numeric($luas_lahan_panen)) {
        die("Input data tidak valid. Pastikan format angka sesuai.");
    }

    if (isset($_POST['tambah_hasil_panen'])) {
        // Tambah data baru
        $stmt = $conn->prepare("INSERT INTO hasil_panen (id_jenis_panen, id_daerah, tahun_panen, kuantitas, luas_lahan_panen) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidd", $id_jenis_panen, $id_daerah, $tahun_panen, $kuantitas, $luas_lahan_panen);
    } elseif (isset($_POST['edit_hasil_panen'])) {
        // Update data yang ada
        $stmt = $conn->prepare("UPDATE hasil_panen 
                                SET id_jenis_panen = ?, id_daerah = ?, tahun_panen = ?, kuantitas = ?, luas_lahan_panen = ? 
                                WHERE id_hasil_panen = ?");
        $stmt->bind_param("iiiddi", $id_jenis_panen, $id_daerah, $tahun_panen, $kuantitas, $luas_lahan_panen, $id_hasil_panen);
    }

    if (isset($stmt)) {
        $stmt->execute();
        $stmt->close();
    }

    header("Location: kelola_hasil_panen.php");
    exit();
}

// Ambil data untuk dropdown jenis_panen dan daerah
$jenis_panen = mysqli_query($conn, "SELECT * FROM jenis_panen");
$daerah = mysqli_query($conn, "SELECT * FROM data_daerah");

// Jika ingin mengedit data
$edit_hasil_panen = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT * FROM hasil_panen WHERE id_hasil_panen = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $edit_hasil_panen = $result->fetch_assoc();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Hasil Panen</title>
    <link rel="stylesheet" href="../css/form_hasil_panen.css">
    <link rel="stylesheet" href="../css/footeradmin.css">
    <link rel="stylesheet" href="../css/sidebaradmin.css">
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <h2><?= $edit_hasil_panen ? 'Edit Hasil Panen' : 'Tambah Hasil Panen'; ?></h2>

    <form method="POST">
        <input type="hidden" name="id_hasil_panen" value="<?= $edit_hasil_panen['id_hasil_panen'] ?? ''; ?>">

        <!-- Dropdown Jenis Panen -->
        <label for="id_jenis_panen">Jenis Panen:</label>
        <select name="id_jenis_panen" required>
            <option value="">Pilih Jenis Panen</option>
            <?php while ($row = mysqli_fetch_assoc($jenis_panen)) : ?>
                <option value="<?= $row['id_jenis_panen']; ?>" 
                    <?= isset($edit_hasil_panen) && $edit_hasil_panen['id_jenis_panen'] == $row['id_jenis_panen'] ? 'selected' : ''; ?>>
                    <?= $row['nama_jenis_panen']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Dropdown Daerah -->
        <label for="id_daerah">Daerah:</label>
        <select name="id_daerah" required>
            <option value="">Pilih Daerah</option>
            <?php while ($row = mysqli_fetch_assoc($daerah)) : ?>
                <option value="<?= $row['id_daerah']; ?>" 
                    <?= isset($edit_hasil_panen) && $edit_hasil_panen['id_daerah'] == $row['id_daerah'] ? 'selected' : ''; ?>>
                    <?= $row['nama_daerah']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Input Tahun Panen -->
        <label for="tahun_panen">Tahun Panen:</label>
        <input type="number" name="tahun_panen" min="2000" max="2100" value="<?= $edit_hasil_panen['tahun_panen'] ?? ''; ?>" required>
 
        <!-- Input Luas Lahan Panen--> 
        <label for="luas_lahan_panen">Luas Lahan Panen (ha):</label>
        <input type="text" name="luas_lahan_panen" value="<?= isset($edit_hasil_panen) ? number_format($edit_hasil_panen['luas_lahan_panen'], 2, ',', '.') : ''; ?>" required>

        <!-- Input Kuantitas -->
        <label for="kuantitas">Produksi (ton):</label>
        <input type="text" name="kuantitas" value="<?= isset($edit_hasil_panen) ? number_format($edit_hasil_panen['kuantitas'], 2, ',', '.') : ''; ?>" required>
  
        <!-- Tombol Submit -->
        <div class="form-buttons">
            <button type="submit" name="<?= isset($edit_hasil_panen) ? 'edit_hasil_panen' : 'tambah_hasil_panen'; ?>">
                <?= isset($edit_hasil_panen) ? 'Simpan Perubahan' : 'Tambah Hasil Panen'; ?>
            </button>
            <a href="kelola_hasil_panen.php" class="cancel-button">Cancel</a>
        </div>
    </form>

    <?php include '../includes/adminfooter.php'; ?>
</body>
</html>
