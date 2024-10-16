<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../../../includes/db_con.php';

header('Content-Type: application/json');

try {
    // Get flight plan ID from request
    $flightPlanId = $_GET['id'];

    // Prepare SQL query to fetch the JSON markers field for the specified flight plan
    $stmt = $conn->prepare("SELECT markers FROM flight_plan_markers WHERE flight_plan_id = ?");
    $stmt->bind_param("i", $flightPlanId);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Decode the JSON markers field
    $markers = json_decode($row['markers'], true);

    // If the markers data is properly formatted
    if (is_array($markers)) {
        foreach ($markers as $index => &$marker) {
            // Assign a name based on the index, e.g., "Marker 1", "Marker 2", etc.
            $marker['name'] = 'Marker ' . ($index + 1);
        }
    }

    // Send the updated markers data back as a JSON response
    echo json_encode(['status' => 'success', 'data' => $markers]);

    // Close the statement
    $stmt->close();

} catch (Exception $e) {
    // Send error message if something goes wrong
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();

?>
