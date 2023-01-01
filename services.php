<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Facilities - Rastatel</title>
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
    <!--services-->
    <div class="content">
        <div class="services">
            <div class="container">
                <div class="features-grids">
                    <?php
                        $sql="SELECT * from hrs_tblfacility";
                        if($rs=$conn->query($sql)){
                            $cnt=1;
                            if($rs->num_rows>0){
                                while($row=$rs->fetch_assoc()){
                                    ?>
                    <div class="col-md-6 feature-grid">
                        <div class="feature" style="border-radius: 20px; margin-bottom: 20px;">

                            <div class="feature1">
                                 <img src="admin/images/<?php echo $row['Image'];?>" height="300" width="300" alt=""
                                    class="img-responsive-feature">
                                <h4><?php  echo $row['FacilityTitle'];?></h4>
                            </div>
                            <div class="feature2" style="height: 180px;">
                                <p><?php  echo $row['Description'];?>. </p>
                            </div>
                        </div>
                    </div>
                    <?php $cnt=$cnt+1;
                            }
                        }
                    }
                    else{
                        die("Error:".$conn->error);
                    } 
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <?php include_once('includes/getintouch.php');?>

    </div>
    <!--footer-->
    <?php include_once('includes/footer.php');?>
</body>

</html>