<?php
session_start();
include '../includes/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $userid = $row['id'];
        $_SESSION['userid'] = $userid;
        echo "success";
        exit();
    } else {
        echo "Invalid username or password";
    }

    $conn->close();
}
?>
