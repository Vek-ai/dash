<?php
// Set a default title if $pageTitle is not set
$pageTitle = isset($pageTitle) ? $pageTitle : 'Page Title';
?>

<div class="row">
    <div id="paper-top">
        <div class="col-sm-3">
            <h2 class="tittle-content-header">
                <i class="icon-window"></i>
                <span id="page-title"><?php echo $pageTitle; ?></span>
            </h2>

        </div>

        <div class="col-sm-7">
            <div class="devider-vertical visible-lg"></div>
            <div class="tittle-middle-header">

                <div class="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <span class="tittle-alert entypo-info-circled"></span>
                    Welcome back,&nbsp;
                    <strong> <span id="welcome-user-name">Username</span>!</strong>&nbsp;&nbsp;Your last sig in at
                    Yesterday, 16:54 PM
                </div>

            </div>

        </div>
        <div class="col-sm-2">
            <div class="devider-vertical visible-lg"></div>
            <div class="btn-group btn-wigdet pull-right visible-lg">
                <div class="btn">
                    Widget</div>
                <button data-toggle="dropdown" class="btn dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul role="menu" class="dropdown-menu">
                    <li>
                        <a href="#">
                            <span class="entypo-plus-circled margin-iconic"></span>Add New</a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="entypo-heart margin-iconic"></span>Favorite</a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="entypo-cog margin-iconic"></span>Setting</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
        $(document).ready(function() {
            // AJAX call to get the authenticated user's details
            $.ajax({
                url: 'php/crud/get_user_details.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Combine fname and lname to form the full name
                        var fullName = response.data.fname + " " + response.data.lname;
                        
                                // Update the name in the dropdown
                                $('#user-name').text(fullName);

                                // Update the name in the alert div
                                $('#welcome-user-name').text(fullName);
                            } else {
                                alert(response.message);
                            }
                        },
                error: function(xhr, status, error) {
                    console.log("An error occurred: " + error);
                }
            });
        });
    </script>