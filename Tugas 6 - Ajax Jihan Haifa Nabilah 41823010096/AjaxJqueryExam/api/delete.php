`<?php

require 'db_config.php';

// Pastikan menerima ID dengan metode yang benar (POST atau GET)
$id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"]; 

// Validasi ID (misalnya, pastikan berupa integer)
if (!is_numeric($id)) {
  die(json_encode(['status' => 'error', 'message' => 'Invalid ID']));
}

$sql = "DELETE FROM items WHERE id = $id"; // Tidak perlu tanda kutip jika $id integer

$result = $conn->query($sql);

if ($result) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
}

?>