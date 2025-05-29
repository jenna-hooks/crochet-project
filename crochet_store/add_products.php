<?php
include 'db_connect.php';
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);
    $image_url   = trim($_POST['image_url']);

    if ($name && $price) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $image_url);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Product added successfully!');</script>";
        } else {
            echo "<script>alert('❌ Failed to add product: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Crochet Product</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: transparent;
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

        .container {
            background: #2471a3;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .container img.logo {
            width: 120px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #000;
        }

        .form-group i {
            position: absolute;
            top: 40px;
            left: 10px;
            color: #2471a3;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus, 
        .form-group textarea:focus {
            border-color: #2471a3;
        }

        button {
            width: 100%;
            padding: 12px;
            background: rgb(169, 216, 214);
            color: black;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #476cd1;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color:rgb(169, 216, 214);
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Live Image Preview Styling */
        .image-preview {
            margin-top: 10px;
            max-height: 200px;
            display: none; /* hidden until a valid URL is entered */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            object-fit: contain;
        }
    </style>
</head>
<body>

<div class="container">
   
    <h2><i class="fa-solid fa-plus"></i> Add New Crochet Product</h2>

    <form method="POST">
        <div class="form-group">
            <label><i class="fa-solid fa-tag"></i> Product Name *</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-align-left"></i> Description</label>
            <textarea name="description" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-money-bill-wave"></i> Price (Ksh) *</label>
            <input type="number" step="0.01" name="price" required>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-image"></i> Image URL</label>
            <input type="text" name="image_url" id="image_url" oninput="previewImage()">
            <img id="preview" class="image-preview" alt="Image Preview">
        </div>

        <button type="submit"><i class="fa-solid fa-upload"></i> Add Product</button>
    </form>

    <a href="products.php"><i class="fa-solid fa-store"></i> View Products in display</a>
</div>

<script>
    function previewImage() {
        const urlInput = document.getElementById('image_url');
        const preview = document.getElementById('preview');
        
        const url = urlInput.value.trim();
        
        if (url) {
            preview.src = url;
            preview.style.display = "block";
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    }
</script>

</body>
</html>
