<?php
// Check if markers data is received via POST
if (isset($_POST['markers'])) {
    $markersData = $_POST['markers']; // Get the markers array from the POST request flight_plan_markers and drone_flights

    // Check if flight_plan_markers is in the markers data
    if (isset($markersData['flight_plan_markers']) && isset($markersData['flight_plan_markers'])) {
        $markers = $markersData['flight_plan_markers']; // Get the flight_plan_markers array
        $drone_flights = $markersData['drone_flights'];
    } else {
        $markers = [];
        $drone_flights = [];
    }
} else {
    $markers = [];
    $drone_flights = [];
}
?>

<div class="nest" id="GmapClose">
    <div style="padding:0;" class="body-nest" id="Gmap">
        <div id="test1" class="gmap" style="width:100%;height:500px;position:relative;"></div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        // Default center coordinates
        var defaultCenter = [52.500556, 13.398889]; // Fallback center

        // Get markers and drone_flights data from PHP and Convert PHP markers and drone_flights array to JavaScript
        var markers = <?php echo json_encode($markers); ?>; // 
        var drone_flights = <?php echo json_encode($drone_flights); ?>;

        // If markers are available, set the default center to the first marker's coordinates
        if (Array.isArray(markers) && markers.length > 0) {
            defaultCenter = [markers[0].latitude, markers[0].longitude];
        }

        // Initialize the map with the dynamic center and zoomed-out view
        $("#test1").gmap3({
            map: {
                options: {
                    zoom: 17, 
                    center: defaultCenter // Center the map dynamically
                }
            }
        });

        // Function to add markers to the map with names
        function addMarkersToMap(markers) {
            var polylineCoordinates = []; // Array to hold marker coordinates for the polyline

            markers.forEach(function(markerData) {
                var markerPosition = [markerData.latitude, markerData.longitude];
                polylineCoordinates.push(markerPosition); // Add marker position to the polyline coordinates

                // Add marker with label (name)
                $("#test1").gmap3({
                    marker: {
                        latLng: markerPosition,
                        options: {
                            draggable: true,
                            label: {
                                text: markerData.name, // Add the name from markerData
                                color: "#000", // Set text color for the label
                                fontSize: "14px",
                                fontWeight: "bold"
                            }
                        },
                        events: {
                            dragend: function(marker) {
                                $(this).gmap3({
                                    getaddress: {
                                        latLng: (marker.getPosition()),
                                        callback: function(results) {
                                            var map = $(this).gmap3("get"),
                                                infowindow = $(this).gmap3({
                                                    get: "infowindow"
                                                }),
                                                content = results && results[1] ? results[1].formatted_address : "no address";
                                            if (infowindow) {
                                                infowindow.open(map, marker);
                                                infowindow.setContent(content);
                                            } else {
                                                $(this).gmap3({
                                                    infowindow: {
                                                        anchor: marker,
                                                        options: {
                                                            content: content
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
            });

            // Draw polyline connecting all marker positions
            if (polylineCoordinates.length > 1) {
                $("#test1").gmap3({
                    polyline: {
                        options: {
                            path: polylineCoordinates,
                            strokeColor: "#FF0000",
                            strokeOpacity: 1.0,
                            strokeWeight: 3
                        }
                    }
                });
            }
        }

        // Function to add markers to the map with names
        function addDronesToMap(drone_flights) {
            drone_flights.forEach(function(droneData){
                var dronePosition = [droneData.markers.latitude, droneData.markers.longitude];

                $('#test1').gmap3({
                    marker: {
                        latLng: dronePosition,
                        options: {
                            draggable: true,
                            icon: {
                                url: "assets/img/drone-icon.png", // Path to the icon
                                scaledSize: new google.maps.Size(30, 30) // Set size (width, height) in pixels
                            },
                            label: {
                                text: droneData.drone_name, // Add the name from droneData
                                color: "#8cbeff", // Set text color for the label
                                fontSize: "14px",
                                fontWeight: "bold"
                            }
                        }
                    }
                })
            })
        }

        // Call the function to add markers to the map and draw the connecting line if markers are available
        if (Array.isArray(markers) && markers.length > 0) {
            addMarkersToMap(markers);
            addDronesToMap(drone_flights);
        } else {
            console.log("No valid markers to display.");
        }
    });
</script>
