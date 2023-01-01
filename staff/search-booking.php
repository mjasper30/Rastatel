<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmssid']==0)) {
  header('location:logout.php');
  } else{
  
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Rastatel | All Booking</title>
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

                            <div class="panel panel-widget forms-panel">
                                <div class="forms">
                                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                                        <div class="form-title">
                                            <h4>Search Booking</h4>
                                        </div>
                                        <form id="basic-form" method="post">
                                            <div class="form-group" style="padding-top: 20px">
                                                <label style="font-size: 20px;padding-bottom: 10px">Search
                                                    Booking</label>
                                                <input style="width: 250px;" id="searchdata" type="text" name="searchdata" required="true"
                                                    class="form-control" placeholder="Enter Your Booking Number">
                                            </div>

                                            <br>
                                            <button type="submit" class="btn btn-primary" name="search"
                                                id="submit">Search</button>
                                        </form>
                                        <div class="form-body">
                                            <?php
                                            if(isset($_POST['search']))
                                            { 

                                            $sdata=$_POST['searchdata'];
                                            ?>
                                            <h4 align="center">Result against "<?php echo $sdata;?>" keyword </h4>
                                            <table
                                                class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S.No</th>
                                                        <th>Booking Number</th>
                                                        <th>Name</th>
                                                        <th class="d-none d-sm-table-cell">Email</th>
                                                        <th class="d-none d-sm-table-cell">Mobile Number</th>
                                                        <th class="d-none d-sm-table-cell">Booking Date</th>
                                                        <th class="d-none d-sm-table-cell">Status</th>
                                                        <th class="d-none d-sm-table-cell" style="width: 15%;">Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_GET['pageno'])) {
                                                        $pageno = $_GET['pageno'];
                                                    } else {
                                                        $pageno = 1;
                                                    }
                                                    // Formula for pagination
                                                    $no_of_records_per_page = 3;
                                                    $offset = ($pageno-1) * $no_of_records_per_page;
                                                    $ret = "SELECT ID FROM hrs_tblbooking";
                                                    $result = mysqli_query($conn, $ret);
                                                    mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                    $total_rows=$result->num_rows;
                                                    $total_pages = ceil($total_rows / $no_of_records_per_page);

                                                    $sql="SELECT hrs_tbluser.*,hrs_tblbooking.BookingNumber,hrs_tblbooking.ID,hrs_tblbooking.Status,hrs_tblbooking.BookingDate from hrs_tblbooking join hrs_tbluser on hrs_tblbooking.UserID=hrs_tbluser.ID where hrs_tblbooking.BookingNumber like '$sdata%' LIMIT $offset, $no_of_records_per_page";
                                                    
                                                    if($rs=$conn->query($sql)){
                                                        $cnt=1;
                                                        if($rs->num_rows>0){
                                                                if($row=$rs->fetch_assoc()){
                                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $cnt;?></td>
                                                        <td class="font-w600">
                                                            <?php  echo $row['BookingNumber'];?></td>
                                                        <td class="font-w600">
                                                            <?php  echo $row['FullName'];?></td>
                                                        <td class="d-none d-sm-table-cell">
                                                            <?php  echo $row['Email'];?></td>
                                                        <td class="d-none d-sm-table-cell">
                                                            <?php  echo $row['MobileNumber'];?></td>

                                                        <td class="d-none d-sm-table-cell">
                                                            <span
                                                                class="badge badge-primary"><?php  echo $row['BookingDate'];?></span>
                                                        </td>
                                                        <?php if($row['Status']==""){ ?>

                                                        <td class="font-w600"><?php echo "Not Updated Yet"; ?></td>
                                                        <?php } else { ?>
                                                        <td class="d-none d-sm-table-cell">
                                                            <span
                                                                class="badge badge-primary"><?php  echo $row['Status'];?></span>
                                                        </td>
                                                        <?php } ?>
                                                        <td class="d-none d-sm-table-cell"><a
                                                                href="view-booking-detail.php?=&&bookingid=<?php echo $row['BookingNumber'];?>"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i></a></td>
                                                    </tr>



                                                </tbody>
                                            </table>
                                            <div align="left">
                                                <ul class="pagination">
                                                    <li><a href="?pageno=1"><strong>First</strong></a></li>
                                                    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                                        <a
                                                            href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong
                                                                style="padding-left: 10px">Prev</strong></a>
                                                    </li>
                                                    <li
                                                        class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                                        <a
                                                            href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong
                                                                style="padding-left: 10px">Next</strong></a>
                                                    </li>
                                                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong
                                                                style="padding-left: 10px">Last</strong></a></li>
                                                </ul>
                                            </div>
                                            <?php 
                                                $cnt=$cnt+1;
                                                                }
                                                            }else { ?>
                                            <tr>
                                                <td colspan="8"> No record found against this search</td>
                                            </tr>
                                            <?php }
                                                        }
                                                        else{
                                                            die("Error:".$conn->error);
                                                        }  }?>
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

    <script src="js/pages/be_tables_datatables.js"></script>
</body>

</html><?php }  ?>