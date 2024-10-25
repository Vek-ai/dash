<!-- Modal for displaying flight plan markers -->
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="flightPlanMarkersModalLabel">Flight Plan Markers</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="flightPlanMarkersContent">
        <!-- Dynamic content will be added here -->
      </div>

      <div>
        <button class="btn btn-primary editFlightPlanMarkersModalBtn" data-id="${flightPlanId}"
          data-markers="${JSON.stringify(flightPlansMarkerData)">Edit Markers</button>
      </div>
    </div>
  </div>

  <script>
    // Function to display markers in the modal
    function displayMarkers(flightPlansMarkerData, flightPlanId) {
      if (flightPlansMarkerData.status === 'success') {
        // Create a table for displaying markers
        var tableHtml = '<table class="table table-striped">';
        tableHtml += '<thead><tr><th>Marker</th><th>Latitude</th><th>Longitude</th></tr></thead><tbody>';
        // Loop through the markers and create table rows
        $.each(flightPlansMarkerData.data, function (index, marker) {
          tableHtml += '<tr>';
          tableHtml += '<td>Marker ' + (index + 1) + '</td>'; // Display the marker index
          tableHtml += '<td>' + marker.latitude + '</td>'; // Display the latitude
          tableHtml += '<td>' + marker.longitude + '</td>'; // Display the longitude
          tableHtml += '</tr>';
        });
        tableHtml += '</tbody></table>';

        // Populate the modal with the table
        $('#flightPlanMarkersContent').html(tableHtml);
        // Set data attributes for the edit button
        $('.editFlightPlanMarkersModalBtn').data('id', flightPlanId);
        $('.editFlightPlanMarkersModalBtn').data('markers', JSON.stringify(flightPlansMarkerData.data));

        // Show the modal
        $('#flightPlanMarkersModal').modal('show');
      } else {
        alert('No markers found for this flight plan.');
      }
    }

    // Event listener for clicking on a flight plan name to load the markers
    $(document).on('click', '.flight-plan-link', function (e) {
      e.preventDefault();
      var flightPlanId = $(this).data('id');
      fetchFlightPlanMarkers(flightPlanId); // Fetch and display the markers when the name is clicked
    });
  </script>