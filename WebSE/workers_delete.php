<?php
include("connection.php");

$id = $_POST['id'] ?? '';
if ($id) {
    $id = intval($id);
    $query = "DELETE FROM tbl_workersdata WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "No ID provided";
}
?>
