<?php
include("connection.php");
header("Content-Type: application/json");

$result = mysqli_query($conn, "SELECT * FROM tbl_workersdata ORDER BY id DESC");
$workers = [];

while ($row = mysqli_fetch_assoc($result)) {
    $workers[] = [
        "id" => $row["id"],
        "Fisherman" => $row["Fisherman"],
        "Permitnumber" => $row["Permitnumber"],
        "AmountofSimilia" => $row["AmountofSimilia"],
        "Age" => $row["Age"],
        "DateStarted" => $row["DateStarted"],
        "Picture" => $row["Picture"]
    ];
}

echo json_encode(["workers" => $workers]);
?>
