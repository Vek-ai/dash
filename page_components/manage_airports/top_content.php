<style>
	.btn-card {
		padding-left: 10px;
		width: 200px;
		height: 70px;
		border-radius: 10px;
		/* Rounds the corners */
		font-size: 16px;
		/* Adjusts the font size for better readability */
		background-color: #f0f0f0;
		/* Adds a background color */
		border: none;
		/* Adds a subtle border */
		cursor: pointer;
		/* Changes cursor on hover */
	}

	.btn-card:hover {
		background-color: #e0e0e0;
		/* Slight hover effect */
	}

</style>
<div>
	<button class="btn-card">
		<p class="pull-left">All Markers</p>
	</button>
	<button class="btn-card" style="margin-left: 10px;">
		<p class="pull-left">Airports</p>
	</button>

	<div class="pull-right titleToggle">
		<a class="nav-toggle-alt" href="#Gmap">
			<span class="entypo-up-open"></span>
		</a>
	</div>
</div>