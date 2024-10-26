<?php

include '../../../includes/db_con.php';

// Check if POST request is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the POST request
    $flightPlans = json_decode($_POST['flight_plans'], true);

    // Check if the flightPlans array is populated
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
            // Sanitize flight plan name and drone_id
            $flightPlanName = isset($plan['flight_plan']) && is_string($plan['flight_plan']) ? $conn->real_escape_string($plan['flight_plan']) : '';

            // Check if drone_id is an array
            if (isset($plan['drone_id'])) {
                if (is_array($plan['drone_id'])) {
                    $drone_id = implode(',', $plan['drone_id']);  // Convert array to string
                } else {
                    $drone_id = $plan['drone_id'];  // Use as it is if it's a string
                }
                $drone_id = $conn->real_escape_string($drone_id); // Sanitize drone_id
            } else {
                throw new Exception('Drone ID is missing.');
            }

            if (empty($flightPlanName) || empty($drone_id)) {
                throw new Exception('Invalid flight plan name or drone ID.');
            }

            // Insert the flight plan into the flight_plans table
            $sqlInsertPlan = "INSERT INTO flight_plans (plan_name, drone_id) VALUES ('$flightPlanName', '$drone_id')";
            if (!$conn->query($sqlInsertPlan)) {
                throw new Exception("Error inserting flight plan: " . $conn->error);
            }

            // Get the last inserted flight_plan_id
            $flightPlanId = $conn->insert_id;

            // Convert the markers array to a JSON-encoded string for the flight_plan_markers table
            if (isset($plan['markers']) && is_array($plan['markers'])) {
                $markersJson = json_encode($plan['markers']);
                $markersJsonEscaped = $conn->real_escape_string($markersJson);

                // Insert the markers as a JSON string into the markers field in flight_plan_markers table
                $sqlInsertMarker = "INSERT INTO flight_plan_markers (flight_plan_id, markers) 
                                    VALUES ('$flightPlanId', '$markersJsonEscaped')";
                if (!$conn->query($sqlInsertMarker)) {
                    throw new Exception("Error inserting markers: " . $conn->error);
                }

                // Get the first marker for centering
                $firstMarker = $plan['markers'][0] ?? null;

                // Check if the first marker is available
                if ($firstMarker) {
                    $baseLatitude = $firstMarker['latitude'];
                    $baseLongitude = $firstMarker['longitude'];

                    // Loop through each drone_id and insert data into the drone_flights table
                    if (isset($plan['drone_id']) && is_array($plan['drone_id'])) {
                        $numDrones = count($plan['drone_id']);
                        $spacing = 0.00005; // Adjust this value for spacing

                        foreach ($plan['drone_id'] as $index => $drone_id) {
                            $drone_id = $conn->real_escape_string($drone_id);

                            // Calculate new longitude for each drone
                            // Distribute drones horizontally around the first marker
                            $newLongitude = $baseLongitude + ($spacing * ($index - ($numDrones - 1) / 2)); // Center the first marker
                            $newLatitude = $baseLatitude; // Keep the latitude same for horizontal alignment

                            // Create a new marker for the drone flight
                            $droneMarker = [
                                'latitude' => $newLatitude,
                                'longitude' => $newLongitude
                            ];
                            $droneMarkerJson = json_encode($droneMarker);
                            $droneMarkerJsonEscaped = $conn->real_escape_string($droneMarkerJson);

                            // Insert data into the drone_flights table with the new marker
                            $sqlInsertDroneFlight = "INSERT INTO drone_flights (drone_id, flight_plan_id, markers) 
                                                     VALUES ('$drone_id', '$flightPlanId', '$droneMarkerJsonEscaped')";
                            if (!$conn->query($sqlInsertDroneFlight)) {
                                throw new Exception("Error inserting into drone_flights: " . $conn->error);
                            }
                        }
                    } else {
                        throw new Exception("Drone ID data is missing or not in expected format.");
                    }
                } else {
                    throw new Exception("First marker data is required for centering.");
                }
            } else {
                throw new Exception("Markers data is missing or not in expected format.");
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
