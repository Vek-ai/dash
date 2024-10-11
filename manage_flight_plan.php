
<!-- HEADER -->
<?php include 'includes/header.php'; ?>    
<!-- /END OF HEADER -->
 
    <!-- Specific to the page -->
    <!-- Le styles -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
    <!-- Style -->
    <link rel="stylesheet" href="assets/js/button/ladda/ladda.min.css">
    <link rel="stylesheet" href="assets/js/dataTable/lib/jquery.dataTables/css/DT_bootstrap.css" />
    <link rel="stylesheet" href="assets/js/dataTable/css/datatables.responsive.css" />

    <link href="assets/js/footable/css/footable.core.css?v=2-0-1" rel="stylesheet" type="text/css" />
    <link href="assets/js/footable/css/footable.standalone.css" rel="stylesheet" type="text/css" />
    <link href="assets/js/footable/css/footable-demos.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="assets/js/dataTable/lib/jquery.dataTables/css/DT_bootstrap.css" />
    <link rel="stylesheet" href="assets/js/dataTable/css/datatables.responsive.css" />

    <!-- 3 Dots Dropdown -->
    <!-- NOTE: This causes problem to login if transfered to header.php -->
    <link href="assets\custom\css\3-dots-dropdown-menu.css" rel="stylesheet" type="text/css" />
    <script src="assets\custom\js\3-dots-dropdown-menu.js"></script>

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/minus.png">

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- TOP NAVBAR -->
        <?php include 'includes/navbar.php'; ?>    
    <!-- /END OF TOP NAVBAR -->

    <!-- SIDE MENU -->
        <?php include 'includes/sidebar.php'; ?>
    <!-- END OF SIDE MENU -->



    <!--  PAPER WRAP -->
    <div class="wrap-fluid">
        <div class="container-fluid paper-wrap bevel tlbr">

            <!-- CONTENT -->
            <!--TITLE -->
                <?php 
                    $pageTitle = "Manage Flight Plan";
                    include 'includes/title.php'; 
                ?>
            <!--/ TITLE -->

            <!-- BREADCRUMB -->
            <ul id="breadcrumb">
                <li>
                    <span class="entypo-home"></span>
                </li>
                <li><i class="fa fa-lg fa-angle-right"></i>
                </li>
                <li><a href="index.php" title="Dashboard">Dashboard</a>
                </li>
                <li><i class="fa fa-lg fa-angle-right"></i>
                </li>
                <li><a href="manage_flight_plan.php" title="Manage Drones"><?php echo $pageTitle; ?></a>
                </li>
                <li class="pull-right">
                    <div class="input-group input-widget">

                        <input style="border-radius:15px" type="text" placeholder="Search..." class="form-control">
                    </div>
                </li>
            </ul>

            <!-- END OF BREADCRUMB -->

            <div class="content-wrap">
                <div class="row">

                    <div class="col-sm-12">


                        <!-- ADD DRONE -->
                        <div class="row">
                            <div class="col-md-12" style="padding: 0px 10px;">
                                <?php include 'page_components/manage_flight_plan/add_flight_plan.php'; ?>
                            </div>
                            
                        </div>
                        <!-- /END OF ADD DRONE -->

                        <!-- DRONE LIST -->
                        <div class="row">
                            <div class="col-md-12" style="padding: 0px 10px;">
                                <?php include 'page_componenets\manage_flight_plan\flight_plan_list.php'; ?>
                            </div>
                        </div>
                        <!-- /END OF DRONE LIST -->

                    </div>
                    <!-- END OF DRONE SURVEILLANCE -->

                </div>

                <!-- /END OF CONTENT -->

                <!-- FOOTER -->
                    <?php include 'includes/footer.php'; ?> 
                <!-- / END OF FOOTER -->


            </div>
        </div>
        <!--  END OF PAPER WRAP -->


        <!-- MAIN EFFECT -->
        <script type="text/javascript" src="assets/js/preloader.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="assets/js/app.js"></script>
        <script type="text/javascript" src="assets/js/load.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>

        <!-- /MAIN EFFECT -->
        <!-- GAGE -->
        <script type="text/javascript" src="assets/js/toggle_close.js"></script>
        <script src="assets/js/footable/js/footable.js?v=2-0-1" type="text/javascript"></script>
        <script src="assets/js/footable/js/footable.sort.js?v=2-0-1" type="text/javascript"></script>
        <script src="assets/js/footable/js/footable.filter.js?v=2-0-1" type="text/javascript"></script>
        <script src="assets/js/footable/js/footable.paginate.js?v=2-0-1" type="text/javascript"></script>
        <script src="assets/js/footable/js/footable.paginate.js?v=2-0-1" type="text/javascript"></script>
</body>