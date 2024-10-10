<style>
	.btn-airport-cards {
		padding-left: 20px;
		width: 300px;
		height: 150px;
		border-radius: 10px;
		font-size: 16px;
		background-color: #f0f0f0;
		border: none;
		cursor: pointer;
		transition: transform 0.3s ease, background-color 0.3s ease;
	}

	.btn-airport-cards:hover {
		background-color: #e0e0e0;
		transform: scale(1.05);
        font-weight: bold;
		background-color: #e0e0e0;
		color: #3276B1;
		/* Slight hover effect */
	}
</style>

<div>
	<div style="display: flex; align-items: center;">
		<h1>Flight Plan</h1>
		<button class="btn-primary" id="myBtn" style="margin-left: 50px; padding: 10px 20px; border: none; border-radius: 10px;">Add Flight Plan</button>
	</div>

	<div id="airportResult" style="padding-top: 10px;">
		<!-- AIRPORTS AJAX GET RESULTS WILL DISPLAY HERE -->
	</div>
</div>

<div id="myModal" class="modal">
	<?php include 'page_componenets\manage_airports\add_airport.php'; ?>
</div>

<script>
	// For Modal
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	// AIRPORTS GET AJAX
	$(document).ready(function () {
    // Fetch airports and populate the table
    $.ajax({
        type: 'GET',
        url: 'php/crud/airports/get_airports.php', // The PHP file that fetches all airports
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                var airportResult = $('#airportResult'); // The container for the buttons
                var airports = response.data;

                // Clear any existing buttons
                airportResult.empty();

                // Loop through each airport and append buttons to the div
                airports.forEach(function (airport) {
                    var button = `
                        <button class="btn-airport-cards" style="margin-left: 10px;" id="airport-${airport.id}">
                            <p class="pull-left">${airport.name}</p>
                        </button>
                    `;

                    // Append each button to the airportResult div
                    airportResult.append(button);

                    // Add any additional functionality to the buttons (e.g., dropdowns)
                    var el = document.querySelector(`#airport-${airport.id}`).parentNode;
                    var btn = el.querySelector(`#airport-${airport.id}`);
                    var menu = el.querySelector('.more-menu');
                    var visible = false;

                    function showMenu(e) {
                        e.preventDefault();
                        if (!visible) {
                            visible = true;
                            el.classList.add('show-more-menu');
                            menu.setAttribute('aria-hidden', false);
                            document.addEventListener('mousedown', hideMenu, false);
                        }
                    }

                    function hideMenu(e) {
                        if (btn.contains(e.target)) {
                            return;
                        }
                        if (visible) {
                            visible = false;
                            el.classList.remove('show-more-menu');
                            menu.setAttribute('aria-hidden', true);
                            document.removeEventListener('mousedown', hideMenu);
                        }
                    }

                    btn.addEventListener('click', showMenu, false);
                });

                // Initialize footable if needed after appending rows (if you're using a table)
                $('#footable-res2').footable();
            } else {
                alert('Failed to load airports.');
            }
        },
        error: function () {
            alert('Error fetching airports.');
        }
    });
});

</script>