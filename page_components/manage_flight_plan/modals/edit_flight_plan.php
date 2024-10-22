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
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  // Edit Flight Plan - Open Modal and Populate Data
  $(document).on('click', '.editBtn', function () {
    // Get the Flight Plan data from the clicked row (You can adjust this according to your table structure)
    var flightPlanId = $(this).data('id');
    var flightPlanName = $(this).closest('tr').find('td:eq(0)').text();
    var flightPlanStatus = $(this).closest('tr').find('td:eq(1)').text();

    // Populate the modal with the existing flight plan data
    $('#flightPlanId').val(flightPlanId);
    $('#flightPlanName').val(flightPlanName);
    $('#flightPlanStatus').val(flightPlanStatus);

    // Open the modal
    $('#editFlightPlanModal').modal('show');
  });

  // Handle form submission for editing the flight plan
  $('#editFlightPlanForm').submit(function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Get form data
    var formData = {
      flight_plan_id: $('#flightPlanId').val(),
      flight_plan_name: $('#flightPlanName').val()
    };

    $.ajax({
      type: 'POST',
      url: 'php/crud/flight_plans/edit_flight_plan.php',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          // Update the flightPlan data in the table without refreshing
          var flightPlanRow = $('button[data-id="' + formData.flightPlan_id + '"]').closest('tr');
          flightPlanRow.find('td:eq(0)').text(formData.flightPlan_name);

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