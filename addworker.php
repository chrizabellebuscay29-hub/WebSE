<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $Fisherman = $_POST['Fisherman'];
  $Permitnumber = $_POST['Permitnumber'];
  $AmountofSimilia = $_POST['AmountofSimilia'];
  $Age = $_POST['Age'];
  $DateStarted = $_POST['DateStarted'];
  
// Handle file upload
  $picturePath = "";
  if (!empty($_FILES['Picture']['name'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $fileName = time() . "_" . basename($_FILES['Picture']['name']);
    $targetFile = $targetDir . $fileName;
    if (move_uploaded_file($_FILES['Picture']['tmp_name'], $targetFile)) {
      $picturePath = $targetFile;
    }
  }


  $query = "INSERT INTO tbl_workersdata (Fisherman, Permitnumber, AmountofSimilia, Age, DateStarted, Picture)
            VALUES ('$Fisherman', '$Permitnumber', '$AmountofSimilia', '$Age', '$DateStarted', '$Picture')";
  mysqli_query($conn, $query);
  header("Location: index.php");
  exit;
}
?>
