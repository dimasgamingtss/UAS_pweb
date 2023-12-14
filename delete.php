<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_pembeli = $_GET['id'];

    // Hapus data transaksi
    $deleteTransaksi = "DELETE FROM transaksi WHERE id_pembeli = '$id_pembeli'";
    $resultTransaksi = $mysqli->query($deleteTransaksi);

    // Hapus data pembeli
    $deletePembeli = "DELETE FROM pembeli WHERE pembeli_id = '$id_pembeli'";
    $resultPembeli = $mysqli->query($deletePembeli);

    if ($resultTransaksi && $resultPembeli) {
        header("Location: read.php");
        exit;
    } else {
        echo "Error: " . $mysqli->error;
    }
} else {
    echo "Invalid request.";
}

$mysqli->close();
?>
