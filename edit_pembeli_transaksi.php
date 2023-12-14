<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $pembeli_id = $_POST['pembeli_id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    // Update pembeli data
    $sqlPembeli = "UPDATE pembeli SET nama='$nama', alamat='$alamat' WHERE pembeli_id=$pembeli_id";
    
    if ($mysqli->query($sqlPembeli) === TRUE) {
        header("Location: read.php");
        exit;
    } else {
        echo "Error: " . $sqlPembeli . "<br>" . $mysqli->error;
    }
}

if (isset($_GET['id'])) {
    $pembeli_id = $_GET['id'];
    
    $queryPembeli = "SELECT * FROM pembeli WHERE pembeli_id=$pembeli_id";
    $resultPembeli = $mysqli->query($queryPembeli);

    if ($resultPembeli && $resultPembeli->num_rows > 0) {
        $rowPembeli = $resultPembeli->fetch_assoc();
    } else {
        echo "Pembeli not found!";
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
    <title>Edit Pembeli</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        input {
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
    </style>
</head>

<body>
    <h2>Edit Pembeli</h2>
    <form action="edit_pembeli_transaksi.php" method="POST">
        <input type="hidden" name="pembeli_id" value="<?php echo $rowPembeli['pembeli_id']; ?>">
        Nama: <input type="text" name="nama" value="<?php echo $rowPembeli['nama']; ?>" required><br>
        Alamat: <input type="text" name="alamat" value="<?php echo $rowPembeli['alamat']; ?>" required><br>
        <input type="submit" name="edit" value="Simpan Perubahan">
    </form>
</body>

</html>

<?php
$mysqli->close();
?>
