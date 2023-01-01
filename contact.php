<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);


if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $message=$_POST['message'];

    $sql="insert into hrs_tblcontact(Name,MobileNumber,Email,Message)values('$name','$phone','$email','$message')";

    if (mysqli_query($conn, $sql)) {
        $lastInsertId = mysqli_insert_id($conn);
        if($lastInsertId){
            echo "<script>alert('Your message was sent successfully!.');</script>";
            echo "<script>window.location.href ='contact.php'</script>";
        }else{
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }else{
        die("Error:".$conn->error);
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Contact Us - Rastatel</title>
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
    <!--about-->

    <div class="content">
        <div class="contact">
            <div class="container">
                <h2>contact us</h2><br><br>
                <div class="contact-grids">
                    <div class="col-md-6 contact-left">
                        <?php
                        $sql="SELECT * from hrs_tblpage where PageType='aboutus'";
                        if($rs=$conn->query($sql)){
                            $cnt=1;
                            if($rs->num_rows>0){
                                while($row=$rs->fetch_assoc()){ ?>
                        <p><?php echo $row['PageDescription']; ?>.</p><?php $cnt=$cnt+1;
                                }
                            }
                        }?>

                        <?php
                        $sql="SELECT * from hrs_tblpage where PageType='contactus'";
                        if($rs=$conn->query($sql)){  
                            if($rs->num_rows>0){
                                while($row=$rs->fetch_assoc()){ ?>
                        <address>
                            <p><?php echo $row['PageTitle'];?></p>
                            <p><?php echo $row['PageDescription'];?></p>

                            <p>Telephone : +<?php echo $row['MobileNumber'];?></p>

                            <p>E-mail : <?php echo $row['Email'];?></p>
                        </address><?php $cnt=$cnt+1;
                                }
                            }
                        }?>
                    </div>
                    <div class="col-md-6 contact-right">
                        <form method="post">
                            <h5>Name</h5>
                            <input type="text" type="text" value="" name="name" required="true">
                            <h5>Mobile Number</h5>
                            <input type="text" name="phone" required="true" maxlength="10" pattern="[0-9]+">
                            <h5>Email Address</h5>
                            <input type="text" type="email" value="" name="email" required="true">
                            <h5>Message</h5>
                            <textarea rows="10" name="message" required="true"></textarea>
                            <input type="submit" value="send" name="submit" style="border-radius: 5px;">
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php include_once('includes/getintouch.php');?>
    </div>
    <?php include_once('includes/footer.php');?>

</html>