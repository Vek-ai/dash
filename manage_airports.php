
<!-- HEADER -->
<?php include 'includes/header.php'; ?>    
<!-- /END OF HEADER -->
 
    <!-- Specific to the page -->
    <!-- Le styles -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
    <!-- Style -->
    <link rel="stylesheet" href="assets/js/button/ladda/ladda.min.css">

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
                    $pageTitle = "Manage Airport";
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
                <li><a href="manage_airports.php" title="Manage Airports"><?php echo $pageTitle; ?></a>
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


                        <div class="row">
                        		<!-- MAP -->
                            <div class="col-md-12" style="padding: 0px 10px;">
                                <?php include 'page_components/manage_airports/map.php'; ?>
                            </div>
														<!-- /END OF MAP -->

														<!-- CONTAINER -->
                            <div class="col-md-12" style="padding: 0px 10px;">
															<section class="panel">
																<div class="panel-body">
																	<?php include 'page_components/manage_airports/top_content.php'; ?>
																	<?php include 'page_components/manage_airports/bottom_content.php'; ?>																			
																</div>
															</section>
                            </div>
                            <!-- /END OF CONTAINER -->
                        </div>


                    </div>

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

				<script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
				<script type="text/javascript" src="assets/js/map/gmap3.js"></script>
				<script src="https://jhere.net/js/jhere-custom.js"></script>
</body>