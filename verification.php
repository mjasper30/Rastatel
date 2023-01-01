<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsuid']==1)) {
    header('location:logout.php');
} 
else{
    if(isset($_POST['submit'])){
        $otp = $_SESSION['otp'];
        $email = $_SESSION['mail'];
        $otp_code = $_POST['otp_code'];

        if($otp != $otp_code){
            ?>
           <script>
               alert("Invalid OTP code");
           </script>
           <?php
        }else{
            $isverified = 'Yes';
            $fname = $_SESSION['fname'];
            $mobno = $_SESSION['mobno'];
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
            $gender = $_SESSION['gender'];
            
            $sql="Insert Into hrs_tbluser(FullName,MobileNumber,Email,Gender,Password,IsVerified)Values('$fname','$mobno','$email','$gender','$password','$isverified')";
            if (mysqli_query($conn, $sql)) {
                 ?><script>
                       window.location.replace("signin.php");
                 </script><?php
            }else{
                echo "<script>alert('It has an error');</script>";
            }
            
        }

    }

?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Verify Account - Rastatel</title>
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
    function valid() {
        if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
            alert("New Password and Confirm Password Field do not match  !!");
            document.chngpwd.confirmpassword.focus();
            return false;
        }
        return true;
    }
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
                    <h2>Account &nbsp;Verification</h2>

                    <div class="contact-grids">

                        <div class="col-md-12">
                            <form method="post">
                                
                                <div style="margin: auto; width: 50%;">
                                    <h5 style="padding: 40px 0 10px;">Verification Code</h5>
                                    <input type="text" placeholder="Verification Code" class="form-control" value="" name="otp_code"
                                    required="true">
                                    <br />
                                    <input class="btn btn-warning" type="submit" value="Verify" name="submit">
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

</html><?php }  ?>