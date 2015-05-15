<?php
require_once("lib/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>foodhub</title>
    <link rel="icon" href="img/favicon.png" type="image/x-icon">

    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
          type="text/css">
    <link rel="stylesheet" href="css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootbox.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet"/>

    <!-- rating styles   -->
    <link rel="stylesheet" href="css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="css/select2.min.css" rel="stylesheet"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-slider.css" rel="stylesheet">
    <script src="js/select2.min.js"></script>
    <script src="js/clear.js"></script>

    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript">
        $(document).ready(function () {
            $.getJSON("js/place_types.json", function (place_type) {
                $("#selecta option").remove(); // Remove all <option> child tags.
                $.each(place_type.place_types, function (index, item) { // Iterates through a collection
                    $("#selecta").append( // Append an object to the inside of the select box
                        $("<option></option>") // Yes you can do this.
                            .text(item.label)
                            .val(item.id)
                    );
                });
            });

            $("#my_slider").slider({step: 100, min: 500, max: 5000});
        });

        window.fbAsyncInit = function () {
            FB.init({
                appId: '641937869274213',
                cookie: true,  // enable cookies to allow the server to access
                               // the session
                xfbml: true,  // parse social plugins on this page
                version: 'v2.2' // use version 2.2
            });
        };

        function facebook_login() {
            FB.login(function (response) {

                if (response.status == 'connected') {
                    FB.api('/me', function (response) {
                        $.post("public/userAction/savefbUser.php", {
                            id: response.id,
                            name: response.name,
                            email: response.email
                        }, function (data) {
                            if (data == 1) {
                                $("#user_login").hide();
                                $("#status").hide();
                                $(".login_wrapper").html("");
                                $("#btn_register").hide();
                                $(".userinfo_container").css("padding", "10px 15px");
                                $(".userinfo_container").html(response.name + ' <div style="padding-top: 2px;padding-bottom: 10px;" id="btn-group-login" class="btn-group" role="group" aria-label="Default button group"><button type="button" class="btn btn-primary btn-sm logout">Logout</button></div>');
                                setTimeout(function () {
                                    $('#registerModal').modal('hide');
                                }, 1000);

                            }
                        });
                    });
                } else {
                    console.log("log in canceled");
                }
            }, {scope: 'email'});
        }
        // Load the SDK asynchronously
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement("script");
            js.id = "fb-root";
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    </script>
</head>

<body id="page-top" class="index">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#page-top">foodhub</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li id="mnu_1" class="page-scroll">
                    <a href="#portfolio">You are Here!</a>
                </li>
                <li id="mnu_2" class="page-scroll">
                    <a href="#about">Places</a>
                </li>
                <li id="mnu_3" class="page-scroll">
                    <a href="#contact">Contact</a>
                </li>
                <li id="mnu_4">
                    <div class="userinfo_container">
                        <?php
                        if ($user->is_logged_in()) {
                            ?>
                            <div class="user_cont">
                                <?php
                                echo $user->user_fullname . " ";
                                ?>
                                <div id="btn-group-login" class="btn-group" role="group"
                                     aria-label="Default button group">
                                    <button type="button" class="btn btn-primary btn-sm logout">Logout</button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if (!$user->is_logged_in()) {
                        ?>
                        <div id="status">
                        </div>
                        <a href="#" id="btn_register" data-toggle="modal" data-target="#registerModal">Login
                        </a>
                    <?php
                    }
                    ?>

                </li>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<header>
    <div class="container">
        <div class="row">
            <div id="select" class="col-lg-12 text-center">
                <!-- modal code -->
                <div data-backdrop="static" class="modal fade" id="registerModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel"
                                    style="text-transform:none;color:#545454">Sign in</h4>
                            </div>
                            <div class="modal-body">
                                <div class="login_wrapper">
                                    <button class="btn btn-primary btn-sm"
                                            style="background-color: #5776Cd;border-color: #5776Cd;"
                                            onclick="facebook_login();"><i class="fa fa-facebook"></i> connect
                                    </button>
                                    <div id="fb-root"></div>
                                </div>


                                <div class="user_reg login_wrapper">

                                    <form id="user_login" accept-charset="UTF-8" method="post">
                                        &nbsp;<span class="or">or</span>
                                        <input class="form-control" id="txt_email" type="email" required="email"
                                               placeholder="Email">
                                        <input class="form-control" id="txt_password" type="password"
                                               required="password"
                                               placeholder="Password">

                                        <p>

                                        <div id="btn-group-login" class="btn-group" role="group"
                                             aria-label="Default button group">
                                            <button class="btn btn-success btn-sm" id="btn_login">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form id="frm_regiters" accept-charset="UTF-8" method="post">
                                <div class="modal-body">
                                    <div id="reg_error"></div>
                                    <hr>
                                    <h4 class="modal-title" id="exampleModalLabel"
                                        style="text-transform:none;color:#545454">Quick sign up</h4>

                                    <div class="form-group">
                                        <input name="username" type="text" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <input name="useremail" type="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input name="userpassword" type="password" class="form-control"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                    <button id="btn_register" type="submit" name="register"
                                            class="btn btn-primary btn-sm">
                                        Continue
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end modal code -->
            </div>


        </div>
        <div id="select" class="col-lg-12 text-center">

            <div class="intro-text">

                    <span class="skills"><strong>foodhub</strong> is an app that helps you when going to new places when you're letting loose of yourself. Great companion, just hit of a button and you will know your current location and places near you (eg. <i>bars,
                            hotels, stores, etc.</i>).
                    <span class="intro"><p>To <strong>start</strong>&nbsp;select place/s you want know about, then hit
                            <strong>Go</strong>.</p></span>

                <div id="alert-msg">
                </div>
            </div>

            <select class="js-example-basic-multiple form-control" multiple="" id="selecta">

            </select>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <span style="color:#545454;">My radius slider lorem ipsum</span>
            </div>
            <div class="col-lg-12 text-center">
                <input id="my_slider" type="text"/>
            </div>
            <div class="col-lg-12 text-center">
                <p></p>
                <button id="cmdSubmit" type="submit" class="btn btn-success btn-lg">Go</button>
                <button id="noSubmit" class="btn btn-success btn-lg"><span
                        class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...
                </button>
            </div>
        </div>
    </div>
    </div>
</header>
<!-- review modal code-->
<div>
    <div data-backdrop="static" class="modal fade" id="addreview" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Writing Review</h4>
                </div>
                <form id="frm_add_reviews" action="" method="post">
                    <div class="modal-body">
                        <div id="review_error_container">

                        </div>
                        <div class="form-group">
                            <input class="form-control" id="txt_place_id" type="hidden">
                            <input id="rating-input" type="number"/>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- end modal view code -->
<!-- Portfolio Grid Section -->
<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 id="your">You are here!</h2>

                <div id="map_holder">
                    <div id="mapcanvas" style="width: 100%; ">
                    </div>
                    <div id="location_container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="success" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 id="h_place">Places</h2>

                <p class="">Sort by :</p>

                <div id="btn-group-places" class="btn-group" role="group" aria-label="Default button group">
                    <button type="button" class="sortby btn btn-success active ">Popularity</button>
                    <button type="button" class="sortby btn btn-success ">Distance</button>
                </div>
                <div id="places">

                </div>
            </div>
            <div id="json_container_prominence" style="color:red;"></div>
            <div id="json_container_distance" style="color:blue;">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <div id="placeres"></div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <div id="p_user_review">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Contact Me</h2>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                <form name="sentMessage" id="contactForm" novalidate>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Name" id="name" required
                                   data-validation-required-message="Please enter your name.">

                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Email Address</label>
                            <input type="email" class="form-control" placeholder="Email Address" id="email" required
                                   data-validation-required-message="Please enter your email address.">

                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Phone Number</label>
                            <input type="tel" class="form-control" placeholder="Phone Number" id="phone" required
                                   data-validation-required-message="Please enter your phone number.">

                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Message</label>
                            <textarea rows="5" class="form-control" placeholder="Message" id="message" required
                                      data-validation-required-message="Please enter a message."></textarea>

                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>

                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
<footer class="text-center">
    <div class="footer-above">
        <div class="container">
            <div class="row">
                <div class="footer-col col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a target="_blank" href="https://www.facebook.com/minatocompany"
                               class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                        </li>
                        <li>
                            <a target="_blank href="#" class="btn-social btn-outline"><i
                                class="fa fa-fw fa-google-plus"></i></a>
                        </li>
                        <li>
                            <a target="_blank href="#" class="btn-social btn-outline"><i
                                class="fa fa-fw fa-twitter"></i></a>
                        </li>
                        <li>
                            <a target="_blank href="#" class="btn-social btn-outline"><i
                                class="fa fa-fw fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 page-scroll">
                    <a href="#page-top"><strong><span class="foot-nom">foodhub&nbsp;</span></strong></a>Copyright &copy;
                    All rights reserved 2015
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Geo location   -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&libraries=geometry,places"></script>
<script src="js/h5utils.js"></script>
<script src="js/h5geo.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="js/classie.js"></script>
<script src="js/cbpAnimatedHeader.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.js"></script>
<script src="js/contact_me.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/freelancer.js"></script>
<script type="text/javascript" src="js/user.js"></script>
<script src="js/star-rating.js" type="text/javascript"></script>

<script type='text/javascript' src="js/bootstrap-slider.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#rating-input').rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'sm',
            showClear: false
        });

        $('#rating-input').on('rating.change', function () {

        });
    });
</script>

</body>
</html>