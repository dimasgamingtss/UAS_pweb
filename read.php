<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

function displayDashboardMenu() {
    echo "
    <div class='dashboard-links'>
        <a href='create_pembeli_transaksi.php' class='btn-create'>Pesan dan Beli Ikan Cupang</a>
        <p><a href='logout.php' class='logout-btn'>Logout</a></p>
    </div>";
}

$id_pengguna = $_SESSION['user_id'];

$query = "SELECT pembeli.*, transaksi.jenis_ikan, transaksi.harga, transaksi.tanggal
          FROM pembeli
          LEFT JOIN transaksi ON pembeli.pembeli_id = transaksi.id_pembeli
          WHERE transaksi.id_pengguna = '$id_pengguna'";

$result = $mysqli->query($query);

echo "
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Dashboard Ikan Cupang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 2em;
        }

        .dashboard-links {
            margin-top: 20px;
        }

        a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .btn-create {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-create:hover {
            background-color: #45a049;
        }

        .logout-btn {
            background-color: #555;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #333;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .delete-btn, .edit-btn {
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 5px;
            border: 2px solid #e74c3c;
        }

        .delete-btn:hover, .edit-btn:hover {
            background-color: #c0392b;
        }

        .no-data {
            color: #333;
            margin: 20px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Ikan Cupang Jepara</h1>
    </header>";

displayDashboardMenu();

if ($result) {
    if ($result->num_rows > 0) {
        echo "
        <table>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis Ikan</th>
                <th>Harga</th>
                <th>Tanggal Transaksi</th>
                <th>Tindakan</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["pembeli_id"] . "</td>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "<td>" . $row["alamat"] . "</td>";
            echo "<td>" . $row["jenis_ikan"] . "</td>";
            echo "<td>" . formatCurrency($row["harga"]) . "</td>";
            echo "<td>" . $row["tanggal"] . "</td>";
            echo "<td>
                        <a href='edit_pembeli_transaksi.php?id=" . $row["pembeli_id"] . "' class='edit-btn'>Edit Pembeli</a> | 
                        <a href='edit_transaksi.php?id=" . $row["pembeli_id"] . "' class='edit-btn'>Edit Transaksi</a> | 
                        <a href='delete.php?id=" . $row["pembeli_id"] . "' class='delete-btn'>Delete</a>
                    </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<div class='no-data'>Tidak ada data transaksi.</div>";
    }
} else {
    echo "<div style='color: red; margin: 10px;'>Error: " . $mysqli->error . "</div>";
}

$mysqli->close();

function formatCurrency($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
?>
</body>

</html>
