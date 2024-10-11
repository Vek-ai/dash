<section class="panel">
    <div class="panel-body">
        <div class="nest" id="FilteringClose">
            <div class="title-alt">
                <h6>Flight Plans Filtering</h6>
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
                        <a href="#clear" style="margin-left:10px;" class="pull-right btn btn-info clear-filter" title="clear filter">clear</a>
                        <a href="#api" class="pull-right btn btn-info filter-api" title="Filter using the Filter API">filter API</a>
                    </div>
                </div>

                <table id="footable-res2" class="demo tablet breakpoint no-paging footable-loaded footable" data-filter="#filter" data-filter-text-only="true">
                    <thead>
                        <tr>
                            <th data-toggle="true">Flight Plan Name</th>
                            <th data-toggle="true">Action</th>
                        </tr>
                    </thead>
                    <tbody id="flightPlanTableBody">
                        <!-- Dynamic rows will be added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- FOR FLIGHT PLAN MARKERS MODAL -->
<div class="modal fade" id="flightPlanMarkersModal" tabindex="-1" role="dialog" aria-labelledby="flightPlanMarkersModalLabel" aria-hidden="true">
    <?php include 'modals/flight_plan_marker_modal.php'; ?>
</div>
<!-- /END OF FLIGHT PLAN MARKERS MODAL -->

<script type="text/javascript">
    $(document).ready(function () {
        // Fetch flight plans and populate the table
        $.ajax({
            type: 'GET',
            url: 'php/crud/flight_plans/get_flight_plans.php', // The PHP file that fetches all flight plans
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var flightPlanTableBody = $('#flightPlanTableBody');
                    var flightPlans = response.data;

                    // Clear any existing rows
                    flightPlanTableBody.empty();

                    // Loop through each flight plan and append rows to the table
                    flightPlans.forEach(function (plan) {
                        var row = '<tr>';
                        // Make flight plan name clickable
                        row += '<td class="flight-plan-name" data-id="' + plan.id + '">' + plan.plan_name + '</td>';
                        
                        // Existing dropdown HTML
                        row += `
                        <td>
                            <div class="more">
                                <button id="more-btn-${plan.id}" class="more-btn">
                                    <span class="more-dot"></span>
                                    <span class="more-dot"></span>
                                    <span class="more-dot"></span>
                                </button>
                                <div class="more-menu">
                                    <div class="more-menu-caret">
                                        <div class="more-menu-caret-outer"></div>
                                        <div class="more-menu-caret-inner"></div>
                                    </div>
                                    <ul class="more-menu-items" tabindex="-1" role="menu" aria-labelledby="more-btn-${plan.id}" aria-hidden="true">
                                        <li class="more-menu-item" role="presentation">
                                            <button type="button" class="more-menu-btn" role="menuitem">Edit</button>
                                        </li>
                                        <li class="more-menu-item" role="presentation">
                                            <button type="button" class="more-menu-btn" role="menuitem">View</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>`;
                        
                        row += '</tr>';
                        flightPlanTableBody.append(row);
                    });

                    // Add click event for flight plan name AFTER appending rows
                    $('.flight-plan-name').on('click', function () {
                        var flightPlanId = $(this).data('id'); // Get flight plan ID
                        fetchFlightPlanMarkers(flightPlanId); // Call function to fetch markers
                    });

                    // Initialize footable after appending rows
                    $('#footable-res2').footable();
                } else {
                    alert('Failed to load flight plans.');
                }
            },
            error: function () {
                alert('Error fetching flight plans.');
            }
        });

        // Footable filtering
        $('#footable-res2').footable().bind('footable_filtering', function (e) {
            var selected = $('.filter-status').find(':selected').text();
            if (selected && selected.length > 0) {
                e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
                e.clear = !e.filter;
            }
        });

        // Clear filter
        $('.clear-filter').click(function (e) {
            e.preventDefault();
            $('.filter-status').val('');
            $('table.demo').trigger('footable_clear_filter');
        });

        // Trigger filtering based on filter status change
        $('.filter-status').change(function (e) {
            e.preventDefault();
            $('table.demo').trigger('footable_filter', {
                filter: $('#filter').val()
            });
        });

        // Example filter API usage
        $('.filter-api').click(function (e) {
            e.preventDefault();

            // Get the footable filter object
            var footableFilter = $('table').data('footable-filter');

            alert('About to filter table by "active"');
            // Filter by 'active'
            footableFilter.filter('active');

            // Clear the filter
            if (confirm('Clear filter now?')) {
                footableFilter.clearFilter();
            }
        });
    });

    // Function to fetch flight plan markers and display in modal
    function fetchFlightPlanMarkers(flightPlanId) {
        $.ajax({
            type: 'GET',
            url: 'php/crud/flight_plans/get_flight_plan_markers.php', // PHP file to fetch flight plan markers
            data: { id: flightPlanId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Populate modal with markers data
                    var modalBody = $('#flightPlanMarkersModal .modal-body');
                    modalBody.empty();

                    response.data.forEach(function (marker) {
                        modalBody.append('<p>Marker: ' + marker.latitude + ', ' + marker.longitude + '</p>');
                    });

                    // Show the modal
                    $('#flightPlanMarkersModal').modal('show');
                } else {
                    alert('No markers found for this flight plan.');
                }
            },
            error: function () {
                alert('Error fetching flight plan markers.');
            }
        });
    }
</script>

<style>
    .bg-green {
        background-color: #45B6B0; /* Light green for Active */
        padding: 0.2em 0.5em;
        border-radius: 4px;
        color: #155724; /* Dark green text for contrast */
    }

    .bg-red {
        background-color: #FF6B6B; /* Light red for Disabled */
        padding: 0.2em 0.5em;
        border-radius: 4px;
        color: #721c24; /* Dark red text for contrast */
    }

    .bg-gray {
        background-color: #A8BDCF; /* Light gray for Suspended */
        padding: 0.2em 0.5em;
        border-radius: 4px;
        color: #6c757d; /* Dark gray text for contrast */
    }

    /* Additional styling as needed */
</style>
