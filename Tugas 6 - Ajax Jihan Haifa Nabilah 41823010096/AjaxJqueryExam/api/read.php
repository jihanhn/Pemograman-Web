<?php
header('Content-Type: application/json');

// Konfigurasi koneksi database
$host = "localhost";
$username = "root";
$password = "@Jihan2106";
$db = "webbasic";

// Koneksi ke database
$conn = mysqli_connect($host, $username, $password, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

// Periksa error query
if (!$result) {
    die("Error query: " . $conn->error);
}

// Ambil semua data
$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data);

$conn->close();
