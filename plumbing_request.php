<?php
require 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields are set
    if (isset($_POST["laundry_service_provider"], $_POST["carpentry_service"], $_POST["pickup_date"], $_POST["pickup_time"])) {
        // Assign form data to variables
        $serviceProvider = $_POST["laundry_service_provider"];
        $carpentryService = $_POST["carpentry_service"];
        $pickupDate = $_POST["pickup_date"];
        $pickupTime = $_POST["pickup_time"];

        // Retrieve user information from session
        $userEmail = $_SESSION['email']; // Example: $_SESSION['user_email']
        $username = $_SESSION['name']; // Example: $_SESSION['username']
        $phoneNumber = $_SESSION['phone']; // Example: $_SESSION['phone_number']
        $address = $_SESSION['address']; // Example: $_SESSION['address']

        // Fetch the price of the selected carpentry service
        $sql = "SELECT s.service_name, p.price
                FROM plumbing_services s
                INNER JOIN plumbing_services_prices p ON s.id = p.service_id
                WHERE s.service_name = ? AND s.provider_name = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $carpentryService, $serviceProvider);
            $executionResult = mysqli_stmt_execute($stmt);
            
            if ($executionResult) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    mysqli_stmt_bind_result($stmt, $serviceName, $price);
                    $fetchResult = mysqli_stmt_fetch($stmt);

                    // Close the statement after fetching results
                    mysqli_stmt_close($stmt);

                    if ($fetchResult) {
                        // Generate order ID (you can customize this as per your requirements)
                        $orderId = "CR" . uniqid();

                        // Set request status to pending
                        $requestStatus = "Pending";

                        // Insert data into carpentry_request table
                        $insertSql = "INSERT INTO plumbing_request (order_id, user_email, username, phone_number, address, service_provider_name, service, price, request_status, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $insertStmt = mysqli_prepare($conn, $insertSql);

                        if ($insertStmt) {
                            mysqli_stmt_bind_param($insertStmt, "sssssssssss", $orderId, $userEmail, $username, $phoneNumber, $address, $serviceProvider, $serviceName, $price, $requestStatus, $pickupDate, $pickupTime);
                            $executionResult = mysqli_stmt_execute($insertStmt);

                            if ($executionResult) {
                                // Alert for successful request submission
                                echo "<script>alert('Plumbing Request Sent Successfully!');</script>";
                            } else {
                                // Alert for error in executing insert statement
                                echo "<script>alert('Error: Unable to execute insert statement: " . mysqli_error($conn) . "');</script>";
                            }

                            mysqli_stmt_close($insertStmt);
                        } else {
                            // Alert for error in preparing insert statement
                            echo "<script>alert('Error: Unable to prepare insert statement: " . mysqli_error($conn) . "');</script>";
                        }
                    } else {
                        // Alert for price not found for the selected service
                        echo "<script>alert('Error: Price not found for the selected service.');</script>";
                    }
                } else {
                    // Alert for no matching service found for the selected provider
                    echo "<script>alert('Error: No matching service found for the selected provider.');</script>";
                }
            } else {
                // Alert for error in executing statement
                echo "<script>alert('Error: Unable to execute statement: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            // Alert for error in preparing statement
            echo "<script>alert('Error: Unable to prepare statement: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        // Alert for all form fields required
        echo "<script>alert('Error: All form fields are required.');</script>";
      }

    // mysqli_close($conn); // Close the database connection
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Plumbing Request Form</title>
  <style>
    body {
      background-image: url('bg.jpeg');
      background-attachment: fixed; /* Fix the background image */

      background-size: cover;
      font-family: Arial, sans-serif;
      background-color: #F9F9F9;
      margin: 0;
      padding: 0;
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
      margin-right: 50px; /* Reduce margin-right */
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    h2 {
      text-align: center;
      margin-top: 150px; /* Adjust margin-top to accommodate the fixed header */
      color: #d9812d;
    }

    form {
      border: 3px solid #f1f1f1;
      background-color: rgba(255, 255, 255, 0.8);
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
      margin-top: 20px; /* Add margin-top to create space below the header */
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
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url('drop-icon.png');
      background-position: calc(100% - 10px) center;
      background-repeat: no-repeat;
      background-size: 10px;
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

    @media screen and (max-width: 300px) {
      span.psw {
        display: block;
        float: none;
      }

      .registerbtn {
        width: 100%;
      }
    }

    a {
      text-decoration: none;
      margin-right: 20px;
      color: #8b5a2b;
    }

    a:hover {
      text-decoration: underline;
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
    .logo {
            background-image: url('image.png');
            background-size: cover;
            width: 50px; /* Adjust the width as needed */
            height: 50px; /* Adjust the height as needed */
            border-radius: 50%; /* Make the image circular */
            overflow: hidden; /* Hide any content outside the border-radius */
            cursor: pointer;
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
  <h2>Plumbing Request Form</h2>
  <form class="" action="" method="post">
    <label for="laundry_service_provider">Choose Plumber:</label>
    <select name="laundry_service_provider" id="laundry_service_provider" required>
      <option value="">Select</option>
      <?php
      $sql = "SELECT * FROM users WHERE user_type = 'plumber'";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
      }
      ?>
    </select>
    <label for="carpentry_service">Choose Plumbing Service:</label>
    <select name="carpentry_service" id="carpentry_service" required>
      <option value="">Select Plumber First</option>
    </select>

    <label for="pickup_date">Appointment Date:</label>
    <input type="date" name="pickup_date" id="pickup_date" required>

    <label for="pickup_time">Appointment Time:</label>
    <input type="time" name="pickup_time" id="pickup_time" required>

    <button type="submit" name="submit">Submit</button>

    <a href="./plumbing_service.php" style="text-decoration: none; margin-right: 20px;">Go back</a>
  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#laundry_service_provider').change(function() {
        var carpenter = $(this).val();
        // Fetch carpentry services dynamically based on the selected carpenter
        $.ajax({
          url: 'fetch_plumbing_services.php',
          type: 'get',
          data: {
            'carpenter': carpenter
          },
          success: function(response) {
            // Parse the JSON data
            var services = JSON.parse(response);
            // Clear previous options
            $('#carpentry_service').empty();
            // Generate options for the dropdown menu
            $.each(services, function(index, service) {
              $('#carpentry_service').append('<option value="' + service.name + '">' + service.name + ' (\u20B9' + service.price + ')</option>');
            });
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>
</body>

</html>
