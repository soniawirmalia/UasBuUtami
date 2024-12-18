<?php
include "config/koneksi.php";

// Cek apakah ID transaksi ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus detail transaksi terlebih dahulu (relasi dengan transaksi)
    $queryDetail = "DELETE FROM detail_transaksi WHERE transaksi_id = '$id'";
    mysqli_query($conn, $queryDetail);

    // Hapus transaksi utama setelah detail transaksi dihapus
    $queryTransaksi = "DELETE FROM transaksi WHERE id = '$id'";
    $result = mysqli_query($conn, $queryTransaksi);

    if ($result) {
        echo "<script>
                alert('Transaksi berhasil dihapus!');
                window.location = 'transaksi.php'; // Redirect ke halaman utama transaksi
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus transaksi!');
                window.location = 'transaksi.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID transaksi tidak ditemukan!');
            window.location = 'transaksi.php';
          </script>";
}
?>
