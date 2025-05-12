<?php
include 'config.php';

if (isset($_GET['data_daerah']) && isset($_GET['tahun_panen'])) {
    $data_daerah = $_GET['daerah'];
    $tahun_panen = $_GET['tahun_panen'];

    // Query untuk menampilkan jenis panen berdasarkan daerah dan tahun panen yang dipilih
    $query = "SELECT DISTINCT jp.id_jenis_panen, jp.nama_jenis_panen 
              FROM hasil_panen hp
              JOIN jenis_panen jp ON hp.id_jenis_panen = jp.id_jenis_panen
              WHERE hp.id_daerah = ? AND hp.tahun_panen = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $data_daerah, $tahun_panen);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Pilih Jenis Panen</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_jenis_panen'] . "'>" . $row['nama_jenis_panen'] . "</option>";
    }
}
?>
