<?php
include("connection.php");

if (isset($_GET['fisherman'])) {
    $fisherman = mysqli_real_escape_string($conn, $_GET['fisherman']);
    $query = "SELECT SUM(TotalAmount) AS totalFeeds FROM tbl_transactions WHERE Fisherman = '$fisherman'";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_assoc($result);
    echo json_encode([
        "success" => true,
        "total" => $data['totalFeeds'] ?? 0
    ]);
    exit;
}

echo json_encode(["success" => false, "message" => "Missing fisherman name"]);
?>
