<?php
include 'config/koneksi.php';

# Menangani filter bulan dan tahun
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : date('m');
$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date('Y');

# Query untuk mengambil transaksi berdasarkan bulan dan tahun
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal DESC");

# Menghitung total semua transaksi
$totalTransaksi = 0;
while ($row = mysqli_fetch_assoc($query)) {
    $totalTransaksi += $row['total'];
}

# Reset pointer hasil query ke awal untuk menampilkan data
mysqli_data_seek($query, 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Bulanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
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
    </style>
</head>
<body>

<div class="container">
    <h2>Laporan Transaksi</h2>

    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col">
                <select name="bulan" class="form-select">
                    <option value="01" <?= ($bulan == '01') ? 'selected' : '' ?>>Januari</option>
                    <option value="02" <?= ($bulan == '02') ? 'selected' : '' ?>>Februari</option>
                    <option value="03" <?= ($bulan == '03') ? 'selected' : '' ?>>Maret</option>
                    <option value="04" <?= ($bulan == '04') ? 'selected' : '' ?>>April</option>
                    <option value="05" <?= ($bulan == '05') ? 'selected' : '' ?>>Mei</option>
                    <option value="06" <?= ($bulan == '06') ? 'selected' : '' ?>>Juni</option>
                    <option value="07" <?= ($bulan == '07') ? 'selected' : '' ?>>Juli</option>
                    <option value="08" <?= ($bulan == '08') ? 'selected' : '' ?>>Agustus</option>
                    <option value="09" <?= ($bulan == '09') ? 'selected' : '' ?>>September</option>
                    <option value="10" <?= ($bulan == '10') ? 'selected' : '' ?>>Oktober</option>
                    <option value="11" <?= ($bulan == '11') ? 'selected' : '' ?>>November</option>
                    <option value="12" <?= ($bulan == '12') ? 'selected' : '' ?>>Desember</option>
                </select>
            </div>
            <div class="col">
                <select name="tahun" class="form-select">
                    <?php
                    $current_year = date('Y');
                    for ($i = $current_year; $i >= $current_year - 5; $i--) {
                        echo "<option value='$i' " . ($tahun == $i ? 'selected' : '') . ">$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="excel_laporan.php" class="btn btn-success">Export to Excel</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['tanggal']}</td>
                    <td>Rp. " . number_format($row['total'], 0, ',', '.') . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Menampilkan Total Transaksi -->
    <div class="d-flex justify-content-between">
        <div><strong>Total Semua Transaksi:</strong></div>
        <div><strong>Rp. <?= number_format($totalTransaksi, 0, ',', '.') ?></strong></div>
    </div>

    <a href="home.php" class="btn btn-warning">Kembali Menu Awal</a>
</div>

</body>
</html>
