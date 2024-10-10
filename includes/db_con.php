<?php
// Database connection details
$servername = "localhost"; 
$username = "benguetf_safesky"; 
$password_db = "Safesky@123"; 
$dbname = "benguetf_safesky"; 

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}