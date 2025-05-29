<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('❌ Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('❌ No account found with that email.');</script>";
    }
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
            background-image: url("images/jennahooks logo.jpg");
            background-repeat: no-repeat;
            background-position: center top;
            background-size: cover;    
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
            background: #c55d3f;
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
<body>

<div class="login-box">
     
    <img src="images/crochet logo.jpg" alt="crochet logo"class="logo">

    <h2><i class="fa-solid fa-right-to-bracket"></i> Welcome Back</h2>

    <form method="POST">
        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</button>
    </form>

    <div class="footer">
        Don't have an account? <a href="register.php">Register here</a><br><br>
        Are you an admin? <a href="admin_login.php">Login here</a>
    </div>
</div>

</body>
</html>
