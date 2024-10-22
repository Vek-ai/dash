<?php

include '../../../includes/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $airport_id = $_POST['airport_id']; // Get the airport ID from the form
    $airport_name = $_POST['airport_name']; // Get the new airport name from the form

    // Validate input
    if (!empty($airport_id) && !empty($airport_name)) {
        try {
            // Check if the airport exists by ID
            $checkAirportStmt = $conn->prepare("SELECT COUNT(*) FROM airports WHERE id = ?");
            $checkAirportStmt->bind_param("i", $airport_id);
            $checkAirportStmt->execute();
            $checkAirportStmt->bind_result($airportExists);
            $checkAirportStmt->fetch();
            $checkAirportStmt->close();

            if ($airportExists == 0) {
                // If airport does not exist, send an error response
                echo json_encode(['status' => 'error', 'message' => 'Airport not found.']);
            } else {
                // Check if the new name already exists for another airport
                $checkNameStmt = $conn->prepare("SELECT COUNT(*) FROM airports WHERE name = ? AND id != ?");
                $checkNameStmt->bind_param("si", $airport_name, $airport_id);
                $checkNameStmt->execute();
                $checkNameStmt->bind_result($nameExists);
                $checkNameStmt->fetch();
                $checkNameStmt->close();

                if ($nameExists > 0) {
                    // If the new name already exists, send an error response
                    echo json_encode(['status' => 'error', 'message' => 'Airport name already exists.']);
                } else {
                    // Update the airport's name and status if the name doesn't already exist
                    $updateStmt = $conn->prepare("UPDATE airports SET name = ? WHERE id = ?");
                    $updateStmt->bind_param("si", $airport_name, $airport_id); // Corrected placeholder

                    // Execute the statement
                    if ($updateStmt->execute()) {
                        // Send a success response
                        echo json_encode(['status' => 'success', 'message' => 'Airport updated successfully!']);
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
        echo json_encode(['status' => 'error', 'message' => "Please provide airport ID and name."]);
    }

    // Close the database connection
    $conn->close();
}
