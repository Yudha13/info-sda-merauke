<?php
session_start();
include 'config.php'; // Koneksi ke database
include 'includes/header.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil admin berdasarkan username
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika user ditemukan
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verifikasi password dengan password_verify
        if (password_verify($password, $admin['password'])) {
            // Set session jika login berhasil
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $admin['username']; // Simpan data username di session

            // Redirect ke dashboard jika login berhasil
            header("Location: dashboard_content/admin_dashboard.php");
            exit();
        } else {
            // Jika password salah
            $error = "Password salah.";
        }
    } else {
        // Jika username tidak ditemukan
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <!-- username : alva | password: 123  -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;800&display=swap"rel="stylesheet"/>
    <link rel="stylesheet" href="css/loginadmin.css">
    <link rel="stylesheet" href="css/index_footer.css">
    <link rel="stylesheet" href="css/index_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <div class="login-container">
        <h2>Log In</h2>
        <p>Log In sebagai Admin</p>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <!-- Form login -->
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" autocomplete="off" required>
            <input type="password" name="password" placeholder="Password" autocomplete="off" required>
            <button type="submit">Log In</button>
        </form>
    </div>
   
    <script src="js/loginadmin.js"></script>
    <script src="javascript/script.js"></script>
        <!-- feather icon -->
    <script> feather.replace(); </script>

</body> 
    <?php include 'includes/footer.php';?>
</html>
