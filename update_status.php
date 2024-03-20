<?php
session_start(); // Start session if not already started

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit;
}
echo "Reached update_status.php<br>";


// Get the logged-in service provider's username
$loggedInServiceProvider = $_SESSION['name'];
echo "Logged-in service provider: " . $loggedInServiceProvider . "<br>";

// Check if the status and orderId are set in the POST request
if (isset($_POST['status']) && isset($_POST['orderId'])) {
    $status = $_POST['status'];
    $orderId = $_POST['orderId'];

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "laundry");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query to update the status
    $sql = "UPDATE laundry_requests SET status = '$status' WHERE order_id = '$orderId' AND laundry_service_provider = '$loggedInServiceProvider'";
    echo "SQL query: " . $sql . "<br>";

    if ($conn->query($sql) === TRUE) {
        // Status updated successfully
        echo "<script> alert('Status updated successfully'); </script>";
    } else {
        // Error occurred while updating status
        echo "Error updating status: " . $conn->error;
    }

    $conn->close();
} else {

    echo "Invalid request";
}
?>
