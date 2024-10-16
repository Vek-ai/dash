
		<div class="nest" id="GmapClose">
			<div class="title-alt">
				<h6>
					Airports</h6>
				<div class="titleClose">
					<a class="gone" href="#GmapClose">
						<span class="entypo-cancel"></span>
					</a>
				</div>
			</div>

			<div style="padding:0;" class="body-nest" id="Gmap">



				<div id="test1" class="gmap" style="width:100%;height:500px;position:relative;"></div>



			</div>
		</div>

<script type="text/javascript">
    $(function() {

        $("#test1").gmap3({
            marker: {
                latLng: [52.500556, 13.398889],
                options: {
                    draggable: true
                },
                events: {
                    dragend: function(marker) {
                        $(this).gmap3({
                            getaddress: {
                                latLng: marker.getPosition(),
                                callback: function(results) {
                                    var map = $(this).gmap3("get"),
                                        infowindow = $(this).gmap3({
                                            get: "infowindow"
                                        }),
                                        content = results && results[1] ? results && results[1].formatted_address : "no address";
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
            },
            map: {
                options: {
                    zoom: 13
                }
            }
        });

    });
    </script>