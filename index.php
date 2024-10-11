<?php
include 'includes/header.php';
?>

<body>
    <!-- Preloader test-->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- TOP NAVBAR -->
    <?php include 'includes/navbar.php'; ?>
    <!-- /END OF TOP NAVBAR -->

    <!-- SIDE MENU -->
    <?php include 'includes/sidebar.php'; ?>
    <!-- END OF SIDE MENU -->

    <!-- PAPER WRAP -->
    <div class="wrap-fluid">
        <div class="container-fluid paper-wrap bevel tlbr">

            <!-- TITLE -->
            <?php
            $pageTitle = "Dashboard";
            include 'includes/title.php';
            ?>
            <!--/ TITLE -->

            <!-- BREADCRUMB -->
            <ul id="breadcrumb">
                <li>
                    <span class="entypo-home"></span>
                </li>
                <li><i class="fa fa-lg fa-angle-right"></i></li>
                <li><a href="index.php" title="Sample page 1"><?php echo $pageTitle; ?></a></li>
                <li class="pull-right">
                    <div class="input-group input-widget">
                        <input style="border-radius:15px" type="text" placeholder="Search..." class="form-control">
                    </div>
                </li>
            </ul>
            <!-- END OF BREADCRUMB -->

            <!-- CONTENT WRAP -->
            <div class="content-wrap">
                <div class="row">
                    <div id="paper-middle">

                        <div class="col-sm-12">


                            <div class="row">
                                <!-- MAP -->
                                <div class="col-md-12" style="padding: 0px 10px;">
                                    <?php include 'page_components/dashboard/map.php'; ?>
                                </div>
                                <!-- /END OF MAP -->

                                <!-- CONTAINER -->
                                <div class="col-md-12" style="padding: 0px 10px;">
                                    <section class="panel">
                                        <div class="panel-body">
                                            <?php include 'page_components/dashboard/top_content.php'; ?>

                                            <div id="airportContent" style="display:block;">
                                                <?php include 'page_components/dashboard/airport_content.php'; ?>
                                            </div>
                                            <div id="droneContent" style="display:none;">
                                                <?php include 'page_components/dashboard/drone_content.php'; ?>
                                            </div>
                                            <div id="flightPlanContent" style="display:none;">
                                                <?php include 'page_components/dashboard/flight_plan_content.php'; ?>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <!-- /END OF CONTAINER -->
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- /END OF CONTENT -->

            <!-- FOOTER -->
            <?php include 'includes/footer.php'; ?>
            <!-- / END OF FOOTER -->

        </div>
    </div>
    <!-- END OF PAPER WRAP -->

    <!-- RIGHT SLIDER CONTENT -->
    <div class="sb-slidebar sb-right">
        <div class="right-wrapper">
            <div class="row"></div>
        </div>
    </div>
    <!-- END OF RIGHT SLIDER CONTENT -->

    <!-- JAVASCRIPT INCLUDES -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
    <script src="assets/js/progress-bar/src/jquery.velocity.min.js"></script>
    <script src="assets/js/progress-bar/number-pb.js"></script>
    <script src="assets/js/progress-bar/progress-app.js"></script>
    <script type="text/javascript" src="assets/js/preloader.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    <script type="text/javascript" src="assets/js/load.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="assets/js/map/gmap3.js"></script>
    <script src="assets/js/jhere-custom.js"></script>
</body>
