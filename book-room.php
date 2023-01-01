<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
if (strlen($_SESSION['hbmsuid']==0)) {
    header('location:logout.php');
}else{

    if(isset($_POST['submit'])){
        $booknum=mt_rand(100000000, 999999999);
        $rid=intval($_GET['rmid']);
        $uid=$_SESSION['hbmsuid'];
        $idtype=$_POST['idtype'];
        $gender=$_POST['gender'];
        $checkindate=$_POST['checkindate'];
        $checkoutdate=$_POST['checkoutdate'];
        $arrivaltime=$_POST['arrivaltime'];
    
        $cdate=date('Y-m-d');
        if($checkindate <  $cdate){
            echo '<script>alert("Check in date must be greater than current date")</script>';
        } else if($checkindate > $checkoutdate){
            echo '<script>alert("Check out date must be equal to / greater than  check in date")</script>';	
        } else {
            $sql="insert into hrs_tblbooking(RoomId,BookingNumber,UserID,IDType,Gender,CheckinDate,CheckoutDate,ArrivalTime)values('$rid','$booknum','$uid','$idtype','$gender','$checkindate','$checkoutdate','$arrivaltime')";
                if (mysqli_query($conn, $sql)) {
                $lastInsertId = mysqli_insert_id($conn);
                    if($lastInsertId > 0){
                        $emailsave = $_SESSION['login'];
                        $name = $row['FullName'];
                        include('testmail.php');
                        echo '<script>alert("Your room has been book successfully. Booking Number is "+"'.$booknum.' NOTE: This will sent to your email to confirm your booking from the hotel.")</script>';
                        echo "<script>window.location.href ='index.php'</script>";
                    }else{
                        echo '<script>alert("Something Went Wrong. Please try again")</script>';
                    }
                }else{
                    die("Error:".$conn->error);
                }
        }
    }
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Book Room - Rastatel</title>
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
    <div class="header head-top">
        <div class="container">
            <?php include_once('includes/header.php');?>
        </div>
    </div>
    <!--header-->
    <!--about-->

    <div class="content">
        <div class="contact">
            <div class="container">
                
                <h2>Book Your Room</h2>
                <div class="contact-grids">
                    
                    
                    
                    <div class="col-md-6 ">
                        <?php
                            $rid=intval($_GET['rmid']);
							$sql="SELECT * from  hrs_tblroom where ID='$rid'";

                            if($rs=$conn->query($sql)){
                                $cnt=1;
                                if($rs->num_rows>0){
                                    if($row=$rs->fetch_assoc()){
                            ?>
                                <h3 style="margin: 10px; font-size: x-large; margin: 20px;"><?php  echo $row['RoomName'];?></h3>
                                <a href="admin/images/<?php echo $row['Image'];?>" target="_blank"><img src="admin/images/<?php echo $row['Image'];?>" class=" mask img-responsive zoom-img" alt="" style="width: 1000px; margin: 50px;"/></a>
                                
                                <!-- slider -->
                            <div class="slider1" style="margin: 0px 0px 30px 70px;">
                                <div class="arrival-grids">
                                    <ul id="flexiselDemo1">
                                        <li>
                                            <a href="images/bathroom.png" target="_blank" style="cursor:pointer;"><img src="images/bathroom.png" alt="" />
                                            </a>
                                            <!--<a class="example-image-link" data-lightbox="example-set" data-title="" href="images/s1.jpg"><img src="images/s1.jpg" alt="" />-->
                                            <!--</a>-->
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
                                
                                <h3 style="margin: 10px; background-color: blue; border-radius: 30px; color: white; padding: 10px; width: 230px; text-align: center;">P <?php  echo $row['Price'];?> per night</h3>
                                <?php $cnt=$cnt+1;
                                    }
                                }
                            }
                            else{
                                die("Error:".$conn->error);
                            } ?>
                            <div style="margin-top: 40px;">
                            <h3>Amenities</h3>
                                <ul style="margin-left: 30px;"><br>
                                    <li>Free Wifi</li>
                                    <li>Swimming pool</li>
                                    <li>Parking</li>
                                    <li>Air conditioning</li>
                                    <li>24-hour front desk</li>
                                    <li>Gym Fitness Centre</li>
                                </ul>
                            </div>
                    </div>
                    <div class="col-md-5 m-4 contact-right" style="margin-left: 80px;">
                        <form method="post">
                            </select>
                            <?php
							$uid=$_SESSION['hbmsuid'];
							$checkin=$_SESSION['checkin'];
							$checkout=$_SESSION['checkout'];
							$sql="SELECT * from  hrs_tbluser where ID='$uid'";

                            if($rs=$conn->query($sql)){
                                $cnt=1;
                                if($rs->num_rows>0){
                                    while($row=$rs->fetch_assoc()){
                                                        ?>
                            <!--<h5>Name</h5>-->
                            <input type="hidden" value="<?php  echo $row['FullName'];?>" name="name" class="form-control"
                                required="true" readonly="true">
                            <!--<h5>Mobile Number</h5>-->
                            <input type="hidden" name="phone" class="form-control" required="true" maxlength="10"
                                pattern="[0-9]+" value="<?php  echo $row['MobileNumber'];?>" readonly="true">
                            <!--<h5>Email Address</h5>-->
                            <input type="hidden" value="<?php  echo $row['Email'];?>" class="form-control" name="email"
                                required="true" readonly="true">
                            <!--<h5>Gender</h5>-->
                            <input type="hidden" value="<?php  echo $row['Gender'];?>" class="form-control" name="gender" 
                                required="true" readonly="true">
                                    <?php $cnt=$cnt+1;
                                    }
                                }
                            }
                            else{
                                die("Error:".$conn->error);
                            } ?>
                            <div style="margin-top: 150px;">
                                <h5>ID Type</h5>
                                <select type="text" value="" class="form-control" name="idtype" required="true"
                                    class="form-control">
                                    <option value="">Choose ID Type</option>
                                    <option value="National ID">National ID</option>
                                    <option value="Voters ID">Voter's ID</option>
                                    <option value="Driving License Card">Driver's License</option>
                                    <option value="Passport">Passport</option>
                                    <option value="SSS ID">SSS ID</option>
                                    <option value="Philhealth ID">Philhealth ID</option>
                                    <option value="UMID ID">UMID ID</option>
                                    <option value="GSIS ID">GSIS ID</option>
                                    <option value="Senior Citizen ID">Senior Citizen ID</option>
                                </select>
    
                                <!--<h5>Address</h5>-->
                                <!--<textarea type="hidden" rows="10" name="address" required="true"></textarea>-->
                                
                                <h5>Check-in Date</h5>
                                <input type="date" value="<?php echo $checkin; ?>" class="form-control" name="checkindate" id="demo2" required="true">
                                <h5>Check-out Date</h5>
                                <input type="date" value="<?php echo $checkout; ?>" class="form-control" name="checkoutdate" id="demo3" required="true">
                                
                                <h5>Arrival Time</h5>
                                <input type="time" value="" class="form-control" name="arrivaltime" required="true">
                                <input style="margin-top: 20px;" type="submit" value="Book Now" name="submit">
                                
                                <!--Comments-->
                                <div style="margin: 10px;">
                                <h3 style="margin-top: 40px">Comments</h3>
                                    <div style="margin: 10px 0px 30px 0px;"><br>
                                        <ul>
                                            <li style="list-style: none; border: solid 1px gray; padding: 20px; margin-bottom: 20px; border-radius: 10px;">
                                                <div><h4 style="color: blue;">Fr***** S*******</h4></div>
                                                <div style="padding: 15px;">I had a wonderful experience at the (HN). Every staff member I encountered, from the valet to the check- in to the cleaning staff were delightful and eager to help! Thank you! Will recommend to my colleagues!</div>
                                            </li>
                                            <li style="list-style: none; border: solid 1px gray; padding: 20px; margin-bottom: 20px; border-radius: 10px;">
                                                <div><h4 style="color: blue;">A**** M********</h4></div>
                                                <div style="padding: 15px;">The best hotel I’ve ever been privileged enough to stay at. Gorgeous building, and it only gets more breathtaking when you walk in. High quality rooms (there was even a tv by the shower), and high quality service.</div>
                                            </li>
                                            <li style="list-style: none; border: solid 1px gray; padding: 20px; margin-bottom: 20px; border-radius: 10px;">
                                                <div><h4 style="color: blue;">J*** K***** A*****</h4></div>
                                                <div style="padding: 15px;">Everything was great at this hotel.. amazing staff that is friendly and makes customers feel welcome.</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
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
                                document.getElementById("demo2").setAttribute("min", maxDate);
                                console.log(maxDate);
                            </script>
                            
                            <script>
                                var todayDate = new Date();
                                var month = todayDate.getMonth() + 1;
                                var year = todayDate.getUTCFullYear() - 0;
                                var tdate = todayDate.getDate() + 1;
                                if (month < 10) {
                                    month = "0" + month;
                                }
                                if (tdate < 10) {
                                    tdate = "0" + tdate;
                                }
                                var maxDate = year + "-" + month + "-" + tdate;
                                document.getElementById("demo3").setAttribute("min", maxDate);
                                console.log(maxDate);
                            </script>
                        
                        
                        
                        
                        
                    
                    </div>
                    
                    
                    <div class="clearfix"></div>
                    
                    
                </div>
            </div>
        </div>
        <?php include_once('includes/getintouch.php');?>
    </div>
    <?php include_once('includes/footer.php');?>

</html><?php }  ?>