<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_details = $_POST['product_details'];
    $product_color = $_POST['product_color'];
    $product_size = $_POST['product_size'];
    $product_category = $_POST['product_category'];
    $product_quantity = $_POST['product_quantity'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);

    // Dynamically insert into categories table
    $sql_category = "INSERT INTO tbl_categories (product_category, product_color, product_size) 
                     VALUES ('$product_category', '$product_color', '$product_size')";

    if ($conn->query($sql_category) === TRUE) {
        $category_id = $conn->insert_id;

        $sql_product = "INSERT INTO tbl_products (product_name, product_details, category_id, product_image, product_quantity, product_price) 
                        VALUES ('$product_name', '$product_details', '$category_id', '$product_image', '$product_quantity', '$product_price')";

        if ($conn->query($sql_product) === TRUE) {
            echo "<p>Product added successfully!</p>";
        } else {
            echo "<p>Error adding product: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Error adding category: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* Navbar Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #F2F2F2;
            padding: 15px 30px;
            border-bottom: 1px solid #ddd;
        }

        .header .logo img {
            height: 25px;
        }

        .header .nav {
            display: flex;
            gap: 20px;
        }

        .header .nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .header .icons {
            display: flex;
            gap: 15px;
        }

        .header .icons .icon {
            font-size: 18px;
            cursor: pointer;
        }

        /* Form Styles */
        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input, select, textarea {
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="header">
    <div class="logo">
        <img src="images/vision_logo.png" alt="Vision Verse Logo"> <span>Vision Verse <sub>ADMIN</sub></span>
    </div>
    <div class="nav">
        <a href="admin_dashboard.html">Dashboard</a>
        <a href="admin_products.html">Products</a>
        <a href="customers.html">Customers</a>
        <a href="adminhistory.html">History</a>
        <a href="admin_orders.html">Orders</a>
    </div>
    <div class="icons">
        <span class="icon"><i class="fas fa-search" title="Search"></i></span>
        <span class="icon"><i class="fas fa-bell" title="Notifications"></i></span>
        <a href="adminsetting.html"><span class="icon"><i class="fas fa-gear" title="Settings"></i></span></a>
    </div>
</div>

<!-- Product Form -->
<h1>Add Product</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required>

    <label for="product_details">Product Details:</label>
    <textarea id="product_details" name="product_details" required></textarea>

    <label for="product_category">Product Category:</label>
    <select id="product_category" name="product_category" required>
        <option value="VR">VR</option>
        <option value="AR">AR</option>
    </select>

    <label for="product_color">Product Color:</label>
    <input type="text" id="product_color" name="product_color" required>

    <label for="product_size">Product Size:</label>
    <input type="text" id="product_size" name="product_size" required>

    <label for="product_quantity">Product Quantity:</label>
    <input type="number" id="product_quantity" name="product_quantity" required>

    <label for="product_price">Product Price:</label>
    <input type="number" id="product_price" name="product_price" required>

    <label for="product_image">Product Image:</label>
    <input type="file" id="product_image" name="product_image">

    <button type="submit">Add Product</button>
</form>

</body>
</html>
