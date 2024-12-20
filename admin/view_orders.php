<?php
require 'db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'create') {
       
        $customer = htmlspecialchars($_POST['customer']);
        $productId = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $paymentMethod = htmlspecialchars($_POST['payment_method']);

        
        $stmtOrder = $conn->prepare("INSERT INTO orders (customer) VALUES (?)");
        $stmtOrder->bind_param("s", $customer);

        if ($stmtOrder->execute()) {
            $orderId = $stmtOrder->insert_id;

          
            $stmtGetCustomerId = $conn->prepare("SELECT customer_id FROM orders WHERE id = ?");
            $stmtGetCustomerId->bind_param("i", $orderId);
            $stmtGetCustomerId->execute();
            $stmtGetCustomerId->bind_result($customerId);
            $stmtGetCustomerId->fetch();
            $stmtGetCustomerId->close();

            
            $stmtDetails = $conn->prepare("INSERT INTO order_details (order_id, product_id, order_quantity, customer_id, payment_method, status) 
                                           VALUES (?, ?, ?, ?, ?, 'Pending')");
            $stmtDetails->bind_param("iiiss", $orderId, $productId, $quantity, $customerId, $paymentMethod);
            $stmtDetails->execute();
            $stmtDetails->close();
        }
        $stmtOrder->close();
    } elseif ($action === 'update') {
     
        $orderId = intval($_POST['order_id']);
        $quantity = intval($_POST['quantity']);
        $paymentMethod = htmlspecialchars($_POST['payment_method']);
        $stmtUpdate = $conn->prepare("UPDATE order_details SET order_quantity = ?, payment_method = ? WHERE order_id = ?");
        $stmtUpdate->bind_param("isi", $quantity, $paymentMethod, $orderId);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    } elseif ($action === 'delete') {
     
        $orderId = intval($_POST['order_id']);
        $stmtDeleteDetails = $conn->prepare("DELETE FROM order_details WHERE order_id = ?");
        $stmtDeleteDetails->bind_param("i", $orderId);
        $stmtDeleteDetails->execute();
        $stmtDeleteDetails->close();

        $stmtDeleteOrder = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmtDeleteOrder->bind_param("i", $orderId);
        $stmtDeleteOrder->execute();
        $stmtDeleteOrder->close();
    }
}


$query = "
    SELECT o.id AS order_id, o.customer, od.product_id, od.order_quantity, od.payment_method, od.status, o.created_at
    FROM orders o
    JOIN order_details od ON o.id = od.order_id
    ORDER BY o.created_at DESC";
$orderResults = $conn->query($query);
?>
