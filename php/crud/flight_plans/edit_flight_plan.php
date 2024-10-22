<?php

include '../../../includes/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flight_plan_id = $_POST['flight_plan_id']; // Get the fight_plan ID from the form
    $plan_name = $_POST['flight_plan_name']; // Get the new flight plan name from the form

    // Validate input
    if (!empty($flight_plan_id) && !empty($plan_name)) {
        try {
            // Check if the flight plan exists by ID
            $checkFlightPlanStmt = $conn->prepare("SELECT COUNT(*) FROM flight_plans WHERE id = ?");
            $checkFlightPlanStmt->bind_param("i", $flight_plan_id);
            $checkFlightPlanStmt->execute();
            $checkFlightPlanStmt->bind_result($flightPlanExists);
            $checkFlightPlanStmt->fetch();
            $checkFlightPlanStmt->close();

            if ($flightPlanExists == 0) {
                // If flight plan does not exist, send an error response
                echo json_encode(['status' => 'error', 'message' => 'Flight plan not found.']);
            } else {
                // Check if the new name already exists for another flight plan
                $checkNameStmt = $conn->prepare("SELECT COUNT(*) FROM flight_plans WHERE plan_name = ? AND id != ?");
                $checkNameStmt->bind_param("si", $plan_name, $flight_plan_id);
                $checkNameStmt->execute();
                $checkNameStmt->bind_result($nameExists);
                $checkNameStmt->fetch();
                $checkNameStmt->close();

                if ($nameExists > 0) {
                    // If the new name already exists, send an error response
                    echo json_encode(['status' => 'error', 'message' => 'Flight plan name already exists.']);
                } else {
                    // Update the flight plan's name if the name doesn't already exist
                    $updateStmt = $conn->prepare("UPDATE flight_plans SET plan_name = ? WHERE id = ?");
                    $updateStmt->bind_param("si", $plan_name, $flight_plan_id);

                    // Execute the statement
                    if ($updateStmt->execute()) {
                        // Send a success response
                        echo json_encode(['status' => 'success', 'message' => 'Plan updated successfully!']);
                    } else {
                        // Send an error message if something goes wrong
                        echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again. ' . $updateStmt->error]);
                    }

                    // Close the update statement
                    $updateStmt->close();
                }
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "Error: " . $e->getMessage()]);
        }
    } else {
        // If any field is empty
        echo json_encode(['status' => 'error', 'message' => "Please provide flight plan ID, name, and status."]);
    }

    // Close the database connection
    $conn->close();
}
