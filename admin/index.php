<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsaid']==0)) {
        header('location: ../index.php');
}

if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID FROM hrs_tbladmin WHERE UserName='$username' and Password='$password'";

    if($rs=$conn->query($sql)){
	    if($rs->num_rows>0){
            while($row=$rs->fetch_assoc()){
                $_SESSION['hbmsaid']=$result['ID'];
            }
            if(!empty($_POST["remember"])) {
			    //COOKIES for username
			    setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
			    //COOKIES for password
			    setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
            }else{
                if(isset($_COOKIE["user_login"])) {
                    setcookie ("user_login","");
                    if(isset($_COOKIE["userpassword"])) {
                        setcookie ("userpassword","");
                    }
                }
            }
            $_SESSION['login']=$_POST['username'];
            echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
        }else{
		    echo "<script>alert('Invalid Details');</script>";
		}
    }
    else{
        die("Error:".$conn->error);
    } 
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Rastatel | Login</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">

    <script type="application/x-javascript">
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
        window.scrollTo(0, 1);
    }
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- Graph CSS -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
        type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <!-- lined-icons -->
    <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
    <script src="js/simpleCart.min.js"> </script>
    <script src="js/amcharts.js"></script>
    <script src="js/serial.js"></script>
    <script src="js/light.js"></script>
    <!-- //lined-icons -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <!--pie-chart--->
    <script src="js/pie-chart.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#demo-pie-1').pieChart({
            barColor: '#3bb2d0',
            trackColor: '#eee',
            lineCap: 'round',
            lineWidth: 8,
            onStep: function(from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });

        $('#demo-pie-2').pieChart({
            barColor: '#fbb03b',
            trackColor: '#eee',
            lineCap: 'butt',
            lineWidth: 8,
            onStep: function(from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });

        $('#demo-pie-3').pieChart({
            barColor: '#ed6498',
            trackColor: '#eee',
            lineCap: 'square',
            lineWidth: 8,
            onStep: function(from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });


    });
    </script>
</head>

<body
    style="background: url('images/hotel.jpg') no-repeat center center fixed; background-size: cover; height: 100%; overflow: hidden;">
    <p style="padding-top: 20px;padding-left: 20px"><a href="../index.php"><i class="fa fa-home" aria-hidden="true"
                style="font-size: 30px;padding-right: 10px;"></i></a></p>

    <center>
        <div class="container" style="display: flex; justify-content: center; align-items: center;">
            <div class=" content" style="display: flex;
  justify-content: center;
  align-items: center;">
                <div class="registration"
                    style="border: 3px solid black; width: 400px; background-color: #203354; border-radius: 10px;">
                    <img src="../images/rastatel_logo.png" alt="rastatel" height="180px" style="padding: 10px;">
                    <h1 style="color: white">Login</h1>
                    <div class="registration_form">
                        <!-- Form -->
                        <form method="post">
                            <div style="width: 300px;">
                                <label>
                                    <input placeholder="Username" type="text" required="true" name="username"
                                        style="border:solid #000 1px; border-radius: 5px;"
                                        value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>">
                                </label>
                            </div>
                            <div style="width: 300px;">
                                <label>
                                    <input placeholder="password" type="Password" name="password" required="true"
                                        style="border:solid #000 1px; border-radius: 5px;"
                                        value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                                </label>
                            </div>
                            <div class="checkbox checkbox-primary" style="padding-left: 10px">
                                <input type="checkbox" id="remember" name="remember" style="margin-left: -70px;"
                                    <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> />
                                <label for="keep_me_logged_in" style="color: white;">Remember Me</label>
                            </div>
                            <div>
                                <input type="submit" value="Login" name="login"
                                    style="background-color: #FFBF00; color: black;">
                            </div>
                            <div class="forget">
                                <a href="#">forgot your password</a>
                            </div>
                        </form>
                        <!-- /Form -->
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>


            <div class="clearfix"></div>
            
        </div>
    </center>
    <script>
    var toggle = true;

    $(".sidebar-icon").click(function() {
        if (toggle) {
            $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
            $("#menu span").css({
                "position": "absolute"
            });
        } else {
            $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
            setTimeout(function() {
                $("#menu span").css({
                    "position": "relative"
                });
            }, 400);
        }

        toggle = !toggle;
    });
    </script>
    <!--js -->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- /Bootstrap Core JavaScript -->
    <!-- real-time -->
    <script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>
    <script type="text/javascript">
    $(function() {

        // We use an inline data source in the example, usually data would
        // be fetched from a server

        var data = [],
            totalPoints = 300;

        function getRandomData() {

            if (data.length > 0)
                data = data.slice(1);

            // Do a random walk

            while (data.length < totalPoints) {

                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;

                if (y < 0) {
                    y = 0;
                } else if (y > 100) {
                    y = 100;
                }

                data.push(y);
            }

            // Zip the generated y values with the x values

            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }

            return res;
        }

        // Set up the control widget

        var updateInterval = 30;
        $("#updateInterval").val(updateInterval).change(function() {
            var v = $(this).val();
            if (v && !isNaN(+v)) {
                updateInterval = +v;
                if (updateInterval < 1) {
                    updateInterval = 1;
                } else if (updateInterval > 2000) {
                    updateInterval = 2000;
                }
                $(this).val("" + updateInterval);
            }
        });

        var plot = $.plot("#placeholder", [getRandomData()], {
            series: {
                shadowSize: 0 // Drawing is faster without shadows
            },
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                show: false
            }
        });

        function update() {

            plot.setData([getRandomData()]);

            // Since the axes don't change, we don't need to call plot.setupGrid()

            plot.draw();
            setTimeout(update, updateInterval);
        }

        update();

        // Add the Flot version string to the footer

        $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
    });
    </script>
    <!-- /real-time -->
    <script src="js/jquery.fn.gantt.js"></script>
    <script>
    $(function() {

        "use strict";

        $(".gantt").gantt({
            source: [{
                name: "Sprint 0",
                desc: "Analysis",
                values: [{
                    from: "/Date(1320192000000)/",
                    to: "/Date(1322401600000)/",
                    label: "Requirement Gathering",
                    customClass: "ganttRed"
                }]
            }, {
                name: " ",
                desc: "Scoping",
                values: [{
                    from: "/Date(1322611200000)/",
                    to: "/Date(1323302400000)/",
                    label: "Scoping",
                    customClass: "ganttRed"
                }]
            }, {
                name: "Sprint 1",
                desc: "Development",
                values: [{
                    from: "/Date(1323802400000)/",
                    to: "/Date(1325685200000)/",
                    label: "Development",
                    customClass: "ganttGreen"
                }]
            }, {
                name: " ",
                desc: "Showcasing",
                values: [{
                    from: "/Date(1325685200000)/",
                    to: "/Date(1325695200000)/",
                    label: "Showcasing",
                    customClass: "ganttBlue"
                }]
            }, {
                name: "Sprint 2",
                desc: "Development",
                values: [{
                    from: "/Date(1326785200000)/",
                    to: "/Date(1325785200000)/",
                    label: "Development",
                    customClass: "ganttGreen"
                }]
            }, {
                name: " ",
                desc: "Showcasing",
                values: [{
                    from: "/Date(1328785200000)/",
                    to: "/Date(1328905200000)/",
                    label: "Showcasing",
                    customClass: "ganttBlue"
                }]
            }, {
                name: "Release Stage",
                desc: "Training",
                values: [{
                    from: "/Date(1330011200000)/",
                    to: "/Date(1336611200000)/",
                    label: "Training",
                    customClass: "ganttOrange"
                }]
            }, {
                name: " ",
                desc: "Deployment",
                values: [{
                    from: "/Date(1336611200000)/",
                    to: "/Date(1338711200000)/",
                    label: "Deployment",
                    customClass: "ganttOrange"
                }]
            }, {
                name: " ",
                desc: "Warranty Period",
                values: [{
                    from: "/Date(1336611200000)/",
                    to: "/Date(1349711200000)/",
                    label: "Warranty Period",
                    customClass: "ganttOrange"
                }]
            }],
            navigate: "scroll",
            scale: "weeks",
            maxScale: "months",
            minScale: "days",
            itemsPerPage: 10,
            onItemClick: function(data) {
                alert("Item clicked - show some details");
            },
            onAddClick: function(dt, rowId) {
                alert("Empty space clicked - add an item!");
            },
            onRender: function() {
                if (window.console && typeof console.log === "function") {
                    console.log("chart rendered");
                }
            }
        });

        $(".gantt").popover({
            selector: ".bar",
            title: "I'm a popover",
            content: "And I'm the content of said popover.",
            trigger: "hover"
        });

        prettyPrint();

    });
    </script>
    <script src="js/menu_jquery.js"></script>
</body>

</html>