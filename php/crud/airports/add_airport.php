<?php

include '../../../includes/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $airport_name = $_POST['airport_name'];

    // Validate input
    if (!empty($airport_name)) {
        try {
            // Check if the airport name already exists
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM airports WHERE name = ?");
            $checkStmt->bind_param("s", $airport_name);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                // Send an error response if the name already exists
                echo json_encode(['status' => 'error', 'message' => 'Airport name already exists.']);
            } else {
                // If the name doesn't exist, proceed with the insert
                $stmt = $conn->prepare("INSERT INTO airports (name) VALUES (?)");
                $stmt->bind_param("s", $airport_name);

                // Execute the statement
                if ($stmt->execute()) {
                    // Send a success response
                    echo json_encode(['status' => 'success', 'message' => 'Airport added successfully!']);
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
        // If the airport name is empty
        echo json_encode(['status' => 'error', 'message' => "Please enter a airport name."]);
    }

    // Close the database connection
    $conn->close();
}
?>
