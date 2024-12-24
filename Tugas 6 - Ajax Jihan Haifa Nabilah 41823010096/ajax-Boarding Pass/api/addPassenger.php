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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $flight_id = $_POST['flight_id'];
    $airline = $_POST['airline'];

    $query = "INSERT INTO passengers (name, flight_id, airline, created_at) VALUES (:name, :flight_id, :airline, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['name' => $name, 'flight_id' => $flight_id, 'airline' => $airline]);

    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add passenger']);
    }
}
