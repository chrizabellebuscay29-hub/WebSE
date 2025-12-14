<?php
header('Content-Type: application/json');
include "connection.php";

$response = ["success" => false, "message" => "", "role" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $response["message"] = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM tbl_login WHERE email = ?");
        if (!$stmt) {
            $response["message"] = "Database error (prepare login): " . $conn->error;
            echo json_encode($response);
            exit;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $username, $hashedPwd, $role);

        if ($stmt->num_rows === 1) {
            $stmt->fetch();
            if (password_verify($password, $hashedPwd)) {
                session_start();
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                $response["success"] = true;
                $response["message"] = "Login successful!";
                $response["role"] = $role; // important for JS redirect
            } else {
                $response["message"] = "Invalid email or password.";
            }
        } else {
            $response["message"] = "Email not registered.";
        }

        $stmt->close();
    }
}

$conn->close();
echo json_encode($response);
?>
