<?php
include 'config.php';

if (isset($_GET['daerah']) && isset($_GET['jenis_panen'])) {
    $data_daerah = $_GET['daerah'];
    $jenis_panen = $_GET['jenis_panen'];

    // Query untuk menampilkan tahun panen berdasarkan daerah dan jenis panen yang dipilih
    $query = "SELECT DISTINCT hp.tahun_panen 
              FROM hasil_panen hp
              WHERE hp.id_daerah = ? AND hp.id_jenis_panen = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $data_daerah, $jenis_panen);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Pilih Tahun</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['tahun_panen'] . "'>" . $row['tahun_panen'] . "</option>";
    }
}
?>
