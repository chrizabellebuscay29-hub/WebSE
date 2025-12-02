<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Fisherman = $_POST['Fisherman'];
    $TypeofFeeds = $_POST['TypeofFeeds'];
    $Price = $_POST['Price'];
    $Quantity = $_POST['Quantity'];
    $TotalAmount = $_POST['TotalAmount'];
    $TransactionDate = $_POST['TransactionDate'];

    $query = "INSERT INTO tbl_transactions (Fisherman, TypeofFeeds, Price, Quantity, TotalAmount, TransactionDate)
              VALUES ('$Fisherman', '$TypeofFeeds', '$Price', '$Quantity', '$TotalAmount', '$TransactionDate')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
