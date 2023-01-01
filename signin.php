<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

    if(isset($_POST['login'])){
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $sql ="SELECT * FROM hrs_tbluser WHERE Email='$email' and Password='$password'";
        $sql1 ="SELECT * FROM hrs_tbladmin WHERE Email='$email' and Password='$password'";
        $sql2 ="SELECT * FROM hrs_tblstaff WHERE Email='$email' and Password='$password'";
        
        if($rs1=$conn->query($sql)){
            if($rs1->num_rows>0){
                if($row=$rs1->fetch_assoc()){
                    if($row['IsVerified'] == "Yes"){
                        if($rs=$conn->query($sql)){
                            if($rs->num_rows>0){
                                if($row=$rs->fetch_assoc()){
                                    $_SESSION['hbmsuid']=$row['ID'];
                                }
                                $_SESSION['login']=$_POST['email'];
                                echo "<script type='text/javascript'> document.location ='index.php'; </script>";
                            }
                            
                            
                        }else{
                            die("Error:".$conn->error);
                        }
                        
                        
                        
                    }else{
                        echo '<script>alert("Your account must be verified! Please check your email")</script>';
                        // OTP
                        $otp = rand(100000,999999);
                        $_SESSION['otp'] = $otp;
                        $_SESSION['mail'] = $email;
                        include('otpmail.php');
                        
                            ?>
                            <script>
                                window.location.replace('mustverified.php');
                            </script>
                            <?php

                    }
                    
                    
                }
            }if($rs=$conn->query($sql1)){
                                if($rs->num_rows>0){
                                    if($row=$rs->fetch_assoc()){
                                        $_SESSION['hbmsaid']=$row['ID'];
                                    }
                                    if(!empty($_POST["remember"])) {
                                        //COOKIES for username
                                        setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
                                        //COOKIES for password
                                        setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
                                    } else {
                                        if(isset($_COOKIE["user_login"])) {
                                            setcookie ("user_login","");
                                        if(isset($_COOKIE["userpassword"])) {
                                            setcookie ("userpassword","");
                                            }
                                        }
                                    }
                                    $_SESSION['login']=$_POST['username'];
                                    header("Location: admin/dashboard.php");
                                }if($rs=$conn->query($sql2)){
                                    if($rs->num_rows>0){
                                        if($row=$rs->fetch_assoc()){
                                            $_SESSION['hbmssid']=$row['ID'];
                                        }
                                        if(!empty($_POST["remember"])) {
                                            //COOKIES for username
                                            setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
                                            //COOKIES for password
                                            setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
                                        } else {
                                            if(isset($_COOKIE["user_login"])) {
                                                setcookie ("user_login","");
                                            if(isset($_COOKIE["userpassword"])) {
                                                setcookie ("userpassword","");
                                                }
                                            }
                                        }
                                        $_SESSION['login']=$_POST['username'];
                                        header("Location: staff/dashboard.php");
                                    }else{
                                        echo '<script>alert("Email or Password is incorrect!")</script>';
                                    }
                                }else{
                                    die("Error:".$conn->error);
                                } 
                            }else{
                                die("Error:".$conn->error);
                            } 
        }
        
        // dsadsa
                            

        
    }

?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Login Page - Rastatel</title>
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
    </style>

</head>

<body>
    <div class="bg">
        <div class="content">
            <div class="logincontainer" style="background-color: white; border-radius: 10px;">
                <div class="tooltip">Hover over me
                <span class="tooltiptext">Click </span>
                </div>
                <div class="login-container">
                    <a href="index.php">
                        <div class = "logodiv">
                            <img src = images/favicon.ico>
                            <h2 style="padding-left: 10px; font-size: 60px;" title="Click here to go back Home">Rastatel</h2>
                        </div>
                    </a>
                    
                    <div class="contact-grids">
                        <div class="col-md-4 contact-right">
                            <form method="post">
                                <h5>Email Address</h5>
                                <input type="email" class="form-control" value="" name="email" required="true">
                                <h5>Password</h5>
                                <input type="password" value="" class="form-control" name="password" required="true">
                                <br />
                                <input type="submit" value="Login" name="login" style="border-radius: 5px;">
                                <br />
                                <div style="margin-top: 20px;"><a href="forgot-password.php">Forgot your password?</a></div>
                            </form>
    
                    </div>
                <center>
                    <div class="clearfix"></div>
                </center>
            </div>
        </div>
    </div>
</html>