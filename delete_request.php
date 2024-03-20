<?php
require 'config.php';

// Retrieve the request ID sent from the client-side JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Extract the request ID from the data
$requestId = $data['id'];

// Delete the laundry request from the database
$query = "DELETE FROM laundry_requests WHERE id = '$requestId'";

if(mysqli_query($conn, $query)){
    // Return a success response if the deletion was successful
    http_response_code(200);
    echo json_encode(array("message" => "Request deleted successfully."));
} else {
    // Return an error response if the deletion failed
    http_response_code(500);
    echo json_encode(array("message" => "Failed to delete request."));
}
?>
