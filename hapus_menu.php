<?php
include 'config/koneksi.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $id = mysqli_real_escape_string($conn, $id);

    # Hapus data yang terkait di tabel detail_transaksi
    $delete_detail = "DELETE FROM detail_transaksi WHERE menu_id = $id";
    mysqli_query($conn, $delete_detail);

    # Hapus menu dari tabel menu
    $delete_menu = "DELETE FROM menu WHERE id = $id";
    $result = mysqli_query($conn, $delete_menu);

    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='menu.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='menu.php';</script>";
}
?>