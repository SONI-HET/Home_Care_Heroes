<?php
require 'config.php';

if (isset($_GET["carpenter"])) {
    $carpenterName = $_GET["carpenter"];
    $services = array();

    // Prepare the SQL statement
    $sql = "SELECT cs.service_name, sp.price FROM plumbing_services cs
    LEFT JOIN plumbing_services_prices sp ON cs.id = sp.service_id
    WHERE cs.provider_name = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) { // Check if the statement was prepared successfully
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "s", $carpenterName);
        mysqli_stmt_execute($stmt);

        // Bind result variables
        mysqli_stmt_bind_result($stmt, $service_name, $price);

        // Fetch results
        while (mysqli_stmt_fetch($stmt)) {
            $services[] = array("name" => $service_name, "price" => $price);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error handling if statement preparation fails
        echo "Error: Unable to prepare SQL statement - " . mysqli_error($conn);
    }

    // Return carpentry services as JSON
    echo json_encode($services);
}
?>
