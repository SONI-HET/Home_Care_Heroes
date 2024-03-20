<?php
require 'config.php';

// Read JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

// Log the received data (for debugging purposes)
file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

// Extract data from the JSON object
$order_id = $data['order_id'];
$pickup_date = $data['pickup_date'];
$pickup_time = $data['pickup_time'];
$delivery_date = $data['delivery_date'];
$delivery_time = $data['delivery_time'];
$wash_fold = $data['wash_fold'];
$wash_iron = $data['wash_iron'];
$dry_clean = $data['dry_clean'];

// Update the corresponding row in the database
$query = "UPDATE laundry_requests SET
            pickup_date = '$pickup_date',
            pickup_time = '$pickup_time',
            delivery_date = '$delivery_date',
            delivery_time = '$delivery_time',
            wash_fold = '$wash_fold',
            wash_iron = '$wash_iron',
            dry_clean = '$dry_clean'
          WHERE order_id = '$order_id'";

if (mysqli_query($conn, $query)) {
    // Database update successful
    http_response_code(200);
} else {
    // Database update failed
    http_response_code(500);
}
?>
