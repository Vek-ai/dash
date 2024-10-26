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
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('Invalid flight plan ID.');
    }
    $flightPlanId = (int)$_GET['id'];

    // Prepare SQL query to fetch the JSON markers field from flight_plan_markers table
    $stmtMarkers = $conn->prepare("SELECT markers FROM flight_plan_markers WHERE flight_plan_id = ?");
    $stmtMarkers->bind_param("i", $flightPlanId);
    
    // Execute the query for markers
    $stmtMarkers->execute();
    
    // Fetch the result for markers
    $resultMarkers = $stmtMarkers->get_result();
    $rowMarkers = $resultMarkers->fetch_assoc();

    // Decode the JSON markers field and initialize $markers as an empty array if decoding fails
    $markers = isset($rowMarkers['markers']) ? json_decode($rowMarkers['markers'], true) : [];

    // Check if decoding was successful and if markers data is properly formatted
    if (is_array($markers)) {
        foreach ($markers as $index => &$marker) {
            if (is_array($marker)) {
                $marker['name'] = 'Marker ' . ($index + 1);
            }
        }
    } else {
        $markers = []; // Set to empty array if markers are not in expected format
    }

    // Prepare SQL query to fetch data from drone_flights and join with drones table
    $stmtDrones = $conn->prepare("SELECT df.drone_id, d.name, df.markers 
                                   FROM drone_flights df 
                                   JOIN drones d ON df.drone_id = d.id 
                                   WHERE df.flight_plan_id = ?");
    $stmtDrones->bind_param("i", $flightPlanId);
    
    // Execute the query for drones
    $stmtDrones->execute();
    
    // Fetch the results for drones
    $resultDrones = $stmtDrones->get_result();
    $drones = [];

    // Loop through each row in drone_flights
    while ($rowDrone = $resultDrones->fetch_assoc()) {
        // Decode the JSON markers field for each drone entry
        $droneMarkers = isset($rowDrone['markers']) ? json_decode($rowDrone['markers'], true) : [];
        
        // Check if decoding was successful and if droneMarkers data is properly formatted
        if (is_array($droneMarkers)) {
            foreach ($droneMarkers as $index => &$droneMarker) {
                if (is_array($droneMarker)) {
                    $droneMarker['name'] = 'Marker ' . ($index + 1);
                }
            }
        } else {
            $droneMarkers = []; // Set to empty array if drone markers are not in expected format
        }

        // Add the drone data to the drones array with drone name
        $drones[] = [
            'drone_id' => $rowDrone['drone_id'],
            'drone_name' => $rowDrone['name'], // Include drone name here
            'markers' => $droneMarkers
        ];
    }

    // Send the combined data back as a JSON response
    echo json_encode([
        'status' => 'success',
        'data' => [
            'flight_plan_markers' => $markers,
            'drone_flights' => $drones
        ]
    ]);

    // Close the statements
    $stmtMarkers->close();
    $stmtDrones->close();

} catch (Exception $e) {
    // Send error message if something goes wrong
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
