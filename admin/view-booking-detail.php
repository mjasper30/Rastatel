<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsaid']==0)) {
  header('location:logout.php');
}else{
    if(isset($_POST['submit'])){
        $bookingid=$_GET['bookingid'];
        $status=$_POST['status'];
        $remark=$_POST['remark'];
        $roomnumber=$_POST['roomnumber'];
        
        $getroomid="SELECT RoomId from hrs_tblbooking WHERE BookingNumber='$bookingid'";
        $getquantity = "SELECT hrs_tblroom.RoomQuantity FROM hrs_tblroom INNER JOIN hrs_tblbooking ON hrs_tblroom.RoomType=hrs_tblbooking.RoomId";
        if($rs=$conn->query($getroomid)){
            if($rs->num_rows>0){
                if($row=$rs->fetch_assoc()){
                    $id = $row['RoomId'];
                        if($rs1=$conn->query($getquantity)){
                            if($rs1->num_rows>0){
                                if($row1=$rs1->fetch_assoc()){
                                    
                                if($status == "Approved"){
                                    //$quantity = ($row1['RoomQuantity'] - 1);
                                
                                    $sql= "update hrs_tblbooking set Status='$status',Remark='$remark' where BookingNumber='$bookingid'";
                                    if($conn->query($sql)){
                                        echo '<script>alert("Remark has been updated")</script>';
                                        echo "<script>window.location.href ='new-booking.php'</script>";
                                    }
                                    else{
                                        die("Error:".$conn->error);
                                    }
                                    
                                }else if($status == "Check in"){
                                    $quantity = ($row1['RoomQuantity'] - 1);
                                
                                    $sql= "update hrs_tblbooking set Status='$status',Remark='$remark',RoomNumber='$roomnumber' where BookingNumber='$bookingid'";
                                    $sql1 = "update hrs_tblroom set RoomQuantity=$quantity WHERE ID = $id";
                                    $sql2 = "update hrs_tblroomnumber set Status='Not Available' WHERE ID = $id";
                                    if($conn->query($sql) && $conn->query($sql1) && $conn->query($sql2)){
                                        echo '<script>alert("Remark has been updated")</script>';
                                        echo "<script>window.location.href ='new-booking.php'</script>";
                                    }
                                    else{
                                        die("Error:".$conn->error);
                                    }
                                }else if($status == "Check out"){
                                    $quantity = ($row1['RoomQuantity'] + 1);
                                
                                    $sql= "update hrs_tblbooking set Status='$status',Remark='$remark' where BookingNumber='$bookingid'";
                                    $sql1 = "update hrs_tblroom set RoomQuantity=$quantity WHERE ID = $id";
                                    $sql2 = "update hrs_tblroomnumber set Status='Available' WHERE ID = $id";
                                    if($conn->query($sql) && $conn->query($sql1) && $conn->query($sql2)){
                                        echo '<script>alert("Remark has been updated")</script>';
                                        echo "<script>window.location.href ='new-booking.php'</script>";
                                    }
                                    else{
                                        die("Error:".$conn->error);
                                    }
                                }
                                
                                    
                                }
                            }
                        }
                    

                }
            }
        }
    }
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Rastatel | View Booking</title>
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

<body>
    <div class="page-container">
        <!--/content-inner-->
        <div class="left-content">
            <div class="inner-content">
                <!-- header-starts -->
                <?php include_once('includes/header.php');?>

                <!--content-->
                <div class="content">
                    <div class="women_main">
                        <!-- start content -->
                        <div class="grids">
                            <div class="progressbar-heading grids-heading">
                                <h2>View Booking</h2>
                            </div>
                            <div class="panel panel-widget forms-panel">
                                <div class="forms">
                                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                                        <div class="form-title">
                                            <h4>View Booking</h4>
                                        </div>
                                        <div class="form-body">
                                            <?php
                  
                                            $bookid=$_GET['bookingid'];

                                            $sql="SELECT hrs_tblbooking.BookingNumber,hrs_tbluser.FullName,hrs_tbluser.MobileNumber,hrs_tbluser.Email,hrs_tblbooking.IDType,hrs_tblbooking.Gender,hrs_tblbooking.ArrivalTime,hrs_tblbooking.CheckinDate,hrs_tblbooking.CheckoutDate,hrs_tblbooking.BookingDate,hrs_tblbooking.Remark,hrs_tblbooking.Status,hrs_tblbooking.UpdationDate,hrs_tblcategory.CategoryName,hrs_tblcategory.Description,hrs_tblcategory.Price,hrs_tblroom.RoomName,hrs_tblroom.MaxAdult,hrs_tblroom.MaxChild,hrs_tblroom.RoomDesc,hrs_tblroom.NoofBed,hrs_tblroom.Image,hrs_tblroom.RoomFacility 
                                            from hrs_tblbooking 
                                            join hrs_tblroom on hrs_tblbooking.RoomId=hrs_tblroom.ID 
                                            join hrs_tblcategory on hrs_tblcategory.ID=hrs_tblroom.RoomType 
                                            join hrs_tbluser on hrs_tblbooking.UserID=hrs_tbluser.ID  
                                            where hrs_tblbooking.BookingNumber='$bookid'";

                                            if($rs=$conn->query($sql)){
                                                $cnt=1;
                                                if($rs->num_rows>0){
                                                    if($row=$rs->fetch_assoc()){
                                                        ?>
                                            <table border="1"
                                                class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                                <tr>
                                                    <th colspan="4"
                                                        style="color: red;font-weight: bold;text-align: center;font-size: 20px">
                                                        Booking Number: <?php echo $row['BookingNumber'];?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4"
                                                        style="color: blue;font-weight: bold;font-size: 15px"> Booking
                                                        Detail:</th>
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
                                                    <th>Check in Date (yyyy/mm/dd)</th>
                                                    <td><?php  echo $row['CheckinDate'];?></td>
                                                    <th>Check out Date (yyyy/mm/dd)</th>
                                                    <td><?php  echo $row['CheckoutDate'];?></td>
                                                </tr>

                                                <tr>
                                                <tr>
                                                    <th colspan="4"
                                                        style="color: blue;font-weight: bold;font-size: 15px"> Room
                                                        Detail:</th>
                                                </tr>
                                                <th>Room Type</th>
                                                <td><?php  echo $row['CategoryName'];?></td>
                                                <th>Room Price(per night)</th>
                                                <td>₱<?php  echo $row['Price'];?></td>
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
                                                    <td><img src="images/<?php echo $row['Image'];?>" width="100"
                                                            height="100" value="<?php  echo $row['Image'];?>"></td>
                                                </tr>
                                                <tr>

                                                    <th>Room Facility</th>
                                                    <td><?php  echo $row['RoomFacility'];?></td>
                                                    <th>Booking Date (yyyy/mm/dd)|time</th>
                                                    <td><?php  echo $row['BookingDate'];?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4"
                                                        style="color: blue;font-weight: bold;font-size: 15px">
                                                        Remarks:</th>
                                                </tr>
                                                <tr>

                                                    <th>Order Final Status</th>

                                                    <td> <?php  $status=$row['Status'];
    
                                                    if($row['Status']=="Approved")
                                                    {
                                                    echo "Your Booking has been approved";
                                                    }

                                                    if($row['Status']=="Cancelled")
                                                    {
                                                    echo "Your Booking has been cancelled";
                                                    }


                                                    if($row['Status']=="")
                                                    {
                                                    echo "Not Response Yet";
                                                    }


                                                        ;?></td>
                                                    <th>Remark</th>
                                                    <?php if($row['Status']==""){ ?>

                                                    <td><?php echo "Not Updated Yet"; ?></td>
                                                    <?php } else { ?> <td><?php  echo $row['Status'];?>
                                                    </td>
                                                    <?php } ?>
                                                </tr>

                                                <?php $cnt=$cnt+1;
                                                    }
                                                }
                                            }
                                            else{
                                                die("Error:".$conn->error);
                                            } ?>

                                            </table>
                                            <?php 

                                            if ($status=="" || $status=="Approved" || $status=="Check in"){
                                            ?>
                                            <p align="center" style="padding-top: 20px">
                                                <button class="btn btn-primary waves-effect waves-light w-lg"
                                                    data-toggle="modal" data-target="#myModal" name="takeaction">Take Action</button>
                                            </p>

                                            <?php } ?>
                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Take
                                                                Action
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-bordered table-hover data-tables">
                                                                <form method="post" name="submit">


                                                                    <tr>
                                                                        <th>Remark :</th>
                                                                        <td>
                                                                            <textarea name="remark" placeholder="Remark"
                                                                                rows="12" cols="14"
                                                                                class="form-control wd-450"
                                                                                required="true"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <th>Room Number:</th>
                                                                        <td>
                                                                            <select name="roomnumber"
                                                                                class="form-control wd-450"
                                                                                required="true">
                                                                                <option value=""
                                                                                    selected="true">Select Room Number
                                                                                </option>
                                                                                
                                                                                <?php 
                                                                                $bookid=$_GET['bookingid'];

                                                                                $sql="SELECT hrs_tblbooking.BookingNumber,hrs_tbluser.FullName,hrs_tbluser.MobileNumber,hrs_tbluser.Email,hrs_tblbooking.IDType,hrs_tblbooking.Gender,hrs_tblbooking.ArrivalTime,hrs_tblbooking.CheckinDate,hrs_tblbooking.CheckoutDate,hrs_tblbooking.BookingDate,hrs_tblbooking.Remark,hrs_tblbooking.Status,hrs_tblbooking.UpdationDate,hrs_tblcategory.CategoryName,hrs_tblcategory.Description,hrs_tblcategory.Price,hrs_tblroom.RoomName,hrs_tblroom.MaxAdult,hrs_tblroom.MaxChild,hrs_tblroom.RoomDesc,hrs_tblroom.NoofBed,hrs_tblroom.Image,hrs_tblroom.RoomFacility 
                                                                                from hrs_tblbooking 
                                                                                join hrs_tblroom on hrs_tblbooking.RoomId=hrs_tblroom.ID 
                                                                                join hrs_tblcategory on hrs_tblcategory.ID=hrs_tblroom.RoomType 
                                                                                join hrs_tbluser on hrs_tblbooking.UserID=hrs_tbluser.ID  
                                                                                where hrs_tblbooking.BookingNumber='$bookid'";
                                                                                
                                                                                // $sql="SELECT hrs_tblroom.RoomName from hrs_tblroom join hrs_tblroomnumber on hrs_tblroom.RoomName=hrs_tblroomnumber.RoomName";
                                                                                    if($rs=$conn->query($sql)){
                                                                                        $cnt=1;
                                                                                        if($rs->num_rows>0){                            
                                                                                            while($row=$rs->fetch_assoc()){
                                                                                                $roomname = $row['RoomName'];
                                                                                                $sql2 = "SELECT RoomNumber from hrs_tblroomnumber WHERE Status='Available' && RoomName='$roomname'";
                                                                                                if($rs=$conn->query($sql2)){
                                                                                                    if($rs->num_rows>0){
                                                                                                        while($row=$rs->fetch_assoc()){
                                                                                                            ?>
                                                                                                        <option value="<?php echo $row['RoomNumber'];?>">
                                                                                                            <?php echo $row['RoomNumber'];?></option>
                                                                                                        <?php 
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                else{
                                                                                                    die("Error:".$conn->error);
                                                                                                }     
                                                                                            }
                                                                                            $cnt=$cnt+1;
                                                                                        }
                                                                                    }else{
                                                                                        die("Error:".$conn->error);
                                                                                    }
                
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Status :</th>
                                                                        <td>

                                                                            <select name="status"
                                                                                class="form-control wd-450"
                                                                                required="true">
                                                                                <option value=""
                                                                                    selected="true">Select Status
                                                                                </option>
                                                                                
                                                                                <?php 
                                                                                    $sql2 = "SELECT Status from hrs_tblbooking WHERE BookingNumber = '$bookid'";
                                                                                    if($rs=$conn->query($sql2)){
                                                                                        if($rs->num_rows>0){
                                                                                            if($row=$rs->fetch_assoc()){
                                                                                                
                                                                                                if($row['Status'] == "Approved"){
                                                                                                    ?>
                                                                                                    <option value="Check in">Check in
                                                                                                    </option>
                                                                                                    
                                                                                                    <?php
                                                                                                }else if($row['Status'] == ""){
                                                                                                    ?>
                                                                                                    <option value="Approved">Approved
                                                                                                    </option>
                                                                                                    <option value="Cancelled">Cancelled
                                                                                                    </option>
                                                                                                    <?php
                                                                                                }else if($row['Status'] == "Check in"){
                                                                                                    ?>
                                                                                                    <option value="Check out">Check out
                                                                                                    </option>
                                                                                                    
                                                                                                    <?php
                                                                                                }
                                                                                                
                                                                                                
                                                    
    
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" name="submit"
                                                                class="btn btn-primary">Update</button>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- end content -->

                                        <?php include_once('includes/footer.php');?>
                                    </div>

                                </div>
                                <!--content-->
                            </div>
                        </div>
                        <!--//content-inner-->
                        <!--/sidebar-menu-->
                        <?php include_once('includes/sidebar.php');?>
                        <div class="clearfix"></div>
                    </div>
                    <script>
                    var toggle = true;

                    $(".sidebar-icon").click(function() {
                        if (toggle) {
                            $(".page-container").addClass("sidebar-collapsed").removeClass(
                                "sidebar-collapsed-back");
                            $("#menu span").css({
                                "position": "absolute"
                            });
                        } else {
                            $(".page-container").removeClass("sidebar-collapsed").addClass(
                                "sidebar-collapsed-back");
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

                    <script src="js/pages/be_tables_datatables.js"></script>
</body>

</html><?php }  ?>