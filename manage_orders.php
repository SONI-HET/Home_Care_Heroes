<?php
session_start(); // Start session if not already started

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Add your CSS styles or link to external CSS files here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("bg.jpeg");
            background-repeat: no-repeat;
            background-attachment: fixed; /* Fix the background image */

            background-size: cover;
            padding: 20px;
            margin: 0;
        }

        /* .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
        } */

        h1 {
            color: #ce7e31;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: transparent;
        }

        th {
            background-color: #8b5a2b;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            color: #ce7e31;
            text-decoration: none;
            display: block;
            width: fit-content;
            margin: 0 auto;
            margin-top: 20px;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }

        .edit-icon, .delete-icon {
            cursor: pointer;
        }

        .edit-icon:hover, .delete-icon:hover {
            color: #ff0000;
        }

        input[type="text"] {
            width: 80px; /* Adjust width as needed */
        }

        /* Define colors based on status */
        .status-pending {
            color: #eeac33;
            font-weight: bold;
        }

        .status-delivered {
            color: #23dc23;
            font-weight: bold;
        }

        .status-rejected {
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Pickup Date</th>
                    <th>Pickup Time</th>
                    <th>Delivery Date</th>
                    <th>Delivery Time</th>
                    <th>Services</th>
                    <th>Status</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP code to fetch and display orders -->
                <?php
                    // Get the logged-in service provider's username
                    $loggedInServiceProvider = $_SESSION['name'];

                    // Database connection
                    $conn = mysqli_connect("localhost", "root", "", "laundry");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch data from the laundry_requests table for the logged-in service provider
                    $sql = "SELECT * FROM laundry_requests WHERE laundry_service_provider = '$loggedInServiceProvider'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Display the orders for the logged-in service provider
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["order_id"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . $row["user_email"] . "</td>";
                            echo "<td>" . $row["address"] . "</td>";
                            echo "<td>" . $row["phone_number"] . "</td>";
                            echo "<td>" . $row["pickup_date"] . "</td>";
                            echo "<td>" . $row["pickup_time"] . "</td>";
                            echo "<td>" . $row["delivery_date"] . "</td>";
                            echo "<td>" . $row["delivery_time"] . "</td>";
                            echo "<td>Wash & Fold: " . $row["wash_fold"] . "<br>Wash & Iron: " . $row["wash_iron"] . "<br>Dry Clean: " . $row["dry_clean"] . "</td>";
                            echo "<td class='status-" . strtolower($row["status"]) . "'>";
                            echo $row["status"] . " <i class='fas fa-pencil-alt edit-icon' onclick='editStatus(\"" . $row["order_id"] . "\")'></i>";
                            echo "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No orders found for the logged-in service provider.</td></tr>";
                    }
                    
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function editStatus(orderId) {
            console.log("Editing status for order ID: " + orderId);

            var newStatus = prompt("Enter new status (Pending, Delivered, Rejected):");
            if (newStatus !== null && newStatus !== "") {
                updateStatus(newStatus, orderId);
            }
        }

        function updateStatus(newStatus, orderId) {
            // AJAX request to update status
            console.log("newStatus: " + newStatus)
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Status updated successfully
                        alert('Status updated successfully');
                        location.reload(); // Refresh the page to reflect changes
                    } else {
                        // Error occurred while updating status
                        console.error('Error occurred while updating status');
                    }
                }
            };
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("status=" + newStatus + "&orderId=" + orderId);
        }
    </script>
<div style="text-align: center; margin-top: 20px;">
        <a href="javascript:history.back()">Go Back</a>
    </div>
</body>
</html>
