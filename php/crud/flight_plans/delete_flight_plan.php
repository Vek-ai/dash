<?php

include '../../../includes/db_con.php';

// Check if the flight plan ID is provided
if (isset($_POST['id'])) {
    $flightPlanId = $_POST['id'];

    // Begin transaction
    $conn->begin_transaction();
    try {
        // Prepare and execute the DELETE query for flight_plan_markers
        $queryMarkers = "DELETE FROM flight_plan_markers WHERE flight_plan_id = ?";
        $stmtMarkers = $conn->prepare($queryMarkers);
        $stmtMarkers->bind_param('i', $flightPlanId);
        $stmtMarkers->execute();

        // Prepare and execute the DELETE query for flight_plans
        $queryFlightPlan = "DELETE FROM flight_plans WHERE id = ?";
        $stmtFlightPlan = $conn->prepare($queryFlightPlan);
        $stmtFlightPlan->bind_param('i', $flightPlanId);
        $stmtFlightPlan->execute();

        // Commit transaction if both deletions are successful
        $conn->commit();
        $response = [
            'status' => 'success',
            'message' => 'Flight Plan and associated markers deleted successfully.'
        ];
    } catch (Exception $e) {
        // Rollback transaction if there's an error
        $conn->rollback();
        $response = [
            'status' => 'error',
            'message' => 'Failed to delete flight plan and markers: ' . $e->getMessage()
        ];
    }

    // Close the statements and connection
    $stmtMarkers->close();
    $stmtFlightPlan->close();
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
