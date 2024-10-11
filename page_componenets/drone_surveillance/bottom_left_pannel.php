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
	.real-time-view {
		padding-inline: 2px;
		background-color: #F0F0F0;
		height: 65px;
	}

	.real-time-box {
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: center;
	}

	.real-time-row {
		padding-top: 10px;
		display: flex;
		justify-content: space-between;
	}

	.real-time-view-cards-content {
		font-weight: bold;
		font-size: 25px;
	}
	.card-btn {
      border-radius: 40%; 
      height: 20px; 
      width: 30px; 
      border: none; 
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
</style>
<section class="panel">
	<div class="panel-body content-2" style=" height: 370px;">
		<div class="row">
			<div class="col-md-4" style="padding-left: 12px;">
				<div class="btn-group" style="width: 100%; padding-bottom: 15px">
					<button type="button" class="btn active" style="width: 50%;" id="videoBtn">Video</button>
					<button type="button" class="btn btn-primary" style="width: 50%;" id="imageBtn">Image</button>
				</div>

				<div>
					<img src="assets/img/custom/farm-satellite-view.png" alt="Farm satellite view" class="img-fluid"
						style="max-width: 100%; height: auto; object-fit: contain; border-radius: 15px;">
				</div>
			</div>

			<!-- REAL TIME VIEW -->
			<div class="col-md-4">
				<h4>Real time view</h4>

				<div class="row real-time-row">

					<div class="col-md-5 real-time-view">
						<label for="speed">Speed</label>
						<div class="real-time-box">
							<div id="speed" class="real-time-view-cards-content"><?php echo htmlspecialchars($drone_data['speed']); ?></div>
							<i> Km/h</i>
						</div>
					</div>

					<div class="col-md-5 real-time-view">
						<label for="lens">Lens</label>
						<div class="real-time-box">
							<div id="lens" class="real-time-view-cards-content"><?php echo htmlspecialchars($drone_data['lens']); ?></div>
							<i> mm</i>
						</div>
					</div>

				</div>

				<div class="row real-time-row">

					<div class="col-md-5 real-time-view">
						<label for="height">Height</label>
						<div class="real-time-box">
							<div id="height" class="real-time-view-cards-content"><?php echo htmlspecialchars($drone_data['height']); ?></div>
							<i> m</i>
						</div>
					</div>

					<div class="col-md-5 real-time-view">
						<label for="iso">ISO</label>
						<div class="real-time-box">
							<div id="iso" class="real-time-view-cards-content"><?php echo htmlspecialchars($drone_data['iso']); ?></div>
							<i> </i>
						</div>
					</div>

				</div>

				<div class="row real-time-row">

					<div class="col-md-5 real-time-view">
						<label for="flight-time">Flight Time</label>
						<div class="real-time-box">
							<div id="flight-time" class="real-time-view-cards-content"><?php echo htmlspecialchars($drone_data['flight_time']); ?></div>
							<i></i>
						</div>
					</div>


					<div class="col-md-5 real-time-view">
						<label for="shutter">Shutter</label>
						<div class="real-time-box">
							<div id="shutter" class="real-time-view-cards-content"><?php echo htmlspecialchars($drone_data['shutter']); ?></div>
							<i></i>
						</div>
					</div>

				</div>
			</div>
			<!-- END OF REAL TIME VIEW -->

			<!-- DISPLAY RESOLUTION -->
			<div class="col-md-4">
				<h4>Display resolution</h4>
				<div id="card" class="col-mb-4 real-time-row" style="width: 100%;">
					<div class="panel-body card" style="width: 100%; display: flex; align-items: center;">
						<button class="card-btn"
							style="border-radius: 40%; padding: 10px 20px; border: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);"></button>
						<h5 style="padding-left: 10px;">1280:720</h5>
						<label for="status" style="margin-left: 15px;">Status:</label>
						<div style="display: flex; align-items: center; padding-left: 10px;">
							<div style="width: 15px; height: 15px; background-color: red; border-radius: 50%; margin-right: 5px;">
							</div>
							<div style="width: 15px; height: 15px; background-color: green; border-radius: 50%;"></div>
						</div>
					</div>
				</div>

				<div id="card" class="col-mb-4 real-time-row" style="width: 100%;">
					<div class="panel-body card" style="width: 100%; display: flex; align-items: center;">
						<button class="card-btn"
							style="border-radius: 40%; padding: 10px 20px; border: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);"></button>
						<h5 style="padding-left: 10px;">1920:1080</h5>
						<label for="status" style="margin-left: 15px;">Status:</label>

						<!-- Red and Green Circles -->
						<div style="display: flex; align-items: center; padding-left: 10px;">
							<div style="width: 15px; height: 15px; background-color: red; border-radius: 50%; margin-right: 5px;">
							</div>
							<div style="width: 15px; height: 15px; background-color: green; border-radius: 50%;"></div>
						</div>
					</div>
				</div>

				<div id="card" class="col-mb-4 real-time-row" style="width: 100%;">
					<div class="panel-body card" style="width: 100%; display: flex; align-items: center;">
						<button class="card-btn"
							style="border-radius: 40%; padding: 10px 20px; border: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);"></button>
						<h5 style="padding-left: 10px;">854:480</h5>
						<label for="status" style="margin-left: 15px;">Status:</label>

						<!-- Red and Green Circles -->
						<div style="display: flex; align-items: center; padding-left: 10px;">
							<div style="width: 15px; height: 15px; background-color: red; border-radius: 50%; margin-right: 5px;">
							</div>
							<div style="width: 15px; height: 15px; background-color: green; border-radius: 50%;"></div>
						</div>
					</div>
				</div>

				<div id="card" class="col-mb-4 real-time-row" style="width: 100%;">
					<div class="panel-body card" style="width: 100%; display: flex; align-items: center;">
						<button class="card-btn"
							style="border-radius: 40%; padding: 10px 20px; border: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);"></button>
						<h5 style="padding-left: 10px;">640:360</h5>
						<label for="status" style="margin-left: 15px;">Status:</label>

						<!-- Red and Green Circles -->
						<div style="display: flex; align-items: center; padding-left: 10px;">
							<div style="width: 15px; height: 15px; background-color: red; border-radius: 50%; margin-right: 5px;">
							</div>
							<div style="width: 15px; height: 15px; background-color: green; border-radius: 50%;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /END OF DISPLAY RESOLUTION -->

	</div>
</section>