<?php
$host = 'db';
$user = 'root';
$pass = 'MYSQL_ROOT_PASSWORD';
$dbname = "member";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    $connectionResult = "Connection failed: " . $conn->connect_error;
} else {
    $connectionResult = "Connected successfully";
}
?>