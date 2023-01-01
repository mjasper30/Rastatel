<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $uid=$_SESSION['hbmsuid'];
    $email=$_POST['email'];
    $sql ="SELECT Email FROM hrs_tbluser WHERE Email='$email'";
    
    if($rs=$conn->query($sql)){
        if($rs->num_rows>0){
            $_SESSION['email'] = $email;
            $otp = rand(100000,999999);
            $_SESSION['otp'] = $otp;
            include('resetmail.php');
            
            ?>
                <script>
                    alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                    window.location.replace('verificationpass.php');
                </script>
            <?php
            
            echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
        }else {
            echo "<script>alert('Email is invalid. Please make sure that email is registered');</script>"; 
        }
    }else{
        die("Error:".$conn->error);
    } 
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Forgot Password - Rastatel</title>
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
                    <h2>Forgot &nbsp;Password</h2>

                    <div class="contact-grids">

                        <div class="col-md-12">
                            <form method="post">
                                
                                <div style="margin: auto; width: 50%;">
                                    <h5 style="padding: 40px 0 10px;">Email</h5>
                                    <input type="email" placeholder="Email" class="form-control" value="" name="email"
                                    required="true">
                                <!--<h5>Mobile Number</h5>-->
                                <!--<input type="text" placeholder="Mobile Number" class="form-control" name="mobile"-->
                                <!--    required="true">-->
                                <!--<h5>New Password</h5>-->
                                <!--<input type="password" placeholder="New Password" name="newpassword" required="true"-->
                                <!--    class="form-control">-->
                                <!--<h5>Confirm Password</h5>-->
                                <!--<input type="password" placeholder="Confirm Password" name="confirmpassword" required="true"-->
                                <!--    class="form-control">-->
                                    <br />
                                    <input class="btn btn-warning" type="submit" name="submit" value="Reset">
                                    <br />
                                    <br />
                                    <br />
                                    <a href="signin.php" style="color: black">Back to Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

</html>