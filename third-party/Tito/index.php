
<!DOCTYPE html>

<?php
$mapsurl = "https://maps.googleapis.com/maps/api/js?key=".getenv('MAPSKEY')."&libraries=places&callback=initAutocomplete";
?>

<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Time Traffic overview by Vince</title>


        <!-- Bootstrap Core CSS -->
        <link href="./asset/css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="./asset/css/stylish-portfolio.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="./asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- css for tables -->
   <!--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->
		<!-- Ajout script Ajax -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="./asset/js/book.js"></script>

<script>
$(document).ready(function () {
    $("#read").click(function () {
            $.get("API_GW/read", function(data, status){
                    initCarsList(data,"#cars-list-container",{
                        idKey: 'name',
                        tableClass: "table custom-table",
                        buttonClass: "btn btn-default",
                        buttonClick: function (id){
                            var json = '{"name":"'+ id +'"}';
                            $.post("API_GW/book",'{"name":"'+ id +'"}');
                            }
                    })
            });
        }); 
});
</script>
		
    </head>

    <body>

	 <!-- Navigation
        <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
        <nav id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
                <li class="sidebar-brand">
                    <a href="#top" onclick=$("#menu-close").click();>Start Bootstrap</a>
                </li>
                <li>
                    <a href="#top" onclick=$("#menu-close").click();>Home</a>
                </li>
                <li>
                    <a href="#about" onclick=$("#menu-close").click();>About</a>
                </li>
                <li>
                    <a href="#services" onclick=$("#menu-close").click();>Services</a>
                </li>
                <li>
                    <a href="#portfolio" onclick=$("#menu-close").click();>Portfolio</a>
                </li>
                <li>
                    <a href="#contact" onclick=$("#menu-close").click();>Contact</a>
                </li>
            </ul>
        </nav>
        -->

        <!-- Header -->
        <header id="top" class="header">
            <div class="text-vertical-center">
                <h1>Tito</h1>
                <h3>Time Traffic Overview</h3>
                <h5>by Vince :)</h5>
                 <?PHP
                 echo "Runs on : " . gethostname() . " (" . getHostByName(getHostName()) .")";

                                 ?>
                <br>
                <br>
                <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
            </div>
        </header>

        <!-- About -->
        <section id="about" class="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Commuting every day?</h2>
                        <p class="lead">Let's take a moment to look at your commuting data</p>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>

        <!-- Services -->
        <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
        <section id="services" class="services bg-primary">
            <div class="container">
                <hr class="small">
                <form class="form-horizontal" role="form" action="index.php#titleResult" method="POST" id="form_result">
                    <div id="form_error">

                    </div>
                    <div class="row text-center">
                        <div class="col-lg-4 col-md-4 col-lg-offset-1 col-md-offset-1">
                            <div class="form-group">
                                <div class="service-item">
                                    <i class="fa fa-home fa-5x"></i>
                                    <h4>
                                        <strong>Home address</strong>
                                    </h4>
                                    <input type="text" class="form-control" id="home" name="home_addr" placeholder="Home Address" value="">
                                    <select name="home_time" class="select-date form-control">
                                        <?PHP
                                        $dateStart = new \DateTime();
                                        $dateStart->setTime(6, 0, 0);
                                        while ($dateStart->format("H") < 21) {
                                            echo "<option value='" . $dateStart->format("H:i") . "'>" . $dateStart->format("H:i") . "</option>";
                                            $dateStart->modify("+30 min");
                                        }
                                        ?>
                                    </select>
                                    <select name="home_range" class="select-date form-control">
                                        <?php
                                        for($i=0;$i<=60;$i+=10){
                                            echo '<option value="'.($i*60).'">+/- '.$i.'min</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-lg-offset-2 col-md-offset-2">
                            <div class="form-group">
                                <div class="service-item">
                                    <i class="fa fa-building fa-5x"></i>
                                    <h4>
                                        <strong>Work address</strong>
                                    </h4>
                                    <input type="text" class="form-control" id="work" name="work_addr" placeholder="Work Address" value="">
                                    <select name="work_time" class="select-date form-control">
                                        <?PHP
                                        $dateStart = new \DateTime();
                                        $dateStart->setTime(6, 0, 0);
                                        while ($dateStart->format("H") < 21) {
                                            echo "<option value='" . $dateStart->format("H:i") . "'>" . $dateStart->format("H:i") . "</option>";
                                            $dateStart->modify("+30 min");
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <input id="submit" name="submit" type="submit" value="Send" class="btn btn-default"> 
                        </div>
				</div>
                    <!-- /.container -->
                </form>
            </div>
        </section>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            include "form_result.php";
        }
        ?>
		<!--ajout bouton read -->
<div class="col-lg-12 col-md-12 read-car-list-container">
                            <input id="read" name="read" type="submit" value="Need a car?" class="btn btn-default btn-lg">
                        </div>
        <div id="cars-list-container"></div>
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center">
                        <h4><strong>Powered by PHP/Bootstrap/Javascript/SDDC</strong>
                        </h4>
                        VMware France
                        <ul class="list-unstyled">
                            <li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:name@example.com">vmeoc@vmware.com</a>
                            </li>
                        </ul>
                        <br>
                        <hr class="small">
                       <p class="text-muted">
                        <?PHP
                        echo "V2";
                        echo "<br>";
                        echo "Tito Front End: " . gethostname() . " (" . getHostByName(getHostName()) .")";
                        echo "<br>";
                        echo "Tito Back End: " . getenv('TITODBSERVER');
                        echo "<br>";
                        echo "<a href=\"db_dump.php\">db_dump";

                                ?>
                        </p>
                        <p class="text-muted">
                            <a href="API_GW/reset" target="_blank">Reset

                        </p>
                    </div>
                </div>
            </div>
            <a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
        </footer>

        <!-- jQuery -->
        <script src="./asset/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="./asset/js/bootstrap.min.js"></script>

        <!-- Parallax Core JavaScript -->
        <script src="./asset/js/parallax.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script>
            // Check the form inputs
            $('#form_result').submit(function(e){
                if($('#home').val() === "" || $('#work').val() === ""){
                    e.stopPropagation();
                    e.preventDefault();
                    $('#form_error').html("All fields are required");
                    return;
                }
            });
           /*
            $('#submit').click(function(e){
                console.log("home input: "+$('#home').val());
                console.log("work input: "+$('#work').val());
                if($('#home').val() === "" || $('#work').val() === ""){
                    e.stopPropagation();
                    e.preventDefault();
                    $('#form_error').html("All fields are required");
                    return;
                }
                console.log('submit form');
                $('#form_result').submit();
            });
            */

            // Closes the sidebar menu
            $("#menu-close").click(function (e) {
                e.preventDefault();
                $("#sidebar-wrapper").toggleClass("active");
            });
            // Opens the sidebar menu
            $("#menu-toggle").click(function (e) {
                e.preventDefault();
                $("#sidebar-wrapper").toggleClass("active");
            });
            // Scrolls to the selected menu item on the page
            $(function () {
                $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function () {
                    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            $('html,body').animate({
                                scrollTop: target.offset().top
                            }, 1000);
                            return false;
                        }
                    }
                });

                $('.stat-block').fadeIn(1000);

                //window.setTimeout("displayStatBlock()", 200);
            });

            /*
            var displayStatBlock = function () {
                var item = $('.stat-block:hidden:first');
                item.fadeIn('slow');
                window.setTimeout("displayStatBlock()", 200);
            };
            */

            //#to-top button appears after scrolling
            var fixed = false;
            /*
            $(document).scroll(function () {
                if ($(this).scrollTop() > 250) {
                    if (!fixed) {
                        fixed = true;
                        // $('#to-top').css({position:'fixed', display:'block'});
                        $('#to-top').show("slow", function () {
                            $('#to-top').css({
                                position: 'fixed',
                                display: 'block'
                            });
                        });
                    }
                } else {
                    if (fixed) {
                        fixed = false;
                        $('#to-top').hide("slow", function () {
                            $('#to-top').css({
                                display: 'none'
                            });
                        });
                    }
                }
            });
            */
            // Disable Google Maps scrolling
            // See http://stackoverflow.com/a/25904582/1607849
            // Disable scroll zooming and bind back the click event
            var onMapMouseleaveHandler = function (event) {
                var that = $(this);
                that.on('click', onMapClickHandler);
                that.off('mouseleave', onMapMouseleaveHandler);
                that.find('iframe').css("pointer-events", "none");
            }
            var onMapClickHandler = function (event) {
                var that = $(this);
                // Disable the click handler until the user leaves the map area
                that.off('click', onMapClickHandler);
                // Enable scrolling zoom
                that.find('iframe').css("pointer-events", "auto");
                // Handle the mouse leave event
                that.on('mouseleave', onMapMouseleaveHandler);
            }
            // Enable map zooming with mouse scroll when the user clicks the map
            $('.map').on('click', onMapClickHandler);
        </script>

        <!-- autocompletion des champs addresse avec Google -->
        <script>
            // This example displays an address form, using the autocomplete feature
            // of the Google Places API to help users fill in the information.

            // This example requires the Places library. Include the libraries=places
            // parameter when you first load the API. For example:
            //<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk&libraries=places">

            var placeSearch, autocomplete;


            function initAutocomplete() {
                // Create the autocomplete object, restricting the search to geographical
                // location types.
                autocomplete = new google.maps.places.Autocomplete(
                        /** @type {!HTMLInputElement} */(document.getElementById('home')),
                        {types: ['geocode']});
                autocomplete = new google.maps.places.Autocomplete(
                        /** @type {!HTMLInputElement} */(document.getElementById('work')),
                        {types: ['geocode']});


            }

            // Bias the autocomplete object to the user's geographical location,
            // as supplied by the browser's 'navigator.geolocation' object.
            function geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        autocomplete.setBounds(circle.getBounds());
                    });
                }
            }
        </script>

        <script src="<?php echo $mapsurl ?>" async defer></script>

    </body>

</html>
