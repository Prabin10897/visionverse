<?php

require 'db_connection.php';


$sql_categories = "SELECT category_id, product_category FROM tbl_categories";
$result_categories = $conn->query($sql_categories);


$product = [
    'product_name' => '',
    'product_details' => '',
    'category_id' => '',
    'product_quantity' => '',
    'product_price' => '',
    'product_image' => ''
];


if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql_product = "SELECT * FROM tbl_products WHERE product_id = $product_id";
    $result_product = $conn->query($sql_product);

    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>No product ID provided.</p>";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_details = $_POST['product_details'];
    $category_id = $_POST['category_id'];
    $product_quantity = $_POST['product_quantity'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];

    
    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);
    } else {
        $product_image = $product['product_image']; 
    }

   
    $sql_update = "UPDATE tbl_products 
                   SET product_name = '$product_name',
                       product_details = '$product_details',
                       category_id = '$category_id',
                       product_quantity = '$product_quantity',
                       product_price = '$product_price',
                       product_image = '$product_image' 
                   WHERE product_id = $product_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<p>Product updated successfully!</p>";
    } else {
        echo "<p>Error: " . $sql_update . "<br>" . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        form {
            width: 400px;
            margin: 0 auto;
        }
        input, select, textarea {
            width: 100%;
            margin: 10px 0;
            padding: 8px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Edit Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>

        <label for="product_details">Product Details:</label>
        <textarea id="product_details" name="product_details" required><?= htmlspecialchars($product['product_details']) ?></textarea>

        <label for="category_id">Product Category:</label>
        <select id="category_id" name="category_id" required>
            <?php while ($row = $result_categories->fetch_assoc()): ?>
                <option value="<?= $row['category_id'] ?>" 
                    <?= $row['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['product_category']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="product_quantity">Product Quantity:</label>
        <input type="number" id="product_quantity" name="product_quantity" value="<?= htmlspecialchars($product['product_quantity']) ?>" required>

        <label for="product_price">Product Price:</label>
        <input type="number" id="product_price" name="product_price" value="<?= htmlspecialchars($product['product_price']) ?>" required>

        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image">
        <?php if (!empty($product['product_image'])): ?>
            <p>Current Image: <img src="uploads/<?= htmlspecialchars($product['product_image']) ?>" alt="Product Image" style="max-width: 100px;"></p>
        <?php endif; ?>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
