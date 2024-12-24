<?php
// Database connection
$host = 'localhost';
$db = 'passengers';
$user = 'root';
$pass = '';

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

$query = "SELECT * FROM passengers";
$stmt = $pdo->query($query);
$data = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode(['data' => $data]);
