<?php
session_start(); // Start session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    // Include database configuration
    include('../api/dbconnect.php'); // Include your database connection file

    // Get input values from the form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user credentials
    $sql = "select * from users where email = '$email' and password = '$password' ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if($count==1){
      header("Location:home.php");
    }
    else{
      echo '<script>
         window.location.href ="login.php"
         alert("Login failed. Invalid email or password!!!")
         </script>';
    }
  
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
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
    <form name="form" action="login.php" onsubmit="return isvalid()" method="post">
      <h2>Login</h2>
      <?php
      if (isset($error_message)) {
          echo '<p style="color: red;">' . $error_message . '</p>';
      }
      ?>
      <div class="input-field">
        <input type="text" name="email">
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="password">
        <label>Enter your password</label>
      </div>
      <div class="forget">
        <a href="forget.php">Forgot password?</a>
      </div>
      <input type="submit" id="btn" value="Login" name="login"/>
      <div class="register">
        <p>Don't have an account? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>
  <script>
    function isvalid(){
      var email = document.form.user.value;
      var password = document.form.user.value;
      if(email.length=="" && password.length==""){
      alert("Email and Password field is empty!!!");
      return false
      }
      else{
        if(email.length==""){
          alert("Email is empty!!!");
          return false
        }
        if(Password.length==""){
          alert("Password is Empty!!!")
          return false
        }
      }
    }
  </script>
</body>
</html>