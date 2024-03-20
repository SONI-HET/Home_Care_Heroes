<?php
require 'config.php';

// Check if user is logged in
if(empty($_SESSION["id"])){
  header("Location: login.php");
  exit(); // Stop further execution
}

// Fetch user data from the database
$id = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($result);

// Check if form is submitted for updating user details
if(isset($_POST["update"])){
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $address = $_POST["address"];

  // Update user details in the database
  $query = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address' WHERE id = $id";
  if(mysqli_query($conn, $query)){
    // Update successful, refresh the page to display updated information
    echo "<script> alert('Your Profile Has Been Updated Successfully'); </script>";

    header("Refresh:0");
    exit(); // Stop further execution
  } else {
    echo "<script>alert('Failed to update user details');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-image: url('bg.jpeg');
      background-attachment: fixed; /* Fix the background image */

      background-size: cover;
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

    .button-container1 {
      display: flex;
      align-items: center;
    }

    .button {
      padding: 12px 24px;
      background-color: #8b5a2b;
      color: white;
      text-align: center;
      font-size: 18px;
      border-radius: 8px;
      margin-right: 50px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    .profilebutton {
      padding: 12px 24px;
      background-color: #4d2c12;
      color: white;
      text-align: center;
      font-size: 18px;
      border-radius: 8px;
      margin-right: 50px;
      text-decoration: none;
      transition: 0.3s ease-in;
    }

    .profilebutton:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    /* Profile Page Styles */
    .form-container {
      max-width: 450px;
      width: 100%;
      padding: 10px 20px; /* Decreased padding */
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
      margin-top: 100px; /* Adjusted margin top */
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
    input[type=email],
    input[type=password] {
      width: calc(100% - 40px); /* Decreased width to accommodate icon */
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    input[type=text]:focus,
    input[type=email]:focus,
    input[type=password]:focus {
      outline: none;
      border-color: #8b5a2b;
    }

    .icon-container {
      position: relative;
    }

    .icon-container .fa-pencil-alt {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #8b5a2b;
    }

    button {
      background-color: #8b5a2b;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    .update {
        width: 100%;
    }

    .button-container::after {
      content: "";
      display: table;
      clear: both;
    }

    .button-container button,
    .button-container a {
      background-color: transparent;
      border: none;
      color: #8b5a2b;
      font-size: 16px;
      cursor: pointer;
      text-decoration: underline;
    }

    .button-container button:hover,
    .button-container a:hover {
      text-decoration: none;
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

    /* Additional Styles */
    .button-container2 {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <header>
  <a href="index.php" class="logo"></a> <!-- Add anchor tag here -->
    <div class="button-container1">
      <a href="./plumber.php " class="button">Dashboard</a>
      <a href="./about_us2.php" class="button">About Us</a>
      <a href="./contact.html" class="button">Contact Now</a>
      <a href="./profile.php" class="profilebutton">View Profile</a>
      <a href="./logout.php" class="button">Logout</a>
    </div>
  </header>

  <div class="form-container">
    <h2>User Profile</h2>
    <form method="post">
      <div class="icon-container">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required readonly>
        <i class="fas fa-pencil-alt"></i>
      </div>

      <div class="icon-container">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required readonly>
        <i class="fas fa-pencil-alt"></i>
      </div>

      <div class="icon-container">
        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" value="<?php echo $row['phone']; ?>" required readonly>
        <i class="fas fa-pencil-alt"></i>
      </div>

      <div class="icon-container">
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $row['address']; ?>" required readonly>
        <i class="fas fa-pencil-alt"></i>
      </div>

      <button class="update" type="submit" name="update">Update</button>
    </form>

    <div class="button-container">
      <a href="dashboard.html" >Go Back</button>
      <a href="forgot_password.php"  style="margin-left: 250px;">Change Password</a>
    </div>
  </div>

  <script>
    document.querySelectorAll('.icon-container .fa-pencil-alt').forEach(icon => {
      icon.addEventListener('click', () => {
        const input = icon.previousElementSibling;
        input.readOnly = !input.readOnly;
        input.focus();
      });
    });
  </script>
</body>
</html>
