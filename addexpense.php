<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fisherman = mysqli_real_escape_string($conn, $_POST['Fisherman']);
    $TypeofFeeds = mysqli_real_escape_string($conn, $_POST['TypeofFeeds']);
    $Price = floatval($_POST['Price']);
    $Quantity = floatval($_POST['Quantity']);
    $TotalAmount = $Price * $Quantity;
    $TransactionDate = mysqli_real_escape_string($conn, $_POST['TransactionDate']);

    $feedQuery = "SELECT Quantity FROM tbl_feeds WHERE NameofFeeds = '$TypeofFeeds'";
    $feedResult = mysqli_query($conn, $feedQuery);

    if ($feedResult && mysqli_num_rows($feedResult) > 0) {
        $feed = mysqli_fetch_assoc($feedResult);
        $currentQty = floatval($feed['Quantity']);

        if ($currentQty >= $Quantity) {
            $newQty = $currentQty - $Quantity;
            mysqli_query($conn, "UPDATE tbl_feeds SET Quantity = $newQty WHERE NameofFeeds = '$TypeofFeeds'");

            $insertExpense = "INSERT INTO tbl_transactions (Fisherman, TypeofFeeds, Price, Quantity, TotalAmount, TransactionDate)
                              VALUES ('$Fisherman', '$TypeofFeeds', $Price, $Quantity, $TotalAmount, '$TransactionDate')";

            if (mysqli_query($conn, $insertExpense)) {
                $insert_id = mysqli_insert_id($conn);

                // ✅ Fetch newly inserted record for the receipt
                $receiptQuery = mysqli_query($conn, "SELECT * FROM tbl_transactions WHERE id = $insert_id");
                $receiptData = mysqli_fetch_assoc($receiptQuery);

                echo json_encode([
                    "success" => true,
                    "message" => "Expense added successfully and feed stock updated!",
                    "receiptData" => $receiptData
                ]);
                exit;
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Database insert error: " . mysqli_error($conn)
                ]);
                exit;
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Feed type '$TypeofFeeds' is out of stock (available: $currentQty)"
            ]);
            exit;
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Feed type '$TypeofFeeds' not found in feedstock records."
        ]);
        exit;
    }
}
?>
