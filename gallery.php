<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Gallery - Rastatel</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="css/lightbox.css">

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
</head>

<body>
    <!--header-->
    <div class="header head-top">
        <div class="container">
            <?php include_once('includes/header.php');?>
        </div>
    </div>
    <!--header-->
    <div class="content">
        <!-- gallery -->
        <div class="gallery-top">
            <!-- container -->
            <div class="container">
                <div class="gallery-info">
                    <h2>gallery</h2>
                </div>
                <div class="gallery-grids-top">
                    <div class="gallery-grids">
                        <?php
                            $sql="SELECT * from hrs_tblroom";
                            if($rs=$conn->query($sql)){
                                $cnt=1;
                                if($rs->num_rows>0){
                                    while($row=$rs->fetch_assoc()){ ?>
                        <div class="col-md-4 gallery-grid">
                            <br />
                            <a class="example-image-link" href="admin/images/<?php echo $row['Image'];?>"
                                data-lightbox="example-set" data-title=""><img class="example-image"
                                    src="admin/images/<?php echo $row['Image'];?>" height="300" width="300"
                                    alt="" /></a>
                        </div><?php $cnt=$cnt+1;
		                            }
                                }
                            }else{
                                die("Error:".$conn->error);
                            }?>
                            
                        <div class="col-md-4 gallery-grid">
                            <br />
                            <a class="example-image-link" href="images/s1.jpg"
                                data-lightbox="example-set" data-title=""><img class="example-image"
                                    src="images/s1.jpg" height="300" width="300"
                                    alt="" /></a>
                        </div>
                        <div class="col-md-4 gallery-grid">
                            <br />
                            <a class="example-image-link" href="images/s2.jpg"
                                data-lightbox="example-set" data-title=""><img class="example-image"
                                    src="images/s2.jpg" height="300" width="300"
                                    alt="" /></a>
                        </div>
                        <div class="col-md-4 gallery-grid">
                            <br />
                            <a class="example-image-link" href="images/s3.jpg"
                                data-lightbox="example-set" data-title=""><img class="example-image"
                                    src="images/s3.jpg" height="300" width="300"
                                    alt="" /></a>
                        </div>
                        <div class="col-md-4 gallery-grid">
                            <br />
                            <a class="example-image-link" href="images/s4.jpg"
                                data-lightbox="example-set" data-title=""><img class="example-image"
                                    src="images/s4.jpg" height="300" width="300"
                                    alt="" /></a>
                        </div>
                        <div class="col-md-4 gallery-grid">
                            <br />
                            <a class="example-image-link" href="images/s5.jpg"
                                data-lightbox="example-set" data-title=""><img class="example-image"
                                    src="images/s5.jpg" height="300" width="300"
                                    alt="" /></a>
                        </div>
                        
                        <div class="clearfix"> </div>
                    </div>

                    <script src="js/lightbox-plus-jquery.min.js"></script>
                </div>
            </div>
            <!-- //container -->
        </div>
        <!-- //gallery -->

        <?php include_once('includes/getintouch.php');?>
    </div>
    <!--footer-->
    <?php include_once('includes/footer.php');?>
</body>

</html>