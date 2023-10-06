<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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
        .form-control{
            margin: 10px 0px;
        }
    </style>
</head>
<body>
    <div class="container center-form">
          <!-- Image Logo -->
          <div class="text-center mt-4 logo">
          <img src="./images/logo.jpg" alt="Logo">
        </div>
        <form action="process_form.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary" type="submit">Register</button>
               
                
            </div>
        </form>
        <a href="index.php"><button class="btn btn-secondary">Back</button></a>

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
</body>
</html>
