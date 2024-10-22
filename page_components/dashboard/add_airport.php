<!-- Modal content -->
<div class="panel modal-content">
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

<style>
    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1000;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Solid black background */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>