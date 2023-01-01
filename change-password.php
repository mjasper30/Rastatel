<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsuid']==1)) {
    header('location:logout.php');
}else{
    if(isset($_POST['submit'])){
        $email=$_SESSION['email'];
        $newpassword=md5($_POST['newpassword']);
        $cpassword=md5($_POST['confirmpassword']);
        $sql ="SELECT ID FROM hrs_tbluser WHERE Email='$email'";
        
        echo '<script>alert('. $email .')</script>';

        if($rs=$conn->query($sql)){
            if($rs->num_rows>0){
                if($newpassword == $cpassword){
                    $con="update hrs_tbluser set Password='$newpassword' where Email='$email'";
                    if($conn->query($con)){
                        echo '<script>alert("Your password successully changed")</script>';
                        echo "<script type='text/javascript'> document.location ='index.php'; </script>";
                    }
                }else{
                    echo '<script>alert("New Password and Confirm Password is not matched")</script>';
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
    
    <style>
        .logincontainer{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        
        body, html {
          height: 100%;
        }
        
        .bg {
          /* The image used */
          background-image: url("images/login-bg2.jpg");
        
          /* Full height */
          height: 100%;
        
          /* Center and scale the image nicely */
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
        }
        
        .forgotpassword-container {
            width: 700px;
            padding: 50px 20px 50px 20px;
            position: relative;
            border: 5px solid;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="bg">
        <div class="content">
            <div class="contact">
                <div class="logincontainer" style="background-color: white; border-radius: 10px;">
                    <div class="forgotpassword-container">

                <h2>Change Password</h2>

                <div class="contact-grids">

                    <div class="col-md-12" style="padding: 10px;">
                        <form method="post">
                            <div style="margin: auto; width: 50%;">
                            <h5 style="padding: 10px;">New Password</h5>
                            <input type="password" class="form-control" required="true" name="newpassword"
                                style="font-size: 20px">
                            <h5 style="padding: 10px;">Confirm Password</h5>
                            <input type="password" class="form-control" required="true" name="confirmpassword"
                                style="font-size: 20px">

                            <br />

                            <br />
                            <input class="btn btn-warning" type="submit" value="Change Password" name="submit">
                            </div>
                        </form>

                    </div>
                    <div class="col-md-6 contact-right">

                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html><?php }  ?>