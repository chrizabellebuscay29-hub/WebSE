<?php
include("connection.php");

$data = [];

// Total Workers
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_workersdata");
$row = mysqli_fetch_assoc($result);
$data['total_workers'] = $row['total'] ?? 0;

// Workers list
$workers = [];
$q = mysqli_query($conn, "SELECT * FROM tbl_workersdata ORDER BY id DESC");
while ($r = mysqli_fetch_assoc($q)) $workers[] = $r;
$data['workers'] = $workers;

// Total Expenses
$res = mysqli_query($conn, "SELECT SUM(amount) as total FROM tbl_expenses");
$r = mysqli_fetch_assoc($res);
$data['total_expenses'] = $r['total'] ?? 0;

// Total Harvests
$res2 = mysqli_query($conn, "SELECT SUM(profit) as total FROM tbl_harvests");
$r2 = mysqli_fetch_assoc($res2);
$data['total_harvests'] = $r2['total'] ?? 0;

// Net profit
$data['net_profit'] = ($data['total_harvests'] ?? 0) - ($data['total_expenses'] ?? 0);

header('Content-Type: application/json');
echo json_encode($data);
?>
