<?php

require 'db_connection.php';


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
<html>
<head>
    <title>View Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .action-btn {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .edit-btn {
            background-color: #007BFF;
        }
        .delete-btn {
            background-color: #FF0000;
        }
    </style>
</head>
<body>
    <h1>View Products</h1>
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
                        <td><img src="uploads/<?= htmlspecialchars($row['product_image']); ?>" alt="Product Image" style="max-width: 80px;"></td>
                        <td><?= htmlspecialchars($row['product_name']); ?></td>
                        <td><?= htmlspecialchars($row['product_details']); ?></td>
                        <td><?= htmlspecialchars($row['product_price']); ?></td>
                        <td><?= htmlspecialchars($row['product_category']); ?></td>
                        <td><?= htmlspecialchars($row['product_size']); ?></td>
                        <td><?= htmlspecialchars($row['product_color']); ?></td>
                        <td><?= htmlspecialchars($row['product_quantity']); ?></td>
                        <td>
                            <a href="edit_product.php?product_id=<?= $row['product_id']; ?>" class="action-btn edit-btn">Edit</a>
                            <a href="delete_product.php?product_id=<?= $row['product_id']; ?>" class="action-btn delete-btn" 
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
