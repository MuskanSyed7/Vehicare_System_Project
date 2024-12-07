<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    include '../api/dbconnect.php'; 

    $email = $_POST["email"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($result) > 0) {
    
        $temp_password = substr(md5(mt_rand()), 0, 8);
        
        $hashed_temp_password = password_hash($temp_password, PASSWORD_DEFAULT);
        
        $update_query = "UPDATE users SET password = '$hashed_temp_password' WHERE email = '$email'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            $to = $email;
            $subject = "Temporary Password";
            $message = "Your temporary password is: $temp_password";
            $headers = "From: your_email@example.com";

            if (mail($to, $subject, $message, $headers)) {
                echo "<script>alert('A temporary password has been sent to your email.');</script>";
            } else {
                echo "<script>alert('Failed to send email. Please try again later.');</script>";
            }
        } else {
            echo "<script>alert('Failed to update password.');</script>";
        }
    } else {
        echo "<script>alert('Email not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <style>

  </style>
</head>
<body>

  <div class="wrapper">
    <form action="forgot.php" method="post">
      <h2>Forgot Password</h2>
      <div class="input-field">
        <input type="email" id="email" name="email" required>
        <label>Enter your email</label>
      </div>
      <input type="submit" id="btn" value="Submit" name="submit"/>
      <div class="back">
        <a href="login.php">Back to Login</a>
      </div>
    </form>
  </div>

</body>
</html>
