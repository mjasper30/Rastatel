<?php
    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>About Us - Rastatel</title>
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
        <div class="about-section">
            <div class="container">
                <?php
                $sql="SELECT * from hrs_tblpage where PageType='aboutus'";

                if($rs=$conn->query($sql)){
                    $cnt=1;
                    if($rs->num_rows>0){
                        while($row=$rs->fetch_assoc()){
                            ?>
                <h2><?php  echo $row['PageTitle'];?></h2><br><br>
                <center><img src="images/hotel.jpg" style="height: 400px; width: 600px;" class="img-responsive"
                        alt="/"></center><br><br>
                <p><?php  echo $row['PageDescription'];?>.</p>
                <?php $cnt=$cnt+1;
                        }
                    }
                }
                else{
                    die("Error:".$conn->error);
                } ?>
            </div>
        </div>
        <!--about-->

        <?php include_once('includes/getintouch.php');?>

    </div>

    <?php include_once('includes/footer.php');?>
</body>

</html>