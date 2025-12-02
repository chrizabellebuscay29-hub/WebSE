<?php
include("connection.php");
$res = mysqli_query($conn, "SELECT * FROM tbl_workersdata ORDER BY Fisherman ASC");
$workers = [];
while($row = mysqli_fetch_assoc($res)) {
    $workers[] = $row;
}
echo json_encode($workers);
?>
