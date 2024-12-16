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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];

  // Menyimpan data yang diperbarui ke database
  $query = "UPDATE items SET title = :title, description = :description WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute(['title' => $title, 'description' => $description, 'id' => $id]);

  // Mengirim respons dalam format JSON
  echo json_encode(['success' => true]);
}
