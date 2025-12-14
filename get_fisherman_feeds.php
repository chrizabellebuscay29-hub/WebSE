<?php
include("connection.php");

if (isset($_GET['fisherman'])) {
    $fisherman = mysqli_real_escape_string($conn, $_GET['fisherman']);

    $query = "SELECT SUM(TotalAmount) AS total_feeds FROM tbl_transactions WHERE Fisherman = '$fisherman'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $total = $data['total_feeds'] ?? 0;
        echo json_encode(["success" => true, "total" => floatval($total)]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No fisherman parameter provided."]);
}
?>
