<?php
// Include your database connection file
include 'includes/db_con.php'; 

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

<style>
    #altitude,
    #resolution-px {
        -webkit-appearance: none;
        width: 100%;
        height: 20px;
        /* Adjust this to make the slider track more square */
        background: #ddd;
        border-radius: 5px;
        outline: none;
    }

    #altitude::-webkit-slider-thumb,
    #resolution-px::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        /* Width and height for the thumb */
        height: 20px;
        background: #428BCA;
        cursor: pointer;
        border-radius: 20%;
    }
</style>

<section class="panel">
    <div class="panel-body content-1" style="padding: 30px;">
        <div class="row">
            <h4> <?php echo htmlspecialchars($drone_data['name']); ?></h4>
            <p>We've increased the range of droplet size from 50 to 500um</p>
        </div>

        <div class="row" style="padding-top: 20px;">
            <label for="battery">Battery</label>
            <div class="card" style="width: 100%; display: flex; align-items: center; height: 65px;">
                <div style="width: 80%; padding-inline: 10px"><?php echo htmlspecialchars($drone_data['battery']); ?>%
                    <span class="fas fa-battery-full"></span></div>
                <div style="padding-inline: 5px;"><?php echo htmlspecialchars($drone_data['bat_temp']); ?>°C</div>
            </div>
        </div>

        <div class="row" style="padding-top: 20px;">
            <label for="altitude">Altitude Limited</label>
            <div class="card" style="width: 100%; padding: 20px; height: 65px;">
                <div style="display: flex; align-items: center;">
                    <input type="range" class="form-range" id="altitude" min="0" max="100" step="1"
                        value="<?php echo htmlspecialchars($drone_data['altitude_limited']); ?>" style="flex-grow: 1;">
                    <span id="altitude-output"
                        style="padding-left: 10px;"><?php echo htmlspecialchars($drone_data['altitude_limited']); ?></span>
                </div>
                <div class="slider-ticks" style="position: relative; width: 90%; height: 20px; margin-top: 5px;">
                    <div style="display: flex; justify-content: space-between; width: 100%; position: relative;">
                        <span style="text-align: center; width: 27%;">10</span>
                        <span style="text-align: center; width: 25%;">50</span>
                        <span style="text-align: center; width: 20%;">100</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-top: 20px;">
            <label for="resolution-px">Resolution px</label>
            <div class="card" style="width: 100%; padding: 20px; height: 65px;">
                <div style="display: flex; align-items: center;">
                    <input type="range" class="form-range" id="resolution-px" min="0" max="100" step="1"
                        value="<?php echo htmlspecialchars($drone_data['resolution_px']); ?>" style="flex-grow: 1;">
                    <span id="resolution-output"
                        style="padding-left: 10px;"><?php echo htmlspecialchars($drone_data['resolution_px']); ?></span>
                </div>
                <div class="slider-ticks" style="position: relative; width: 90%; height: 20px; margin-top: 5px;">
                    <div style="display: flex; justify-content: space-between; width: 100%; position: relative;">
                        <span style="text-align: center; width: 27%;">10</span>
                        <span style="text-align: center; width: 25%;">50</span>
                        <span style="text-align: center; width: 20%;">100</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ISO, HDR, and DVR Grouped Buttons -->
        <div class="row">
            <div class="btn-group"
                style="width: 100%; padding-bottom: 15px; padding-top: 15px; display: flex; justify-content: center; align-items: center;">
                <button type="button" class="btn active" id="isoBtn">ISO</button>
                <button type="button" class="btn active" id="hdrBtn">HDR</button>
                <button type="button" class="btn btn-primary" id="dvrBtn">DVR</button>
            </div>
        </div>
    </div>
</section>

<script>
    const altitudeSlider = document.getElementById('altitude');
    const resolutionSlider = document.getElementById('resolution-px');
    const altitudeOutput = document.getElementById('altitude-output');
    const resolutionOutput = document.getElementById('resolution-output');

    altitudeSlider.oninput = function () {
        altitudeOutput.textContent = this.value;
    }

    resolutionSlider.oninput = function () {
        resolutionOutput.textContent = this.value;
    }
</script>