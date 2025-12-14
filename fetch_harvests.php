<?php
include("connection.php");

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = $search ? "WHERE Fisherman LIKE '%$search%'" : '';

$result = mysqli_query($conn, "SELECT * FROM tbl_profit $where ORDER BY id DESC");
$harvests = [];

while ($row = mysqli_fetch_assoc($result)) {
  $harvests[] = $row;
}

echo json_encode($harvests);
?>
