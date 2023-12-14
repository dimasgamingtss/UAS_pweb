<?php
include 'koneksi.php';

function logout()
{
    session_start();
    session_unset();
    session_destroy();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout();
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        // Login berhasil
        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['user_id'] = $user['id']; // Simpan ID pengguna ke dalam sesi
        header("Location: read.php");
        exit;
    } else {
        echo "Username atau password salah!";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna</title>
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

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        .register-link {
            display: block;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Login Pengguna</h2>
    <form action="login.php" method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>

    <p class="register-link"><a href="register.php">Belum punya akun? Daftar di sini.</a></p>
</body>

</html>
