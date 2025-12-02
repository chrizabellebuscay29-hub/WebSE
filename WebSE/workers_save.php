<?php
include("connection.php");

$id = $_POST['id'] ?? '';
$Fisherman = $_POST['Fisherman'];
$Permitnumber = $_POST['Permitnumber'];
$AmountofSimilia = $_POST['AmountofSimilia'];
$Age = $_POST['Age'];
$DateStarted = $_POST['DateStarted'];

$Picture = '';
if (!empty($_FILES['Picture']['name'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $fileName = time() . "_" . basename($_FILES['Picture']['name']);
    $targetFile = $targetDir . $fileName;
    move_uploaded_file($_FILES['Picture']['tmp_name'], $targetFile);
    $Picture = $targetFile;
}

if ($id) {
    // Update existing worker
    $query = "UPDATE tbl_workersdata SET 
        Fisherman='$Fisherman', 
        Permitnumber='$Permitnumber',
        AmountofSimilia='$AmountofSimilia',
        Age='$Age',
        DateStarted='$DateStarted'";
    if ($Picture) $query .= ", Picture='$Picture'";
    $query .= " WHERE id=$id";
} else {
    // Add new worker
    $query = "INSERT INTO tbl_workersdata (Fisherman, Permitnumber, AmountofSimilia, Age, DateStarted, Picture)
              VALUES ('$Fisherman', '$Permitnumber', '$AmountofSimilia', '$Age', '$DateStarted', '$Picture')";
}

mysqli_query($conn, $query);
?>
