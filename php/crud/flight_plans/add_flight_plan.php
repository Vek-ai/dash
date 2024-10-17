<?php

include '../../../includes/db_con.php';

// Check if POST request is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the POST request
    $flightPlans = json_decode($_POST['flight_plans'], true);
    /* Example: $flightPlans = [{"flight_plan":"Flight Plan 1", 
                                 "markers":[
                                   {"latitude":"1", "longitude":"2"}, 
                                   {"latitude":"3","longitude":"4"} 
                                 ]} 
                               ] */

    // Check if the flightPlans array is populated and return the content for debugging
    if (empty($flightPlans)) {
        $response = [
            'status' => 'error',
            'message' => 'No flight plans received. Debug: ' . json_encode($_POST['flight_plans'])
        ];
        echo json_encode($response);
        exit();
    }

    // Start a database transaction
    $conn->begin_transaction();

    try {
        // Loop through each flight plan
        foreach ($flightPlans as $plan) {
            $flightPlanName = $conn->real_escape_string($plan['flight_plan']); // Sanitize flight plan name
            $drone_id = $conn->real_escape_string($plan['drone_id']); // Sanitize drone_id

            // Insert the flight plan into the flight_plans table
            $sqlInsertPlan = "INSERT INTO flight_plans (plan_name, drone_id) VALUES ('$flightPlanName', '$drone_id')";
            if (!$conn->query($sqlInsertPlan)) {
                throw new Exception("Error inserting flight plan: " . $conn->error);
            }

            // Get the last inserted flight_plan_id
            $flightPlanId = $conn->insert_id;

            // Convert the markers array to a JSON-encoded string
            $markersJson = json_encode($plan['markers']);

            // Insert the markers into the flight_plan_markers table as a single entry
            $sqlInsertMarker = "INSERT INTO flight_plan_markers (flight_plan_id, markers) 
                                VALUES ($flightPlanId, '$markersJson')";
            if (!$conn->query($sqlInsertMarker)) {
                throw new Exception("Error inserting markers: " . $conn->error);
            }
        }

        // Commit the transaction if everything is successful
        $conn->commit();

        // Return success response
        $response = [
            'status' => 'success',
            'message' => 'Flight plan and markers added successfully.',
            'data_received' => $flightPlans // Debug: include the received data
        ];

    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        $response = [
            'status' => 'error',
            'message' => 'Transaction failed: ' . $e->getMessage(),
            'data_received' => $flightPlans // Debug: include the received data
        ];
    }

    // Return the response as JSON
    echo json_encode($response);

} else {
    // If request method is not POST, return an error response
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];
    echo json_encode($response);
}
