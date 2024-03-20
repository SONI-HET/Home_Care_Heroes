<?php
require 'config.php';

if (empty($_SESSION["id"])) {
  header("Location: login.php");
  exit(); // Ensure script stops executing after redirect
}

$user_id = $_SESSION["id"];
$query = "SELECT * FROM laundry_requests WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
  // Handle query execution error
  echo "Error: " . mysqli_error($conn);
  exit(); // Stop execution if there's an error
}

if (isset($_POST['submit'])) {
  // Check if form is submitted
  $order_id = $_POST['order_id'];
  $wash_fold = $_POST['wash_fold'];
  $wash_iron = $_POST['wash_iron'];
  $dry_clean = $_POST['dry_clean'];
  $pickup_date = $_POST['pickup_date']; // Added Pickup Date
  $pickup_time = $_POST['pickup_time']; // Added Pickup Time
  $delivery_date = $_POST['delivery_date']; // Added Delivery Date
  $delivery_time = $_POST['delivery_time']; // Added Delivery Time


  // Update the database
  $update_query = "UPDATE laundry_requests SET wash_fold='$wash_fold', wash_iron='$wash_iron', dry_clean='$dry_clean', pickup_date='$pickup_date', pickup_time='$pickup_time', delivery_date='$delivery_date', delivery_time='$delivery_time' WHERE order_id='$order_id'";
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
      background-attachment: fixed; /* Fix the background image */

      background-repeat: no-repeat;
      background-size: cover;
      padding: 20px;
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
        <th>Delivery Date</th>
        <th>Delivery Time</th>
        <th>Wash and Fold</th>
        <th>Wash and Iron</th>
        <th>Dry Clean</th>
        <th>Status</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <td><?php echo $row['order_id']; ?><input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>"></td>
            <td><?php echo $row['laundry_service_provider']; ?></td>
            <td>
              <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['pickup_date'];
              else echo "<input type='date' name='pickup_date' value='" . $row['pickup_date'] . "' />"; ?>
            </td>
            <td>
              <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['pickup_time'];
              else echo "<input type='time' name='pickup_time' value='" . $row['pickup_time'] . "' />"; ?>
            </td>
            <td>
              <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['delivery_date'];
              else echo "<input type='date' name='delivery_date' value='" . $row['delivery_date'] . "' />"; ?>
            </td>
            <td>
              <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['delivery_time'];
              else echo "<input type='time' name='delivery_time' value='" . $row['delivery_time'] . "' />"; ?>
            </td>
            <td><?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['wash_fold'];
                else echo "<input type='text' name='wash_fold' value='" . $row['wash_fold'] . "' />"; ?></td>
            <td><?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['wash_iron'];
                else echo "<input type='text' name='wash_iron' value='" . $row['wash_iron'] . "' />"; ?></td>
            <td><?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) echo $row['dry_clean'];
                else echo "<input type='text' name='dry_clean' value='" . $row['dry_clean'] . "' />"; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php if (!isset($_POST['edit']) || $_POST['order_id'] != $row['order_id']) : ?>
                  <button type="submit" name="edit" style="border: none; background: none;"><i class="fas fa-edit edit-icon"></i></button>
                <?php else : ?>
                  <button type="submit" name="submit" id="edit-submit" style="border: none; background: none;"><i class="fas fa-check"></i></button>
                <?php endif; ?>
                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
              </form>
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
    <a href="laundry_request.php">Book Now</a>
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