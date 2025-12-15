<?php
include("connection.php");

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = $search ? "WHERE Fisherman LIKE '%$search%'" : '';

$result = mysqli_query(
  $conn,
  "SELECT * FROM tbl_profit $where ORDER BY Date DESC"
);

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}

header('Content-Type: application/json');
echo json_encode($rows);
