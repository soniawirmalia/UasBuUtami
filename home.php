<?php
session_start();

# Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include "config/koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h1 {
            color: #343a40;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .btn {
            font-size: 18px;
            font-weight: 500;
            padding: 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1>Sistem Informasi Restoran</h1>
        <div class="row gy-3">
            <div class="col-md-4">
                <a href="menu.php" class="btn btn-primary w-100">Manajemen Menu</a>
            </div>
            <div class="col-md-4">
                <a href="transaksi.php" class="btn btn-success w-100">Transaksi</a>
            </div>
            <div class="col-md-4">
                <a href="laporan_transaksi.php" class="btn btn-danger w-100">Laporan Transaksi</a>
            </div>
            <div class="d-flex justify-content-center">
            <div class="col-md-4">
                <a href="index.php" class="btn btn-warning w-100">Log Out</a>
            </div>
        </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>