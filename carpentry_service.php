<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Additional styles for aligning content */
    body {
      background-attachment: fixed; /* Fix the background image */

      margin-top: 120px; /* Adjusted margin to accommodate the fixed header */
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
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
      text-align: center; /* Align text content center */
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card h3 {
      margin-top: 0;
      color: #8b5a2b;
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

    .servicebutton {
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

    .servicebutton:hover {
      opacity: 0.8;
      background-color: #714623;
    }
  </style>
</head>

<body>
  <header>
  <a href="index.php" class="logo"></a> <!-- Add anchor tag here -->
    <div class="button-container">
      <a href="#" class="servicebutton">Services</a>
      <a href="./about_us.php" class="button">About Us</a>
      <a href="./contact.html" class="button">Contact Now</a>
      <a href="./profile1.php" class="button">View Profile</a>
      <a href="./logout.php" class="button">Logout</a>
    </div>
  </header>

  <h2 style="color: #df9349; text-align: center;">Dashboard</h2>

  <div class="card-container">
    <!-- Laundry Request Card -->
    <div class="card card-1">
      <h3>Carpentry Request</h3>
      <p>Book a new carpentry request</p>
      <a href="carpentry_request.php">Book now</a>
    </div>

    <!-- Laundry Request Card -->
    <div class="card card-2">
      <h3>View Request</h3>
      <p>View your request here</p>
      <a href="./view_carpentry_request.php">View now</a>
    </div>

    <!-- Notification Card -->
    <!-- <div class="card card-3">
      <h3>Notification</h3>
      <p>View notifications and updates</p>
      <a href="notification.php">View now</a>
    </div> -->

    <!-- Profile Card -->
    <div class="card card-4">
      <h3>Profile</h3>
      <p>View and edit your profile</p>
      <a href="profile1.php">View now</a>
    </div>

    <!-- Contact Us Card -->
    <div class="card card-5">
      <h3>Contact Us</h3>
      <p>Get in touch with our support team</p>
      <a href="contact.html">Contact now</a>
    </div>

    <!-- Feedback -->
    <div class="card card-6">
      <h3>Feedback</h3>
      <p>Give your feedback about our service</p>
      <a href="feedback.html">Feedback form</a>
    </div>
  </div>

  <br>

  <!-- Price Table -->
  <!-- <h3><b>Price List</b></h3>
  <table>
    <tr>
      <th>Service</th>
      <th>Price</th>
    </tr>
    <tr>
      <td><b>Wash and Fold</b></td>
      <td><em>$10.5</em></td>
    </tr>
    <tr>
      <td><b>Wash and Iron</b></td>
      <td><em>$20.0</em></td>
    </tr>
    <tr>
      <td><b>Dry Clean</b></td>
      <td><em>$30.5</em></td>
    </tr>
    <tr>
      <td><b>Delivery[above 20km]</b></td>
      <td><em>$1.5</em>  [per cloth]</td>
    </tr>
  </table>

  <br> -->

</body>

</html>
