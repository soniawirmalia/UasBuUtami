<?php
include "config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM menu WHERE id = $id");
    $menu = mysqli_fetch_assoc($query);
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    mysqli_query($conn, "UPDATE menu SET nama = '$nama', harga = '$harga', kategori = '$kategori' WHERE id = $id");
    echo "<script>alert('Menu berhasil diperbarui!'); window.location='menu.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
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
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
            font-weight: bold;
        }
        label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
            font-size: 16px;
            padding: 10px;
        }
        .btn-secondary {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Menu</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nama">Nama Menu</label>
            <input type="text" id="nama" name="nama" class="form-control" value="<?= $menu['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" class="form-control" value="<?= $menu['harga']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" class="form-select">
                <option value="Makanan" <?= $menu['kategori'] == 'Makanan' ? 'selected' : ''; ?>>Makanan</option>
                <option value="Minuman" <?= $menu['kategori'] == 'Minuman' ? 'selected' : ''; ?>>Minuman</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
        <a href="menu.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>