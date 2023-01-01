<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
if (strlen($_SESSION['hbmsuid']==0)) {
  header('location:logout.php');
  } else{
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>My Booking - Rastatel</title>
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
    <!-- typography -->
    <div class="typography">
        <!-- container-wrap -->
        <div class="container">
            <div class="typography-info">
                <h2 class="type">My Booking History</h2>
            </div>

            <div class="bs-docs-example">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booking Number</th>
                            <th>Room Name</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $uid= $_SESSION['hbmsuid'];
                        $sql="SELECT hrs_tblroom.*,hrs_tblbooking.BookingNumber,hrs_tblbooking.CheckinDate,hrs_tblbooking.CheckoutDate,hrs_tblbooking.Status,hrs_tblbooking.ID as bid from hrs_tblbooking join hrs_tblroom on hrs_tblbooking.UserID=hrs_tblroom.ID where UserID='$uid'";

                        if($rs=$conn->query($sql)){
                            $cnt=1;
                            if($rs->num_rows>0){
                                while($row=$rs->fetch_assoc()){
                                    ?>
                        <tr>
                            <td><?php echo $cnt;?></td>
                            <td><?php echo $row['BookingNumber'];?></td>
                            <td><?php echo $row['RoomName'];?></td>
                            <td><?php echo $row['CheckinDate'];?></td>
                            <td><?php echo $row['CheckoutDate'];?></td>

                            <?php 
                            if($row['Status']==""){ ?>
                            <td><?php echo "Still Pending"; ?></td>
                            <?php 
                            } else { ?>
                            <td><?php  echo $row['Status'];?></td>
                            <?php } ?>
                            <td><a href="view-application-detail.php?viewid=<?php echo $row['bid'];?>"
                                    class="btn btn-primary">View</a>
                            </td>
                        </tr>
                        <?php $cnt=$cnt+1;
                                }
                            }
                        }
                        else{
                            die("Error:".$conn->error);
                        } 
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- //container-wrap -->
    </div>
    <!-- //typography -->

    </div>
    <!--footer-->
</body>

</html><?php }  ?>