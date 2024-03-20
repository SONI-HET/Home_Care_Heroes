<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Services</title>
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
            background-image: url('image.png');
            background-size: cover;
            width: 50px; /* Adjust the width as needed */
            height: 50px; /* Adjust the height as needed */
            border-radius: 50%; /* Make the image circular */
            overflow: hidden; /* Hide any content outside the border-radius */
            cursor: pointer;
        }

    .button-container {
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

    .servicebutton{
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
    .servicebutton:hover{
      opacity: 0.8;
      background-color: #714623;
    }
    .service-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 100px;
    }

    .service {
      width: 250px;
      height: 150px;
      margin: 20px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      background-color: rgba(255, 255, 255, 0.8);
      transition: transform 0.3s ease;
      text-align: center;
    }

    .service:hover {
      transform: scale(1.05);
    }

    .service h3 {
      margin-top: 0;
      color: #8b5a2b;
    }

    .service p {
      margin-bottom: 15px;
      color: #8f5c2c;
    }

    .service a {
      display: inline-block;
      padding: 8px 15px;
      background-color: #8b5a2b;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .service a:hover {
      background-color: #714623;
    }
  </style>
</head>

<body>
  <header>
  <!-- <div class="logo">
  <img src="image.png" alt="Logo" style="width: 50px; height: 50px;"> -->
  <a href="index.php" class="logo"></a> <!-- Add anchor tag here -->

</div>

    <div class="button-container">
      <a href="#" class="servicebutton" >Services</a>
      <a href="./about_us.php" class="button" >About Us</a>
      <a href="./contact.html" class="button" >Contact Now</a>
      <a href="./profile.php" class="button" >View Profile</a>
      <a href="./logout.php" class="button" >Logout</a>
    </div>
  </header>
  <?php
  require 'config.php';
  if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
  } else {
    header("Location: login.php");
  }
  ?>
  <div class="service-container">
    <div class="service">
      <h3>Laundry Service</h3>
      <p>Get your clothes cleaned!</p>
      <a href="./dashboard.html" class="service-button">Explore</a>
    </div>
    <div class="service">
      <h3>Carpentry Service</h3>
      <p>Need something fixed or built?</p>
      <a href="./carpentry_service.php" class="service-button">Explore</a>
    </div>
    <div class="service">
      <h3>Plumbing Service</h3>
      <p>Got a leak or need a new installation?</p>
      <a href="./plumbing_service.php" class="service-button">Explore</a>
    </div>
  </div>

  <script>
   
  </script>
</body>

</html>
