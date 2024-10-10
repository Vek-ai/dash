<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!-- STYLE -->
    <style>
        .card {
            padding-inline: 2px;
            background-color: #F0F0F0;
            height: 46px;
        }
        .content-1{
            height: 530px;
        }
        .content-2{
            height: 300px;
        }

        .active-resolution {
            background-color: #f0f8ff; /* Light blue highlight */
            border: 2px solid #007bff; /* Border to indicate active state */
        }

        .active-resolution h5 {
            color: #007bff; /* Change text color */
        }

    </style>
<!-- /END OF STYLE -->

<!-- HEADER -->
    <?php include 'includes/header.php'; ?>    
<!-- /END OF HEADER -->
 
    <!-- Specific to the page -->
    <!-- Le styles -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
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
                    $pageTitle = "Drone Surveillance";
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
                <li><a href="drone_surveillance.php" title="Drone Surveillance"><?php echo $pageTitle; ?></a>
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
                        <!-- DRONE SURVEILLANCE-->
                        <!-- TOP ROW -->
                        <div class="row">
                            <!-- LEFT ROW -->
                            <div class="col-md-8">
                                <?php include 'page_componenets/drone_surveillance/top_left_pannel.php'; ?>
                            </div>

                            <!-- RIGHT ROW -->
                            <div class="col-md-4">
                                <?php include 'page_componenets/drone_surveillance/top_right_pannel.php'; ?>
                            </div>
                        </div>
                        <!-- /END OF TOP ROW -->

                        <!-- BOTTOM ROW -->
                        <div class="row">
                            <!-- LEFT ROW -->
                            <div class="col-md-8">
                                <?php include 'page_componenets/drone_surveillance/bottom_left_pannel.php'; ?>
                            </div>

                            <!-- RIGHT ROW -->
                            <div class="col-md-4">
                                <?php include 'page_componenets/drone_surveillance/bottom_right_pannel.php'; ?>
                            </div>
                        </div>
                        <!-- /END OF BOTTOM ROW -->
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
        <script type="text/javascript" src="assets/js/speed/canvasgauge-coustom-custom.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>


</body>

<script>
    // VIDEO AND IMAGE GROUPED BOTTON
    document.getElementById('videoBtn').onclick = function() {
        this.classList.add('active');
        this.classList.remove('btn-primary');
        document.getElementById('imageBtn').classList.remove('active');
        document.getElementById('imageBtn').classList.add('btn-primary');
    };

    document.getElementById('imageBtn').onclick = function() {
        this.classList.add('active');
        this.classList.remove('btn-primary');
        document.getElementById('videoBtn').classList.remove('active');
        document.getElementById('videoBtn').classList.add('btn-primary');
    };
    // END OF VIDEO AND IMAGE GROUPED BOTTON

    // ISO, HDR, and DVR GROUPED BOTTON
    document.getElementById('isoBtn').onclick = function() {
        this.classList.add('active');
        this.classList.remove('btn-primary');
        document.getElementById('hdrBtn').classList.remove('active');
        document.getElementById('hdrBtn').classList.add('btn-primary');
        
        document.getElementById('dvrBtn').classList.remove('active');
        document.getElementById('dvrBtn').classList.add('btn-primary');
    };

    document.getElementById('hdrBtn').onclick = function() {
        this.classList.add('active');
        this.classList.remove('btn-primary');
        document.getElementById('isoBtn').classList.remove('active');
        document.getElementById('isoBtn').classList.add('btn-primary');
        
        document.getElementById('dvrBtn').classList.remove('active');
        document.getElementById('dvrBtn').classList.add('btn-primary');
    };

    document.getElementById('dvrBtn').onclick = function() {
        this.classList.add('active');
        this.classList.remove('btn-primary');
        document.getElementById('isoBtn').classList.remove('active');
        document.getElementById('isoBtn').classList.add('btn-primary');
        
        document.getElementById('hdrBtn').classList.remove('active');
        document.getElementById('hdrBtn').classList.add('btn-primary');
    };
    // END OF ISO, HDR, and DVR GROUPED BOTTON
    
    const canvas = document.getElementById('canvas4');
    const ctx = canvas.getContext('2d');
    let number = 0;
    let direction = 1;

    function drawNumber() {
        // Clear the canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Set font and alignment for the number
        ctx.font = "30px Arial";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";

        // Draw the number
        ctx.fillText(number, canvas.width / 2, canvas.height / 2);

        // Update the number
        number += direction;

        // Reverse direction if number reaches 0 or 90
        if (number >= 90 || number <= 0) {
            direction *= -1;
        }

        // Continue the animation
        requestAnimationFrame(drawNumber);
    }

    // Start the animation
    drawNumber();

    // Listeners for all display resolution buttons
    const resolutionButtons = document.querySelectorAll('.card-btn');
    resolutionButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove 'active-resolution' from all resolution panels
            document.querySelectorAll('.panel-body').forEach(panel => {
                panel.classList.remove('active-resolution');
            });
            
            // Add 'active-resolution' to the clicked button's parent panel
            button.closest('.panel-body').classList.add('active-resolution');
        });
    });

</script>