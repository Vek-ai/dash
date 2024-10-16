<?php
// Check if markers data is received via POST
if (isset($_POST['markers'])) {
    $markers = $_POST['markers']; // Get the markers array from the POST request
} else {
    $markers = []; // Set an empty array if no markers are received
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

        // Get markers data from PHP
        var markers = <?php echo json_encode($markers); ?>; // Convert PHP markers array to JavaScript

        // If markers are available, set the default center to the first marker's coordinates
        if (Array.isArray(markers) && markers.length > 0) {
            defaultCenter = [markers[0].latitude, markers[0].longitude];
            console.log(markers);
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

        // Call the function to add markers to the map and draw the connecting line if markers are available
        if (Array.isArray(markers) && markers.length > 0) {
            addMarkersToMap(markers);
        } else {
            console.log("No valid markers to display.");
        }
    });
</script>
