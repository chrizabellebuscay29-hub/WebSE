<?php
include("connection.php");

// --- Pagination setup ---
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start_from = ($page - 1) * $limit;

// --- Search ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = $search ? "WHERE Fisherman LIKE '%$search%'" : '';

// --- Count total records for pagination ---
$total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_transactions $where");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// --- Fetch limited records ---
$query = "SELECT * FROM tbl_transactions $where ORDER BY id DESC LIMIT $start_from, $limit";
$result = mysqli_query($conn, $query);

$expenses = [];
while ($row = mysqli_fetch_assoc($result)) {
  $expenses[] = $row;
}

// --- Output JSON ---
header('Content-Type: application/json');
echo json_encode([
  'data' => $expenses,
  'total_pages' => $total_pages,
  'current_page' => $page
]);
?>
