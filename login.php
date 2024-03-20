<?php
require 'config.php';

if(isset($_SESSION["id"])){
  header("Location: index.php");
  exit();
}

if(isset($_POST["submit"])){
  $usernameemail = $_POST["usernameemail"];
  $password = $_POST["password"];

  $hashed_password = hash('sha512', $password);

  $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);
  if(mysqli_num_rows($result) > 0){
    if($hashed_password == $row['password']){
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id"];
      $_SESSION["email"] = $row['email']; // Assuming $user_email is the user's email
      $_SESSION["name"] = $row['name']; // Assuming $user_name is the user's name
      $_SESSION["phone"] = $row['phone']; // Assuming $user_phone is the user's phone number
      $_SESSION["address"] = $row['address']; 
      
      // Redirect based on user type
      switch($row['user_type']) {
        case 'user':
          echo "<script> alert('Login Successful'); window.location='index.php'; </script>";
          break;
        case 'laundry_service_provider':
          echo "<script> alert('Login Successful'); window.location='laundry_service_provider.php'; </script>";
          break;
        case 'carpenter':
          echo "<script> alert('Login Successful'); window.location='carpenter.php'; </script>";
          break;
        case 'plumber':
          echo "<script> alert('Login Successful'); window.location='plumber.php'; </script>";
          break;
      }
      exit();
    }
    else{
      echo "<script> alert('Wrong Password'); </script>";
    }
  }
  else{
    echo "<script> alert('User Not Registered'); </script>";
  }
}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <style>
    body {
      background-size: cover;
      font-family: Arial, sans-serif;
      background-image: url('bg.jpeg');
      background-attachment: fixed; /* Fix the background image */

      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    
.logo {
            background-image: url('image.png');
            background-size: cover;
            width: 50px; /* Adjust the width as needed */
            height: 50px; /* Adjust the height as needed */
            border-radius: 50%; /* Make the image circular */
            overflow: hidden; /* Hide any content outside the border-radius */
            cursor: pointer;
        }


    .login-container {
      max-width: 400px;
      width: 100%;
      padding: 25px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    h2 {
      text-align: center;
      margin-top: 0;
      color: #8b5a2b;
      margin-bottom: 20px;
    }

    label {
      font-size: 18px;
      color: #8b5a2b;
    }

    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button {
      background-color: #8b5a2b;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
      transition: 0.3s ease-in;
    }

    button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    .register-btn {
      width: auto;
      color: #8b5a2b;
      padding: 10px 18px;
      background-color: transparent;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      text-align: center;
      transition: background-color 0.3s ease;
    }

    .forgot-password {
      text-decoration: none;
      margin-left: auto;
      color: #8b5a2b;
      float: right;
      font-size: 16px;
    }

    .button-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 57%; /* Adjust the width of the button container */

    }

    .button-container::after {
      content: "";
      display: table;
      clear: both;
    }

    .loginbutton{
      padding: 12px 24px;
      background-color: #4d2c12;
      color: white;
      text-align: center;
      font-size: 18px;
      border-radius: 8px;
      margin-right: 10px;
      text-decoration: none;
      transition: 0.3s ease-in;
    }
    .loginbutton:hover{
      opacity: 0.8;
      background-color: #714623;
    }
    .button {
      padding: 12px 24px;
      background-color: #8b5a2b;
      color: white;
      text-align: center;
      font-size: 18px;
      border-radius: 8px;
      margin-right: 10px;
      text-decoration: none;
      transition: 0.3s ease-in;
    }

    .button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    .button-container a {
      text-decoration: none;
      /* color: #8b5a2b; */
      font-size: 16px;
    }

    .button-container a:hover {
      text-decoration: underline;
    }

    /* Header Styles */
    header {
      width: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }

    .logo {
      font-size: 24px;
      color: #8b5a2b;
    }
  </style>
</head>

<body>
  <header>
  <a href="index.php" class="logo"></a> <!-- Add anchor tag here -->
    <div class="button-container">
      <a href="./registration.php" class="button">Registration</a>
      <a href="#" onclick="showAlert()" class="loginbutton">Login</a>
      <a href="#" onclick="showAlert()" class="button">Services</a>
      <a href="#" onclick="showAlert()"  class="button">About Us</a>
      <a href="#" onclick="showAlert()" class="button">Contact Now</a>
    </div>
  </header>

  <div class="login-container">
    <h2>Login</h2>
    <form class="" action="" method="post">
      <label for="usernameemail">Email:</label>
      <input type="text" placeholder="Enter Your Email Address" name="usernameemail" id="usernameemail" required> <br>
      <label for="password">Password:</label>
      <input type="password" placeholder="Enter Your Password" name="password" id="password" required> <br>
      <button type="submit" name="submit">Login</button>
      <br>

      <div class="button-container">
        <a href="registration.php" class="register-btn">Register</a>
        <a href="forgot_password.php" class="forgot-password">Forgot password?</a>
      </div>
    </form>
  </div>

  <script>
    function showAlert() {
      alert("You need to login first!");
    }
  </script>
</body>

</html>
