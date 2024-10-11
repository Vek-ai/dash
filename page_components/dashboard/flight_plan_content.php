<style>
	.btn-flightPlan-cards {
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

	.btn-flightPlan-cards:hover {
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

	<div id="planResult" style="padding-top: 10px;">
		<!-- AIRPORTS AJAX GET RESULTS WILL DISPLAY HERE -->
	</div>
</div>

<div id="myModal" class="modal">
	<?php include 'page_components\manage_airports\add_airport.php'; ?>
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
    // Fetch flightPlans and populate the table
    $.ajax({
        type: 'GET',
        url: 'php/crud/flight_plans/get_flight_plans.php', // The PHP file that fetches all flightPlans
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                var planResult = $('#planResult'); // The container for the buttons
                var flightPlans = response.data;

                // Clear any existing buttons
                planResult.empty();

                // Loop through each flightPlan and append buttons to the div
                flightPlans.forEach(function (flightPlan) {
                    var button = `
                        <button class="btn-flightPlan-cards" style="margin-left: 10px;" id="flightPlan-${flightPlan.id}">
                            <p class="pull-left">${flightPlan.plan_name}</p>
                        </button>
                    `;

                    // Append each button to the planResult div
                    planResult.append(button);

                    // Add any additional functionality to the buttons (e.g., dropdowns)
                    var el = document.querySelector(`#flightPlan-${flightPlan.id}`).parentNode;
                    var btn = el.querySelector(`#flightPlan-${flightPlan.id}`);
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
                alert('Failed to load flightPlans.');
            }
        },
        error: function () {
            alert('Error fetching flightPlans.');
        }
    });
});

</script>