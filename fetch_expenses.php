<?php
include("connection.php");

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = $search ? "WHERE Fisherman LIKE '%$search%'" : '';

$query = "SELECT * FROM tbl_transactions $where ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$expenses = [];
while ($row = mysqli_fetch_assoc($result)) {
  $expenses[] = $row;
}

header('Content-Type: application/json');
echo json_encode($expenses);
?>
