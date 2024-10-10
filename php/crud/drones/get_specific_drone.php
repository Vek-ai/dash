<?php
// Include your database connection file
include('includes\db_con.php');

// Initialize a variable to store drone data
$drone_data = null;

// Check if the 'id' is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $drone_id = intval($_GET['id']); // Sanitize and cast to integer to prevent SQL injection

    // Prepare the SQL statement to fetch drone data based on the passed ID
    $query = "SELECT * FROM drones WHERE id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the drone ID to the statement
        $stmt->bind_param("i", $drone_id);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if any data was fetched
        if ($result->num_rows > 0) {
            // Fetch the data as an associative array
            $drone_data = $result->fetch_assoc();
        } else {
            echo "No drone found with this ID.";
            exit; // Stop further execution if no data is found
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error in SQL preparation.";
        exit; // Stop execution in case of SQL preparation error
    }
} else {
    echo "No drone ID was passed in the URL.";
    exit; // Stop execution if no ID is passed
}
?>
