<?php

require 'db_config.php';

header('Content-Type: application/json');

$num_rec_per_page = 5;

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$start_from = ($page - 1) * $num_rec_per_page;

// Query untuk total record
$sqlTotal = "SELECT * FROM items";
$resultTotal = $conn->query($sqlTotal);
$totalRecords = $resultTotal ? $resultTotal->num_rows : 0;

// Query untuk data dengan paginasi
$sql = "SELECT * FROM items ORDER BY id DESC LIMIT $start_from, $num_rec_per_page";
$result = $conn->query($sql);

$json = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $json[] = $row;
    }
}

$data = [
    'data' => $json,
    'total' => $totalRecords,
];

echo json_encode($data);

?>