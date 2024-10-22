<?php

include '../../../includes/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drone_id = $_POST['drone_id']; // Get the drone ID from the form
    $drone_name = $_POST['drone_name']; // Get the new drone name from the form
    $drone_status = $_POST['drone_status']; // Get the new drone status from the form

    // Validate input
    if (!empty($drone_id) && !empty($drone_name) && !empty($drone_status)) {
        try {
            // Check if the drone exists by ID
            $checkDroneStmt = $conn->prepare("SELECT COUNT(*) FROM drones WHERE id = ?");
            $checkDroneStmt->bind_param("i", $drone_id);
            $checkDroneStmt->execute();
            $checkDroneStmt->bind_result($droneExists);
            $checkDroneStmt->fetch();
            $checkDroneStmt->close();

            if ($droneExists == 0) {
                // If drone does not exist, send an error response
                echo json_encode(['status' => 'error', 'message' => 'Drone not found.']);
            } else {
                // Check if the new name already exists for another drone
                $checkNameStmt = $conn->prepare("SELECT COUNT(*) FROM drones WHERE name = ? AND id != ?");
                $checkNameStmt->bind_param("si", $drone_name, $drone_id);
                $checkNameStmt->execute();
                $checkNameStmt->bind_result($nameExists);
                $checkNameStmt->fetch();
                $checkNameStmt->close();

                if ($nameExists > 0) {
                    // If the new name already exists, send an error response
                    echo json_encode(['status' => 'error', 'message' => 'Drone name already exists.']);
                } else {
                    // Update the drone's name and status if the name doesn't already exist
                    $updateStmt = $conn->prepare("UPDATE drones SET name = ?, status = ? WHERE id = ?");
                    $updateStmt->bind_param("ssi", $drone_name, $drone_status, $drone_id);

                    // Execute the statement
                    if ($updateStmt->execute()) {
                        // Send a success response
                        echo json_encode(['status' => 'success', 'message' => 'Drone updated successfully!']);
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
        echo json_encode(['status' => 'error', 'message' => "Please provide drone ID, name, and status."]);
    }

    // Close the database connection
    $conn->close();
}
