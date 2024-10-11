<style>
	.btn-card {
		padding-left: 10px;
		width: 200px;
		height: 70px;
		border-radius: 10px;
		font-size: 16px;
		background-color: #f0f0f0;
		border: none;
		cursor: pointer;
	}

	.btn-card:hover {
		font-weight: bold;
		background-color: #e0e0e0;
		color: #3276B1;
	}

	.btn-card.active {
		font-weight: bold;
		color: #3276B1;
	}
</style>

<div>
	<button class="btn-card" id="airportMarkers">
		<p class="pull-left">Airports</p>
	</button>
	<button class="btn-card" id="droneMarkers" style="margin-left: 10px;">
		<p class="pull-left">Drones</p>
	</button>
	<button class="btn-card" id="flightPlanMarkers" style="margin-left: 10px;">
		<p class="pull-left">Flight Plan</p>
	</button>

	<div class="pull-right titleToggle">
		<a class="nav-toggle-alt" href="#Gmap">
			<span class="entypo-up-open"></span>
		</a>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		// Get references to buttons and components
		const airportMarkersBtn = document.getElementById('airportMarkers');
		const droneMarkersBtn = document.getElementById('droneMarkers');
		const flightPlanMarkersBtn = document.getElementById('flightPlanMarkers');

		const airportContent = document.getElementById('airportContent');
		const droneContent = document.getElementById('droneContent');
		const flightPlanContent = document.getElementById('flightPlanContent');

		// Function to hide all components
		function hideAllComponents() {
			airportContent.style.display = 'none';
			droneContent.style.display = 'none';
		}

		// Function to remove active class from all buttons
		function removeActiveClass() {
			airportMarkersBtn.classList.remove('active');
			droneMarkersBtn.classList.remove('active');
			flightPlanMarkersBtn.classList.remove('active');
		}

		// Show only airport content and add active class
		airportMarkersBtn.addEventListener('click', function () {
			hideAllComponents();
			airportContent.style.display = 'block';
			removeActiveClass();
			airportMarkersBtn.classList.add('active');  // Add active class to clicked button
		});

		// Show only drone content and add active class
		droneMarkersBtn.addEventListener('click', function () {
			hideAllComponents();
			droneContent.style.display = 'block';
			removeActiveClass();
			droneMarkersBtn.classList.add('active');  // Add active class to clicked button
		});

		// Show only drone content and add active class
		flightPlanMarkersBtn.addEventListener('click', function () {
			hideAllComponents();
			flightPlanContent.style.display = 'block';
			removeActiveClass();
			flightPlanMarkersBtn.classList.add('active');  // Add active class to clicked button
		});
		// Initial setup: Show airport content and set the airport markers button active
		hideAllComponents();
		airportContent.style.display = 'block';
		airportMarkersBtn.classList.add('active'); // Set the default active button
	});

</script>