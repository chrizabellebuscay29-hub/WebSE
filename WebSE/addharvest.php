<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data safely
    $Fisherman = mysqli_real_escape_string($conn, $_POST['Fisherman']);
    $KiloofFish = floatval($_POST['KiloofFish']);
    $Priceperkilo = floatval($_POST['Priceperkilo']);
    $AmountofSimilia = floatval($_POST['AmountofSimilia']);
    $AmountofFeeds = floatval($_POST['AmountofFeeds']);
    $Date = mysqli_real_escape_string($conn, $_POST['Date']);

    // Perform automatic calculations (same as JS)
    $Subtotal = $KiloofFish * $Priceperkilo;
    $TotalExpense = $AmountofSimilia + $AmountofFeeds;
    $Profit = $Subtotal - $TotalExpense;
    $Dividedprofit = $Profit / 2;

    // Insert into database
    $sql = "INSERT INTO tbl_profit
            (Fisherman, KiloofFish, Priceperkilo, Subtotal, AmountofSimilia, 
             AmountofFeeds, TotalExpense, Profit, Dividedprofit, Date)
            VALUES 
            ('$Fisherman', $KiloofFish, $Priceperkilo, $Subtotal, 
             $AmountofSimilia, $AmountofFeeds, $TotalExpense, $Profit, $Dividedprofit, '$Date')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
}
?>
