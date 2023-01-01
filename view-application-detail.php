<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsuid']==0)) {
    header('location:logout.php');
}else{
      
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>View Booking Detail - Rastatel</title>
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
                <h2>My Hotel Booking Detail</h2>
            </div>

            <div class="bs-docs-example">
                <?php
                  $vid=$_GET['viewid'];

                    $sql="SELECT hrs_tblbooking.BookingNumber,hrs_tbluser.FullName,hrs_tbluser.MobileNumber,hrs_tbluser.Email,hrs_tblbooking.ID as tid,hrs_tblbooking.IDType,hrs_tblbooking.Gender,hrs_tblbooking.ArrivalTime,hrs_tblbooking.CheckinDate,hrs_tblbooking.CheckoutDate,hrs_tblbooking.BookingDate,hrs_tblbooking.Remark,hrs_tblbooking.Status,hrs_tblbooking.UpdationDate,hrs_tblcategory.CategoryName,hrs_tblcategory.Description,hrs_tblcategory.Price,hrs_tblroom.RoomName,hrs_tblroom.MaxAdult,hrs_tblroom.MaxChild,hrs_tblroom.RoomDesc,hrs_tblroom.NoofBed,hrs_tblroom.Image,hrs_tblroom.RoomFacility 
                    from hrs_tblbooking 
                    join hrs_tblroom on hrs_tblbooking.RoomId=hrs_tblroom.ID 
                    join hrs_tblcategory on hrs_tblcategory.ID=hrs_tblroom.RoomType 
                    join hrs_tbluser on hrs_tblbooking.UserID=hrs_tbluser.ID  
                    where hrs_tblbooking.ID='$vid'";

                    if($rs=$conn->query($sql)){
                        $cnt=1;
                        if($rs->num_rows>0){// record checking
                            while ($row=$rs->fetch_assoc()) {
                                ?>
                <table border="1" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <tr>
                        <th colspan="4" style="color: red;font-weight: bold;text-align: center;font-size: 20px"> Booking
                            Number: <?php echo $row['BookingNumber'];?></th>
                    </tr>
                    <tr>
                        <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px"> Booking Detail:</th>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td><?php  echo $row['FullName'];?></td>
                        <th>Mobile Number</th>
                        <td><?php  echo $row['MobileNumber'];?></td>
                    </tr>


                    <tr>

                        <th>Email</th>
                        <td><?php  echo $row['Email'];?></td>
                        <th>ID Type</th>
                        <td><?php  echo $row['IDType'];?></td>
                    </tr>
                    <tr>

                        <th>Gender</th>
                        <td><?php  echo $row['Gender'];?></td>
                        <th>Arrival Time</th>
                        <td><?php  echo $row['ArrivalTime'];?></td>
                    </tr>
                    <tr>
                        <th>Check in Date <br> (yyyy/mm/dd)</th>
                        <td><?php  echo $row['CheckinDate'];?></td>
                        <th>Check out Date <br> (yyyy/mm/dd)</b></th>
                        <td><?php  echo $row['CheckoutDate'];?></td>
                    </tr>

                    <tr>
                    <tr>
                        <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px"> Room Detail:</th>
                    </tr>
                    <th>Room Type</th>
                    <td><?php  echo $row['CategoryName'];?></td>
                    <th>Room Price(perday)</th>
                    <td>P<?php  echo $row['Price'];?></td>
                    </tr>

                    <tr>

                        <th>Room Name</th>
                        <td><?php  echo $row['RoomName'];?></td>
                        <th>Room Description</th>
                        <td><?php  echo $row['RoomDesc'];?></td>
                    </tr>
                    <tr>

                        <th>Max Adult</th>
                        <td><?php  echo $row['MaxAdult'];?></td>
                        <th>Max Child</th>
                        <td><?php  echo $row['MaxChild'];?></td>
                    </tr>
                    <tr>

                        <th>No.of Bed</th>
                        <td><?php  echo $row['NoofBed'];?></td>
                        <th>Room Image</th>
                        <td><img src="admin/images/<?php echo $row['Image'];?>" width="100" height="100"
                                value="<?php  echo $row['Image'];?>"></td>
                    </tr>
                    <tr>

                        <th>Room Facility</th>
                        <td><?php  echo $row['RoomFacility'];?></td>
                        <th>Booking Date <br> (yyyy/mm/dd)|time</th>
                        <td><?php  echo $row['BookingDate'];?></td>
                    </tr>
                    <tr>
                        <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px">Remarks:</th>
                    </tr>
                    <tr>

                        <th>Order Final Status</th>

                        <td> <?php  $status=$row['Status'];
                        
                        if($row['Status']=="Approved"){
                            echo "Your Booking has been approved";
                        }

                        if($row['Status']=="Cancelled"){
                            echo "Your Booking has been cancelled";
                        }

                        if($row['Status']==""){
                            echo "Not Response Yet";
                        }

                        ?></td>
                        <th>Remark</th>
                        <?php if($row['Status']==""){ ?>

                        <td><?php echo "Not Updated Yet"; ?></td>
                        <?php } else { ?> <td><?php  echo $row['Status'];?>
                        </td>
                        <?php } ?>
                    </tr>
                </table>
                <a href="invoice.php?invid=<?php echo $row['tid'];?>" class="btn btn-warning" style="color: black;">Invoice</a>
                <?php $cnt=$cnt+1;}} ?>

                <?php
                            }
                    else{
                        die("Error:".$conn->error);
                    }
                ?>
            </div>

        </div>
        <!-- //container-wrap -->
    </div>
    <!-- //typography -->

    <?php include_once('includes/getintouch.php');?>
    </div>
    <!--footer-->
    <?php include_once('includes/footer.php');?>
</body>

</html><?php }  ?>