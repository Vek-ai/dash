<?php

include '../../../includes/db_con.php';

// Check if the flight plan ID is provided
if (isset($_POST['id'])) {
    $flightPlanId = $_POST['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM flight_plans WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Bind the flight plan ID to the query
    $stmt->bind_param('i', $flightPlanId);

    // Execute the query
    if ($stmt->execute()) {
        // If the flight plan was successfully deleted
        $response = [
            'status' => 'success',
            'message' => 'Flight Plan deleted successfully.'
        ];
    } else {
        // If there was an error during deletion
        $response = [
            'status' => 'error',
            'message' => 'Failed to delete flight plan.'
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
        'message' => 'Invalid request. Flight Plan ID is missing.'
    ];
    echo json_encode($response);
}
?>
