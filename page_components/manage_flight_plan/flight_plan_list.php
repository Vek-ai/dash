<section class="panel">
    <div class="panel-body">
        <div class="nest" id="FilteringClose">
            <div class="title-alt">
                <h6>Flight Plan List</h6>
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
                            <th data-toggle="true">Drone</th>
                            <th data-toggle="true">Action</th>
                        </tr>
                    </thead>
                    <tbody id="flightPlanTableBody">
                        <!-- Flight plan rows will be inserted here -->
                    </tbody>
                </table>

            </div>
        </div>

        <!-- Edit Flight Plan Modal -->
        <div id="editFlightPlanModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="editFlightPlanLabel" aria-hidden="true">
            <?php include 'modals/edit_flight_plan.php'; ?>
        </div>

        <!-- Delete Flight Plan Modal -->
        <div id="deleteFlightPlanModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="deleteFlightPlanLabel" aria-hidden="true">
            <?php include 'modals/delete_flight_plan.php'; ?>
        </div>

        <!-- Flight Plan Marker Modal -->
        <div class="modal fade" id="flightPlanMarkersModal" tabindex="-1" role="dialog"
            aria-labelledby="flightPlanMarkersModalLabel" aria-hidden="true">
            <?php include 'modals/flight_plan_marker_modal.php'; ?>
        </div>

        <!-- Edit Flight Plan Markers Modal -->
        <div id="editFlightPlanMarkersModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="editFlightPlanMarkersModalLabel" aria-hidden="true">
            <?php include 'modals/edit_flight_plan_markers_modal.php'; ?>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        var flightPlanIdToDelete; // Variable to store the ID of the flight plan to be deleted

        // Fetch flight plans and populate the table
        $.ajax({
            type: 'GET',
            url: 'php/crud/flight_plans/get_flight_plans.php',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var flightPlansData = response.data;

                    var flightPlanTableBody = $('#flightPlanTableBody');

                    flightPlanTableBody.empty();

                    flightPlansData.forEach(function (flightPlan) {
                        var actionButton = `
                        <button class="btn btn-primary editBtn" data-id="${flightPlan.id}" data-drone_id="${flightPlan.drone_id}" data-name="${flightPlan.plan_name}">Edit</button>
                        <button class="btn btn-danger deleteBtn" data-id="${flightPlan.id}">Delete</button>
                    `;

                        // Make the flight plan name clickable
                        flightPlanTableBody.append(`
                            <tr>
                                <td><a href="#" class="flight-plan-link" data-id="${flightPlan.id}">${flightPlan.plan_name}</a></td>
                                <td>${flightPlan.drone_names}</td>
                                <td>${actionButton}</td>
                            </tr>
                        `);
                    });

                    // Attach click event for edit buttons
                    $('.editBtn').click(function () {
                        var flightPlanId = $(this).data('id');
                        var flightPlanName = $(this).data('name');

                        $('#flightPlanId').val(flightPlanId);
                        $('#flightPlanName').val(flightPlanName);

                        $('#editFlightPlanModal').modal('show');
                    });

                    // Attach click event for delete buttons
                    $('.deleteBtn').click(function () {
                        flightPlanIdToDelete = $(this).data('id'); // Store the ID of the flight plan to delete
                        $('#deleteResponseMessage').empty(); // Clear previous messages
                        $('#deleteFlightPlanModal').modal('show'); // Show the delete confirmation modal
                    });
                } else {
                    $('#deleteResponseMessage').html('<div class="alert alert-warning">Failed to load flight plans.</div>');
                    $('#deleteFlightPlanModal').modal('show');
                }
            },
            error: function () {
                $('#deleteResponseMessage').html('<div class="alert alert-danger">Error fetching flight plans.</div>');
                $('#deleteFlightPlanModal').modal('show');
            }
        });

        // Attach click event for the confirm delete button in the modal
        $('#confirmDeleteBtn').click(function () {
            if (flightPlanIdToDelete) { // Check if there's a flight plan to delete
                $.ajax({
                    type: 'POST',
                    url: 'php/crud/flight_plans/delete_flight_plan.php',
                    data: { id: flightPlanIdToDelete },
                    dataType: 'json',
                    success: function (response) {
                        $('#deleteResponseMessage').html('<div class="alert alert-' + (response.status === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
                        $('#deleteFlightPlanModal').modal('show');

                        // If successful, remove the flight plan from the table
                        if (response.status === 'success') {
                            $('button[data-id="' + flightPlanIdToDelete + '"]').closest('tr').remove();
                            flightPlanIdToDelete = null; // Reset the ID after deletion

                            // Close the modal after 3 seconds
                            setTimeout(function () {
                                $('#deleteFlightPlanModal').modal('hide');
                            }, 3000);
                        }
                    },
                    error: function () {
                        $('#deleteResponseMessage').html('<div class="alert alert-danger">An error occurred while deleting the flight plan.</div>');
                        $('#deleteFlightPlanModal').modal('show');
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

    .flight-plan-link {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Inherit the color from the parent */
        cursor: pointer;
        /* Optional: make it look like a clickable link */
    }
</style>