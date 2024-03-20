<?php
// session_start(); // Start the session if not already started

require_once 'config.php'; // Include database configuration

// Function to load services dynamically
function loadServices($conn, $provider_name) {
    $output = "";
    $sql = "SELECT cs.id, cs.service_name, sp.price FROM plumbing_services cs LEFT JOIN plumbing_services_prices sp ON cs.id = sp.service_id WHERE cs.provider_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $provider_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= "<tr>";
            $output .= "<td>" . $row['service_name'] . "</td>";
            $output .= "<td>$" . $row['price'] . "</td>";
            $output .= "<td><button class='edit-service-btn' data-service-id='" . $row['id'] . "'><i class='fas fa-edit'></i></button></td>";
            $output .= "<td><button class='delete-service-btn' data-service-id='" . $row['id'] . "'><i class='fas fa-trash-alt'></i></button></td>";
            $output .= "</tr>";
        }
    } else {
        $output = "<tr><td colspan='4'>No services found.</td></tr>";
    }

    return $output;
}


// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add service
    if (isset($_POST['add-service'])) {
        $service_name = $_POST['service_name'];
        $price = $_POST['price'];

        // Get provider name from session
        $provider_name = $_SESSION['name'];

        // Insert service into carpentry_services table
        $sql_insert_service = "INSERT INTO plumbing_services (service_name, provider_name) VALUES (?, ?)";
        $stmt_insert_service = mysqli_prepare($conn, $sql_insert_service);
        mysqli_stmt_bind_param($stmt_insert_service, "ss", $service_name, $provider_name);
        mysqli_stmt_execute($stmt_insert_service);
        mysqli_stmt_close($stmt_insert_service);

        // Get the ID of the inserted service
        $service_id = mysqli_insert_id($conn);

        // Insert price into service_prices table
        $sql_insert_price = "INSERT INTO plumbing_services_prices (service_id, price) VALUES (?, ?)";
        $stmt_insert_price = mysqli_prepare($conn, $sql_insert_price);
        mysqli_stmt_bind_param($stmt_insert_price, "id", $service_id, $price);
        mysqli_stmt_execute($stmt_insert_price);
        mysqli_stmt_close($stmt_insert_price);
    }

    // Edit service
    if (isset($_POST['edit-service'])) {
        $service_id = $_POST['service_id'];
        $new_service_name = $_POST['new_service_name'];
        $new_price = $_POST['new_price'];

        // Update service name in carpentry_services table
        $sql_update_service = "UPDATE plumbing_services SET service_name = ? WHERE id = ?";
        $stmt_update_service = mysqli_prepare($conn, $sql_update_service);
        mysqli_stmt_bind_param($stmt_update_service, "si", $new_service_name, $service_id);
        mysqli_stmt_execute($stmt_update_service);
        mysqli_stmt_close($stmt_update_service);

        // Update price in service_prices table
        $sql_update_price = "UPDATE plumbing_services_prices SET price = ? WHERE service_id = ?";
        $stmt_update_price = mysqli_prepare($conn, $sql_update_price);
        mysqli_stmt_bind_param($stmt_update_price, "di", $new_price, $service_id);
        mysqli_stmt_execute($stmt_update_price);
        mysqli_stmt_close($stmt_update_price);
    }

    // Delete service
// Delete service
if (isset($_POST['delete-service'])) {
    $service_id = $_POST['service_id'];

    // Delete corresponding price entries from service_prices table
    $sql_delete_prices = "DELETE FROM plumbing_services_prices WHERE service_id = ?";
    $stmt_delete_prices = mysqli_prepare($conn, $sql_delete_prices);
    mysqli_stmt_bind_param($stmt_delete_prices, "i", $service_id);

    if (mysqli_stmt_execute($stmt_delete_prices)) {
        // Now, delete the service entry from carpentry_services table
        $sql_delete_service = "DELETE FROM plumbing_services WHERE id = ?";
        $stmt_delete_service = mysqli_prepare($conn, $sql_delete_service);
        mysqli_stmt_bind_param($stmt_delete_service, "i", $service_id);

        if (mysqli_stmt_execute($stmt_delete_service)) {
            echo "Service and corresponding price entries deleted successfully.";
        } else {
            echo "Error deleting service entry: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt_delete_service);
    } else {
        echo "Error deleting corresponding price entries: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_delete_prices);
}



}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services and Prices</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Add your CSS styles or link to external CSS files here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("bg.jpeg");
            background-attachment: fixed; /* Fix the background image */

            background-repeat: no-repeat;
            background-size: cover;
            padding: 20px;
            margin: 0;
        }
        .add-service-form {
            margin-top: 20px;
        }

        .add-service-form input[type="text"],
        .add-service-form input[type="number"],
        .add-service-form button[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in the element's total width and height */
        }

        .add-service-form button[type="submit"] {
            background-color: #8b5a2b;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-service-form button[type="submit"]:hover {
            background-color: #654321; /* Darken the background color on hover */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            color: #ce7e31;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
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

        .edit-service-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .edit-service-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close-edit-service-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-edit-service-modal:hover,
        .close-edit-service-modal:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="card-header">Manage Services and Prices</h1>
            <table>
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Service Name</th>
                        <th>Price</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo loadServices($conn, $_SESSION['name']); ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h1 class="card-header">Add New Service</h1>
            <div class="add-service-form">
                <form  autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="text" name="service_name" placeholder="Service Name" required>
                    <input type="number" step="0.01" name="price" placeholder="Price" required>
                    <button type="submit" name="add-service">Add Service</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div id="edit-service-modal" class="edit-service-modal">
        <div class="edit-service-modal-content">
            <span class="close-edit-service-modal">&times;</span>
            <h2>Edit Service</h2>
            <form autocomplete="off" id="edit-service-form" method="post">
                <input type="hidden" id="edit-service-id" name="service_id">
                <label for="edit-service-name">New Service Name:</label>
                <input type="text" id="edit-service-name" name="new_service_name" required >
                <label for="edit-service-price">New Price:</label>
                <input type="number" step="0.01" id="edit-service-price" name="new_price" required>
                <button type="submit" name="edit-service">Save Changes</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Edit service modal
            $('.edit-service-btn').click(function() {
                var serviceId = $(this).data('service-id');
                $('#edit-service-id').val(serviceId);
                $('#edit-service-modal').show();
            });

            $('.close-edit-service-modal').click(function() {
                $('#edit-service-modal').hide();
            });

            // Delete service
            $('.delete-service-btn').click(function() {
            var serviceId = $(this).data('service-id');
            var row = $(this).closest('tr'); // Get the parent row of the button
            if (confirm('Are you sure you want to delete this service?')) {
                $.ajax({
                    url: '<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                    type: 'post',
                    data: { 'delete-service': true, 'service_id': serviceId },
                    success: function(response) {
                        // Remove the row from the table
                        row.remove();
                    }
                });
            }
        });

        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>
