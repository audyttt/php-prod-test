<?php
// Include the db_connection.php file
include('db_connection.php');

// Initialize variables for error message and database insert status
$error = "";
$dbStatus = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $phone = $_POST["phone"];
    $name = $_POST["name"];

    // SQL query to check if the phone number or name already exists
    $checkQuery = "SELECT COUNT(*) as count FROM users WHERE phone = '$phone' OR name = '$name'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        $count = $row["count"];

        if ($count > 0) {
            // A record with the same phone number or name already exists
            $dbStatus = "Phone number or name already exists.";
        } else {
            // No duplicate phone number or name found, proceed with insertion
            $sql = "INSERT INTO users (name, phone, point) VALUES ('$name', '$phone', 1000)";

            if ($conn->query($sql) === TRUE) {
                $dbStatus = "Registered successfully.";
            } else {
                $dbStatus = "Error inserting data: " . $conn->error;
            }
        }
    } else {
        $dbStatus = "Error checking for duplicate records: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <!-- Link to Bootstrap CSS from a CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Center the form and adjust form width */
        .center-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 94vh; /* Set the height to 80% viewport height */
        }
        .center-form form {
            width: 60%;
        }
        /* Set body height to 100% */
        body, html {
            height: 100%;
        }
        /* Style the footer */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa; /* Change the background color as needed */
        }
        /* Add margin to the logo */
        .logo {
            margin: 20px; /* Adjust the margin as needed */
        }
        .logo img{
            width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container center-form">
        <!-- Image Logo -->
        <div class="text-center mt-4 logo">
        <img src="./images/logo.jpg" alt="Logo">
        </div>

        <!-- Display the database insert status message -->
        <div class="alert alert-info">
            <?php echo $dbStatus; ?>
        </div>

        <!-- Back to Index button -->
        <div class="text-center">
            <a href="index.php" class="btn btn-primary">Back to Login</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date("Y"); ?> Your Company Name. All Rights Reserved.
    </footer>

    <!-- JavaScript and jQuery (Optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
