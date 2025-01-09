<?php

require 'db_config].php';

// Pastikan menerima ID dengan metode yang benar (POST atau GET)
$id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"];

// Validasi ID (misalnya, pastikan berupa integer)
if (!is_numeric($id)) {
  die(json_encode(['status' => 'error', 'message' => 'Invalid ID']));
}

// Escape data untuk mencegah SQL injection
$title = $conn->real_escape_string($_POST['title']);
$description = $conn->real_escape_string($_POST['description']);

$sql = "UPDATE items SET 
          title = '$title',
          description = '$description' 
        WHERE id = $id";

$result = $conn->query($sql);

if ($result) {
  // Ambil data yang baru diupdate
  $sql = "SELECT * FROM items WHERE id = $id";
  $result = $conn->query($sql);
  $data = $result->fetch_assoc();

  echo json_encode(['status' => 'success', 'data' => $data]);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Failed to update item']);
}
