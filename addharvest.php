<?php
include("connection.php");
header("Content-Type: application/json");

$response = ["success" => false, "message" => "", "data" => []];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fisherman = mysqli_real_escape_string($conn, $_POST['Fisherman']);
    $KiloofFish = floatval($_POST['KiloofFish']);
    $Priceperkilo = floatval($_POST['Priceperkilo']);
    $AmountofSimilia = floatval($_POST['AmountofSimilia']);
    $AmountofFeeds = floatval($_POST['AmountofFeeds']);
    $Date = mysqli_real_escape_string($conn, $_POST['Date']);

    $Subtotal = $KiloofFish * $Priceperkilo;
    $TotalExpense = $AmountofSimilia + $AmountofFeeds;
    $Profit = $Subtotal - $TotalExpense;
    $Dividedprofit = $Profit / 2;

    $insert = mysqli_query($conn, "INSERT INTO tbl_profit
        (Fisherman, KiloofFish, Priceperkilo, Subtotal, AmountofSimilia,
         AmountofFeeds, TotalExpense, Profit, Dividedprofit, Date)
         VALUES
        ('$Fisherman', $KiloofFish, $Priceperkilo, $Subtotal,
         $AmountofSimilia, $AmountofFeeds, $TotalExpense, $Profit, $Dividedprofit, '$Date')");

    if ($insert) {
        $id = mysqli_insert_id($conn);
        $record = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_profit WHERE id = $id"));

        $response["success"] = true;
        $response["message"] = "Harvest saved successfully!";
        $response["data"] = $record;
    } else {
        $response["message"] = "Error saving harvest: " . mysqli_error($conn);
    }
}

echo json_encode($response);
?>
