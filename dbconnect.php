<?php
$server = "localhost"; // Corrected spelling of "localhost"
$username = "root";
$password = "";
$database = "miniproject";

// Corrected order of parameters in mysqli_connect function
$conn = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
