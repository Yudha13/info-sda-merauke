<?php
include 'config.php';

if (isset($_GET['jenis_panen']) && isset($_GET['tahun_panen'])) {
    $jenis_panen = $_GET['jenis_panen'];
    $tahun_panen = $_GET['tahun_panen'];

    // Query untuk menampilkan daerah berdasarkan jenis panen dan tahun panen yang dipilih
    $query = "SELECT DISTINCT d.id_daerah, d.nama_daerah 
              FROM hasil_panen hp
              JOIN data_daerah d ON hp.id_daerah = d.id_daerah
              WHERE hp.id_jenis_panen = ? AND hp.tahun_panen = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $jenis_panen, $tahun_panen);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Pilih Daerah</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_daerah'] . "'>" . $row['nama_daerah'] . "</option>";
    }
}
?>
