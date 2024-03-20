<?php
require 'config.php';

if (!empty($_SESSION["id"])) {
  header("Location: index.php");
}

if (isset($_POST["register"])) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  $phone = $_POST["phone"];
  $address = $_POST["address"];
  $user_type = $_POST["user_type"];

  $hashed_password = hash('sha512', $password);

  $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
  if (mysqli_num_rows($duplicate) > 0) {
    echo "<script> alert('Email Has Already Been Used'); </script>";
  } else {
    if ($password == $confirmpassword) {
      $query = "INSERT INTO users (name, email, password, phone, address, user_type) VALUES('$name','$email','$hashed_password','$phone','$address','$user_type')";
      if (mysqli_query($conn, $query)) {
        echo "<script> alert('Registration Successful'); window.location='login.php'; </script>";
        echo "<script> alert('user_type $user_type'); </script>";

        if ($user_type === 'laundry_service_provider') {
          $insert_prices_query = "INSERT INTO manage_prices (name, wash_and_fold_price, wash_and_iron_price, dry_clean_price) VALUES ('$name', 0, 0, 0)";
          mysqli_query($conn, $insert_prices_query);
        }
      }
      else{
        echo "<script> alert('user_type $user_type'); </script>";

      }
    } else {
      echo "<script> alert('Password Does Not Match'); </script>";
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Registration</title>
  <style>
    body {
      background-image: url('bg.jpeg');
      background-size: cover;
      background-attachment: fixed; /* Fix the background image */

      font-family: Arial, sans-serif;
      background-color: #F9F9F9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
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

    /* Adjust registration card position */
    .form-container {
      max-width: 500px;
      width: 100%;
      padding: 10px 20px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
      margin-top: 200px;
      /* Add margin to the top */
    }

    /* .form-container:hover {
    transform: scale(1.05);
  } */

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
    input[type=email],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
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
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    .register-btn {
      width: auto;
      padding: 14px 20px;
      border: none;
      border-radius: 5px;
      color: #8b5a2b;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .register-btn:hover {
      opacity: 0.8;
      background-color: #714623;
      color: white;
    }

    .forgot-password {
      text-decoration: none;
      margin-right: 10px;
      color: #8b5a2b;
      font-size: 16px;
      margin-left: auto;
    }

    .button-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 57%;
      /* Adjust the width of the button container */

    }

    .button-container::after {
      content: "";
      display: table;
      clear: both;
    }

    .registerbutton {
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

    .registerbutton:hover {
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
    .logo {
            background-image: url('image.png');
            background-size: cover;
            width: 50px; /* Adjust the width as needed */
            height: 50px; /* Adjust the height as needed */
            border-radius: 50%; /* Make the image circular */
            overflow: hidden; /* Hide any content outside the border-radius */
            cursor: pointer;
        }

    .button-container a:hover {
      text-decoration: underline;
    }
  </style>

</head>

<body>
  <header>
  <a href="index.php" class="logo"></a> <!-- Add anchor tag here -->
    <div class="button-container">
      <a href="#" class="registerbutton">Registration</a>
      <a href="./login.php" class="button">Login</a>
      <a href="#" onclick="showAlert()" class="button">Services</a>
      <a href="#" onclick="showAlert()" class="button">About Us</a>
      <a href="#" onclick="showAlert()" class="button">Contact Now</a>
    </div>
  </header>

  <div class="form-container">
    <h2>Registration</h2>
    <form method="post" autocomplete="off">
      <div class="container">
        <label for="name"><b>Name:</b></label>
        <input type="text" placeholder="Enter Name" name="name" required>

        <label for="email"><b>Email:</b></label>
        <input type="email" placeholder="Enter Email" name="email" required>

        <label for="password"><b>Password:</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <label for="confirmpassword"><b>Confirm Password:</b></label>
        <input type="password" placeholder="Confirm Password" name="confirmpassword" required>

        <label for="phone"><b>Phone Number:</b></label>
        <input type="text" placeholder="Enter Phone Number" name="phone" required>

        <label for="address"><b>Address:</b></label>
        <input type="text" placeholder="Enter Address" name="address" required>

        <!-- Radio buttons for user type selection -->
        <label><b>Type:</b></label>
        <div class="radio-container">
          <label><input type="radio" name="user_type" value="user" checked> User</label>
          <label><input type="radio" name="user_type" value="laundry_service_provider"> Laundry Service Provider</label>
          <label><input type="radio" name="user_type" value="carpenter"> Carpenter</label>
          <label><input type="radio" name="user_type" value="plumber">Plumber</label>
        </div>
        <button type="submit" name="register">Register</button>
        <div class="button-container">
          <a href="login.php" class="register-btn">Login</a>
          <a href="forgot_password.php" class="forgot-password">Forgot password?</a>
        </div>
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