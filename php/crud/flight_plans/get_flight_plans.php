<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../../../includes/db_con.php';

header('Content-Type: application/json');

try {
    // Prepare the SQL query to fetch flight plans with associated drone names
    $stmt = $conn->prepare("
        SELECT flight_plans.*, GROUP_CONCAT(drones.name SEPARATOR ', ') AS drone_names
        FROM flight_plans
        LEFT JOIN drones ON FIND_IN_SET(drones.id, flight_plans.drone_id)
        GROUP BY flight_plans.id
        ORDER BY flight_plans.plan_name ASC
    ");
    
    // Execute the query
    $stmt->execute();
    
    // Fetch all results
    $result = $stmt->get_result(); // For MySQLi
    
    // Create an array to store the flight plans
    $flightPlans = [];

    // Loop through the result and add each row to the flightPlans array
    while ($row = $result->fetch_assoc()) {
        $flightPlans[] = $row;
    }

    // Send the data back as a JSON response
    echo json_encode(['status' => 'success', 'data' => $flightPlans]);

    // Close the statement
    $stmt->close();

} catch (Exception $e) {
    // Send error message if something goes wrong
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
