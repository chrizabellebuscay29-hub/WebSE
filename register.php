<?php
// ---------------- DATABASE CONNECTION ----------------
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_vbmysql";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Database Connection Error: " . mysqli_connect_error());
}

// Handle AJAX request
if (isset($_POST["action"]) && $_POST["action"] === "save_user") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username === "" || $password === "") {
        echo "empty";
        exit;
    }

    // Check if username already exists
    $stmt = mysqli_prepare($conn, "SELECT id FROM tbl_login WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($exists > 0) {
        echo "exists";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = mysqli_prepare($conn, "INSERT INTO tbl_login (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo $success ? "success" : "error";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Account - FishTracker Pro</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:"Poppins",sans-serif;}
body{height:100vh;background:url('./bg/majestic-back-view-fisherman-boat-sailing.jpg') center/cover no-repeat;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;}
body::before{content:"";position:absolute;inset:0;background:rgba(0,0,0,0.45);backdrop-filter: blur(2px);}
.floating-shape{position:absolute;width:120px;height:120px;background:rgba(255,255,255,0.08);border-radius:50%;animation: float 8s ease-in-out infinite;}
.floating-shape:nth-child(1){top:5%;left:10%;animation-duration:9s;}
.floating-shape:nth-child(2){bottom:10%;right:8%;animation-duration:11s;}
@keyframes float {0% { transform:translateY(0); } 50% { transform:translateY(-25px); } 100% { transform:translateY(0); }}
.register-card{position:relative;width:420px;padding:2.8rem;border-radius:20px;background:rgba(255,255,255,0.14);backdrop-filter:blur(18px);box-shadow:0 8px 25px rgba(0,0,0,0.35);color:white;animation: fadeIn 0.8s ease-out;text-align:center;}
@keyframes fadeIn {from{opacity:0;transform:scale(0.95);} to{opacity:1;transform:scale(1);}}
.register-card i.fa-user-plus{font-size:4rem;color:#2dd4ff;text-shadow:0 0 15px #2dd4ff;animation:glow 2.5s infinite alternate;}
@keyframes glow {from{ text-shadow:0 0 8px #23b9ff; } to { text-shadow:0 0 22px #5ee0ff; }}
h1{margin-top:1rem;font-size:2rem;font-weight:700;}
.subtitle{opacity:0.85;margin-bottom:1.8rem;}
.input-group{text-align:left;margin-bottom:1.1rem;}
.input-group label{font-size:0.9rem;font-weight:600;}
.input-field{width:100%;padding:0.8rem 1rem;margin-top:0.45rem;border:none;border-radius:10px;background:rgba(255,255,255,0.18);color:white;outline:none;transition:0.3s;}
.input-field:focus{background:rgba(255,255,255,0.25);box-shadow:0 0 10px #4ccfff;}
.input-field.error{border:2px solid #ff4d4d;}
.field-error{display:none;color:#ff4d4d;font-size:0.85rem;margin-top:4px;}
.btn{width:100%;padding:0.9rem;margin-top:1.3rem;border:none;border-radius:12px;font-size:1.1rem;font-weight:700;cursor:pointer;background:linear-gradient(120deg,#ff7eb3,#ff758c,#ff616d);background-size:220%;color:white;transition:0.4s ease;}
.btn:hover{background-position:right;transform:translateY(-2px);box-shadow:0 8px 20px rgba(255,110,140,0.35);}
.login-link{margin-top:1.3rem;display:block;font-size:0.9rem;color:#bfe9ff;text-decoration:none;}
.login-link:hover{text-decoration:underline;}
</style>
</head>
<body>

<div class="floating-shape"></div>
<div class="floating-shape"></div>

<div class="register-card">
    <i class="fa-solid fa-user-plus"></i>
    <h1>Create Account</h1>
    <p class="subtitle">Join FishTracker Pro</p>

    <form id="register-form" onsubmit="return false;">
        <div class="input-group">
            <label>Username</label>
            <input type="text" id="username" class="input-field" placeholder="Enter username">
            <div class="field-error" id="username-error"></div>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" id="password" class="input-field" placeholder="Create password">
            <div class="field-error" id="password-error"></div>
        </div>

        <button class="btn" id="create-btn">Create Account</button>
    </form>

    <a class="login-link" href="login.html">Already have an account? Log in</a>
</div>

<script>
const usernameInput = document.getElementById("username");
const passwordInput = document.getElementById("password");
const usernameError = document.getElementById("username-error");
const passwordError = document.getElementById("password-error");

document.getElementById("create-btn").addEventListener("click", () => {
    let username = usernameInput.value.trim();
    let password = passwordInput.value.trim();

    // Reset previous errors
    usernameError.style.display = "none";
    passwordError.style.display = "none";
    usernameInput.classList.remove("error");
    passwordInput.classList.remove("error");

    let hasError = false;

    if(username === ""){
        usernameError.style.display = "block";
        usernameError.innerText = "Username is required.";
        usernameInput.classList.add("error");
        hasError = true;
    }

    if(password === ""){
        passwordError.style.display = "block";
        passwordError.innerText = "Password is required.";
        passwordInput.classList.add("error");
        hasError = true;
    }

    if(hasError) return;

    let formData = new FormData();
    formData.append("action","save_user");
    formData.append("username",username);
    formData.append("password",password);

    fetch("register.php",{
        method:"POST",
        body:formData
    })
    .then(res => res.text())
    .then(response=>{
        if(response === "exists"){
            usernameError.style.display = "block";
            usernameError.innerText = "Username already exists!";
            usernameInput.classList.add("error");
        } else if(response === "success"){
            alert("Account created successfully!");
            window.location.href = "login.html";
        } else {
            alert("Something went wrong. Try again.");
        }
    });
});
</script>

</body>
</html>
