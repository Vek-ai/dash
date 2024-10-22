<div class="panel">
    <div class="panel-body">
        <div id="responseMessage" style="margin-top: 15px;"></div>
        <form id="airportForm">
            <label for="airport_name">Airport name</label>
            <input type="text" placeholder="Enter airport name" id="airport_name" name="airport_name"
                class="form-control" required>
            <button type="submit" class="btn btn-info pull-right" style="margin-top: 10px;">Add</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handle form submission
        $('#airportForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the form from refreshing the page

            // Get the form data
            var airportName = $('#airport_name').val();

            $.ajax({
                type: 'POST',
                url: 'php/crud/airports/add_airport.php',
                data: { airport_name: airportName },
                success: function (response) {
                    // Parse the JSON response
                    var jsonResponse = JSON.parse(response);

                    if (jsonResponse.status === 'error') {
                        $('#responseMessage').html('<div class="alert alert-warning">' + jsonResponse.message + '</div>');
                    } else {
                        // Display the success message
                        $('#responseMessage').html('<div class="alert alert-success">' + jsonResponse.message + '</div>');
                        $('#airportForm')[0].reset(); // Reset the form after success
                    }
                },
                error: function () {
                    $('#responseMessage').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                }
            });
        });
    });
</script>