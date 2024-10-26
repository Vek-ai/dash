<style>
    .btn-flight_plan-cards {
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

    .btn-flight_plan-cards:hover {
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
        <h1>Flight Plan</h1>
        <button class="btn-primary" id="myBtn"
            style="margin-left: 50px; padding: 10px 20px; border: none; border-radius: 10px;">Add Flight Plan</button>
    </div>

    <div id="flightPlanResult" style="padding-top: 10px;">
        <!-- AIRPORTS AJAX GET RESULTS WILL DISPLAY HERE -->
    </div>
</div>

<div id="myModal" class="modal">
    <?php include 'page_components\manage_airports\add_airport.php'; ?>
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
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    $(document).ready(function () {
        // Fetch flight plans and populate buttons
        $.ajax({
            type: 'GET',
            url: 'php/crud/flight_plans/get_flight_plans.php', // Fetch all flight plans
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var flightPlanResult = $('#flightPlanResult'); // The container for the buttons
                    var flight_plans = response.data;

                    // Clear any existing buttons
                    flightPlanResult.empty();

                    // Loop through each flight_plan and append buttons to the div
                    flight_plans.forEach(function (flight_plan) {
                        var button = `
                    <button class="btn-flight_plan-cards reload-map-btn" style="margin-left: 10px;" id="flight_plan-${flight_plan.id}">
                        <p class="pull-left">${flight_plan.plan_name}</p>
                    </button>
                `;

                        // Append each button to the flightPlanResult div
                        flightPlanResult.append(button);

                        // Attach a click event listener to fetch markers and reload the map
                        $(`#flight_plan-${flight_plan.id}`).on('click', function () {
                            fetchMarkers(flight_plan.id);
                            reloadMap(flight_plan.id); // Reload map based on selected flight plan
                        });
                    });

                    // Initialize footable if needed after appending rows (if you're using a table)
                    $('#footable-res2').footable();
                } else {
                    alert('Failed to load flight plans.');
                }
            },
            error: function () {
                alert('Error fetching flight plans.');
            }
        });

        // Function to fetch markers based on selected flight plan
        function fetchMarkers(flight_plan_id) {
            $.ajax({
                type: 'GET',
                url: 'php/crud/flight_plans/get_flight_plan_markers.php', // The PHP file that fetches flight plan markers
                data: { id: flight_plan_id }, // Send the flight_plan_id
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        var markers = response.data;

                        // Example: Display marker details in a div
                        var markerDetails = $('#markerDetails'); // Assuming you have a div with this ID to display marker data
                        markerDetails.empty(); // Clear previous marker data

                        markers.forEach(function (marker) {
                            markerDetails.append(`
                        <div>
                            <p>Latitude: ${marker.latitude}</p>
                            <p>Longitude: ${marker.longitude}</p>
                        </div>
                    `);
                        });
                    } else {
                        alert('No markers found for this flight plan.');
                    }
                },
                error: function () {
                    alert('Error fetching flight plan markers.');
                }
            });
        }

        // Function to reload the map.php dynamically with marker data
        function reloadMap(flight_plan_id) {
            // First, fetch markers for the selected flight plan
            $.ajax({
                type: 'GET',
                url: 'php/crud/flight_plans/get_flight_plan_markers.php', // Fetch markers for the selected flight plan
                data: { id: flight_plan_id }, // Send the flight_plan_id
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        var markers = response.data;
                        // Now send the markers data to map.php
                        $.ajax({
                            url: 'page_components/dashboard/map.php', // Path to your map.php
                            type: 'POST', // Use POST to send more complex data (like marker arrays)
                            data: { markers: markers }, // Send the markers array to map.php
                            success: function (response) {
                                // Update the map container with the response from map.php
                                $('#Gmap').html(response); // Replace the map container's content with the new map
                            },
                            error: function () {
                                alert('Failed to reload the map.');
                            }
                        });
                    } else {
                        alert('No markers found for this flight plan.');
                    }
                },
                error: function () {
                    alert('Error fetching flight plan markers.');
                }
            });
        }




        // Function to refresh the map.php
        // function refreshMap(flight_plan_id) {
        //     $.ajax({
        //         url: 'page_components/dashboard/map.php', // Path to your map.php
        //         type: 'GET',
        //         data: { flight_id: flight_plan_id }, // Send the flight ID to map.php
        //         success: function (response) {
        //             // Update the map container with the response from map.php
        //             $('.col-md-12').html(response); // Replace the map container's content with the new map
        //         },
        //         error: function () {
        //             alert('Failed to reload the map.');
        //         }
        //     });
    });

</script>