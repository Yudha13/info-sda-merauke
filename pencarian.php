<?php
include 'config.php';
include 'includes/header.php';

// Ambil data dari database untuk dropdown
$daerah_result = mysqli_query($conn, "SELECT * FROM data_daerah");
$jenis_panen_result = mysqli_query($conn, "SELECT * FROM jenis_panen");
// Mengambil tahun saja, pastikan tahun_panen disimpan dalam format tahun (4 digit)
$tahun_panen_result = mysqli_query($conn, "SELECT DISTINCT YEAR(tahun_panen) AS tahun FROM hasil_panen");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEM INFORMASI PENCARIAN DATA</title>
    <link rel="stylesheet" href="css/pencariannew.css">
    <link rel="stylesheet" href="css/index_footer.css">
    <link rel="stylesheet" href="css/index_header.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>
<section>
    <main class="search-container">
        
        <h1 class="search-title">Pencarian Data Hasil Panen</h1>
        <h4>Kosongkan filter pencarian untuk memunculkan semua data</h4>

        <form class="search-form" action="pencarian.php" method="GET">
            <!-- Dropdown Nama Daerah -->
            <div class="form-group">
                <label for="nama_daerah" class="form-label">Nama Daerah:</label>
                <select id="nama_daerah" name="nama_daerah" class="form-input" title="Pilih nama daerah dari daftar yang tersedia.">
                    <option value="">Pilih Daerah</option>
                    <?php while ($row = mysqli_fetch_assoc($daerah_result)) { ?>
                        <option value="<?= $row['id_daerah']; ?>"><?= $row['nama_daerah']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Dropdown Jenis Panen -->
            <div class="form-group">
                <label for="jenis_panen" class="form-label">Jenis Panen:</label>
                <select id="jenis_panen" name="jenis_panen" class="form-input" title="Pilih jenis panen yang diinginkan.">
                    <option value="">Pilih Jenis Panen</option>
                    <?php while ($row = mysqli_fetch_assoc($jenis_panen_result)) { ?>
                        <option value="<?= $row['id_jenis_panen']; ?>"><?= $row['nama_jenis_panen']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Dropdown Tahun Panen -->
            <div class="form-group">
                <label for="tahun_panen" class="form-label">Tahun Panen:</label>
                <select id="tahun_panen" name="tahun_panen" class="form-input" title="Pilih tahun panen (hanya tahun).">
                    <option value="">Pilih Tahun</option>
                    <?php while ($row = mysqli_fetch_assoc($tahun_panen_result)) { ?>
                        <option value="<?= $row['tahun']; ?>"><?= $row['tahun']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="form-button">Cari</button>
        </form>
    </main>
</section>


<section>
<div class="hasil_panen">
    <div class="box_hp">
        <div class="title-hasil-pencarian">
            <div class="box_judul">
                <h2 class="judul-hasil-pencarian">Hasil Pencarian</h2>
                <button onclick="printHasilPanen()" class="print-button">Print Hasil Panen</button>
            </div>
        </div>

        <div id="hasil_panen_tabel">
            <?php
            // Ambil filter dari GET
            $nama_daerah = $_GET['nama_daerah'] ?? '';
            $jenis_panen = $_GET['jenis_panen'] ?? '';
            $tahun_panen = $_GET['tahun_panen'] ?? '';

            // Periksa apakah ada filter yang diisi
            $is_filter_applied = !empty($nama_daerah) || !empty($jenis_panen) || !empty($tahun_panen);

            if ($is_filter_applied) {
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10; // Jumlah data per halaman
                $offset = ($page - 1) * $limit;

                // Query untuk menghitung total hasil pencarian
                $count_query = "SELECT COUNT(*) as total 
                                FROM hasil_panen 
                                JOIN jenis_panen ON hasil_panen.id_jenis_panen = jenis_panen.id_jenis_panen 
                                JOIN data_daerah ON hasil_panen.id_daerah = data_daerah.id_daerah 
                                WHERE (hasil_panen.id_daerah = ? OR ? = '') 
                                AND (hasil_panen.id_jenis_panen = ? OR ? = '') 
                                AND (YEAR(hasil_panen.tahun_panen) = ? OR ? = '')";

                // Query untuk data dengan limit dan offset
                $data_query = "SELECT hasil_panen.*, jenis_panen.nama_jenis_panen, data_daerah.nama_daerah 
                               FROM hasil_panen 
                               JOIN jenis_panen ON hasil_panen.id_jenis_panen = jenis_panen.id_jenis_panen 
                               JOIN data_daerah ON hasil_panen.id_daerah = data_daerah.id_daerah 
                               WHERE (hasil_panen.id_daerah = ? OR ? = '') 
                               AND (hasil_panen.id_jenis_panen = ? OR ? = '') 
                               AND (YEAR(hasil_panen.tahun_panen) = ? OR ? = '') 
                               LIMIT ? OFFSET ?";

                // Siapkan statement untuk menghitung total
                $count_stmt = $conn->prepare($count_query);
                $count_stmt->bind_param('ssssss', $nama_daerah, $nama_daerah, $jenis_panen, $jenis_panen, $tahun_panen, $tahun_panen);
                $count_stmt->execute();
                $count_result = $count_stmt->get_result();
                $total_rows = $count_result->fetch_assoc()['total'];

                $total_pages = ceil($total_rows / $limit);

                // Siapkan statement untuk data
                $data_stmt = $conn->prepare($data_query);
                $data_stmt->bind_param('ssssssii', $nama_daerah, $nama_daerah, $jenis_panen, $jenis_panen, $tahun_panen, $tahun_panen, $limit, $offset);
                $data_stmt->execute();
                $result = $data_stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='tabel-hasil-panen'>
                            <table border='1'>
                                <tr>
                                    <th>Nama Daerah</th>
                                    <th>Jenis Panen</th>
                                    <th>Tahun Panen</th>
                                    <th>Produksi</th>
                                    <th>Luas Lahan Panen</th>
                                </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nama_daerah']) . "</td>
                                <td>" . htmlspecialchars($row['nama_jenis_panen']) . "</td>
                                <td>" . htmlspecialchars($row['tahun_panen']) . "</td>
                                <td>" . number_format($row['kuantitas'], 2, ',', '.') . " ton</td>
                                <td>" . number_format($row['luas_lahan_panen'], 2, ',', '.') . " ha</td>
                              </tr>";
                    }
                    echo "</table>
                          </div>";

                    echo "<div class='pagination'>";
                    if ($page > 1) {
                        echo "<a href='pencarian.php?page=" . ($page - 1) . "&nama_daerah=$nama_daerah&jenis_panen=$jenis_panen&tahun_panen=$tahun_panen'>« Sebelumnya</a>";
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<a href='pencarian.php?page=$i&nama_daerah=$nama_daerah&jenis_panen=$jenis_panen&tahun_panen=$tahun_panen' " . ($i == $page ? 'class="active"' : '') . ">$i</a>";
                    }
                    if ($page < $total_pages) {
                        echo "<a href='pencarian.php?page=" . ($page + 1) . "&nama_daerah=$nama_daerah&jenis_panen=$jenis_panen&tahun_panen=$tahun_panen'>Selanjutnya »</a>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>Data tidak ditemukan.</p>";
                }
            } else {
                echo "<p>Silakan masukkan filter pencarian untuk menampilkan data.</p>";
            }
            ?>
        </div>
    </div>
</div>


<div id="peringkat_potensi">
    <h3>Peringkat Potensi Berdasarkan Produktivitas</h3>
    <button onclick="printPeringkatPotensi()" class="print-button">Print Peringkat Potensi</button>
    <?php
    // Tentukan jumlah hasil per halaman
    $limit = 10;
    // Ambil halaman saat ini dari parameter GET
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    // Hitung offset untuk query
    $offset = ($page - 1) * $limit;

    if (!empty($nama_daerah) || !empty($jenis_panen) || !empty($tahun_panen)) {
        // Mulai membangun query dasar
        $query_peringkat = "SELECT d.nama_daerah, jp.nama_jenis_panen, hp.tahun_panen, 
                            hp.kuantitas, hp.luas_lahan_panen, 
                            (hp.kuantitas / hp.luas_lahan_panen) AS produktivitas,
                            RANK() OVER (ORDER BY (hp.kuantitas / hp.luas_lahan_panen) DESC) AS peringkat
                            FROM hasil_panen hp
                            JOIN data_daerah d ON hp.id_daerah = d.id_daerah
                            JOIN jenis_panen jp ON hp.id_jenis_panen = jp.id_jenis_panen
                            WHERE 1=1";

        // Filter berdasarkan nama daerah
        if (!empty($nama_daerah)) {
            $query_peringkat .= " AND d.id_daerah = ?";
        }

        // Filter berdasarkan jenis panen
        if (!empty($jenis_panen)) {
            $query_peringkat .= " AND jp.id_jenis_panen = ?";
        }

        // Filter berdasarkan tahun saja (menggunakan fungsi YEAR)
        if (!empty($tahun_panen)) {
            $query_peringkat .= " AND YEAR(hp.tahun_panen) = ?";
        }

        // Tambahkan LIMIT dan OFFSET untuk pagination
        $query_peringkat .= " ORDER BY produktivitas DESC LIMIT ? OFFSET ?";

        // Siapkan statement
        $stmt_peringkat = $conn->prepare($query_peringkat);

        // Binding parameter dinamis
        $bind_params = [];
        $param_types = '';

        if (!empty($nama_daerah)) {
            $bind_params[] = $nama_daerah;
            $param_types .= 's';
        }
        if (!empty($jenis_panen)) {
            $bind_params[] = $jenis_panen;
            $param_types .= 's';
        }
        if (!empty($tahun_panen)) {
            $bind_params[] = $tahun_panen;
            $param_types .= 's';
        }

        // Tambahkan limit dan offset
        $bind_params[] = $limit;
        $bind_params[] = $offset;
        $param_types .= 'ii';

        // Bind parameters jika ada parameter yang harus dibind
        if (!empty($param_types)) {
            $stmt_peringkat->bind_param($param_types, ...$bind_params);
        }

        // Eksekusi query
        $stmt_peringkat->execute();
        $result_peringkat = $stmt_peringkat->get_result();

        // Tampilkan hasil peringkat
        if ($result_peringkat->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama Daerah</th>
                        <th>Jenis Panen</th>
                        <th>Tahun Panen</th>
                        <th>Produktivitas (ton/ha)</th>
                    </tr>";
            while ($row_peringkat = $result_peringkat->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row_peringkat['peringkat'] . "</td>
                        <td>" . $row_peringkat['nama_daerah'] . "</td>
                        <td>" . $row_peringkat['nama_jenis_panen'] . "</td>
                        <td>" . htmlspecialchars($row_peringkat['tahun_panen']) . "</td>
                        <td>" . number_format($row_peringkat['produktivitas'], 2) . " ton/ha</td>
                      </tr>";
            }
            echo "</table>";

            // Pagination
            // Hitung total hasil untuk pagination
            $count_query = "SELECT COUNT(*) as total FROM hasil_panen hp
                            JOIN data_daerah d ON hp.id_daerah = d.id_daerah
                            JOIN jenis_panen jp ON hp.id_jenis_panen = jp.id_jenis_panen
                            WHERE 1=1";
            // Filter yang sama untuk total count
            if (!empty($nama_daerah)) {
                $count_query .= " AND d.id_daerah = ?";
            }
            if (!empty($jenis_panen)) {
                $count_query .= " AND jp.id_jenis_panen = ?";
            }
            if (!empty($tahun_panen)) {
                $count_query .= " AND YEAR(hp.tahun_panen) = ?";
            }

            $count_stmt = $conn->prepare($count_query);
            $count_bind_params = [];
            $count_param_types = '';

            if (!empty($nama_daerah)) {
                $count_bind_params[] = $nama_daerah;
                $count_param_types .= 's';
            }
            if (!empty($jenis_panen)) {
                $count_bind_params[] = $jenis_panen;
                $count_param_types .= 's';
            }
            if (!empty($tahun_panen)) {
                $count_bind_params[] = $tahun_panen;
                $count_param_types .= 's';
            }

            // Bind parameters jika ada parameter yang harus dibind
            if (!empty($count_param_types)) {
                $count_stmt->bind_param($count_param_types, ...$count_bind_params);
            }

            // Eksekusi query untuk menghitung total
            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $total_count = $count_result->fetch_assoc()['total'];

            // Hitung total halaman
            $total_pages = ceil($total_count / $limit);

            // Tampilkan link pagination
            $query_params = [
                'nama_daerah' => $nama_daerah,
                'jenis_panen' => $jenis_panen,
                'tahun_panen' => $tahun_panen
            ];

            echo "<div class='pagination'>";
            if ($page > 1) {
                $query_params['page'] = $page - 1;
                echo "<a href='?" . http_build_query($query_params) . "'>« Sebelumnya</a>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                $query_params['page'] = $i;
                if ($i == $page) {
                    echo "<a href='?" . http_build_query($query_params) . "' class='active'>$i</a>";
                } else {
                    echo "<a href='?" . http_build_query($query_params) . "'>$i</a>";
                }
            }
            if ($page < $total_pages) {
                $query_params['page'] = $page + 1;
                echo "<a href='?" . http_build_query($query_params) . "'>Selanjutnya »</a>";
            }
            echo "</div>";
        } else {
            echo "<p>Data peringkat tidak ditemukan.</p>";
        }
    }
    ?>
</div>



<?php include 'includes/footer.php'; ?>

<script>
// Print hasil panen
function printHasilPanen() {
    var printContents = document.getElementById("hasil_panen_tabel").innerHTML; 
    var win = window.open('', '', 'height=600,width=800');
    win.document.write('<html><head><title>Print Hasil Panen</title>');
    win.document.write('<link rel="stylesheet" href="css/pencariannew.css">');
    win.document.write('</head><body>');
    win.document.write('<h1>Hasil Pencarian Hasil Panen</h1>');
    win.document.write(printContents);
    win.document.write('</body></html>');
    win.document.close();
    win.focus();
    win.print();
    win.close();
}
// Print peringkat potensi
function printPeringkatPotensi() {
    var printContents = document.getElementById("peringkat_potensi").innerHTML; // Ambil hanya tabel peringkat potensi
    var win = window.open('', '', 'height=600,width=800');
    win.document.write('<html><head><title>Print Peringkat Potensi</title>');
    win.document.write('<link rel="stylesheet" href="css/pencariannew.css">'); // Link ke file CSS agar style tetap terjaga
    win.document.write('</head><body>');
    win.document.write('<h1>Peringkat Potensi Berdasarkan Produktivitas</h1>');
    win.document.write(printContents); // Masukkan tabel peringkat potensi yang ingin dicetak
    win.document.write('</body></html>');
    win.document.close();
    win.focus();
    win.print();
    win.close();
}
feather.replace();
</script>
</html>
