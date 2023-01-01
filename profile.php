<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsuid']==0)) {
    header('location:logout.php');
} 
else{
    if(isset($_POST['submit'])){
        $uid=$_SESSION['hbmsuid'];
        $AName=$_POST['fname'];
        $mobno=$_POST['mobno'];
        $sql="update hrs_tbluser set FullName='$AName',MobileNumber='$mobno' where ID='$uid'";

        if($conn->query($sql)){
            echo '<script>alert("Profile has been updated")</script>';
        }else{
            die("Error:".$conn->error);
        }
    }
  ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Profile - Rastatel</title>
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

                <h2>Your Profile</h2>

                <div class="contact-grids">
                    <div class="col-md-4 contact-right" style="margin-top: 70px;">
                        <form method="post">
                            <?php
                            $uid=$_SESSION['hbmsuid'];
                            $sql="SELECT * from  hrs_tbluser where ID=$uid";
                            if($rs=$conn->query($sql)){
                                $cnt=1;
                                if($rs->num_rows>0){
                                    if($row=$rs->fetch_assoc()){
                                        ?>
                            <h5>Full Name</h5>
                            <input type="text" value="<?php echo $row['FullName'];?>" name="fname" required="true"
                                class="form-control">
                            <h5>Mobile Number</h5>
                            <input type="text" name="mobno" class="form-control" required="true" maxlength="10"
                                pattern="[0-9]+" value="<?php echo $row['MobileNumber'];?>">
                            <h5>Email Address</h5>
                            <input type="email" class="form-control" value="<?php  echo $row['Email'];?>" name="email"
                                required="true" readonly='true'>
                            <h5>Registration Date</h5>
                            <input type="text" value="<?php echo $row['RegDate'];?>" class="form-control"
                                name="password" readonly="true">
                            <br /><?php $cnt=$cnt+1;}}
                            }
                            else{
                                die("Error:".$conn->error);
                            } ?>
                            <br />
                            <input type="submit" value="Update" name="submit">
                        </form>
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <?php
                            $sql="SELECT ProfileImage from hrs_tbluser WHERE ID='$uid'";
                            if($rs=$conn->query($sql)){
                                if($rs->num_rows>0){
                                    if($row=$rs->fetch_assoc()){ 
                                        if($row['ProfileImage'] == NULL){
                                        ?>
                                            <img src="images/defaultprofile.jpg" style="width: 300px; height: 300px; border-radius: 50%; margin-top: 30px;" class="zoom-img">
                                        <?php
                                        
                                        }else{
                                        ?>
                                            <img src="images/<?php echo $row['ProfileImage']?>" style="width: 300px; height: 300px; border-radius: 50%; margin-top: 30px;" class="zoom-img">
                                        <?php
                                        }
                                    }
                                }
                            }
                        ?>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: center; margin-top: 40px;">
                        <form method="post" enctype="multipart/form-data">
                                <div class="form-group"> <label for="exampleInputEmail1">Upload Image</label>
                                    <input type="file" class="form-control" name="image" value="" required='true'>
                                </div>
                                
                                <button type="submit" class="btn btn-warning" name="changeprofile">Change Profle Image</button>
                            </form>
                            <?php 
                                if(isset($_POST['changeprofile'])){
                                    $img=$_FILES["image"]["name"];
                                    $extension = substr($img,strlen($img)-4,strlen($img));
                                    $allowed_extensions = array(".jpg","jpeg",".png",".gif");
                                    if(!in_array($extension,$allowed_extensions)){
                                        echo "<script>alert('Profile image has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
                                    }else{
                                        $img=md5($img).time().$extension;
                                        move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$img);
                                        $sql="update hrs_tbluser set ProfileImage='$img' WHERE ID='$uid'";
                            
                                        if (mysqli_query($conn, $sql)) {
                                            echo '<script>alert("New Profile Image has been updated.")</script>';
                                            echo "<script>window.location.href ='profile.php'</script>";
                                        }else{
                                            die("Error:".$conn->error);
                                        }
                                    }
                                }
                            
                            ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    </div>


</html><?php }  ?>