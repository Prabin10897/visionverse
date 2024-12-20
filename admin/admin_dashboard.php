<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vision_verse"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM tbl_users WHERE admin_id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php"); 
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}


if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];  

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "UPDATE tbl_users SET username = '$username', password = '$hashed_password' WHERE admin_id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php"); 
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}


$sql = "SELECT * FROM tbl_users ORDER BY admin_id DESC";
$result = $conn->query($sql);


$edit_user = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_query = "SELECT * FROM tbl_users WHERE admin_id = $edit_id";
    $edit_result = $conn->query($edit_query);
    if ($edit_result->num_rows > 0) {
        $edit_user = $edit_result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table td {
            font-size: 14px;
        }

        .btn {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            background-color: red;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: darkred;
        }

        .edit-form {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-form h2 {
            margin-bottom: 10px;
        }

        .edit-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Dashboard</h1>

    
    <?php if ($edit_user): ?>
        <div class="edit-form">
            <h2>Edit User</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $edit_user['admin_id'] ?>">
                <label>Username:</label>
                <input type="text" name="username" value="<?= $edit_user['username'] ?>" required>
                <label>Password:</label>
                <input type="password" name="password" value="" required placeholder="Enter new password">
                <label>Email:</label>
                <input type="text" value="<?= $edit_user['email'] ?>" readonly disabled>
                <button type="submit" name="update_user">Update</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- User List -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['admin_id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td>
                            <a href="?edit_id=<?= $row['admin_id'] ?>" class="btn">Edit</a>
                            <a href="?delete_id=<?= $row['admin_id'] ?>" class="btn">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
