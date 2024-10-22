<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editDroneLabel">Edit Drone</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="editResponseMessage" style="margin-top: 15px;">
        <!-- Ajax Response will show here -->
      </div>

      <form id="editDroneForm">
        <input type="hidden" id="droneId" name="droneId" />
        <div class="form-group">
          <label for="droneName">Drone Name</label>
          <input type="text" class="form-control" id="droneName" name="droneName" required>
        </div>
        <div class="form-group">
          <label for="droneStatus">Status</label>
          <select class="form-control" id="droneStatus" name="droneStatus" required>
            <option value="Active">Active</option>
            <option value="Disabled">Disabled</option>
            <option value="Suspended">Suspended</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  // Edit Drone - Open Modal and Populate Data
  $(document).on('click', '.editBtn', function () {
    // Get the drone data from the clicked row (You can adjust this according to your table structure)
    var droneId = $(this).data('id');
    var droneName = $(this).closest('tr').find('td:eq(0)').text();
    var droneStatus = $(this).closest('tr').find('td:eq(1)').text();

    // Populate the modal with the existing drone data
    $('#droneId').val(droneId);
    $('#droneName').val(droneName);
    $('#droneStatus').val(droneStatus);

    // Open the modal
    $('#editDroneModal').modal('show');
  });

  // Handle form submission for editing the drone
  $('#editDroneForm').submit(function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Get form data
    var formData = {
      drone_id: $('#droneId').val(),
      drone_name: $('#droneName').val(),
      drone_status: $('#droneStatus').val()
    };

    $.ajax({
      type: 'POST',
      url: 'php/crud/drones/edit_drone.php',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          // Update the drone data in the table without refreshing
          var droneRow = $('button[data-id="' + formData.drone_id + '"]').closest('tr');
          droneRow.find('td:eq(0)').text(formData.drone_name);
          droneRow.find('td:eq(1)').html('<span class="bg-' + getStatusClass(formData.drone_status) + '">' + formData.drone_status + '</span>');

          // Display the success message
          $('#editResponseMessage').html('<div class="alert alert-success">' + response.message + '</div>');

          // Close the modal after 3 seconds
          setTimeout(function () {
            $('#editDroneModal').modal('hide');
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

  // Helper function to get the status class based on status text
  function getStatusClass(status) {
    switch (status) {
      case 'Active':
        return 'green';
      case 'Disabled':
        return 'red';
      case 'Suspended':
        return 'gray';
      default:
        return '';
    }
  }
});
</script>