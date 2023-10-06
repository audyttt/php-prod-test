<?php
session_start();
include('db_connection.php');

// Initialize variables for error message and membership status
$error = "";
$membershipStatus = "Welcome to member system";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the phone number from the form
    $phone = $_POST["phone"];
    $_SESSION["phone"] = $phone;
    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    // Check if the phone number exists in the database (you may need to customize this part)
    $sql = "SELECT * FROM users WHERE phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Phone number found in the database
        $membershipStatus = "You are a member.";
        // Redirect to privileges.php
        header("Location: privileges.php");
        exit(); // Terminate the script to prevent further execution
    } else {
        $membershipStatus = "You are not a member.";

    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEMBER</title>
    <!-- Link to Bootstrap CSS from a CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Center the input field and adjust form width */
        .center-input {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 94vh; /* Set the height to 80% viewport height */
        }
        .center-input form {
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
    <div class="container center-input">
          <!-- Image Logo -->
          <div class="text-center mt-4 logo">
      
            <img src="./images/logo.jpg" alt="Logo">
        </div>
        <form method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" required>
            </div>
            <div class="form-group text-center">
                <button onclick="storePhone()" class="btn btn-primary" type="submit">Submit</button>
                <a href="register.php" class="btn btn-success">Register</a>
            </div>
        </form>
           <!-- Display the membership status -->
           <div class="alert alert-danger">
            <?php echo $membershipStatus; ?>
        </div>

        <!-- Your content goes here -->

      
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date("Y"); ?> Your Company Name. All Rights Reserved.
    </footer>



    <!-- JavaScript and jQuery (Optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function storePhone() {
            // Get the input value
            var phoneValue = document.getElementById("phone").value;
            
            // Store the value in localStorage
            localStorage.setItem("phone", phoneValue);
            

        }
    </script>
</body>
</html>
