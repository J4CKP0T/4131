<?php
//Set variables to connect with DB
$servername = "egon.cs.umn.edu";
$username = "C4131S15U17";
$password = "3622";
$dbname = "C4131S15U17";
$port = "3307";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>