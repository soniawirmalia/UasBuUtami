<?php
# Menangani filter bulan dan tahun
include 'config/koneksi.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

# Query untuk mengambil transaksi berdasarkan bulan dan tahun
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal DESC");

# Menghitung subtotal
$totalTransaksi = 0;
while ($row = mysqli_fetch_assoc($query)) {
    $totalTransaksi += $row['total'];
}

# Menyiapkan header untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Laporan_Transaksi_' . $tahun . '_' . $bulan . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');

# Membuka output sebagai file CSV
$output = fopen('php://output', 'w');

# Menulis header kolom CSV
fputcsv($output, ['ID Transaksi', 'Tanggal', 'Total']);

# Reset query pointer ke awal untuk menulis data transaksi
mysqli_data_seek($query, 0);

# Menulis data transaksi ke CSV
while ($row = mysqli_fetch_assoc($query)) {
    fputcsv($output, [
        $row['id'],
        $row['tanggal'],
        'Rp. ' . number_format($row['total'], 0, ',', '.')
    ]);
}

# Menulis baris subtotal ke CSV
fputcsv($output, ['Subtotal', '', 'Rp. ' . number_format($totalTransaksi, 0, ',', '.')]);

# Menutup file CSV
fclose($output);
exit;
?>