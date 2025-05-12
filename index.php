<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      SISTEM INFORMASI PENDATAAN POTENSI UNGGULAN DAERAH KABUPATEN MERAUKE
      BERBASIS WEB
    </title>
    <?php
    // Memanggil header
    include 'includes/header.php';
    ?>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;800&display=swap" rel="stylesheet" />
    <!-- my style -->
    <link rel="stylesheet" href="css/styleberanda.css" />
    <link rel="stylesheet" href="css/index_header.css" />
    <link rel="stylesheet" href="css/index_footer.css" />
    <!-- feather icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <!-- Hero section start -->
    <section class="hero" id="home">
      <main class="content">
        <h1>
        Kelola Sumber Daya Alam dengan Mudah dan Efisien! 
        </h1>
        <p>
        Bergabunglah dengan Kami untuk Mendapatkan Data Akurat dan Terkini
        </p>
      </main>
    </section>
    <!-- Hero section end -->

    <!-- about section start -->
    <section id="about" class="about">
      <h2>Tentang Kami</h2>
      <div class="row">
        <div class="about-img">
          <img src="img/fruit1.png" alt="Tentang Kami" />
        </div>
        <div class="content">
          <h3>SISTEM INFORMASI PENDATAAN HASIL PANEN</h3>
          <p>
          Sistem Informasi Pendataan Hasil Panen adalah platform berbasis web yang dirancang untuk mengelola dan mendata potensi unggulan sumber daya alam di Kabupaten Merauke.
          </p>
          <p>
          Sistem Informasi Pendataan Hasil Panen bertujuan untuk meningkatkan akurasi, keterbaruan, dan aksesibilitas data mengenai potensi sumber daya alam, serta mendukung pengelolaan yang efisien di daerah tersebut.
          </p>
        </div>
      </div>
    </section>
    <!-- about section end -->

    <!-- menu section start-->
    <section id="menu" class="menu">
        <div class="boxlay">
          <div class="service-starts">
              <div class="awalbox">Layanan yang kami sediakan</div>
              <div class="service-awal">
                Berikut beberapa layanan yang kami sediakan pada aplikasi ini.</div>
          </div>

          <div class="service-item">
              <div class="service-number2">1</div>
              <div class="titlecard">Sumber Informasi Panen Daerah Terperinci</div>
              <div class="service-description">
                Menyediakan data panen yang lengkap dan terperinci untuk berbagai daerah.</div>
          </div>

          <div class="service-item">
              <div class="service-number3">2</div>
              <div class="titlecard">Kemudahan Memahami Data Melalui Visualisasi</div>
              <div class="service-description">
                Memberikan visualisasi data yang mudah dipahami melalui grafik dan tabel.</div>
          </div>

              <div class="service-item">
              <div class="service-number4">3</div>
              <div class="titlecard">Kemudahan dalam Menemukan Data Panen</div>
              <div class="service-description">
                Mempermudah pencarian data hasil panen dengan fitur filter dan sortir.</div>
          </div>

          <div class="service-item">
              <div class="service-number5">4</div>
              <div class="titlecard">Sumber Informasi Terpercaya untuk Keputusan Pertanian</div>
              <div class="service-description">
              Layanan informasi terpercaya untuk referensi dan keputusan terkait pertanian.</div>
          </div>
      </div>
    </section>
    <!-- menu section end -->

    <!-- grafik -->
    <section id="grafik-panen" class="grafik-panen">
      <h2>Grafik Panen Tahun 2024</h2>
      <div style="width: 80%; margin: auto;">
        <canvas id="grafikPanenKomoditas"></canvas>
      </div>
    </section>
    <!-- grafik end -->

    <!-- Grafik Panen Script -->
    <script>
      // Data contoh
      const dataPanen = {
        labels: ['Padi', 'Jagung', 'Kedelai', 'Ubi Kayu'], // Komoditas
        datasets: [{
          label: 'Hasil Panen (ton)',
          data: [2500, 3039.40, 520.78, 11348.39], // Jumlah panen tiap komoditas
          backgroundColor: ['#4CAF50', '#FF9800', '#2196F3', '#9C27B0'],
        }],
      };

      // Konfigurasi grafik
      const config = {
        type: 'bar',
        data: dataPanen,
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: true,
              position: 'top',
            },
          },
        },
      };

      // Render grafik
      const ctx = document.getElementById('grafikPanenKomoditas').getContext('2d');
      new Chart(ctx, config);
    </script>

    <?php include 'includes/footer.php';?>
    <!-- feather icon -->
    <script>
      feather.replace();
    </script>
    <script src="javascript/script.js">
    </script>
  </body>
</html>
