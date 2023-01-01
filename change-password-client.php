<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

    if(isset($_POST['submit'])){
        $uid=$_SESSION['hbmsuid'];
        $cpassword=md5($_POST['currentpassword']);
        $newpassword=md5($_POST['newpassword']);
        $sql ="SELECT ID FROM hrs_tbluser WHERE ID='$uid' and Password='$cpassword'";

        if($rs=$conn->query($sql)){
            if($rs->num_rows>0){
                $con="update hrs_tbluser set Password='$newpassword' where ID='$uid'";
                if($rs=$conn->query($con)){
                    echo '<script>alert("Your password successully changed")</script>';
                }
            }else {
                echo '<script>alert("Your current password is wrong")</script>';
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
    <title>Change Password - Rastatel</title>
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
    <script type="text/javascript">
    function checkpass() {
        if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
            alert('New Password and Confirm Password field does not match');
            document.changepassword.confirmpassword.focus();
            return false;
        }
        return true;
    }
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
            <div class="container" style="padding: 0px 300px 0px 300px;">

                <h2>Change Password</h2>

                <div class="contact-grids">

                    <div class="col-md-12 contact-right">
                        <form style="margin: 20px;" method="post" onsubmit="return checkpass();" name="changepassword">

                            <h5>Current Password</h5>
                            <input type="password" class="form-control" style="font-size: 20px" required="true"
                                name="currentpassword">
                            <h5>New Password</h5>
                            <input type="password" class="form-control" required="true" name="newpassword"
                                style="font-size: 20px">
                            <h5>Confirm Password</h5>
                            <input type="password" class="form-control" required="true" name="confirmpassword"
                                style="font-size: 20px">

                            <br />

                            <br />
                            <input type="submit" value="Change" name="submit">
                        </form>

                    </div>
                    <div class="col-md-6 contact-right">

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    </div>


</html>