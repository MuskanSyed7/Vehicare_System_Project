<?php
session_start();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    include '../api/dbconnect.php'; // Ensure this path is correct

    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if email is already registered
    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script>alert('Email has already been taken');</script>";
    } else {
        // Check if passwords match
        if ($password == $confirm_password) {
            // Hash the password for security
            
            // Insert new user into database
            $query = "INSERT INTO users (email, password, dt) VALUES ('$email', '$password', NOW() )";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Registration Successful. You can now login.');</script>";
            } else {
                echo "<script>alert('Error registering user.');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>register</title>
<style>
   @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}
body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  width: 100%;
  padding: 0 10px;
}
body::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  background: url("https://lps-images.moneysmart.co/page/og_image/5b36ac4c0ec502d69efd876cf13759d1.png"), #000;
  background-position: center;
  background-size: cover;
}
.wrapper {
  width: 400px;
  border-radius: 8px;
  padding: 30px;
  text-align: center;
  border: 1px solid rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  position: absolute;
}
form {
  display: flex;
  flex-direction: column;
}
h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #fff;
}
.input-field {
  position: relative;
  border-bottom: 2px solid #ccc;
  margin: 15px 0;
}
.input-field label {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  color: #fff;
  font-size: 16px;
  pointer-events: none;
  transition: 0.15s ease;
}
.input-field input {
  width: 100%;
  height: 40px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
  color: #fff;
}
.input-field input:focus~label,
.input-field input:valid~label {
  font-size: 0.8rem;
  top: 10px;
  transform: translateY(-120%);
}
.forget {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 25px 0 35px 0;
  color: #fff;
}
#remember {
  accent-color: #fff;
}
.forget label {
  display: flex;
  align-items: center;
}
.forget label p {
  margin-left: 8px;
}
.wrapper a {
  color: #efefef;
  text-decoration: none;
}
.wrapper a:hover {
  text-decoration: underline;
}
#btn {
  background: #fff;
  color: #000;
  font-weight: 600;
  border: none;
  padding: 12px 20px;
  cursor: pointer;
  border-radius: 3px;
  font-size: 16px;
  border: 2px solid transparent;
  transition: 0.3s ease;
}
#btn:hover {
  color: #fff;
  border-color: #fff;
  background: rgba(255, 255, 255, 0.15);
}
.register {
  text-align: center;
  margin-top: 30px;
  color: #fff;
}
   </style>
</head>
<body>

  <div class="wrapper">
    <form action="register.php" method="post">
      <h2>Register</h2>
      <div class="input-field">
        <input type="text" id="email" name="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" id="password" name="password" required>
        <label>Enter your password</label>
      </div>
      <div class="input-field">
        <input type="password" id="confirm_password" name="confirm_password" required>
        <label>Confirm password</label>
      </div>
      <input type="submit" id="btn" value="Register" name="submit"/>
      <div class="register">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>

</body>
</html>