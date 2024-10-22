<?php

include '../../../includes/db_con.php';

// Check if the drone ID is provided
if (isset($_POST['id'])) {
    $droneId = $_POST['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM drones WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Bind the drone ID to the query
    $stmt->bind_param('i', $droneId);

    // Execute the query
    if ($stmt->execute()) {
        // If the drone was successfully deleted
        $response = [
            'status' => 'success',
            'message' => 'Drone deleted successfully.'
        ];
    } else {
        // If there was an error during deletion
        $response = [
            'status' => 'error',
            'message' => 'Failed to delete drone.'
        ];
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Return the response as JSON
    echo json_encode($response);
} else {
    // If no ID was provided in the request
    $response = [
        'status' => 'error',
        'message' => 'Invalid request. Drone ID is missing.'
    ];
    echo json_encode($response);
}
?>
