<?php
// Include the db_connection.php file
include('db_connection.php');

if (isset($_POST["itemId"])) {
    $itemId = $_POST["itemId"];

    // Query to fetch the item price from the privilegeItem table
    $priceQuery = "SELECT price FROM privilegeItem WHERE id = '$itemId'";
    $priceResult = $conn->query($priceQuery);

    if ($priceResult->num_rows > 0) {
        $row = $priceResult->fetch_assoc();
        $itemPrice = $row["price"];

        // Update the user's points using the fetched item price
        $userId = $_POST["userId"];
        $updateSql = "UPDATE users SET point = point - '$itemPrice' WHERE id = '$userId'";

        if ($conn->query($updateSql) === TRUE) {
            // Insert a new record into the redemption table
            $phone = $_POST["phone"];
            $discountCode = $_POST["discountCode"];

            // Insert the redemption record into the database
            // SQL query to insert a new redemption record with the current timestamp
            $insertSql = "INSERT INTO redemption (itemId, userId, phone, discountCode, created_at)
VALUES ('$itemId', '$userId', '$phone', '$discountCode', CURRENT_TIMESTAMP)";


            if ($conn->query($insertSql) === TRUE) {
                echo "success";
            } else {
                echo "Error inserting redemption record: " . $conn->error;
            }
        } else {
            echo "Error updating user points: " . $conn->error;
        }
    } else {
        echo "Item not found.";
    }
} else {
    echo "Invalid request.";
}
