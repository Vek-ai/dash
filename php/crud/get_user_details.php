<?php
session_start();
require '../../includes/db_con.php'; // This will use $conn from db_con.php

$response = ['session' => $_SESSION]; // Include the session in the response

if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];

    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query); // Use $conn here
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $response['status'] = 'success';
        $response['data'] = $user;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'User not found';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'User not authenticated';
}

echo json_encode($response);
?>
