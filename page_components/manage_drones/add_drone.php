<?php 
include 'php/ajax/ajax_functions_enhanced.php';
?>

<section class="panel">
    <div class="panel-body">
			<div id="responseMessage" style="margin-top: 15px;"></div>
        <form id="droneForm">
            <label for="drone_name">Drone name</label>
            <input type="text" placeholder="Enter drone name" id="drone_name" name="drone_name" class="form-control" required>
            <button type="submit" class="btn btn-info pull-right" style="margin-top: 10px;">Add</button>
        </form>
    </div>
</section>

<script>
$(document).ready(function () {
    // Handle form submission
    $('#droneForm').on('submit', function (event) {
        event.preventDefault(); // Prevent the form from refreshing the page

        var fromData = { drone_name: $('#drone_name').val() }
        
        create('POST', 'php/crud/drones/add_drone.php', fromData, '#droneForm');
    });
});
</script>

