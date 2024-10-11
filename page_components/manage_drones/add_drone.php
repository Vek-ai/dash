<section class="panel">
    <div class="panel-body">
			<div id="responseMessage" style="margin-top: 15px;"></div>
        <form id="droneForm">
            <label for="drone_name">Drone name</label>
            <input type="text" placeholder="Enter drone name" id="drone_name" name="drone_name" class="form-control" required>
            <button type="submit" class="btn btn-info pull-right" style="margin-top: 10px;">Add</button>
        </form>
    </div>
</section>

<script>
$(document).ready(function () {
    // Handle form submission
    $('#droneForm').on('submit', function (event) {
        event.preventDefault(); // Prevent the form from refreshing the page

        // Get the form data
        var droneName = $('#drone_name').val();

        $.ajax({
            type: 'POST',
            url: 'php/crud/drones/add_drone.php', // Server-side script URL
            data: { drone_name: droneName }, // Use the correct POST key 'drone_name'
            success: function (response) {
                // Parse the JSON response
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.status === 'error') {                
                    $('#responseMessage').html('<div class="alert alert-warning">' + jsonResponse.message + '</div>');
                } else {
                    // Display the success message
                    $('#responseMessage').html('<div class="alert alert-success">' + jsonResponse.message + '</div>');
                    $('#droneForm')[0].reset(); // Reset the form after success
                }
            },
            error: function () {
                $('#responseMessage').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
            }
        });
    });
});
</script>

