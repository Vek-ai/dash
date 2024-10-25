<!-- Modal for displaying flight plan markers -->
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="flightPlanMarkersModalLabel">Edit Flight Plan Markers</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="markersEditResponseMessage" style="margin-top: 15px;">
        <!-- Ajax Response will show here -->
      </div>
      <form id="flightPlanMarkersForm">
        <div id="flightPlansContainer"
          style="max-height: 300px; overflow-y: auto; overflow-x: hidden; border: 1px solid #ddd; padding: 10px;">
          <div id="editFlightPlanMarkers">
            <!-- Populated dynamically with markers -->
          </div>
        </div>
        <div style="margin-top: 15px;">
          <button type="submit" class="btn btn-primary">Submit Flight Plans</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.editFlightPlanMarkersModalBtn', function (e) {
    e.preventDefault();

    var markersData = $(this).data('markers'); // Get markers data
    var flightPlanId = $(this).data('id'); // Get flight plan id

    // Set flightPlanId in the hidden input field
    $('#flightPlanId').val(flightPlanId);

    // Parse markers data if it's a string
    if (typeof markersData === 'string') {
      try {
        markersData = JSON.parse(markersData);
      } catch (error) {
        console.error('Error parsing markers data:', error);
        return;
      }
    }

    // Check if markersData is an array
    if (Array.isArray(markersData)) {
      $('#editFlightPlanMarkers').empty(); // Clear existing markers in the modal

      // Populate modal with markers
      markersData.forEach(function (marker, index) {
        const flightPlanTemplate = createMarkerTemplate(index + 1, marker.latitude, marker.longitude);
        $('#editFlightPlanMarkers').append(flightPlanTemplate);
      });

      $('#editFlightPlanMarkersModal').modal('show'); // Show modal after populating
    } else {
      console.error('Invalid markers data format:', markersData);
    }
  });

  // Function to create the marker template
  function createMarkerTemplate(markerIndex, latitude = '', longitude = '') {
    return `
      <div class="row flightPlanMarkers">
        <div class="col-md-12">
          <h5 class="marker-label">Marker ${markerIndex}</h5>
        </div>
        <div class="col-md-4">
          <label for="latitude">Latitude</label>
          <input type="number" value="${latitude}" name="latitude[]" class="form-control latitude" step="any" required>
        </div>
        <div class="col-md-4">
          <label for="longitude">Longitude</label>
          <input type="number" value="${longitude}" name="longitude[]" class="form-control longitude" step="any" required>
        </div>
        <div class="col-md-4" style="margin-top: 23px">
          <button type="button" class="btn btn-info add-flight-plan-markers">Add Marker</button>
          <button type="button" class="btn btn-danger remove-flight-plan-marker">Remove Marker</button>
        </div>
      </div>`;
  }

  // Function to add a new marker
  function addFlightPlanMarker() {
    const newMarkerIndex = document.querySelectorAll('.flightPlanMarkers').length + 1;
    const newMarkerTemplate = createMarkerTemplate(newMarkerIndex);
    $('#editFlightPlanMarkers').append(newMarkerTemplate);
  }

  // Update marker labels
  function updateMarkerLabels() {
    const markers = document.querySelectorAll('.flightPlanMarkers');
    markers.forEach((marker, index) => {
      const label = marker.querySelector('.marker-label');
      if (label) {
        label.textContent = `Marker ${index + 1}`;
      }
    });
  }

  // Event listener for adding/removing markers
  document.getElementById('editFlightPlanMarkersModal').addEventListener('click', function (event) {
    if (event.target.classList.contains('add-flight-plan-markers')) {
      addFlightPlanMarker();
    } else if (event.target.classList.contains('remove-flight-plan-marker')) {
      const flightPlanMarkers = event.target.closest('.flightPlanMarkers');
      if (document.querySelectorAll('.flightPlanMarkers').length > 1) {
        flightPlanMarkers.remove();
        updateMarkerLabels();
      }
    }
  });

  // Form submission event listener
  $('#flightPlanMarkersForm').on('submit', function (event) {
    event.preventDefault();

    // Collect flightPlanId and marker data
    const flightPlanId = $('#flightPlanId').val();
    const markersData = [];
    $('#editFlightPlanMarkers .flightPlanMarkers').each(function () {
      const latitude = $(this).find('input[name="latitude[]"]').val();
      const longitude = $(this).find('input[name="longitude[]"]').val();
      markersData.push({ latitude, longitude });
    });

    // Send marker data with flightPlanId via AJAX
    $.ajax({
      url: 'php/crud/flight_plans/edit_flight_plan_markers.php',
      type: 'POST',
      data: {
        flightPlanId: flightPlanId,
        markers: JSON.stringify(markersData)
      },
      success: function (response) {
        // Display appropriate message based on response
        if (response.status === 'success') {
          // Display the success message
          $('#markersEditResponseMessage').html('<div class="alert alert-success">' + response.message + '</div>');

          // Close the modal after 3 seconds
          setTimeout(function () {
            $('#editFlightPlanModal').modal('hide');
          }, 3000);
        } else {
          // Display the error message if something went wrong
          $('#markersEditResponseMessage').html('<div class="alert alert-warning">' + response.message + '</div>');
        }
      },
      error: function (xhr, status, error) {
        console.error('Error updating markers:', error);
        $('#markersEditResponseMessage').html(
          '<div class="alert alert-danger">An error occurred while updating markers.</div>'
        );
      }
    });
  });
</script>