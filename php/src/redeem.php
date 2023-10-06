<?php
// Include the db_connection.php file
include('db_connection.php');
session_start(); // Start the session

if (isset($_SESSION["phone"])) {
    $phone = $_SESSION["phone"];

    // SQL query to retrieve user data based on the phone number
    $userSql = "SELECT * FROM users WHERE phone = '$phone' LIMIT 1";
    $userResult = $conn->query($userSql);

    if ($userResult->num_rows > 0) {
        // Fetch the user data
        $userRow = $userResult->fetch_assoc();
        $userName = htmlspecialchars($userRow["name"]);
        $userPhone = htmlspecialchars($userRow["phone"]);
        $userPoints = htmlspecialchars($userRow["point"]);
    } else {
        echo "No member found for the phone number: " . htmlspecialchars($phone);
        exit(); // Exit script if no member found
    }
} else {
    echo "Session data not found.";
    exit(); // Exit script if session data not found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Link to Bootstrap CSS from a CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Set body height to 100% */
        body,
        html {
            height: 100%;
        }

        /* Style the footer */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            /* Change the background color as needed */
        }

        /* Style the profile section */
        .profile {
            background-color: #007BFF;
            color: white;
            padding: 20px;
        }

        /* Style the block item list */
        .block-item {
            margin-top: 20px;
        }

        .back-button {
            width: 100%;
            border-radius: 0px;
            background-color: gray;
            padding: 15px;
            color: #fff;
        }

        .back-button a {
            color: #fff;
        }
        .card-img-top {
            width: auto;
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Profile Section -->
    <div class="profile">
        <h1><?php echo $userName; ?></h1>
        <p>Phone Number: <?php echo $userPhone; ?></p>
        <p>Points: <?php echo $userPoints; ?></p>
        <a href="privileges.php" class="btn btn-success">Back</a>
        <a href="index.php" class="btn btn-secondary">Log out</a>
    </div>

    <div class="container">
        <!-- Block Item List -->
        <div class="row">
            <?php
            // Modify the SQL query to retrieve data only from the redemption table
            $itemSql = "SELECT * FROM redemption WHERE phone = '$phone' ORDER BY created_at DESC";
            $itemResult = $conn->query($itemSql);

            if ($itemResult->num_rows > 0) {
                while ($itemRow = $itemResult->fetch_assoc()) {
                    $itemId = $itemRow["itemId"];
                    $discountCode = htmlspecialchars($itemRow["discountCode"]);

                    // Fetch additional data for the item from privilegeItem table based on $itemId
                    $privilegeItemSql = "SELECT name, image, price, discount FROM privilegeItem WHERE id = '$itemId'";
                    $privilegeItemResult = $conn->query($privilegeItemSql);

                    if ($privilegeItemResult->num_rows > 0) {
                        $privilegeItemRow = $privilegeItemResult->fetch_assoc();
                        $itemName = htmlspecialchars($privilegeItemRow["name"]);
                        $itemImage = htmlspecialchars($privilegeItemRow["image"]);
                        $itemPrice = htmlspecialchars($privilegeItemRow["price"]);
                        $itemDiscount = htmlspecialchars($privilegeItemRow["discount"]);
                    }

                    // Display each item in a Bootstrap card
                    echo '<div class="col-md-4 block-item">';
                    echo '<div class="card">';
                    echo '<img src="' . $itemImage . '" class="card-img-top" alt="' . $itemName . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $itemName . '</h5>';
                    echo '<p class="card-text">Discount: ' . $itemDiscount . '%</p>';
                    echo '<p class="card-text">' . $itemPrice . ' Points</p>';
                    // if (!empty($discountCode)) {
                    //     echo '<p class="card-text">Discount Code: ' . $discountCode . '</p>';
                    // }
                    echo '<a href="#" class="btn btn-success redeem-btn" data-toggle="modal" data-target="#qrCodeModal" data-discountcode="' . $discountCode . '">Use</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No redemption records found.";
            }
            ?>
        </div>
    </div>

    <!-- Modal for displaying discount code and confirmation -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">Discount Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="discountCodeDisplay"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmUse">Confirm</button>
                </div>
            </div>
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
    <script>
        $(document).ready(function () {
            $(".redeem-btn").click(function () {
                // Extract the Discount Code from the data attribute
                var discountCode = $(this).data("discountcode");

                // Display the discount code in the modal
                $("#discountCodeDisplay").text(discountCode);

                // Show the QR code modal
                $("#qrCodeModal").modal("show");
            });

            // Handle "Confirm" button in modal click event
            $("#confirmUse").click(function () {
                // Extract the Discount Code from the modal
                var discountCode = $("#discountCodeDisplay").text();

                // Send an AJAX request to remove the redemption record
                $.ajax({
                    url: "remove_redemption.php", // Replace with the actual URL to your removal script
                    type: "POST",
                    data: { discountCode: discountCode },
                    success: function (response) {
                        if (response === "success") {
                            // Redemption record removed successfully
                            $("#qrCodeModal").modal("hide");
                            window.location.reload()
                            // You can add further actions here, such as updating the UI
                            // or reloading the page to reflect the removal.
                        } else {
                            // Handle errors or display an error message
                            alert("Failed to remove redemption record. Please try again.");
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
