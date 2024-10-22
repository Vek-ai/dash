<section class="panel">
    <div class="panel-body">
        <div class="nest" id="FilteringClose">
            <div class="title-alt">
                <h6>Airports List</h6>
                <div class="titleClose">
                    <a class="gone" href="#FilteringClose">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
                <div class="titleToggle">
                    <a class="nav-toggle-alt" href="#Filtering">
                        <span class="entypo-up-open"></span>
                    </a>
                </div>
            </div>

            <div class="body-nest" id="Filtering">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-sm-4">
                        <input class="form-control" id="filter" placeholder="Search..." type="text">
                    </div>
                    <div class="col-sm-2">
                        <select class="filter-status form-control">
                            <option value="active">Active</option>
                            <option value="disabled">Disabled</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <a href="#clear" style="margin-left:10px;" class="pull-right btn btn-info clear-filter"
                            title="clear filter">clear</a>
                        <a href="#api" class="pull-right btn btn-info filter-api"
                            title="Filter using the Filter API">filter API</a>
                    </div>
                </div>

                <table id="footable-res2" class="demo tablet breakpoint no-paging footable-loaded footable"
                    data-filter="#filter" data-filter-text-only="true">
                    <thead>
                        <tr>
                            <th data-toggle="true">Name</th>
                            <th data-toggle="true">Action</th>
                        </tr>
                    </thead>
                    <tbody id="airportTableBody">
                        <!-- Airport rows will be inserted here -->
                    </tbody>
                </table>

            </div>
        </div>

        <!-- Edit Airport Modal -->
        <div id="editAirportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editAirportLabel"
            aria-hidden="true">
            <?php include 'modal/edit_airport.php'; ?>
        </div>

        <!-- Delete Airport Modal -->
        <div id="deleteAirportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteAirportLabel"
            aria-hidden="true">
            <?php include 'modal/delete_airport.php'; ?>
        </div>

    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        var airportIdToDelete; // Variable to store the ID of the airport to be deleted

        // Fetch airports and populate the table
        $.ajax({
            type: 'GET',
            url: 'php/crud/airports/get_airports.php',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var airportsData = response.data;
                    var airportTableBody = $('#airportTableBody');

                    airportTableBody.empty();

                    airportsData.forEach(function (airport) {
                        var actionButton = `
                        <button class="btn btn-primary editBtn" data-id="${airport.id}" data-name="${airport.name}">Edit</button>
                        <button class="btn btn-danger deleteBtn" data-id="${airport.id}">Delete</button>
                    `;

                        airportTableBody.append(`
                        <tr>
                            <td>${airport.name}</td>
                            <td>${actionButton}</td>
                        </tr>
                    `);
                    });

                    // Attach click event for edit buttons
                    $('.editBtn').click(function () {
                        var airportId = $(this).data('id');
                        var airportName = $(this).data('name');

                        $('#airportId').val(airportId);
                        $('#airportName').val(airportName);

                        $('#editAirportModal').modal('show');
                    });

                    // Attach click event for delete buttons
                    $('.deleteBtn').click(function () {
                        airportIdToDelete = $(this).data('id'); // Store the ID of the airport to delete
                        $('#deleteResponseMessage').empty(); // Clear previous messages
                        $('#deleteAirportModal').modal('show'); // Show the delete confirmation modal
                    });
                } else {
                    $('#deleteResponseMessage').html('<div class="alert alert-warning">Failed to load airports.</div>');
                    $('#deleteAirportModal').modal('show');
                }
            },
            error: function () {
                $('#deleteResponseMessage').html('<div class="alert alert-danger">Error fetching airports.</div>');
                $('#deleteAirportModal').modal('show');
            }
        });

        // Attach click event for the confirm delete button in the modal
        $('#confirmDeleteBtn').click(function () {
            if (airportIdToDelete) { // Check if there's an airport to delete
                $.ajax({
                    type: 'POST',
                    url: 'php/crud/airports/delete_airport.php',
                    data: { id: airportIdToDelete },
                    dataType: 'json',
                    success: function (response) {
                        $('#deleteResponseMessage').html('<div class="alert alert-' + (response.status === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
                        $('#deleteAirportModal').modal('show');

                        // If successful, remove the airport from the table
                        if (response.status === 'success') {
                            $('button[data-id="' + airportIdToDelete + '"]').closest('tr').remove();
                            airportIdToDelete = null; // Reset the ID after deletion

                            // Close the modal after 3 seconds
                            setTimeout(function () {
                                $('#deleteAirportModal').modal('hide');
                            }, 3000);
                        }
                    },
                    error: function () {
                        $('#deleteResponseMessage').html('<div class="alert alert-danger">An error occurred while deleting the airport.</div>');
                        $('#deleteAirportModal').modal('show');
                    }
                });
            }
        });
    });
</script>

<style>
    .bg-green {
        background-color: #45B6B0;
        /* Light green for Active */
        padding: 0.2em 0.5em;
        border-radius: 4px;
        color: #155724;
        /* Dark green text for contrast */
    }

    .bg-red {
        background-color: #FF6B6B;
        /* Light red for Disabled */
        padding: 0.2em 0.5em;
        border-radius: 4px;
        color: #721c24;
        /* Dark red text for contrast */
    }

    .bg-gray {
        background-color: #A8BDCF;
        /* Light gray for Suspended */
        padding: 0.2em 0.5em;
        border-radius: 4px;
        color: #6c757d;
        /* Dark gray text for contrast */
    }

    /* Additional styling as needed */
</style>