<?php
include '../../../includes/db_con.php';
header('Content-Type: application/json'); // Set JSON header

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flightPlanId = $_POST['flightPlanId'];
    $markersData = json_decode($_POST['markers'], true);

    // Check if markers data is provided
    if (empty($markersData)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No markers received.',
            'data_received' => $_POST['markers']
        ]);
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();
    try {
        // Delete existing markers for this flight plan
        $sqlDeleteMarkers = "DELETE FROM flight_plan_markers WHERE flight_plan_id = ?";
        $stmtDelete = $conn->prepare($sqlDeleteMarkers);
        $stmtDelete->bind_param('i', $flightPlanId);
        $stmtDelete->execute();

        // Prepare the insert statement for markers as a single JSON array
        $sqlInsertMarker = "INSERT INTO flight_plan_markers (flight_plan_id, markers) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsertMarker);

        // Convert markers array to JSON format
        $markersJson = json_encode($markersData);

        // Bind and execute the insert statement
        $stmtInsert->bind_param('is', $flightPlanId, $markersJson);
        if (!$stmtInsert->execute()) {
            throw new Exception('Insert failed: ' . $stmtInsert->error);
        }

        // Commit transaction if all markers are inserted successfully
        $conn->commit();
        echo json_encode([
            'status' => 'success',
            'message' => 'Markers updated successfully.',
            'data_received' => $markersData // Debug: include the received markers data
        ]);

    } catch (Exception $e) {
        // Rollback transaction if there's an error
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => 'Transaction failed: ' . $e->getMessage()
        ]);
    } finally {
        // Close statements
        if (isset($stmtDelete)) {
            $stmtDelete->close();
        }
        if (isset($stmtInsert)) {
            $stmtInsert->close();
        }
        // Close the database connection
        $conn->close();
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
