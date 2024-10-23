<section class="panel">
    <div class="panel-body">
        <div class="nest" id="FilteringClose">
            <div class="title-alt">
                <h6>Drones List</h6>
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
                            <th data-toggle="true">Status</th>
                            <th data-toggle="true">Action</th>
                        </tr>
                    </thead>
                    <tbody id="droneTableBody">

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Drone Modal -->
        <div id="editDroneModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editDroneLabel"
            aria-hidden="true">
            <?php include 'modal/edit_drone.php'; ?>
        </div>

        <!-- Delete Drone Modal -->
        <div id="deleteDroneModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteDroneLabel"
            aria-hidden="true">
            <?php include 'modal/delete_drone.php'; ?>
        </div>

    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        var droneIdToDelete; // Variable to store the ID of the drone to be deleted

        // Fetch drones and populate the table
        $.ajax({
            type: 'GET',
            url: 'php/crud/drones/get_drones.php',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var dronesData = response.data;
                    var droneTableBody = $('#droneTableBody');

                    droneTableBody.empty();

                    dronesData.forEach(function (drone) {
                        var statusClass = '';
                        var actionButton = `
                        <button class="btn btn-primary editBtn" data-id="${drone.id}" data-name="${drone.name}" data-status="${drone.status}">Edit</button>
                        <button class="btn btn-danger deleteBtn" data-id="${drone.id}">Delete</button>
                    `;

                        switch (drone.status) {
                            case 'Active':
                                statusClass = 'bg-green';
                                break;
                            case 'Disabled':
                                statusClass = 'bg-red';
                                break;
                            case 'Suspended':
                                statusClass = 'bg-gray';
                                break;
                            default:
                                statusClass = '';
                        }

                        droneTableBody.append(`
                        <tr>
                            <td>${drone.name}</td>
                            <td><span class="${statusClass}">${drone.status}</span></td>
                            <td>${actionButton}</td>
                        </tr>
                    `);
                    });

                    // Attach click event for edit buttons
                    $('.editBtn').click(function () {
                        var droneId = $(this).data('id');
                        var droneName = $(this).data('name');
                        var droneStatus = $(this).data('status');

                        $('#droneId').val(droneId);
                        $('#droneName').val(droneName);
                        $('#droneStatus').val(droneStatus);

                        $('#editDroneModal').modal('show');
                    });

                    // Attach click event for delete buttons
                    $('.deleteBtn').click(function () {
                        droneIdToDelete = $(this).data('id'); // Store the ID of the drone to delete
                        $('#deleteResponseMessage').empty(); // Clear previous messages
                        $('#deleteDroneModal').modal('show'); // Show the delete confirmation modal
                    });
                } else {
                    $('#deleteResponseMessage').html('<div class="alert alert-warning">Failed to load drones.</div>');
                    $('#deleteDroneModal').modal('show');
                }
            },
            error: function () {
                $('#deleteResponseMessage').html('<div class="alert alert-danger">Error fetching drones.</div>');
                $('#deleteDroneModal').modal('show');
            }
        });

        // Attach click event for the confirm delete button in the modal
        $('#confirmDeleteBtn').click(function () {
            if (droneIdToDelete) { // Check if there's a drone to delete
                $.ajax({
                    type: 'POST',
                    url: 'php/crud/drones/delete_drone.php',
                    data: { id: droneIdToDelete },
                    dataType: 'json',
                    success: function (response) {
                        $('#deleteResponseMessage').html('<div class="alert alert-' + (response.status === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
                        $('#deleteDroneModal').modal('show');

                        // If successful, remove the drone from the table
                        if (response.status === 'success') {
                            $('button[data-id="' + droneIdToDelete + '"]').closest('tr').remove();
                            droneIdToDelete = null; // Reset the ID after deletion

                            // Close the modal after 3 seconds
                            setTimeout(function () {
                                $('#deleteDroneModal').modal('hide');
                            }, 3000);
                        }
                    },
                    error: function () {
                        $('#deleteResponseMessage').html('<div class="alert alert-danger">An error occurred while deleting the drone.</div>');
                        $('#deleteDroneModal').modal('show');
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