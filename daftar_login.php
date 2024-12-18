<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if ($password !== $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak cocok!";
    } else {
        // Periksa apakah username sudah digunakan
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Simpan ke database
            $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($conn, $query)) {
                $success = "Pendaftaran berhasil! Silakan login.";
                header("Refresh: 2; url=index.php");
            } else {
                $error = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Daftar</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= $success; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                        </div>
                        <button type="submit" name="daftar" class="btn btn-primary w-100 mb-2">Daftar</button>
                        <a href="index.php" class="btn btn-secondary w-100">Kembali ke Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
