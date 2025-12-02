<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Fisherman = $_POST['Fisherman'];
    $KiloofFish = $_POST['KiloofFish'];
    $Priceperkilo = $_POST['Priceperkilo'];
    $Subtotal = $_POST['Subtotal'];
    $AmountofSimilia = $_POST['AmountofSimilia'];
    $AmountofFeeds = $_POST['AmountofFeeds'];
    $TotalExpense = $_POST['TotalExpense'];
    $Profit = $_POST['Profit'];
    $Dividedprofit = $_POST['Dividedprofit'];
    $Date = $_POST['Date'];

    $query = "INSERT INTO tbl_profit (Fisherman, KiloofFish, Priceperkilo, Subtotal, AmountofSimilia, AmountofFeeds, TotalExpense, Profit, Dividedprofit, Date)
              VALUES ('$Fisherman', '$KiloofFish', '$Priceperkilo', '$Subtotal', '$AmountofSimilia', '$AmountofFeeds', '$TotalExpense', '$Profit', '$div_profit', '$Date')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
