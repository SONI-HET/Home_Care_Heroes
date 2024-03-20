<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plumbing Service Provider Dashboard</title>
    <!-- Add your CSS styles or link to external CSS files here -->
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
        .logo {
            background-image: url('image.png');
            background-size: cover;
            width: 50px; /* Adjust the width as needed */
            height: 50px; /* Adjust the height as needed */
            border-radius: 50%; /* Make the image circular */
            overflow: hidden; /* Hide any content outside the border-radius */
            cursor: pointer;
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

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            color: #666;
            line-height: 1.6;
        }

        .button-container-inner {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .button-container-inner .button {
            margin: 0 10px;
        }

        .logout-btn {
            display: block;
            width: 120px;
            margin: 20px auto;
            padding: 10px;
            background-color: #ff6347;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #e63c24;
        }
    </style>
</head>

<body>
    <header>
    <a href="index.php" class="logo"></a> <!-- Add anchor tag here -->
        <div class="button-container">
            <a href="./carpenter.php" class="servicebutton">Dashboard</a>
            <a href="./about_us2.php" class="button">About Us</a>
            <a href="./contact3.html" class="button">Contact Now</a>
            <a href="./profile2.php" class="button">View Profile</a>
            <a href="./logout.php" class="button">Logout</a>
        </div>
    </header>

    <div class="container">
        <?php
        // Start session if not already started
        session_start();

        // Check if the user is logged in
        if (isset($_SESSION['name'])) {
            // Get the current service provider's type from session
            $serviceProviderType = $_SESSION['name'];
            echo "<h1>Welcome, <span style='color: #d68232;'>$serviceProviderType</span>!</h1>";
            echo "<p style='text-align: center'>This is your dashboard where you can manage plumbing service-related tasks and also you can manage prices related to those services.</p>";
        } else {
            // If user is not logged in, redirect to login page
            header("Location: login.php");
            exit();
        }
        ?>
        <div class="button-container-inner">
            <a href="plumber_manage_orders.php" class="button">Manage Orders</a>
            <a href="feedback.html" class="button">Feedback Form</a>
            <a href="plumber_manage_prices_services.php" class="button">Manage Prices and Services</a>
        </div>

    </div>
</body>

</html>