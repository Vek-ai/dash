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
    </div>
  </div>
</div>

<script>
  // Function to fetch flight plan markers and display them in the modal
  function fetchFlightPlanMarkers(flightPlanId) {
    $.ajax({
      type: 'GET',
      url: 'php/crud/flight_plans/get_flight_plan_markers.php', // PHP file to fetch flight plan markers
      data: { id: flightPlanId },
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          // Create a table for displaying markers
          var tableHtml = '<table class="table table-striped">';
          tableHtml += '<thead><tr><th>Marker</th><th>Latitude</th><th>Longitude</th></tr></thead><tbody>';

          // Loop through the markers and create table rows
          $.each(response.data, function (index, marker) {
            tableHtml += '<tr>';
            tableHtml += '<td>Marker ' + (index + 1) + '</td>'; // Display the marker index (Marker 1, Marker 2, etc.)
            tableHtml += '<td>' + marker.latitude + '</td>'; // Display the latitude
            tableHtml += '<td>' + marker.longitude + '</td>'; // Display the longitude
            tableHtml += '</tr>';
          });

          tableHtml += '</tbody></table>';

          // Populate the modal with the table
          $('#flightPlanMarkersContent').html(tableHtml);

          // Show the modal
          $('#flightPlanMarkersModal').modal('show');
        } else {
          alert('No markers found for this flight plan.');
        }
      },
      error: function () {
        alert('Error fetching flight plan markers.');
      }
    });
  }

  // Event listener for clicking on a flight plan name to load the markers
  $(document).on('click', '.flight-plan-link', function (e) {
    e.preventDefault();
    var flightPlanId = $(this).data('id');
    fetchFlightPlanMarkers(flightPlanId); // Fetch and display the markers when the name is clicked
  });
</script>