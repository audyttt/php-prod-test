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
        <a href="redeem.php" class="btn btn-success">My Redeem</a>
        <a href="index.php" class="btn btn-secondary">Log out</a>
        <input type="hidden" id="userPoints" value="<?php echo $userPoints; ?>">
    </div>

    <div class="container">
        <!-- Block Item List -->
        <div class="row">
            <?php
            // Fetch data from the privilegeItem table
            $itemSql = "SELECT * FROM privilegeItem";
            $itemResult = $conn->query($itemSql);

            if ($itemResult->num_rows > 0) {
                while ($itemRow = $itemResult->fetch_assoc()) {
                    $itemName = htmlspecialchars($itemRow["name"]);
                    // $itemDescription = htmlspecialchars($itemRow["description"]);
                    $itemImage = htmlspecialchars($itemRow["image"]);
                    $itemPrice = htmlspecialchars($itemRow["price"]);
                    $itemDiscount = htmlspecialchars($itemRow["discount"]);
                    $itemId = $itemRow["id"]; // Assuming you have an 'id' column in the privilegeItem table

                    // Display each item in a Bootstrap card
                    echo '<div class="col-md-4 block-item">';
                    echo '<div class="card">';
                    echo '<img src="' . $itemImage . '" class="card-img-top" alt="' . $itemName . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $itemName . '</h5>';
                    echo '<p class="card-text">Discount: ' . $itemDiscount . '%</p>';
                    echo '<p class="card-text">' . $itemPrice . ' Points</p>';
                    echo '<a href="#" class="btn btn-success redeem-btn" data-toggle="modal" data-target="#redeemModal" data-itemid="' . $itemId . '" data-itemprice="' . $itemPrice . '" data-itemdiscount="' . $itemDiscount . '">Redeem</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No items found.";
            }
            ?>
        </div>
    </div>

    <!-- Redeem Modal -->
    <div class="modal fade" id="redeemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Redemption</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="itemInfo"></p>
                    <p id="confirmationMessage">Are you sure you want to redeem this item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmRedeem">Redeem</button>
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
    // Handle "Redeem" button click event
    $(".redeem-btn").click(function () {
        var itemId = $(this).data("itemid");
        var itemName = $(this).closest(".card").find(".card-title").text();
        var itemPrice = $(this).data("itemprice"); // Retrieve price from data attribute
        var itemDiscount = $(this).data("itemdiscount"); // Retrieve discount from data attribute

        // Retrieve the user's points from the hidden input field
        var userPoints = parseInt($("#userPoints").val());

        // Check if the user has enough points to redeem
        if (userPoints >= parseInt(itemPrice)) {
            // User has enough points, proceed with redemption

            // Update the modal content with item information
            $("#itemInfo").html("<strong>Name:</strong> " + itemName + "<br><strong>Points:</strong>" + itemPrice + "<br><strong>Discount:</strong> " + itemDiscount + "%");

            // Attach the itemId to the "Redeem" button in the modal
            $("#confirmRedeem").data("itemid", itemId);

            // Show the modal
            $("#redeemModal").modal("show");
        } else {
            // User doesn't have enough points
            ("You don't have enough points to redeem this item.");
        }
    });

    // Handle "Confirm" button in modal click event
    $("#confirmRedeem").click(function () {
        var itemId = $(this).data("itemid");

        // Generate a random 10-digit discount code
        var discountCode = generateRandomCode(10);

        // Send an AJAX request to insert the redemption record into the database
        $.ajax({
            url: "process_redemption.php", // Replace with the actual URL to your redemption processing script
            type: "POST",
            data: {
                userId: <?php echo $userRow["id"]; ?>, // Replace with the actual user ID
                itemId: itemId,
                phone: '<?php echo $phone; ?>',
                discountCode: discountCode
            },
            success: function (response) {
                if (response === "success") {
                    // Redemption successful, close the modal
                    $("#redeemModal").modal("hide");

                    // Redirect to the redeem page
                    window.location.href = "redeem.php?item_id=" + itemId;
                } else {
                    // Handle errors or display an error message
                    alert("Redemption failed. Please try again.");
                }
            }
        });
    });

    // Function to generate a random code of the specified length
    function generateRandomCode(length) {
        var chars = "0123456789";
        var code = "";
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * chars.length);
            code += chars.charAt(randomIndex);
        }
        return code;
    }
});

    </script>
</body>

</html>