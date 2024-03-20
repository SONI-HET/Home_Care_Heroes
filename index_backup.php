<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>User Dashboard</title>
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
      font-size: 24px;
      color: #8b5a2b;
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
      margin-right: 10px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    .welcome-container {
      margin-top: 100px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .welcome {
      width: 60%;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      margin-bottom: 20px;
      transition: transform 0.3s ease;
    }

    .welcome:hover {
      transform: scale(1.05);
    }

    h1 {
      font-size: 50px;
      color: #8b5a2b;
    }

    p {
      font-size: 24px;
      color: #8f5c2c;
    }

    .paragraph-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 20px;
    }

    .paragraph {
      width: 60%;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .paragraph:hover {
      transform: scale(1.05);
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
    }

    .card {
      width: 250px;
      height: 150px;
      margin: 10px;
      padding: 20px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      background-color: rgba(255, 255, 255, 0.8);
      transition: transform 0.3s ease;
      text-align: center;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card h3 {
      margin-top: 0;
      color: #8b5a2b;
    }

    .card p {
      margin-bottom: 15px;
      color: #8f5c2c;
    }

    .card a {
      display: inline-block;
      padding: 8px 15px;
      background-color: #8b5a2b;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .card a:hover {
      background-color: #714623;
    }
  </style>
</head>

<body>
  <header>
    <div class="logo">Logo Here</div>
    <div class="button-container">
      <a href="./laundry_request.php" class="button">Book Now</a>
      <a href="./profile.php" class="button">View Profile</a>
      <a href="./notification.php" class="button">View Notifications</a>
      <a href="./contact.html" class="button">Contact Now</a>
      <a href="./logout.php" class="button">Logoout</a>
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

  <div class="welcome-container">
    <div class="welcome">
      <h1>Welcome <span style="color: #433322;"><?php echo $row["name"]; ?></span> to our website !!</h1>
      <p>Our system is designed to make your laundry management easier and more efficient. With our user-friendly interface, you can easily manage all your laundry requests, view notifications, and update your account information.</p>
      <p>We understand that laundry day can be a hassle, but our system is here to help you streamline the process and make it a breeze. Whether you need a quick wash and fold, or a more extensive dry cleaning service, we've got you covered.</p>
      <p>Thank you for choosing us. We're excited to make your laundry experience as stress-free as possible!</p>
      <a href="dashboard.html" class="button">Go To Dashboard</a>
    </div>

    <div class="paragraph-container">
      <div class="paragraph">
        <h2>Additional Information</h2>
        <p>This section provides additional information about our services. Feel free to explore!</p>
      </div>
    </div>
  </div>

  <!-- <div class="card-container">
    <div class="card">
      <h3>Laundry Request</h3>
      <p>Book a new laundry request</p>
      <a href="laundry_request.php">Book now</a>
    </div>

    <div class="card">
      <h3>View Request</h3>
      <p>View your request here</p>
      <a href="view_request.php">View now</a>
    </div>

    <div class="card">
      <h3>Notification</h3>
      <p>View notifications and updates</p>
      <a href="notification.php">View now</a>
    </div>

    <div class="card">
      <h3>Profile</h3>
      <p>View and edit your profile</p>
      <a href="profile.php">View now</a>
    </div>

    <div class="card">
      <h3>Contact Us</h3>
      <p>Get in touch with our support team</p>
      <a href="contact.html">Contact now</a>
    </div>

    <div class="card">
      <h3>Feedback</h3>
      <p>Give your feedback about our service</p>
      <a href="feedback.html">Feedback form</a>
    </div>
  </div> -->

</body>

</html>
