<?php
require("connection.php");

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("No worker ID provided");
}

$id = intval($_GET['id']); // convert to integer for safety

// ✅ Fetch the worker from the database
$sql = "SELECT * FROM tbl_workersdata WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $sql) or die("SQL Error: " . mysqli_error($conn));

if (mysqli_num_rows($result) == 0) {
    die("Worker not found.");
}

$worker = mysqli_fetch_assoc($result);

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fisherman = $_POST['Fisherman'];
    $Permitnumber = $_POST['Permitnumber'];
    $AmountofSimilia = $_POST['AmountofSimilia'];
    $Age = $_POST['Age'];
    $DateStarted = $_POST['DateStarted'];

    // Handle picture upload
    $Picture = $worker['Picture']; // keep old image
    if (!empty($_FILES['Picture']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($_FILES['Picture']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['Picture']['tmp_name'], $targetFile)) {
            $Picture = $targetFile;
        }
    }

    // ✅ Update record
    $update = "UPDATE tbl_workersdata SET 
        Fisherman='$Fisherman', 
        Picture='$Picture', 
        Permitnumber='$Permitnumber', 
        AmountofSimilia='$AmountofSimilia', 
        Age='$Age', 
        DateStarted='$DateStarted'
        WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Worker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 40px;
        }
        form {
            max-width: 400px;
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        img {
            display: block;
            width: 100%;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h2>Update Worker Record</h2>

<form method="POST" enctype="multipart/form-data">
    <label for="worker-name">Full Name:</label>
    <input id="worker-name" name="Fisherman" value="<?php echo htmlspecialchars($worker['Fisherman']); ?>" required />

    <label for="worker-picture">Insert Picture:</label>
    <?php if (!empty($worker['Picture'])): ?>
        <img src="<?php echo $worker['Picture']; ?>" alt="Worker Picture">
    <?php endif; ?>
    <input id="worker-picture" name="Picture" type="file" accept="image/*" />

    <label for="worker-permit">Permit Number:</label>
    <input id="worker-permit" name="Permitnumber" value="<?php echo htmlspecialchars($worker['Permitnumber']); ?>" required />

    <label for="worker-similia">Amount of Similia:</label>
    <input id="worker-similia" name="AmountofSimilia" type="number" value="<?php echo htmlspecialchars($worker['AmountofSimilia']); ?>" required />

    <label for="worker-age">Age:</label>
    <input id="worker-age" name="Age" type="number" value="<?php echo htmlspecialchars($worker['Age']); ?>" required />

    <label for="worker-joined">Joined Date:</label>
    <input id="worker-joined" name="DateStarted" type="date" value="<?php echo htmlspecialchars($worker['DateStarted']); ?>" required />

    <button class="btn-primary" type="submit">Update</button>
    <button class="btn-secondary" type="button" onclick="window.location.href='index.php'">Cancel</button>
</form>

</body>
</html>
