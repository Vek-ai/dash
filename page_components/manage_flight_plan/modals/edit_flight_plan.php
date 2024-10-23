<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editFlightPlanLabel">Edit Flight Plan</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="editResponseMessage" style="margin-top: 15px;">
        <!-- Ajax Response will show here -->
      </div>

      <form id="editFlightPlanForm">
        <input type="hidden" id="flightPlanId" name="flightPlanId" />
        <div class="form-group">
          <label for="flightPlanName">Flight Plan Name</label>
          <input type="text" class="form-control" id="flightPlanName" name="flightPlanName" required>

          <div>
            <label for="drone">Assign Drone</label>
            <select id="editdroneSelect" class="form-control drone-select" multiple="multiple" required>
              <!-- Options will be dynamically populated -->
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  // Initialize select2 with tag support for drone input
  $('#editdroneSelect').select2({
    placeholder: 'Select or Add Drone',
    tags: true, // Allow custom input
    allowClear: true, // Optional: Allow user to clear selection
    width: '100%' // Full-width dropdown
  });

  // Edit Flight Plan - Open Modal and Populate Data
  $(document).on('click', '.editBtn', function () {
    // Get the flight plan data from the clicked row
    var flightPlanId = $(this).data('id');
    var flightPlanName = $(this).closest('tr').find('td:eq(0)').text();
    var droneData = $(this).data('drone_id');

    console.log('droneData: ', droneData)
    // Populate the modal with the existing flight plan data
    $('#flightPlanId').val(flightPlanId);
    $('#flightPlanName').val(flightPlanName);

    // Fetch and populate drones dynamically when the modal is opened
    $.ajax({
      type: 'GET',
      url: 'php/crud/drones/get_drones.php', // URL to get drone options
      success: function (response) {
        const jsonResponse = JSON.parse(response);
        $('#editdroneSelect').empty(); // Clear previous options

        if (jsonResponse.status === 'success') {
          jsonResponse.data.forEach(drone => {
            const option = new Option(drone.name, drone.id, false);
            $('#editdroneSelect').append(option);
          });

          if (droneData) {
            // Ensure droneData is treated as a string
            var droneDataStr = String(droneData);

            // Check if droneData contains multiple values (comma-separated)
            if (droneDataStr.indexOf(',') !== -1) {
              // Split the string by commas to convert it into an array
              var droneArray = droneDataStr.split(',');

              if (droneArray.length > 0) {
                // Set the selected values in the select2 dropdown
                $('#editdroneSelect').val(droneArray).trigger('change');
              }
            } else {
              // If there's only one value, set it directly in the select2 dropdown
              $('#editdroneSelect').val(droneDataStr).trigger('change');
            }
          }


        } else {
          $('#editResponseMessage').html('<div class="alert alert-warning">' + jsonResponse.message + '</div>');
        }
      },
      error: function () {
        $('#editResponseMessage').html('<div class="alert alert-danger">Failed to fetch drones. Please try again.</div>');
      }
    });

    // Open the modal
    $('#editFlightPlanModal').modal('show');
  });

  // Handle form submission for editing the flight plan
  $('#editFlightPlanForm').submit(function (e) {
    e.preventDefault();

    var selectedDroneIds = $('#editdroneSelect').val();
    
    // Map the selected drone IDs to their corresponding names
    var selectedDroneNames = selectedDroneIds.map(function (droneId) {
      return $('#editdroneSelect option[value="' + droneId + '"]').text(); // Get the drone name
    }).join(', '); // Join names with commas

    // Get form data
    var formData = {
      flight_plan_id: $('#flightPlanId').val(),
      flight_plan_name: $('#flightPlanName').val(),
      droneData: selectedDroneIds,
    };

    console.log('droneData= ', selectedDroneNames);
    $.ajax({
      type: 'POST',
      url: 'php/crud/flight_plans/edit_flight_plan.php',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          // Update the flight plan data in the table without refreshing
          var flightPlanRow = $('button[data-id="' + formData.flight_plan_id + '"]').closest('tr');
          
          flightPlanRow.find('td:eq(1)').text(selectedDroneNames);

          // Display the success message
          $('#editResponseMessage').html('<div class="alert alert-success">' + response.message + '</div>');

          // Close the modal after 3 seconds
          setTimeout(function () {
            $('#editFlightPlanModal').modal('hide');
          }, 3000);

        } else {
          // Display the error message if something went wrong
          $('#editResponseMessage').html('<div class="alert alert-warning">' + response.message + '</div>');
        }
      },
      error: function (xhr, status, error) {
        // Handle any errors from the AJAX request
        $('#editResponseMessage').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
      }
    });
  });
});
</script>