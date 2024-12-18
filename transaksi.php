<?php
include 'config/koneksi.php';

// Proses Simpan Transaksi
if (isset($_POST['submit'])) {
    $menu_ids = $_POST['menu_id']; // Array ID Menu
    $qtys = $_POST['qty'];         // Array Jumlah Pesanan

    // Validasi Data
    if (empty($menu_ids) || empty($qtys)) {
        echo "<script>alert('Pilih setidaknya satu menu!');</script>";
        exit;
    }

    // Hitung Total Transaksi
    $total = 0;
    foreach ($menu_ids as $index => $menu_id) {
        $qty = (int)$qtys[$index];
        $query = mysqli_query($conn, "SELECT harga FROM menu WHERE id = $menu_id");
        $menu = mysqli_fetch_assoc($query);

        if ($menu) { // Jika menu valid
            $subtotal = $menu['harga'] * $qty;
            $total += $subtotal;
        }
    }

    // Simpan ke Tabel Transaksi
    $tanggal = date('Y-m-d H:i:s'); // Format Tanggal
    $insert_transaksi = mysqli_query($conn, "INSERT INTO transaksi (tanggal, total) VALUES ('$tanggal', '$total')");

    if ($insert_transaksi) {
        $transaksi_id = mysqli_insert_id($conn); // ID transaksi terakhir

        // Simpan ke Tabel Detail Transaksi
        foreach ($menu_ids as $index => $menu_id) {
            $qty = (int)$qtys[$index];
            $query = mysqli_query($conn, "SELECT harga FROM menu WHERE id = $menu_id");
            $menu = mysqli_fetch_assoc($query);

            if ($menu) {
                $subtotal = $menu['harga'] * $qty;
                mysqli_query($conn, "INSERT INTO detail_transaksi (transaksi_id, menu_id, qty, subtotal) 
                                     VALUES ('$transaksi_id', '$menu_id', '$qty', '$subtotal')");
            }
        }

        echo "<script>alert('Transaksi berhasil disimpan!'); window.location='transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan transaksi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya umum */
        body {
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
            color: #343a40;
            margin: 0;
            padding: 0;
        }

        h2, h3 {
            text-align: center;
            font-weight: bold;
            color: #495057;
            margin-bottom: 20px;
        }

        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.15);
            margin-top: 30px;
        }

        /* Tombol Utama */
        .btn {
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }

        .btn-success {
            background-color: #28a745;
            color: #ffffff;
        }
        .btn-success:hover {
            background-color: #218838;
        }

        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #ffffff;
        }
        .btn-danger:hover {
            background-color: #bd2130;
        }

        /* Table styling */
        table {
            border-radius: 8px;
            overflow: hidden;
        }

        table thead {
            background-color: #f1f3f5;
            color: #343a40;
            font-weight: bold;
        }

        table tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        /* Select dan Input */
        .form-control, .form-select {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        /* Tombol Tambah */
        #add-row {
            width: 100%;
            margin-bottom: 10px;
        }

        /* Riwayat Transaksi */
        .table-bordered {
            background-color: #ffffff;
        }

        .table td .btn-sm {
            padding: 5px 10px;
        }

        /* Animasi tombol hover */
        a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2>Transaksi Pemesanan</h2>
    <form method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="menu-list">
                <tr>
                    <td>
                        <select name="menu_id[]" class="form-select" required>
                            <option value="">-- Pilih Menu --</option>
                            <?php
                            $menu = mysqli_query($conn, "SELECT * FROM menu");
                            while ($row = mysqli_fetch_assoc($menu)) {
                                echo "<option value='{$row['id']}'>{$row['nama']} - Rp. " . number_format($row['harga'], 0, ',', '.') . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="number" name="qty[]" class="form-control" min="1" value="1" required></td>
                    <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-success" id="add-row">Tambah Menu</button>
        <button type="submit" name="submit" class="btn btn-primary">Simpan Transaksi</button>
        <a href="home.php" class="btn btn-warning">Kembali Menu Awal</a>
    </form>

    <h3 class="mt-5">Riwayat Transaksi</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['tanggal']}</td>
                    <td>Rp. " . number_format($row['total'], 0, ',', '.') . "</td>
                    <td>
                        <a href='print_transaksi.php?id={$row['id']}' class='btn btn-info btn-sm' target='_blank'>Print</a>
                        <a href='hapus_transaksi.php?id={$row['id']}' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('add-row').addEventListener('click', function () {
    const row = `
        <tr>
            <td>
                <select name="menu_id[]" class="form-select" required>
                    <option value="">-- Pilih Menu --</option>
                    <?php
                    $menu = mysqli_query($conn, "SELECT * FROM menu");
                    while ($row = mysqli_fetch_assoc($menu)) {
                        echo "<option value='{$row['id']}'>{$row['nama']} - Rp. " . number_format($row['harga'], 0, ',', '.') . "</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input type="number" name="qty[]" class="form-control" min="1" value="1" required></td>
            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
        </tr>`;
    document.getElementById('menu-list').insertAdjacentHTML('beforeend', row);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();
    }
});
</script>

</body>
</html>