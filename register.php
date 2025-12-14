<?php
header('Content-Type: application/json');
include "connection.php";

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $admin_code_input = trim($_POST['admin_code'] ?? '');

    // Default role
    $role = 'user';

    // Secret admin code
    $secretAdminCode = 'FISHMASTER2025'; // you can change this anytime

    // If the entered code matches, assign admin role
    if ($admin_code_input === $secretAdminCode) {
        $role = 'admin';
    }

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $response["message"] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $response["message"] = "Password must be at least 6 characters.";
    } else {
        // Check if email already exists
        $stmtCheck = $conn->prepare("SELECT id FROM tbl_login WHERE email = ?");
        if (!$stmtCheck) {
            $response["message"] = "Database error (prepare check): " . $conn->error;
            echo json_encode($response);
            exit;
        }

        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $response["message"] = "Email is already registered.";
        } else {
            // Insert new user
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            $stmtInsert = $conn->prepare("INSERT INTO tbl_login (username, email, password, role) VALUES (?, ?, ?, ?)");
            if (!$stmtInsert) {
                $response["message"] = "Database error (prepare insert): " . $conn->error;
                echo json_encode($response);
                exit;
            }

            $stmtInsert->bind_param("ssss", $username, $email, $hashedPwd, $role);

            if ($stmtInsert->execute()) {
                $response["success"] = true;
                $response["message"] = "Account created successfully!";
            } else {
                $response["message"] = "Database error (execute insert): " . $stmtInsert->error;
            }

            $stmtInsert->close();
        }

        $stmtCheck->close();
    }
}

$conn->close();
echo json_encode($response);
?>
