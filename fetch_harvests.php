<?php
include("connection.php");
header('Content-Type: application/json');

$search = "";
if (isset($_GET['search']) && $_GET['search'] !== "") {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM tbl_profit WHERE Fisherman LIKE '%$search%' ORDER BY Date DESC";
} else {
    $query = "SELECT * FROM tbl_profit ORDER BY Date DESC";
}

$result = mysqli_query($conn, $query);
$harvests = [];

while ($row = mysqli_fetch_assoc($result)) {
    $harvests[] = $row;
}

echo json_encode($harvests);
?>
