<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fisherman = mysqli_real_escape_string($conn, $_POST['Fisherman']);
    $TypeofFeeds = mysqli_real_escape_string($conn, $_POST['TypeofFeeds']);
    $Price = floatval($_POST['Price']);
    $Quantity = floatval($_POST['Quantity']);
    $TotalAmount = $Price * $Quantity;
    $TransactionDate = mysqli_real_escape_string($conn, $_POST['TransactionDate']);

    $sql = "INSERT INTO tbl_transactions (Fisherman, TypeofFeeds, Price, Quantity, TotalAmount, TransactionDate)
            VALUES ('$Fisherman', '$TypeofFeeds', $Price, $Quantity, $TotalAmount, '$TransactionDate')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php"); // redirect back to main dashboard
        exit;
    } else {
        echo "Error inserting expense: " . mysqli_error($conn);
    }
}
?>
