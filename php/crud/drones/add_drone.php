<?php

include '../../../includes/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drone_name = $_POST['drone_name'];

    // Validate input
    if (!empty($drone_name)) {
        try {
            // Check if the drone name already exists
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM drones WHERE name = ?");
            $checkStmt->bind_param("s", $drone_name);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                // Send an error response if the name already exists
                echo json_encode(['status' => 'error', 'message' => 'Drone name already exists.']);
            } else {
                // If the name doesn't exist, proceed with the insert
                $stmt = $conn->prepare("INSERT INTO drones (name) VALUES (?)");
                $stmt->bind_param("s", $drone_name);

                // Execute the statement
                if ($stmt->execute()) {
                    // Send a success response
                    echo json_encode(['status' => 'success', 'message' => 'Drone added successfully!']);
                } else {
                    // Send an error message if something goes wrong
                    echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again. ' . $stmt->error]);
                }

                // Close the statement
                $stmt->close();
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "Error: " . $e->getMessage()]);
        }
    } else {
        // If the drone name is empty
        echo json_encode(['status' => 'error', 'message' => "Please enter a drone name."]);
    }

    // Close the database connection
    $conn->close();
}
?>
