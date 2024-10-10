<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    // Destroy the session to log the user out
    session_unset();
    session_destroy();
    
    // Redirect to login page
    header("Location: ../login.php");
    exit();
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: ../login.php");
    exit();
}
?>
