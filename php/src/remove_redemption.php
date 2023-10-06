<?php
// Include the db_connection.php file
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the discount code from the POST data
    $discountCode = $_POST["discountCode"];

    // Validate and sanitize the input (e.g., check if $discountCode is a valid format)

    // Perform the removal action on the redemption table
    $deleteSql = "DELETE FROM redemption WHERE discountCode = '$discountCode'";

    if ($conn->query($deleteSql) === TRUE) {
        // Successful removal
        echo "success";
    } else {
        // Error during removal
        echo "error";
    }

    // Close the database connection
    $conn->close();
}
?>
