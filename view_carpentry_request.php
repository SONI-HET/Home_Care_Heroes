<?php
require 'config.php';

if (empty($_SESSION["id"])) {
  header("Location: login.php");
  exit(); // Ensure script stops executing after redirect
}

$user_id = $_SESSION["id"];
$username = $_SESSION["name"];
$query = "SELECT * FROM carpentry_request WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
  // Handle query execution error
  echo "Error: " . mysqli_error($conn);
  exit(); // Stop execution if there's an error
}

if (isset($_POST['tick'])) {
  $order_id = $_POST['order_id'];
  $service = $_POST['service'];
  $pickup_date = $_POST['pickup_date'];
  $pickup_time = $_POST['pickup_time'];

  // Fetch price for the selected service
  $price_query = "SELECT price FROM service_prices WHERE service_id = (SELECT id FROM carpentry_services WHERE service_name = '$service')";
  $price_result = mysqli_query($conn, $price_query);
  if (!$price_result) {
    // Handle query execution error
    echo "Error: " . mysqli_error($conn);
    exit(); // Stop execution if there's an error
}
  $row = mysqli_fetch_assoc($price_result);
  $price = $row['price'];

  // Update the database
$update_query = "UPDATE carpentry_request SET service='$service', price='$price', appointment_date='$pickup_date', appointment_time='$pickup_time' WHERE order_id='$order_id' AND username='$username'";
  $update_result = mysqli_query($conn, $update_query);

  if ($update_result) {
      // Redirect to this page after update
      echo '<script> alert("Changes saved successfully!"); </script>';
      header("Location: {$_SERVER['PHP_SELF']}");
      exit();
  } else {
      // Handle update error
      echo "Error updating record: " . mysqli_error($conn);
  }
}
if (isset($_POST['delete'])) {
  // Check if delete button is clicked
  $order_id = $_POST['order_id'];

  // Delete the record from the database
  $delete_query = "DELETE FROM laundry_requests WHERE order_id='$order_id'";
  $delete_result = mysqli_query($conn, $delete_query);

  if ($delete_result) {
    // Redirect to this page after deletion
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
  } else {
    // Handle delete error
    echo "Error deleting record: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Laundry Requests</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    body {
      background-image: url("bg.jpeg");
      background-repeat: no-repeat;
      background-size: cover;
      padding: 20px;
      background-attachment: fixed; /* Fix the background image */

      display: flex; /* Use flexbox layout */
      flex-direction: column; /* Arrange items vertically */
      align-items: center; /* Center items horizontally */
    }

    .edit-icon,
    .delete-icon {
      color: #8b5a2b;
      /* Set color for icons */
    }

    button[type="submit"] {
      background-color: transparent;
      border: none;
      opacity: 0.7;
    }

    /* Optional: Add hover effect for buttons */
    button[type="submit"]:hover {
      cursor: pointer;
      color: #8b5a2b;
      opacity: 0.7;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      background-color: white;
    }

    th,
    td {
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

    h2 {
      color: #ce7e31;
      text-align: center;
    }

    p {
      color: #8b5a2b;
      text-align: center;
    }

    a,.button {
      color: #ff7d00;
      text-decoration: none;
      display: block;
      width: fit-content;
      margin: 0 auto;
      margin-top: 20px;
      text-align: center;
    }

    .edit-icon,
    .delete-icon {
      cursor: pointer;
      font-size: 1.2em;
      margin: 0 5px;
    }

    .edit-icon:hover,
    .delete-icon:hover {
      color: #ff0000;
    }

    a:hover {
      text-decoration: underline;
    }
    .button-container {
      display: flex;
      justify-content: space-between; /* Distribute space between items */
      width: 100%; /* Full width */
      max-width: 600px; /* Limit width */
    }
    .edit-icon,
    .delete-icon {
      cursor: pointer;
    }

    .edit-icon:hover,
    .delete-icon:hover {
      color: #ff0000;
    }

    input[type="text"] {
      width: 80px;
      /* Adjust width as needed */
    }
  </style>
</head>

<body>
  <h2>Current Requests</h2>

  <?php if (mysqli_num_rows($result) > 0) : ?>
    <table>
      <tr>
        <th>Order ID</th>
        <th>Service Provider</th>
        <th>Pickup Date</th>
        <th>Pickup Time</th>
        <th>Service</th>
        <th>Price</th>
        <th>Request Status</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <td><?php echo $row['order_id']; ?><input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>"></td>
            <td><?php echo $row['service_provider_name']; ?></td>
            <td>
              <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['appointment_date'];
              else echo "<input type='date' name='pickup_date' value='" . $row['appointment_date'] . "' />"; ?>
            </td>
            <td>
              <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['appointment_time'];
              else echo "<input type='time' name='pickup_time' value='" . $row['appointment_time'] . "' />"; ?>
            </td>


            <td>
                            <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['service'];
                            else {
                                // Fetch plumbing services from the database
                                $provider_name = $row['service_provider_name']; // Fetching provider name from the current row
                                $plumbing_services_query = "SELECT * FROM carpentry_services WHERE provider_name = '$provider_name'";
                                $plumbing_services_result = mysqli_query($conn, $plumbing_services_query);
                            ?>
                                <select name="service">
                                    <?php while ($service_row = mysqli_fetch_assoc($plumbing_services_result)) : ?>
                                        <option value="<?php echo $service_row['service_name']; ?>" <?php if ($row['service'] == $service_row['service_name']) echo 'selected="selected"'; ?>>
                                            <?php echo $service_row['service_name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            <?php } ?>
                        </td>            
            
            
            <td><?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['price'];
                else echo "<input type='text' name='wash_iron' value='" . $row['price'] . "' />"; ?></td>
            
            
            <td><?php echo $row['request_status']; ?></td>
            <td>
                            <?php if (isset($_POST['edit']) && $_POST['order_id'] == $row['order_id']) : ?>
                                <button type="submit" name="tick" style="border: none; background: none;"><i class="fas fa-check edit-icon"></i></button>
                            <?php else : ?>
                                <button type="submit" name="edit" style="border: none; background: none;"><i class="fas fa-edit edit-icon"></i></button>
                            <?php endif; ?>
                        </td>
            <td>
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <button type="submit" name="delete" style="border: none; background: none;" onclick="return confirmAndAlert('Are you sure you want to delete this item?');"><i class="fas fa-trash-alt delete-icon"></i></button>
                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
              </form>
            </td>

          </form>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else : ?>
    <p>No laundry requests found. Book your request below.</p>
  <?php endif; ?>
  <div class="button-container">
    <a href="./carpentry_request.php">Book Now</a>
    <a class="button" style="cursor: pointer;" onclick="goBack()">Go Back</a>
  </div>
  <script>
    function confirmAndAlert(message) {
      if (confirm(message)) {
        alert("Item deleted successfully!");
        return true;
      } else {
        return false;
      }
    }
    function goBack() {
      window.history.back();
    }

    <?php if (isset($_POST['submit'])) : ?>
      console.log($_POST);
      document.addEventListener("DOMContentLoaded", function() {
        alert("Changes saved successfully!");
      });
    <?php endif; ?>
  </script>
</body>

</html>