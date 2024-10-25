<script>
      // Function to fetch flight plan markers and display them in the modal
      function fetchFlightPlanMarkers(flightPlanId) {
        $.ajax({
            type: 'GET',
            url: 'php/crud/flight_plans/get_flight_plan_markers.php', // PHP file to fetch flight plan markers
            data: { id: flightPlanId },
            dataType: 'json',
            success: function (response) {
              
                var flightPlansMarkerData = response;
                displayMarkers(flightPlansMarkerData, flightPlanId);
                return displayMarkers;
            },
            error: function () {
                alert('Error fetching flight plan markers.');
            }
        });
    }
</script>