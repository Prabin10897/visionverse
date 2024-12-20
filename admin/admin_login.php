<?php
session_start();
include "db_connection.php"; // Include your database connection file

$errMsg = ''; // To display error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $hashed_password = sha1($password); // Hash the password for comparison

    // Check if user exists in the database
    $query = "SELECT * FROM admins WHERE username='$username'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Validate credentials
        if ($data['password'] == $hashed_password) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $data['id'];
            $_SESSION['username'] = $data['username'];

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $errMsg = "Invalid password.";
        }
    } else {
        $errMsg = "Username not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vision Verse Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        body {
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        a {
            text-decoration: none;
            color: #4a00c0;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 350px;
            text-align: center;
        }

        .logo img {
            width: 80px;
            margin-bottom: 10px;
        }

        .logo h1 {
            font-family: "Oleo Script Swash Caps";
            font-size: 1.8rem;
            color: #333;
        }

        .input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .input-group i {
            margin-right: 10px;
            font-size: 1.2rem;
            color: #666;
        }

        .input-group input {
            border: none;
            outline: none;
            width: 100%;
            background-color: #f9f9f9;
        }

        .login-button {
            background-color: #000000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
        }

        .login-button:hover {
            background-color: #505050;
        }

        .forgot-password {
            text-align: right;
            margin-top: 5px;
        }

        .signup-link {
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .error-msg {
            color: red;
            font-size: 0.9rem;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="./images/vision_logo.png" alt="Vision Verse Logo">
            <h1>Vision Verse</h1>
        </div>
        <?php if ($errMsg): ?>
            <div class="error-msg"><?php echo $errMsg; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="forgot-password">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>
            <button type="submit" class="login-button">LOGIN</button>
        </form>
        <div class="signup-link">
            Don't have an account? <a href="signup.php">SIGNUP</a>
        </div>
        <br>
        <a href="customer_login.php">Login as Customer</a>
    </div>
</body>

</html>
