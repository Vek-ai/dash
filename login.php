<?php include 'includes/header.php'; ?>

    <!-- Le styles -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
   <!--  <link rel="stylesheet" href="assets/css/style.css"> -->
    <link rel="stylesheet" href="assets/css/signin.css">
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/minus.png">

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="container">



        <div class="" id="login-wrapper">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div id="logo-login">
                        <h1>Apricot
                            <span>v1.3</span>
                        </h1>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="account-box" style="z-index: 10000;">

                        <form id="loginForm" >
                            <div class="form-group">
                                <!-- <a href="#" class="pull-right label-forgot">Forgot email?</a> -->
                                <label for="inputUsernameEmail">Username</label>
                                <input type="text" id="inputUsername" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <a href="#" class="pull-right label-forgot">Forgot password?</a>
                                <label for="inputPassword">Password</label>
                                <input type="password" id="inputPassword" name="password" class="form-control" required>
                            </div>
                            <div class="checkbox pull-left">
                                <label>
                                    <input type="checkbox">Remember me</label>
                            </div>
                            <button class="btn btn btn-primary pull-right">
                                Log In
                            </button>
                        </form>
                        
                        <a class="forgotLnk" href="#"></a>
                        <div class="or-box">
                          
                            <center><span class="text-center login-with">Login or <b>Sign Up</b></span></center>
                            <div class="row">
                                <div class="col-md-6 row-block">
                                    <a href="#" class="btn btn-facebook btn-block">
                                        <span class="entypo-facebook space-icon"></span>Facebook</a>
                                </div>
                                <div class="col-md-6 row-block">
                                    <a href="#" class="btn btn-twitter btn-block">
                                        <span class="entypo-twitter space-icon"></span>Twitter</a>
                                        
                                </div>

                            </div>
                            <div style="margin-top:25px" class="row">
                                <div class="col-md-6 row-block">
                                    <a href="#" class="btn btn-google btn-block"><span class="entypo-gplus space-icon"></span>Google +</a>
                                </div>
                                <div class="col-md-6 row-block">
                                    <a href="#" class="btn btn-instagram btn-block"><span class="entypo-instagrem space-icon"></span>Instagram</a>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="row-block">
                            <div class="row">
                                <div class="col-md-12 row-block">
                                    <a href="index.php" class="btn btn-primary btn-block">Create New Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div style="text-align:center;margin:0 auto;">
            <h6 style="color:#fff;">Release Candidate 1.0 Powered by © Themesmiles 2014</h6>
        </div>

    </div>
    <div id="test1" class="gmap3"></div>



    <!--  END OF PAPER WRAP -->




    <!-- MAIN EFFECT -->
    <script type="text/javascript" src="assets/js/preloader.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    <script type="text/javascript" src="assets/js/load.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="assets/js/map/gmap3.js"></script>
    <script type="text/javascript">
    $(function() {

        $("#test1").gmap3({
            marker: {
                latLng: [-7.782893, 110.402645],
                options: {
                    draggable: true
                },
                events: {
                    dragend: function(marker) {
                        $(this).gmap3({
                            getaddress: {
                                latLng: marker.getPosition(),
                                callback: function(results) {
                                    var map = $(this).gmap3("get"),
                                        infowindow = $(this).gmap3({
                                            get: "infowindow"
                                        }),
                                        content = results && results[1] ? results && results[1].formatted_address : "no address";
                                    if (infowindow) {
                                        infowindow.open(map, marker);
                                        infowindow.setContent(content);
                                    } else {
                                        $(this).gmap3({
                                            infowindow: {
                                                anchor: marker,
                                                options: {
                                                    content: content
                                                }
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    }
                }
            },
            map: {
                options: {
                    zoom: 15
                }
            }
        });

    });
    </script>

    <script>
$(document).ready(function () {
    $('#loginForm').submit(function (e) {
        e.preventDefault(); 
        var formData = $(this).serialize(); 
        $.ajax({
            type: 'POST',
            url: 'php/user_login.php',
            data: formData,
            success: function (response) {
                if(response === "success"){
                    window.location.href = "index.php";
                } else {
                    alert("Error: " + response);  // Display error message in alert
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred: " + xhr.responseText);  // Display server-side error in alert
            }
        });
    });
});

    </script>



</body>
