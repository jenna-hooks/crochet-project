<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION["admin_id"] = $id;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Invalid credentials.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url("images/BG.jpg");
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: 100% 100%;    
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .login-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-box img.logo {
            width: 80px;
            margin-bottom: 10px;
        }

        .login-box h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .input-group i {
            position: absolute;
            top: 12px;
            left: 12px;
            color: #888;
        }

        .input-group input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #5c8df6;
        }

        button {
            width: 100%;
            padding: 12px;
            background:  teal;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        button:hover {
            background:rgb(146, 49, 23);
        }

        .footer {
            margin-top: 15px;
            font-size: 14px;
        }

        .footer a {
            color: #5c8df6;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

 <form method="POST">
        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
        <input type="text" name="username" placeholder="Admin Username" required><br><br>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required><br><br>
        </div>
        <button type="submit"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</button>
    </form>
    </html>
