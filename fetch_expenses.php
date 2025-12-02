<?php
include("connection.php");

$search = "";
if (isset($_GET['search']) && $_GET['search'] !== "") {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM tbl_transactions WHERE Fisherman LIKE '%$search%' ORDER BY TransactionDate DESC";
} else {
    $query = "SELECT * FROM tbl_transactions ORDER BY TransactionDate DESC";
}

$result = mysqli_query($conn, $query);
$expenses = [];

while ($row = mysqli_fetch_assoc($result)) {
    $expenses[] = $row;
}

echo json_encode($expenses);
?>
