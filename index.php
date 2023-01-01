<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Home - Rastatel</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <script type="application/x-javascript">
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
        window.scrollTo(0, 1);
    }
    </script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/responsiveslides.min.js"></script>
    <script>
    $(function() {
        $("#slider").responsiveSlides({
            auto: true,
            nav: true,
            speed: 500,
            namespace: "callbacks",
            pager: true,
        });
    });
    </script>

</head>

<body>
    <!--header-->
    <div class="header">
        <div class="container">
            <?php include_once('includes/header.php');?>
            <div class="slider">
                <div class="callbacks_container">
                    <ul class="rslides" id="slider">
                        <li>
                            <h3><span>Come, stay and enjoy your day.</span></h3>
                        </li>
                        <li>
                            <h3><span>The most memorable rest time starts here.</span></h3>
                        </li>
                        <li>
                            <h3><span>Explore your destination with us.</span></h3>
                        </li>
                        <li>
                            <h3><span>Rest well, sleep well.</span></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--header-->
    
    <?php
        if(isset($_POST['submit'])){
            $checkin = $_SESSION['checkin'];
            $checkout = $_SESSION['checkout'];
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
            header("location: available-rooms.php?aid=Available");
        }
    ?>

    <div class="container availability-form p-4" style="height: 100px; display: flex; align-items: center;">
        <form action="available-rooms.php?aid=Available" method="POST" style = "width: 100%; display: flex; justify-content: center;">
            <div class="col-lg-3">
                <label class="form-label" style="font-weight: 500; font-size: 18px;">Check-In</label>
                <input type="date" class="form-control shadow-none" id="checkin" name="checkin" required>
            </div>
            
            <div class="col-lg-3">
                <label class="form-label" style="font-weight: 500; font-size: 18px;">Check-Out</label>
                <input type="date" class="form-control shadow-none" id="checkout" name="checkout" required>
            </div>
            
            <div class="col-lg-2">
                <button type="submit" name="submit" class="btn btn-success text-white shadow-none" style="margin-top: 30px; background-color: #002E94;">Check Available Rooms</button>
            </div>
        </form>
    </div>

    <script>
        var todayDate = new Date();
        var month = todayDate.getMonth() + 1;
        var year = todayDate.getUTCFullYear() - 0;
        var tdate = todayDate.getDate();
        if (month < 10) {
            month = "0" + month;
        }
        if (tdate < 10) {
            tdate = "0" + tdate;
        }
        var maxDate = year + "-" + month + "-" + tdate;
        document.getElementById("checkin").setAttribute("min", maxDate);
        console.log(maxDate);
    </script>
    
    <script>
        var todayDate1 = new Date();
        var month1 = todayDate1.getMonth() + 1;
        var year1 = todayDate1.getUTCFullYear() - 0;
        var tdate1 = todayDate1.getDate() + 1;
        if (month < 10) {
            month = "0" + month1;
        }
        if (tdate1 < 10) {
            tdate1 = "0" + tdate1;
        }
        var maxDate1 = year1 + "-" + month1 + "-" + tdate1;
        document.getElementById("checkout").setAttribute("min", maxDate1);
        console.log(maxDate1);
    </script>

    <div class="content">

        <div class="features">
            <div class="container">
                <h3>Rooms</h3>
                <div class="features-grids">
                    <?php
                    $sql="SELECT * from hrs_tblfacility order by rand() limit 4";

                    if($rs=$conn->query($ret)){
                        $cnt=1;
                        if($rs->num_rows>0){
                            while($row=$rs->fetch_assoc()){
                                ?>
                    <div class="col-md-6 feature-grid">
                        <div class="feature" style="border-radius: 20px; margin-bottom: 20px;">

                            <div class="feature1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-building-fill-check" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514Z"/>
  <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7.256A4.493 4.493 0 0 0 12.5 8a4.493 4.493 0 0 0-3.59 1.787A.498.498 0 0 0 9 9.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .39-.187A4.476 4.476 0 0 0 8.027 12H6.5a.5.5 0 0 0-.5.5V16H3a1 1 0 0 1-1-1V1Zm2 1.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5Zm3 0v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
</svg>
                                <h4><?php  echo $row['FacilityTitle'];?></h4>
                            </div>
                            <div class="feature2" style="height: 180px;">
                                <p><?php  echo $row['Description'];?>. </p>
                            </div>
                        </div>
                    </div>
                    <?php $cnt=$cnt+1;
                            }
                        }
                    }
                    else{
                        die("Error:".$conn->error);
                    } 
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- slider -->
        <div class="slider1">
            <div class="arrival-grids">
                <ul id="flexiselDemo1">
                    <li>
                        <a href="index.php"><img src="images/s1.jpg" alt="" />
                        </a>
                    </li>
                    <li>
                        <a href="index.php"><img src="images/s2.jpg" alt="" />
                        </a>
                    </li>
                    <li>
                        <a href="index.php"><img src="images/s3.jpg" alt="" />
                        </a>
                    </li>
                    <li>
                        <a href="index.php"><img src="images/s4.jpg" alt="" />
                        </a>
                    </li>
                    <li>
                        <a href="index.php"><img src="images/s5.jpg" alt="" />
                        </a>
                    </li>
                    <li>
                        <a href="index.php"><img src="images/s6.jpg" alt="" />
                        </a>
                    </li>
                </ul>
                <script type="text/javascript">
                $(window).load(function() {
                    $("#flexiselDemo1").flexisel({
                        visibleItems: 4,
                        animationSpeed: 1000,
                        autoPlay: true,
                        autoPlaySpeed: 3000,
                        pauseOnHover: true,
                        enableResponsiveBreakpoints: true,
                        responsiveBreakpoints: {
                            portrait: {
                                changePoint: 480,
                                visibleItems: 1
                            },
                            landscape: {
                                changePoint: 640,
                                visibleItems: 2
                            },
                            tablet: {
                                changePoint: 768,
                                visibleItems: 3
                            }
                        }
                    });
                });
                </script>
                <script type="text/javascript" src="js/jquery.flexisel.js"></script>
            </div>
        </div>
        <!-- //slider -->

        <!--GET IN TOUCH-->
        <?php include_once('includes/getintouch.php');?>
    </div>
    <!--footer-->
    <?php include_once('includes/footer.php');?>
</body>

</html>