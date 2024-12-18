<?php
include 'config/koneksi.php';
$transaksi_id = $_GET['id'];

#Ambil Data Transaksi Utama
$transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id = $transaksi_id"));

#Ambil Detail Transaksi
$detail = mysqli_query($conn, "SELECT d.qty, d.subtotal, m.nama, m.harga
FROM detail_transaksi d
JOIN menu m ON d.menu_id = m.id
WHERE d.transaksi_id = $transaksi_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .struk-container {
            background-color: #ffffff;
            width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px dashed #000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .struk-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .struk-header h2 {
            margin: 0;
            font-size: 20px;
        }
        .struk-content {
            text-align: left;
            font-size: 14px;
        }
        .struk-content table {
            width: 100%;
            border-collapse: collapse;
        }
        .struk-content th, .struk-content td {
            text-align: left;
            padding: 5px 0;
        }
        .struk-content th {
            border-bottom: 1px solid #000;
        }
        .struk-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</head>
<body>
    <div class="struk-container">
        <div class="struk-header">
            <h2>STRUK PEMBAYARAN</h2>
            <small>ID Transaksi: #<?= $transaksi['id']; ?></small><br>
            <small><?= $transaksi['tanggal']; ?></small>
        </div>

        <div class="struk-content">
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($detail)) { ?>
                        <tr>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['qty']; ?></td>
                            <td>Rp. <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td>Rp. <?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="line"></div>
            <p><strong>Total: Rp. <?= number_format($transaksi['total'], 0, ',', '.'); ?></strong></p>
        </div>

        <div class="struk-footer">
            <p>** Terima Kasih **</p>
            <p>Selamat menikmati pesanan Anda!</p>
        </div>
    </div>
</body>
</html>