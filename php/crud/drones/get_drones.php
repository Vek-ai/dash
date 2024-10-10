<?php

include '../../../includes/db_con.php';

try {
    // Prepare SQL query to get all drones ordered by name
    $stmt = $conn->prepare("SELECT * FROM drones ORDER BY name ASC");
    
    // Execute the query
    $stmt->execute();
    
    // Fetch all results
    $result = $stmt->get_result();
    
    // Create an array to store the drones
    $drones = [];

    // Loop through the result and add each row to the drones array
    while ($row = $result->fetch_assoc()) {
        $drones[] = $row;
    }

    // Send the data back as a JSON response
    echo json_encode(['status' => 'success', 'data' => $drones]);

    // Close the statement
    $stmt->close();

} catch (Exception $e) {
    // Send error message if something goes wrong
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();

?>
