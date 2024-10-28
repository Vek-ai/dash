<div class="panel">
    <div class="panel-body">
        <div id="responseMessage" style="margin-top: 15px;"></div>
        <form id="airportForm">
            <label for="airport_name">Airport name</label>
            <input type="text" placeholder="Enter airport name" id="airport_name" name="airport_name"
                class="form-control" required>
            <button type="submit" class="btn btn-info pull-right" style="margin-top: 10px;">Add</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handle form submission
        $('#airportForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the form from refreshing the page

            var formData = { airport_name: $('#airport_name').val() };
            
            create('POST', 'php/crud/airports/add_airport.php', formData, '#airportForm');
        });
    });
</script>