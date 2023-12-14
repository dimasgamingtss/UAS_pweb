<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengguna = $_SESSION['user_id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    // Insert into pembeli table
    $sqlPembeli = "INSERT INTO pembeli (nama, alamat) VALUES ('$nama', '$alamat')";

    if ($mysqli->query($sqlPembeli) === TRUE) {
        // Get the last inserted ID from pembeli table
        $id_pembeli = $mysqli->insert_id;

        // Insert into transaksi table
        $jenis_ikan = $_POST['jenis_ikan'];
        $harga = getHargaByJenisIkan($jenis_ikan);
        $tanggal = $_POST['tanggal'];

        $sqlTransaksi = "INSERT INTO transaksi (id_pembeli, jenis_ikan, harga, tanggal, id_pengguna) VALUES ('$id_pembeli', '$jenis_ikan', '$harga', '$tanggal', '$id_pengguna')";

        if ($mysqli->query($sqlTransaksi) === TRUE) {
            header("Location: read.php");
            exit;
        } else {
            echo "Error: " . $sqlTransaksi . "<br>" . $mysqli->error;
        }
    } else {
        echo "Error: " . $sqlPembeli . "<br>" . $mysqli->error;
    }

    $mysqli->close();
}

function getHargaByJenisIkan($jenis_ikan)
{
    // Assign prices based on jenis_ikan
    switch ($jenis_ikan) {
        case 'plakat':
            return 100000;
        case 'halfmoon':
            return 150000;
        case 'crowntail':
            return 200000;
        default:
            return 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan dan Beli Ikan Cupang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        #harga-container {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <h2>Pesan dan Beli Ikan Cupang Baru</h2>
    <form action="create_pembeli_transaksi.php" method="POST">
        Nama: <input type="text" name="nama" required><br>
        Alamat: <input type="text" name="alamat" required><br>
        Jenis Ikan:
        <select name="jenis_ikan" id="jenis_ikan" required onchange="updateHarga()">
            <option value="plakat">Plakat</option>
            <option value="halfmoon">Halfmoon</option>
            <option value="crowntail">Crowntail</option>
        </select><br>
        <div id="harga-container">Harga: Rp 100,000</div>
        Tanggal Transaksi: <input type="date" name="tanggal" required><br>
        <input type="submit" value="Pesan dan Beli">
    </form>

    <script>
        function updateHarga() {
            var jenisIkan = document.getElementById('jenis_ikan').value;
            var hargaContainer = document.getElementById('harga-container');
            var harga = 0;

            switch (jenisIkan) {
                case 'plakat':
                    harga = 100000;
                    break;
                case 'halfmoon':
                    harga = 150000;
                    break;
                case 'crowntail':
                    harga = 200000;
                    break;
            }

            hargaContainer.innerText = 'Harga: Rp ' + harga.toLocaleString();
        }
    </script>
</body>

</html>
