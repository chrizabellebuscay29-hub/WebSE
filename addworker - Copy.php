<?php
require ('connection.php');
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fisherman = $_POST['Fisherman'];
    $Permitnumber = $_POST['Permitnumber'];
    $AmountofSimilia = $_POST['AmountofSimilia'];
    $Age = $_POST['Age'];
    $DateStarted = $_POST['DateStarted'];
    $Picture = $_POST['Picture'];

    $sql = "INSERT INTO tbl_workersdata (Fisherman, Permitnumber, AmountofSimilia, Age, DateStarted, Picture)
    VALUES ('$Fisherman', '$Permitnumber', '$AmountofSimilia', '$Age', '$DateStarted', 'Picture')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?success=1");
        exit;
    } else {
        // Redirect with error flag
        header("Location: index.php?error=1");
        exit;
    }
}
?>

