<?php
// Include the database connection file
include('db_connection.php');

// Fetch orders from the database
$query = "SELECT * FROM tbl_orders";
$result = mysqli_query($conn, $query);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $orders = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
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

        table td input {
            width: 80%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 6px 12px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .actions button {
            margin: 0 5px;
        }
    </style>
</head>
<body>

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
          <a  href="adminsetting.html"> <span class="icon"><i class="fas fa-gear" title="setting"></i></span></a>
      </div>
    </div>

    <h1>Order Management</h1>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Product</th>
                <th>Status</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) {
                foreach ($orders as $order) { ?>
                    <tr>
                        <td><input type="text" value="<?= $order['id'] ?>" disabled></td>
                        <td><input type="text" value="<?= $order['customer_name'] ?>" disabled></td>
                        <td><input type="text" value="<?= $order['product'] ?>" disabled></td>
                        <td><input type="text" value="<?= $order['status'] ?>" disabled></td>
                        <td><input type="text" value="<?= "$" . number_format($order['total'], 2) ?>" disabled></td>
                        <td class="actions">
                            <button>Edit</button>
                            <button>Delete</button>
                        </td>
                    </tr>
            <?php } } else { ?>
                <tr><td colspan="6">No orders found.</td></tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>

<?php

mysqli_close($conn);
?>
