<?php
include("connection.php");

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search === '') {
    echo json_encode([
        'success' => true,
        'total' => 0
    ]);
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT COALESCE(SUM(TotalAmount), 0) AS total
     FROM tbl_transactions
     WHERE TRIM(Fisherman) LIKE CONCAT('%', TRIM(?), '%')"
);

mysqli_stmt_bind_param($stmt, "s", $search);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'total' => (float)$row['total']
]);
