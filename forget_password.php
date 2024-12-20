<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';  



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    
    $conn = new mysqli('localhost', 'root', '', 'ecommerce');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

 
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        
        $token = bin2hex(random_bytes(50)); 
        $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

      
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiration = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expires, $email);
        $stmt->execute();

       
        $mail = new PHPMailer(true);
        try {
       
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'sushilbasnet928@gmail.com';  
            $mail->Password = 'sfgx pdjp qgfi aseb';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

           
            $mail->setFrom('sushilbasnet928@gmail.com', 'Vision Pro Official');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the link below to reset your password:<br><br><a href='http://yourdomain.com/reset_password.php?token=$token'>Reset Password</a>";

           
            $mail->send();
            $success = "Password reset link sent to your email.";
        } catch (Exception $e) {
            $error = "Failed to send the email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Forgot Password</h2>
        <?php if (isset($error)) echo "<div style='color: red;'>$error</div>"; ?>
        <?php if (isset($success)) echo "<div style='color: green;'>$success</div>"; ?>
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
