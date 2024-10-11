<style>
	.btn-drone-cards {
		padding-left: 20px;
		width: 300px;
		height: 150px;
		border-radius: 10px;
		font-size: 16px;
		background-color: #f0f0f0;
		border: none;
		cursor: pointer;
		transition: transform 0.3s ease, background-color 0.3s ease;
	}

	.btn-drone-cards:hover {
		background-color: #e0e0e0;
		transform: scale(1.05);
        font-weight: bold;
		background-color: #e0e0e0;
		color: #3276B1;
		/* Slight hover effect */
	}
</style>

<div>
	<div style="display: flex; align-items: center;">
		<h1>Drones</h1>
		<button class="btn-primary" id="myBtn" style="margin-left: 50px; padding: 10px 20px; border: none; border-radius: 10px;" href="manage_drones.php">Add Drone</button>
	</div>

	<div id="droneResult" style="padding-top: 10px;">
		<!-- DRONES AJAX GET RESULTS WILL DISPLAY HERE -->
	</div>
</div>

<script>
	// For Modal
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

// DRONES GET AJAX
$(document).ready(function () {
    // Fetch drones and populate the table
    $.ajax({
        type: 'GET',
        url: 'php/crud/drones/get_drones.php', // The PHP file that fetches all drones
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                var droneResult = $('#droneResult'); // The container for the buttons
                var drones = response.data;

                // Clear any existing buttons
                droneResult.empty();

                // Loop through each drone and append buttons to the div
                drones.forEach(function (drone) {
                    var button = `
                        <button class="btn-drone-cards" style="margin-left: 10px;" id="drone-${drone.id}">
                            <p class="pull-left">${drone.name}</p>
                        </button>
                    `;

                    // Append each button to the droneResult div
                    droneResult.append(button);

                    // Add click event to the button
                    $(`#drone-${drone.id}`).on('click', function() {
                        // Redirect to drone_surveillance.php with the drone ID
                        window.location.href = `drone_surveillance.php?id=${drone.id}`;
                    });
                });

                // Initialize footable if needed after appending rows (if you're using a table)
                $('#footable-res2').footable();
            } else {
                alert('Failed to load drones.');
            }
        },
        error: function () {
            alert('Error fetching drones.');
        }
    });
});

</script>