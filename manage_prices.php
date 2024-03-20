<?php
// Include config file
require_once 'config.php';

// Initialize variables
$wash_fold_price = $wash_iron_price = $dry_clean_price = '';
$price_err = '';

// Get the name of the currently logged-in service provider
// Assuming you have a session variable storing the service provider's name
$name = $_SESSION['name'] ?? '';

// Check if the service provider exists in the database
// Check if the service provider exists in the database
if (!empty($name)) {
    // Prepare and execute a SELECT query to fetch prices for the service provider
    $select_sql = "SELECT wash_and_fold_price, wash_and_iron_price, dry_clean_price FROM manage_prices WHERE name = ?";
    if ($select_stmt = mysqli_prepare($conn, $select_sql)) {
        // Bind the parameter
        mysqli_stmt_bind_param($select_stmt, "s", $param_name);
        $param_name = $name;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($select_stmt)) {
            // Store result
            mysqli_stmt_store_result($select_stmt);

            // Check if the service provider exists
            if (mysqli_stmt_num_rows($select_stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($select_stmt, $wash_fold_price, $wash_iron_price, $dry_clean_price);

                // Fetch values
                mysqli_stmt_fetch($select_stmt);
            }
        }
    }

    // Close statement
    mysqli_stmt_close($select_stmt);
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate price
    if (empty(trim($_POST['wash_fold_price'])) && empty(trim($_POST['wash_iron_price'])) && empty(trim($_POST['dry_clean_price']))) {
        $price_err = 'Please enter at least one price.';
    } else {
        $wash_fold_price = trim($_POST['wash_fold_price']);
        $wash_iron_price = trim($_POST['wash_iron_price']);
        $dry_clean_price = trim($_POST['dry_clean_price']);

        // Update the prices for the service provider
        $update_sql = "UPDATE manage_prices SET wash_and_fold_price = ?, wash_and_iron_price = ?, dry_clean_price = ? WHERE name = ?";
        if ($update_stmt = mysqli_prepare($conn, $update_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($update_stmt, "ddds", $wash_fold_price, $wash_iron_price, $dry_clean_price, $param_name);
            $param_name = $name;

            // Attempt to execute the prepared statement
            
        } else {
            // Alert for SQL statement preparation error
            echo "<script>alert('Error: Unable to prepare SQL statement.');</script>";
        }

        // Close statement
        mysqli_stmt_close($update_stmt);
    }
}


// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate price
    if (empty(trim($_POST['wash_fold_price'])) && empty(trim($_POST['wash_iron_price'])) && empty(trim($_POST['dry_clean_price']))) {
        $price_err = 'Please enter at least one price.';
    } else {
        $wash_fold_price = trim($_POST['wash_fold_price']);
        $wash_iron_price = trim($_POST['wash_iron_price']);
        $dry_clean_price = trim($_POST['dry_clean_price']);
    }

    // Update the prices for the service provider
    $update_sql = "UPDATE manage_prices SET wash_and_fold_price = ?, wash_and_iron_price = ?, dry_clean_price = ? WHERE name = ?";
    if ($update_stmt = mysqli_prepare($conn, $update_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($update_stmt, "ddds", $param_wash_fold_price, $param_wash_iron_price, $param_dry_clean_price, $param_name);

        // Set parameters
        $param_wash_fold_price = $wash_fold_price;
        $param_wash_iron_price = $wash_iron_price;
        $param_dry_clean_price = $dry_clean_price;
        $param_name = $name;

        // Attempt to execute the prepared statement
        mysqli_stmt_execute($update_stmt);
    }

    // Close statement
    mysqli_stmt_close($update_stmt);

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Prices</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        .form-container {
            max-width: 450px;
            width: 100%;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            margin-top: 0;
            color: #8b5a2b;
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            color: #8b5a2b;
        }

        input[type=text] {
            width: calc(100% - 40px);
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type=text]:focus {
            outline: none;
            border-color: #8b5a2b;
        }

        .icon-container {
            position: relative;
        }

        .icon-container .fa-pencil-alt {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8b5a2b;
        }

        button {
            background-color: #8b5a2b;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            opacity: 0.8;
            background-color: #714623;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Change Price Of Service</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="icon-container">
        <label>Service Provider Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>" readonly>
    </div>
    <div class="icon-container">
        <label>Service: Wash & Fold</label>
        <input type="text" name="wash_fold_price" value="<?php echo $wash_fold_price; ?>" readOnly>
        <i class="fas fa-pencil-alt"></i>
    </div>
    <div class="icon-container">
        <label>Service: Wash & Iron</label>
        <input type="text" name="wash_iron_price" value="<?php echo $wash_iron_price; ?>" readOnly>
        <i class="fas fa-pencil-alt"></i>
    </div>
    <div class="icon-container">
        <label>Service: Dry Clean</label>
        <input type="text" name="dry_clean_price" value="<?php echo $dry_clean_price; ?>" readOnly>
        <i class="fas fa-pencil-alt"></i>
    </div>
    <div class="button-container">
        <button type="submit">Save</button>
        <button type="button" style="margin-left: auto;" onclick="window.history.back();">Go Back</button>
        <button type="reset" style="margin-left: auto;">Reset</button>
    </div>
</form>

    </div>

    <script>
        document.querySelectorAll('.icon-container .fa-pencil-alt').forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.previousElementSibling;
                input.readOnly = !input.readOnly;
                input.focus();
            });
        });
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
            <?php if (!empty($price_err)) { ?>
                alert("<?php echo $price_err; ?>");
            <?php } else { ?>
                alert("Price changed successfully!");
            <?php } ?>
        <?php } ?>
    </script>
</body>

</html>
