<?php
include("connection.php");

// Only get feeds that are in stock (Quantity > 0)
$query = "SELECT NameofFeeds, Price, Quantity 
          FROM tbl_feeds 
          WHERE Quantity > 0 
          ORDER BY NameofFeeds ASC";

$result = mysqli_query($conn, $query);
$feeds = [];

while ($row = mysqli_fetch_assoc($result)) {
    $feeds[] = $row;
}

header('Content-Type: application/json');
echo json_encode($feeds);
?>
