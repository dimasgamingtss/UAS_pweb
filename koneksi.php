<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'iwakcupang';

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>
