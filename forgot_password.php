<?php
require 'config.php';

if(isset($_POST["submit"])){
  $username = $_POST["username"];
  $current_password = $_POST["current_password"];
  $new_password = $_POST["new_password"];
  $confirm_new_password = $_POST["confirm_new_password"];

  // Fetch the current user's password from the database
  $result = mysqli_query($conn, "SELECT password FROM users WHERE name = '$username'");
  if(mysqli_num_rows($result) == 0){
    $message = "<span style='color:red'>Username not found.</span>";
  } else {
    $row = mysqli_fetch_assoc($result);
    $stored_password = $row['password'];

    // Verify if the provided current password matches the one stored in the database
    if($current_password == $stored_password){
      // Verify if the new password matches the confirm new password
      if($new_password == $confirm_new_password){
        // Update the database with the new password
        mysqli_query($conn, "UPDATE users SET password = '$new_password' WHERE name = '$username'");
        $message = "<span style='color:green'>Your password has been reset.</span>";
      } else {
        $message = "<span style='color:red'>New password and confirm new password do not match.</span>";
      }
    } else {
      $message = "<span style='color:red'>Incorrect current password.</span>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
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

    form {
      border: 3px solid #f1f1f1;
      background-color: rgba(255, 255, 255, 0.8); /* Set background color to transparent white */
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease; /* Add transition for transform */
    }

    form:hover {
      transform: scale(1.02); /* Scale the form container by 2% on hover */
    }

    h1 {
      text-align: center;
      margin-top: 0;
      color: #8b5a2b;
      margin-bottom: 20px;
      font-size: 24px;
    }

    label {
      font-size: 18px;
      color: #8b5a2b;
    }

    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button[name=submit] {
      background-color: #8b5a2b; /* Wooden theme color */
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    button[name=submit]:hover {
      opacity: 0.8;
      background-color: #714623; /* Darker shade on hover */
    }

    a[href="login.php"] {
      float: right;
      color: #8b5a2b;
      font-size: 16px;
      text-decoration: none;
    }

    a[href="login.php"]:hover {
      text-decoration: underline;
    }

    .container {
      padding: 16px;
    }

    span.psw {
      float: right;
      padding-top: 16px;
    }

    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }

    @media screen and (max-width: 300px) {
      span.psw {
        display: block;
        float: none;
      }

      button[name=submit] {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <form method="post">
    <h1>Forgot Password</h1>
    <?php if(isset($message)) echo "<p>$message</p>"; ?>

    <label for="username">Username:</label>
    <input type="text" placeholder="Enter Your Username" name="username" required>
    <br>
    <label for="current_password">Current Password:</label>
    <input type="password" placeholder="Enter Your Current Password" name="current_password" required>
    <br>
    <label for="new_password">New Password:</label>
    <input type="password" placeholder="Enter Your New Password" name="new_password" required>
    <br>
    <label for="confirm_new_password">Confirm New Password:</label>
    <input type="password" placeholder="Confirm Your New Password" name="confirm_new_password" required>
    <br>
    <button type="submit" name="submit">Reset Password</button>
    <a href="login.php">Back to Login</a>
  </form>
</body>

</html>
