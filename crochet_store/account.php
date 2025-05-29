<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);

    // Handle image upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_photo']['tmp_name'];
        $file_name = basename($_FILES['profile_photo']['name']);
        $upload_dir = 'uploads/';
        $target_file = $upload_dir . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        move_uploaded_file($file_tmp, $target_file);

        $stmt = $conn->prepare("UPDATE users SET address = ?, profile_photo = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $address, $target_file, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET address = ? WHERE user_id = ?");
        $stmt->bind_param("si", $address, $user_id);
    }

    $stmt->execute();
    header("Location: account.php");
    exit();
}

// Fetch current user data
$stmt = $conn->prepare("SELECT username, email, address, profile_photo FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        img.profile-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Account</h2>
        <form method="POST" enctype="multipart/form-data">

         <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
        
            <label>Profile Photo:</label>
            <?php if ($user['profile_photo']): ?>
                <img src="<?php echo $user['profile_photo']; ?>" alt="Profile Photo" class="profile-photo">
            <?php endif; ?>
            <input type="file" name="profile_photo">

            <label>Username:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>

            <label>Email:</label>
            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>

            <label>Address:</label>
            <textarea name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>



            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
