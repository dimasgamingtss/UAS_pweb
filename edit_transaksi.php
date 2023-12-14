<?php
include 'koneksi.php';

// Function to get price based on jenis_ikan
function getHargaByJenisIkan($jenisIkan)
{
    switch ($jenisIkan) {
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id_pembeli = $_POST['id_pembeli'];
    $jenis_ikan = $_POST['jenis_ikan'];
    $tanggal = $_POST['tanggal'];

    // Update transaksi data
    $sqlTransaksi = "UPDATE transaksi SET jenis_ikan='$jenis_ikan', tanggal='$tanggal' WHERE id_pembeli=$id_pembeli";
    
    if ($mysqli->query($sqlTransaksi) === TRUE) {
        header("Location: read.php");
        exit;
    } else {
        echo "Error: " . $sqlTransaksi . "<br>" . $mysqli->error;
    }
}

if (isset($_GET['id'])) {
    $id_pembeli = $_GET['id'];
    
    $queryTransaksi = "SELECT * FROM transaksi WHERE id_pembeli=$id_pembeli";
    $resultTransaksi = $mysqli->query($queryTransaksi);

    if ($resultTransaksi && $resultTransaksi->num_rows > 0) {
        $rowTransaksi = $resultTransaksi->fetch_assoc();
    } else {
        echo "Transaksi not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
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

        select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        #harga-container {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <h2>Edit Transaksi</h2>
    <form action="edit_transaksi.php" method="POST">
        <input type="hidden" name="id_pembeli" value="<?php echo $rowTransaksi['id_pembeli']; ?>">
        
        <!-- Displaying fish type dropdown and price -->
        Jenis Ikan:
        <select name="jenis_ikan" id="jenis_ikan" required onchange="updateHarga()">
            <option value="plakat" <?php echo ($rowTransaksi['jenis_ikan'] === 'plakat') ? 'selected' : ''; ?>>Plakat</option>
            <option value="halfmoon" <?php echo ($rowTransaksi['jenis_ikan'] === 'halfmoon') ? 'selected' : ''; ?>>Halfmoon</option>
            <option value="crowntail" <?php echo ($rowTransaksi['jenis_ikan'] === 'crowntail') ? 'selected' : ''; ?>>Crowntail</option>
        </select><br>
        
        <!-- Container to display dynamic price -->
        <div id="harga-container">Harga: Rp <?php echo number_format(getHargaByJenisIkan($rowTransaksi['jenis_ikan']), 0, ',', '.'); ?></div>
        
        <!-- Input for transaction date -->
        Tanggal Transaksi: <input type="date" name="tanggal" value="<?php echo $rowTransaksi['tanggal']; ?>" required><br>
        
        <!-- Submit button -->
        <input type="submit" name="edit" value="Simpan Perubahan">
    </form>

    <!-- JavaScript for updating price based on fish type -->
    <script>
        function updateHarga() {
            var jenisIkan = document.getElementById('jenis_ikan').value;
            var hargaContainer = document.getElementById('harga-container');
            var harga = getHargaByJenisIkan(jenisIkan);

            // Update the displayed price
            hargaContainer.textContent = 'Harga: Rp ' + harga.toLocaleString('id-ID');
        }

        // Function to get price based on fish type
        function getHargaByJenisIkan(jenisIkan) {
            switch (jenisIkan) {
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
    </script>
</body>

</html>

<?php
$mysqli->close();
?>
