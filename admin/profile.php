<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsaid']==0)) {
    header('location:logout.php');
} else{
    if(isset($_POST['submit'])){
        $adminid=$_SESSION['hbmsaid'];
        $AName=$_POST['adminname'];
        $mobno=$_POST['mobilenumber'];
        $email=$_POST['email'];
        $sql="update hrs_tbladmin set AdminName='$AName',MobileNumber='$mobno',Email='$email' where ID='$adminid'";
        
        if($rs=$conn->query($sql)){
            if($rs->num_rows>0){
                echo '<script>alert("Profile has been updated")</script>';
                echo "<script>window.location.href ='profile.php'</script>";
            }
        }else{
            die("Error:".$conn->error);
        }
    }
  ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Rastatel | Profile</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">

    <script type="application/x-javascript">
    addEventListener("load", () {
        setTimeout(hideURLbar, 0);
    }, false);

    hideURLbar() {
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
                                <h2>Admin Profile</h2>
                            </div>
                            <div class="panel panel-widget forms-panel">
                                <div class="forms">
                                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                                        <div class="form-title">
                                            <h4>Admin Profile :</h4>
                                        </div>
                                        <div class="form-body">
                                            <?php
                                            $sql="SELECT * from  hrs_tbladmin";
                                            if($rs=$conn->query($sql)){
                                                $cnt=1;
                                                if($rs->num_rows>0){
                                                    if($row=$rs->fetch_assoc()){
                                                        ?>
                                            <form method="post">
                                                <div class="form-group"> <label for="exampleInputEmail1">Admin
                                                        Name</label> <input type="text" class="form-control"
                                                        name="adminname" value="<?php  echo $row['AdminName'];?>"
                                                        required='true'> </div>
                                                <div class="form-group"> <label for="exampleInputEmail1">User
                                                        Name</label> <input type="text" class="form-control"
                                                        name="username" value="<?php  echo $row['UserName'];?>"
                                                        readonly="true"> </div>
                                                <div class="form-group"> <label for="exampleInputEmail1">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="<?php  echo $row['Email'];?>" required='true'>
                                                </div>
                                                <div class="form-group"> <label for="exampleInputEmail1">Contact
                                                        Number</label> <input type="text" class="form-control"
                                                        name="mobilenumber" value="<?php  echo $row['MobileNumber'];?>"
                                                        required='true' maxlength='10'> </div>
                                                <div class="form-group"> <label for="exampleInputEmail1">Admin
                                                        Registration Date</label> <input type="text"
                                                        class="form-control" id="email2" name=""
                                                        value="<?php  echo $row['AdminRegdate'];?>" readonly="true">
                                                </div>
                                                <?php $cnt=$cnt+1;
                                                    }
                                                }
                                            }
                                            else{
                                                die("Error:".$conn->error);
                                            } ?>
                                                <button type="submit" class="btn btn-default"
                                                    name="submit">Submit</button>
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
    <!--js -->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- /Bootstrap Core JavaScript -->
    <!-- real-time -->
    <script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>

    <!-- /real-time -->
    <script src="js/jquery.fn.gantt.js"></script>
    <script src="js/menu_jquery.js"></script>
</body>

</html><?php }  ?>