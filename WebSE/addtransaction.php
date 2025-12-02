<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $NameofFeeds = $_POST['NameofFeeds'];
    $Price = $_POST['Price'];
    $Quantity = $_POST['Quantity'];
    $Date = $_POST['Date'];

    $query = "INSERT INTO tbl_feeds (NameofFeeds, Price, Quantity, Date)
              VALUES ('$NameofFeeds', '$Price', '$Quantity', '$Date')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
