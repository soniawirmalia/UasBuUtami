<?php
include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Makanan & Minuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #fff, #f8f9fa);
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            color: #343a40;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        table {
            margin-top: 20px;
        }
        table th {
            text-align: center;
            background-color: #f8f9fa;
        }
        table td {
            text-align: center;
        }
        .btn-sm {
            margin: 2px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manajemen Menu</h2>
    <div class="text-end">
        <a href="home.php" class="btn btn-warning mb-3">Kembali Menu Awal</a>
        <a href="tambah_menu.php" class="btn btn-primary mb-3">Tambah Menu</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM menu");
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama']}</td>
                    <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                    <td>{$row['kategori']}</td>
                    <td>
                        <a href='edit_menu.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hapus_menu.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus menu ini?\")'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>