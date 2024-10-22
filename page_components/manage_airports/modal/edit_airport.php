<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editAirportLabel">Edit Airport</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="editResponseMessage" style="margin-top: 15px;">
        <!-- Ajax Response will show here -->
      </div>

      <form id="editAirportForm">
        <input type="hidden" id="airportId" name="airportId" />
        <div class="form-group">
          <label for="airportName">Airport Name</label>
          <input type="text" class="form-control" id="airportName" name="airportName" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  // Edit Airport - Open Modal and Populate Data
  $(document).on('click', '.editBtn', function () {
    // Get the airport data from the clicked row (You can adjust this according to your table structure)
    var airportId = $(this).data('id');
    var airportName = $(this).closest('tr').find('td:eq(0)').text();
    var airportStatus = $(this).closest('tr').find('td:eq(1)').text();

    // Populate the modal with the existing airport data
    $('#airportId').val(airportId);
    $('#airportName').val(airportName);

    // Open the modal
    $('#editAirportModal').modal('show');
  });

  // Handle form submission for editing the airport
  $('#editAirportForm').submit(function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Get form data
    var formData = {
      airport_id: $('#airportId').val(),
      airport_name: $('#airportName').val()
    };

    $.ajax({
      type: 'POST',
      url: 'php/crud/airports/edit_airport.php',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          // Update the airport data in the table without refreshing
          var airportRow = $('button[data-id="' + formData.airport_id + '"]').closest('tr');
          airportRow.find('td:eq(0)').text(formData.airport_name);

          // Display the success message
          $('#editResponseMessage').html('<div class="alert alert-success">' + response.message + '</div>');

          // Close the modal after 3 seconds
          setTimeout(function () {
            $('#editAirportModal').modal('hide');
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