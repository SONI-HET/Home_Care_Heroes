<?php
require 'config.php';

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
}

// Fetch prices from the database based on the selected laundry service provider
function fetchPrices($laundry_service_provider, $conn)
{
  $sql = "SELECT wash_and_fold_price, wash_and_iron_price, dry_clean_price FROM manage_prices WHERE name = ?";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $laundry_service_provider);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $wash_fold_price, $wash_iron_price, $dry_clean_price);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return array($wash_fold_price, $wash_iron_price, $dry_clean_price);
  }
  return false;
}

if (isset($_POST["submit"])) {
  // Fetch user data from session
  $user_id = $_SESSION["id"];
  $user_email = $_SESSION["email"];
  $username = $_SESSION["name"];
  $phone_number = $_SESSION["phone"];
  $address = $_SESSION["address"];

  // Fetch form data
  $pickup_date = $_POST["pickup_date"];
  $pickup_time = $_POST["pickup_time"];
  $delivery_date = $_POST["delivery_date"];
  $delivery_time = $_POST["delivery_time"];
  $wash_fold = $_POST["wash_fold"];
  $wash_iron = $_POST["wash_iron"];
  $dry_clean = $_POST["dry_clean"];
  $laundry_service_provider = $_POST["laundry_service_provider"];

  // Fetch prices dynamically based on the selected laundry service provider
  list($wash_fold_price, $wash_iron_price, $dry_clean_price) = fetchPrices($laundry_service_provider, $conn);

  if ($wash_fold_price !== null && $wash_iron_price !== null && $dry_clean_price !== null) {
    // Calculate total price
    $price = calculate_price($wash_fold, $wash_iron, $dry_clean, $wash_fold_price, $wash_iron_price, $dry_clean_price);

    // Insert data into the database
    $status = "Pending";
    $order_id = uniqid('ORDER');
    $sql = "INSERT INTO laundry_requests (order_id, user_id, user_email, username, phone_number, address, pickup_date, pickup_time, delivery_date, delivery_time, wash_fold, wash_iron, dry_clean, laundry_service_provider, price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $order_id, $user_id, $user_email, $username, $phone_number, $address, $pickup_date, $pickup_time, $delivery_date, $delivery_time, $wash_fold, $wash_iron, $dry_clean, $laundry_service_provider, $price, $status);
      if (mysqli_stmt_execute($stmt)) {
        echo "<script> alert('Laundry request submitted successfully.'); </script>";
      } else {
        echo "<script> alert('Error: Unable to submit laundry request - " . mysqli_error($conn) . "'); </script>";
      }
      mysqli_stmt_close($stmt);
    } else {
      echo "<script> alert('Error: Unable to prepare SQL statement - " . mysqli_error($conn) . "'); </script>";
    }
  } else {
    echo "<script> alert('Error: Unable to fetch prices for the selected laundry service provider.'); </script>";
  }
}

function calculate_price($wash_fold, $wash_iron, $dry_clean, $wash_fold_price, $wash_iron_price, $dry_clean_price)
{
  // Calculation logic goes here
  $total_price = $wash_fold * $wash_fold_price + $wash_iron * $wash_iron_price + $dry_clean * $dry_clean_price;
  // Round the price to 2 decimal places
  $total_price = round($total_price, 2);
  return $total_price;
}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Laundry Request Form</title>
  <style>
    body {
      background-image: url('bg.jpeg');
      background-attachment: fixed; /* Fix the background image */

      background-size: cover;
      font-family: Arial, sans-serif;
      background-color: #F9F9F9;
    }

    form {
      border: 3px solid #f1f1f1;
      background-color: rgba(255, 255, 255, 0.8);
      /* Set background color with transparency */
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 10px;
      /* Add border radius */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      /* Add box shadow */
      transition: transform 0.3s ease;
      /* Add transition effect for transform property */
    }


    h2 {
      text-align: center;
      margin-top: 0;
      color: #e48b36;
      /* Match the color of the registration form */
    }

    input[type=text],
    input[type=password],
    input[type=number],
    input[type=date],
    input[type=time] {
      width: 100%;
      padding: 12px 20px;
      margin-bottom: 16px;
      display: block;
      border: 1px solid #ccc;
      border-radius: 5px;
      /* Add border radius */
      box-sizing: border-box;
    }

    select {
      width: 100%;
      padding: 12px 20px;
      margin-bottom: 16px;
      display: block;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      background-color: #fff;
      color: #555;
      /* Add custom dropdown style */
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url('drop-icon.png');
      /* Add your custom arrow icon */
      background-position: calc(100% - 10px) center;
      background-repeat: no-repeat;
      background-size: 10px;
    }

    button {
      background-color: #8b5a2b;
      /* Match the background color of the registration form */
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
      /* Add border radius */
      transition: background-color 0.3s ease;
      /* Add transition effect */
    }

    button:hover {
      opacity: 0.8;
      background-color: #714623;
      /* Darker color on hover */
    }

    .container {
      padding: 16px;
    }

    @media screen and (max-width: 300px) {
      span.psw {
        display: block;
        float: none;
      }

      .registerbtn {
        width: 100%;
      }
    }

    /* Style the 'Go back' link */
    a {
      text-decoration: none;
      margin-right: 20px;
      color: #8b5a2b;
      /* Match the color of the registration form */
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <h2>Laundry Request Form</h2>
  <form class="" action="" method="post">
    <label for="laundry_service_provider">Choose Laundry Service Provider:</label>
    <select name="laundry_service_provider" id="laundry_service_provider" required>
      <option value="">Select</option>
      <?php
      $sql = "SELECT * FROM users WHERE user_type = 'laundry_service_provider'";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
      }
      ?>
    </select>
    <label for="pickup_date">Pickup Date:</label>
    <input type="date" name="pickup_date" id="pickup_date" required>

    <label for="pickup_time">Pickup Time:</label>
    <input type="time" name="pickup_time" id="pickup_time" required>

    <label for="delivery_date">Delivery Date:</label>
    <input type="date" name="delivery_date" id="delivery_date" required>

    <label for="delivery_time">Delivery Time:</label>
    <input type="time" name="delivery_time" id="delivery_time" required>

    <label for="wash_fold">Wash &amp; Fold (number of clothes):</label>
    <input type="number" name="wash_fold" id="wash_fold" min="0" value="0">

    <label for="wash_iron">Wash &amp; Iron (number of clothes):</label>
    <input type="number" name="wash_iron" id="wash_iron" min="0" value="0">

    <label for="dry_clean">Dry Clean (number of clothes):</label>
    <input type="number" name="dry_clean" id="dry_clean" min="0" value="0">



    <button type="submit" name="submit">Submit</button>

    <a href="dashboard.html" style="text-decoration: none; margin-right: 20px;">Go back</a>
  </form>
</body>

</html>