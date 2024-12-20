<?php

require 'db_connection.php';


if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    
    $sql = "DELETE FROM tbl_products WHERE product_id = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='view_products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product: " . $conn->error . "'); window.location.href='view_products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid product ID.'); window.location.href='view_products.php';</script>";
}
?>
