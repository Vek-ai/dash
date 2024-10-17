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
  function fetchFlightPlanMarkers(flightPlanId) {
    $.ajax({
      type: 'GET',
      url: 'php/crud/flight_plans/get_flight_plan_markers.php', // PHP file to fetch markers
      data: { id: flightPlanId }, // Send flight plan ID
      dataType: 'json',
      success: function (response) {
        console.log('Response:', response); // Log the response to check if the data structure is correct
        
        if (response.status === 'success') {
          var markersContent = '<table class="table table-striped table-bordered">';
          markersContent += '<thead><tr><th>Marker</th><th>Latitude</th><th>Longitude</th></tr></thead><tbody>';

          // Check the data format and loop through the markers
          if (Array.isArray(response.data)) {
            response.data.forEach(function(marker) {
              markersContent += '<tr>';
              markersContent += '<td>' + marker.name + '</td>'; // Display the marker name
              markersContent += '<td>' + marker.latitude + '</td>'; // Display the marker latitude
              markersContent += '<td>' + marker.longitude + '</td>'; // Display the marker longitude
              markersContent += '</tr>';
            });
          } else {
            markersContent += '<tr><td colspan="3">No markers found for this flight plan.</td></tr>'; // Fallback message
          }

          markersContent += '</tbody></table>';
          $('#flightPlanMarkersContent').html(markersContent); // Populate modal content
          $('#flightPlanMarkersModal').modal('show'); // Show the modal
        } else {
          alert('Failed to load markers for the selected flight plan.');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('AJAX Error:', textStatus, errorThrown); // Log AJAX errors
        alert('Error fetching flight plan markers.');
      }
    });
  }
</script>
