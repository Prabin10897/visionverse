<?php
require 'db_connection.php';

// Query to fetch product and category details
$sql = "SELECT 
            tbl_products.product_id, 
            tbl_products.product_name, 
            tbl_products.product_details, 
            tbl_products.product_image, 
            tbl_products.product_quantity, 
            tbl_products.product_price, 
            tbl_categories.product_category, 
            tbl_categories.product_color, 
            tbl_categories.product_size 
        FROM tbl_products
        INNER JOIN tbl_categories ON tbl_products.category_id = tbl_categories.category_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f9fafc;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        /* Header Styling */
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
            color: #333;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        table th {
            background-color: #f4f4f4;
        }

        table img {
            max-width: 80px;
            border-radius: 4px;
        }

        .action-btn {
            text-decoration: none;
            padding: 6px 12px;
            color: white;
            border-radius: 4px;
            margin: 0 5px;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .action-btn:hover {
            opacity: 0.9;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="logo">
            <img src="images/vision_logo.png" alt="Vision Verse Logo"> 
            <span>Vision Verse <sub>ADMIN</sub></span>
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

    <!-- Product Management Table -->
    <h1>Product Management</h1>
    <table>
        <thead>
            <tr>
                <th>Serial No.</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Details</th>
                <th>Product Price</th>
                <th>Product Category</th>
                <th>Product Size</th>
                <th>Product Color</th>
                <th>Product Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $serial_no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $serial_no++; ?></td>
                        <td><img src="uploads/<?= htmlspecialchars($row['product_image']); ?>" alt="Product Image"></td>
                        <td><?= htmlspecialchars($row['product_name']); ?></td>
                        <td><?= htmlspecialchars($row['product_details']); ?></td>
                        <td>$<?= htmlspecialchars($row['product_price']); ?></td>
                        <td><?= htmlspecialchars($row['product_category']); ?></td>
                        <td><?= htmlspecialchars($row['product_size']); ?></td>
                        <td><?= htmlspecialchars($row['product_color']); ?></td>
                        <td><?= htmlspecialchars($row['product_quantity']); ?></td>
                        <td>
                            <a href="edit_product.php?product_id=<?= $row['product_id']; ?>" class="action-btn edit-btn">Edit</a>
                            <a href="delete_product.php?product_id=<?= $row['product_id']; ?>" 
                               class="action-btn delete-btn" 
                               onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
