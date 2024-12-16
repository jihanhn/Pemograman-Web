<?php
// Koneksi ke database
$host = 'localhost';
$db = 'webbasic';
$user = 'root';
$pass = '@Jihan2106';

$dsn = "mysql:host=$host;dbname=$db";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  die('Connection failed: ' . $e->getMessage());
}

// Ambil data dari database
$query = "SELECT * FROM items"; // Ganti dengan nama tabel Anda
$stmt = $pdo->query($query);
$data = $stmt->fetchAll();

// Kirim data dalam format JSON
header('Content-Type: application/json');
echo json_encode(['data' => $data]);
