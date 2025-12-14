<?php
include("connection.php");

$table = $_GET['table'];
$id = intval($_GET['id']);

$sql = "SELECT * FROM $table WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo "
<html>
<head>
  <title>Print Record</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    td { border: 1px solid #ccc; padding: 8px; }
    td:first-child { font-weight: bold; width: 30%; background-color: #f3f9ff; }
  </style>
</head>
<body>
  <h2>Record Details</h2>
  <table>";
foreach ($row as $key => $value) {
  echo "<tr><td>$key</td><td>$value</td></tr>";
}
echo "
  </table>
  <script>window.print();</script>
</body>
</html>";
?>
