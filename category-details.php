<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Rooms - Rastatel</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="css/lightbox.css">

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
    <div class="header head-top">
        <div class="container">
            <?php include_once('includes/header.php');?>
        </div>
    </div>
    <!--header-->
    <!--rooms-->
    <div class="content">
        <div class="room-section">
            <div class="container">
                <h2>Rooms Details</h2>
                <div class="room-grids">
                    <?php
						$cid=intval($_GET['catid']);
						$aid=$_GET['aid'];
                        $sql="SELECT hrs_tblroom.*,hrs_tblroom.id as rmid , hrs_tblcategory.Price,hrs_tblcategory.ID,hrs_tblcategory.CategoryName from hrs_tblroom 
                        join hrs_tblcategory on hrs_tblroom.RoomType=hrs_tblcategory.ID 
                        where hrs_tblroom.RoomType='$cid' || hrs_tblroom.Availability='$aid'";

                        if($rs=$conn->query($sql)){
                            $cnt=1;
                            if($rs->num_rows>0){
                                while($row=$rs->fetch_assoc()){
                                    if($row['Availability'] == "Available" && $row['RoomQuantity'] > 0){?>
                    <div class="room1"
                        style="border: 1px solid black; border-radius: 30px; padding: 50px; margin-bottom: 40px;">
                        <div class="col-md-5 room-grid" style="padding-bottom: 50px">
                            <a class="mask" href="admin/images/<?php echo $row['Image'];?>" target="_blank">
                                <img src="admin/images/<?php echo $row['Image'];?>"
                                    class=" mask img-responsive zoom-img" alt="" /></a>

                        <!-- slider -->
                            <div class="slider1" style="margin-top: 20px;">
                                <div class="arrival-grids">
                                    <ul id="flexiselDemo1">
                                        <li>
                                            <a href="images/bathroom.png" target="_blank"><img src="images/bathroom.png" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="images/s2.jpg" target="_blank"><img src="images/s2.jpg" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="images/s3.jpg" target="_blank"><img src="images/s3.jpg" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="images/s4.jpg" target="_blank"><img src="images/s4.jpg" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="images/s5.jpg" target="_blank"><img src="images/s5.jpg" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="images/s6.jpg" target="_blank"><img src="images/s6.jpg" alt="" />
                                            </a>
                                        </li>
                                    </ul>
                                    <script type="text/javascript">
                                    $(window).load(function() {
                                        $("#flexiselDemo1").flexisel({
                                            visibleItems: 2,
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
                        </div>
                        <div class="col-md-7 room-grid1">
                            <h4 style="color: blue;"> <?php  echo $row['RoomName'];?> </h4>
                            <p><?php  echo $row['RoomDesc'];?></p>
                            <p>Max Adult:<?php  echo $row['MaxAdult'];?></p>
                            <p>Max Child:<?php  echo $row['MaxChild'];?></p>
                            <p>No of Beds:<?php  echo $row['NoofBed'];?></p>
                            <p>Room Facilities:<?php  echo $row['RoomFacility'];?></p>
                            <p>Price: P <?php  echo $row['Price'];?></p>
                            <button class="btn btn-success" style="background-color: #002E94; margin-top: 20px;"><a
                                    href="book-room.php?rmid=<?php echo $row['rmid'];?>" style="color: white; text-decoration:none;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
  <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
</svg> Book Now</a></button>
                        </div>

                        <div class="clearfix"></div>
                    </div><?php $cnt=$cnt+1;
                                    }
                                }
                            }
                        }
                        else{
                            die("Error:".$conn->error);
                        } ?>
                    <div class="clearfix"></div>
                </div>
                <!--<script src="js/lightbox-plus-jquery.min.js"></script>-->
            </div>
        </div>
        <!--rooms-->
        <?php include_once('includes/getintouch.php');?>
    </div>
    <!--footer-->
    <?php include_once('includes/footer.php');?>
</body>

</html>