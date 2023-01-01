<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit'])){
    $fname=$_POST['fname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    $password=md5($_POST['password']);
    $confirmpassword=md5($_POST['confirmpassword']);
    $ret="select Email from hrs_tbluser where Email='$email'";

    $_SESSION['fname']=$fname;
    $_SESSION['mobno']=$mobno;
    $_SESSION['email']=$email;
    $_SESSION['gender']=$gender;
    $_SESSION['password']=$password;
    
    if($rs=$conn->query($ret)){
        if($rs->num_rows == 0){
            if($password == $confirmpassword){
                    // OTP
                    $otp = rand(100000,999999);
                    $_SESSION['otp'] = $otp;
                    $_SESSION['mail'] = $email;
                    include('otpmail.php');
                    
                    ?>
                        <script>
                            alert("<?php echo "Please check your email to verify your account, The verification code sent to " . $email ?>");
                            window.location.replace('verification.php');
                        </script>
                        <?php
                    
                
            }else{
                echo "<script>alert('Password and Confirm Password didn't match. Try again');</script>";
            }
        }else{
            echo "<script>alert('Email-id already exist. Please try again');</script>";
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
    <title>Sign Up - Rastatel</title>
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
        
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
    </style>

</head>

<body>
    <!--about-->
<div class="bg">
    <div class="content">
        <div class="contact">
            <div class="signup-container" style="background-color: white; border-radius: 10px;">
                <div class="home-icon-div">
                    <!--Home Icon-->
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" position= "absolute"
    top= "3%" left=  "2%">
                    <a href = "index.php">
                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
                    </a>
                </svg>
                </div>
    

                <h2>Sign Up</h2>

                <div class="contact-grids" style="display: flex; justify-content: center; align-items: center;">
                    <div class="col-md-6 contact-right">
                        <form method="post">
                            <h5>Full Name</h5>
                            <input type="text" value="" name="fname" required="true" class="form-control">
                            <h5>Mobile Number</h5>
                            <input type="number" name="mobno" class="form-control" required="true" maxlength="11"
                                pattern="[0-9]+">
                            <h5>Email Address</h5>
                            <input type="email" class="form-control" value="" name="email" required="true">
                            <h5>Gender</h5>
                            <span style="text-align: left; padding-left: 20px;"> <input type="radio" name="gender" id="gender" value="Male"> Male</span>
                            <span style="text-align: left; padding-left: 20px;"> <input type="radio" name="gender" id="gender" value="Female"> Female</span>
                            <br />
                            <h5>Password</h5>
                            <input type="password" value="" class="form-control" name="password" required="true">
                            <h5>Confirm Password</h5>
                            <input type="password" value="" class="form-control" name="confirmpassword" required="true">
                            <br />
                            <div style = "display: flex; align-items: center; justify-content: center">
                            <span><input type="checkbox" name="agreeterms"> By signing up, you agree to our terms and conditions.</span>
                            </div>
                            <br />
                            <input type="submit" value="Sign Up" name="submit" style="border-radius: 5px;">
                            <br />
                            <div style = "display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                            <p>Already have an account? </p><a href="signin.php" style="color: blue;">&nbsp;Log In</a>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php //include_once('includes/getintouch.php');?>
    </div>
</div>
    <?php //include_once('includes/footer.php');?>

</html>