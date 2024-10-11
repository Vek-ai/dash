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
