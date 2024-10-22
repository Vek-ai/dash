<?php

include '../../../includes/db_con.php';

// Check if the airport ID is provided
if (isset($_POST['id'])) {
    $airportId = $_POST['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM airports WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Bind the airport ID to the query
    $stmt->bind_param('i', $airportId);

    // Execute the query
    if ($stmt->execute()) {
        // If the airport was successfully deleted
        $response = [
            'status' => 'success',
            'message' => 'Airport deleted successfully.'
        ];
    } else {
        // If there was an error during deletion
        $response = [
            'status' => 'error',
            'message' => 'Failed to delete airport.'
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
        'message' => 'Invalid request. Airport ID is missing.'
    ];
    echo json_encode($response);
}
?>
