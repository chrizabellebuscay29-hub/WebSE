<?php
include("connection.php");

// --- Pagination setup ---
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start_from = ($page - 1) * $limit;

// --- Search ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = $search ? "WHERE Category LIKE '%$search%'" : '';

// --- Count total records ---
$total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_feeds $where");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// --- Fetch limited records ---
$query = "SELECT * FROM tbl_feeds $where ORDER BY id DESC LIMIT $start_from, $limit";
$result = mysqli_query($conn, $query);

$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
  $transactions[] = $row;
}

// --- Output JSON ---
header('Content-Type: application/json');
echo json_encode([
  'data' => $transactions,
  'total_pages' => $total_pages,
  'current_page' => $page
]);
?>
