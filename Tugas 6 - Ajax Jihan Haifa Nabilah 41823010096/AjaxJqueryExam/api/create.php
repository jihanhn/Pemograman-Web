<?php
require 'db_config.php';

$post = $_POST;

// Prepared statement
$stmt = $conn->prepare("INSERT INTO items (title, description) VALUES (?, ?)");
$stmt->bind_param("ss", $post['title'], $post['description']);

if ($stmt->execute()) {
  $stmt->close();

  $sql = "SELECT * FROM items Order by id desc LIMIT 1";
  $result = $conn->query($sql);
  $data = $result->fetch_assoc();
  echo json_encode($data);
} else {
  echo "Error: " . $stmt->error;
}
