<?php
session_start(); // Start session if not already started

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit;
}
echo "Reached update_carpentry_status.php<br>";


// Get the logged-in service provider's username
$loggedInServiceProvider = $_SESSION['name'];
echo "Logged-in service provider: " . $loggedInServiceProvider . "<br>";

// Check if the status and orderId are set in the POST request
if (isset($_POST['request_status']) && isset($_POST['order_id'])) {
    $status = $_POST['request_status'];
    $orderId = $_POST['order_id'];

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "laundry");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query to update the status
    $sql = "UPDATE carpentry_request SET request_status = '$status' WHERE order_id = '$orderId' AND service_provider_name = '$loggedInServiceProvider'";
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
