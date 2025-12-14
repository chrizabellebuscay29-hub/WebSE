<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $NameofFeeds = trim($_POST['NameofFeeds']);
    $Price = floatval($_POST['Price']);
    $Quantity = intval($_POST['Quantity']);
    $Date = $_POST['Date'];

    // Check if feed already exists
    $check = mysqli_query($conn, "SELECT * FROM tbl_feeds WHERE NameofFeeds = '$NameofFeeds' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // Feed exists — update quantity and price
        $row = mysqli_fetch_assoc($check);
        $newQuantity = $row['Quantity'] + $Quantity;

        $update = mysqli_query($conn, "
            UPDATE tbl_feeds 
            SET Quantity = $newQuantity, Price = $Price, Date = '$Date'
            WHERE NameofFeeds = '$NameofFeeds'
        ");

        if ($update) {
            echo json_encode(["success" => true, "message" => "✅ Feed stock updated successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "❌ Error updating feed: " . mysqli_error($conn)]);
        }
    } else {
        // Feed does not exist — insert new
        $insert = mysqli_query($conn, "
            INSERT INTO tbl_feeds (NameofFeeds, Price, Quantity, Date)
            VALUES ('$NameofFeeds', $Price, $Quantity, '$Date')
        ");

        if ($insert) {
            echo json_encode(["success" => true, "message" => "✅ New feed added successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "❌ Error inserting feed: " . mysqli_error($conn)]);
        }
    }
}
?>
