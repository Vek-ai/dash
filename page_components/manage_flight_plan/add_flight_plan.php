<section class="panel">
    <div class="panel-body">
        <div id="responseMessage" style="margin-top: 15px;"></div>
        <form id="droneForm">
            <h3>Add Flight Plan</h3>
            <div id="flightPlansContainer" style="max-height: 300px; overflow-y: auto; overflow-x: hidden; border: 1px solid #ddd; padding: 10px;">
                <div id="flightPlans">
                    <div class="row flightPlan">
                        <div class="col-md-6">
                            <label for="flight_plan">Flight Plan Name</label>
                            <input type="text" placeholder="Enter Flight Plan Name" name="flight_plan" class="form-control flight-plan-name" style="width: 100%;" required>
                        </div>
                        <div class="col-md-12">
                            <h5 class="marker-label">Marker 1</h5>
                        </div>
                        <div class="col-md-4">
                            <label for="latitude">Latitude</label>
                            <input type="number" placeholder="Enter Latitude" name="latitude[]" class="form-control latitude" style="width: 100%;" step="any" required>
                        </div>
                        <div class="col-md-4">
                            <label for="longitude">Longitude</label>
                            <input type="number" placeholder="Enter Longitude" name="longitude[]" class="form-control longitude" style="width: 100%;" step="any" required>
                        </div>
                        <div class="col-md-4" style="margin-top: 23px">
                            <button type="button" class="btn btn-info add-flight-plan">Add Marker</button>
                            <button type="button" class="btn btn-danger remove-flight-plan" style="margin-left: 10px;">Remove Marker</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <button type="submit" class="btn btn-primary">Submit Flight Plans</button>
            </div>
        </form>
    </div>
</section>

<script>
    let markerCounter = 1; // Initialize marker counter

    // Function to add a new marker row
    function addFlightPlan() {
        markerCounter++; // Increment the marker counter
        const flightPlanTemplate = `
            <div class="row flightPlan" style="margin-top: 10px;">
                <div class="col-md-12">
                    <h5 class="marker-label">Marker ${markerCounter}</h5>
                </div>
                <div class="col-md-4">
                    <label for="latitude">Latitude</label>
                    <input type="number" placeholder="Enter Latitude" name="latitude[]" class="form-control latitude" style="width: 100%;" step="any" required>
                </div>
                <div class="col-md-4">
                    <label for="longitude">Longitude</label>
                    <input type="number" placeholder="Enter Longitude" name="longitude[]" class="form-control longitude" style="width: 100%;" step="any" required>
                </div>
                <div class="col-md-4" style="margin-top: 23px">
                    <button type="button" class="btn btn-info add-flight-plan">Add Marker</button>
                    <button type="button" class="btn btn-danger remove-flight-plan" style="margin-left: 10px;">Remove Marker</button>
                </div>
            </div>`;
        
        document.getElementById('flightPlans').insertAdjacentHTML('beforeend', flightPlanTemplate);
    }

    // Event listener for adding or removing markers
    document.getElementById('flightPlans').addEventListener('click', function(event) {
        if (event.target.classList.contains('add-flight-plan')) {
            addFlightPlan();
        } else if (event.target.classList.contains('remove-flight-plan')) {
            const flightPlan = event.target.closest('.flightPlan');
            if (document.querySelectorAll('.flightPlan').length > 1) {
                flightPlan.remove();
                markerCounter--; // Decrease marker counter if removed
                // Update marker labels
                const markers = document.querySelectorAll('.marker-label');
                markers.forEach((label, index) => {
                    label.textContent = `Marker ${index + 1}`;
                });
            }
        }
    });

    // Handle form submission
    $('#droneForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from refreshing the page

        let flightPlans = [];

        // Loop through each flight plan section and collect data
        $('#flightPlans').each(function () {
            let flightPlanName = $(this).find('.flight-plan-name').val(); // Get flight plan name
            let markers = [];

            // For each marker under the current flight plan
            $(this).find('.flightPlan').each(function () {
                let latitude = $(this).find('.latitude').val();
                let longitude = $(this).find('.longitude').val();
                
                markers.push({
                    latitude: latitude,
                    longitude: longitude
                });
            });

            flightPlans.push({
                flight_plan: flightPlanName,
                markers: markers // Add markers under each flight plan
            });
        });

        // Convert flight plans to JSON string
        let flightPlansJSON = JSON.stringify(flightPlans);

        // Submit the data via AJAX
        $.ajax({
            type: 'POST',
            url: 'php/crud/flight_plans/add_flight_plan.php', // Server-side script URL
            data: {
                flight_plans: flightPlansJSON // Send flight plans as JSON
            },
            success: function(response) {
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.status === 'error') {
                    $('#responseMessage').html('<div class="alert alert-warning">' + jsonResponse.message + '</div>');
                } else {
                    $('#responseMessage').html('<div class="alert alert-success">' + jsonResponse.message + '</div>');
                    $('#droneForm')[0].reset(); // Reset the form after success
                    markerCounter = 1; // Reset marker counter
                }
            },
            error: function() {
                $('#responseMessage').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
            }
        });
    });
</script>
