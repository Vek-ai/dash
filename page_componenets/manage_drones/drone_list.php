<section class="panel">
    <div class="panel-body">
        <div class="nest" id="FilteringClose">
            <div class="title-alt">
                <h6>Footable Filtering</h6>
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
                            <th data-toggle="true">Name</th>
                            <th data-toggle="true">Status</th>
                            <th data-toggle="true">Action</th>
                        </tr>
                    </thead>
                    <tbody id="droneTableBody">
                        <!-- Dynamic rows will be added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        // Fetch drones and populate the table
        $.ajax({
            type: 'GET',
            url: 'php/crud/drones/get_drones.php', // The PHP file that fetches all drones
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var droneTableBody = $('#droneTableBody');
                    var drones = response.data;

                    // Clear any existing rows
                    droneTableBody.empty();

                    // Loop through each drone and append rows to the table
                    drones.forEach(function (drone) {
                        var droneStatus = drone.status;

                        // Determine the status class based on the status
                        var statusClass;
                        if (droneStatus === 'Active') {
                            statusClass = 'bg-green'; // Green for Active
                        } else if (droneStatus === 'Disabled') {
                            statusClass = 'bg-red'; // Red for Disabled
                        } else if (droneStatus === 'Suspended') {
                            statusClass = 'bg-gray'; // Gray for Suspended
                        } else {
                            statusClass = ''; // Default class (no background color)
                        }

                        var row = '<tr>';
                        row += '<td>' + drone.name + '</td>';
                        row += `<td><span class="status-metro status-${drone.status} ${statusClass}" title="${droneStatus}">${droneStatus}</span></td>`;

                        // 3-dots dropdown HTML
                        row += `
                        <td>
                            <div class="more">
                                <button id="more-btn-${drone.id}" class="more-btn">
                                    <span class="more-dot"></span>
                                    <span class="more-dot"></span>
                                    <span class="more-dot"></span>
                                </button>
                                <div class="more-menu">
                                    <div class="more-menu-caret">
                                        <div class="more-menu-caret-outer"></div>
                                        <div class="more-menu-caret-inner"></div>
                                    </div>
                                    <ul class="more-menu-items" tabindex="-1" role="menu" aria-labelledby="more-btn-${drone.id}" aria-hidden="true">
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
                        droneTableBody.append(row);

                        // Add dropdown functionality for this row
                        var el = document.querySelector(`#more-btn-${drone.id}`).parentNode;
                        var btn = el.querySelector(`#more-btn-${drone.id}`);
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

                    // Initialize footable after appending rows
                    $('#footable-res2').footable();
                } else {
                    alert('Failed to load drones.');
                }
            },
            error: function () {
                alert('Error fetching drones.');
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

            alert('About to filter table by "tech"');
            // Filter by 'tech'
            footableFilter.filter('tech');

            // Clear the filter
            if (confirm('Clear filter now?')) {
                footableFilter.clearFilter();
            }
        });
    });
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
