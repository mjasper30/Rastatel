    <div class="header-top">
        <img src="images/favicon.ico" style="width:60px; height:60px; position: absolute; left: 50px; top: 20px;">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand">
                        <h1><a href="index.php">Rastatel</a></h1>
                    </div>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="services.php">Facilities</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Rooms <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                    $ret="SELECT * from hrs_tblcategory";
                                    if($rs=$conn->query($ret)){
                                        if($rs->num_rows>0){
                                            while($row=$rs->fetch_assoc()){ ?>
                                <li><a
                                        href="category-details.php?catid=<?php echo $row['ID']?>"><?php echo $row['CategoryName']?></a>
                                </li>
                                <?php       
                                            } 
                                        } 
                                    }
                                    else{
                                        die("Error:".$conn->error);
                                    } 
                                ?>
                            </ul>
                        </li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <?php if (strlen($_SESSION['hbmsuid']==0)) {?>
                        <!-- <li><a href="admin/login.php">Admin</a></li> -->

                        <li><a href="signup.php">Sign Up</a></li>
                        <li><a href="signin.php">Login</a></li><?php } ?>
                        <?php if (strlen($_SESSION['hbmsuid']!=0)) {?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="my-booking.php">My Booking</a></li>
                                <li><a href="change-password-client.php">Change Password</a></li>
                                <li><a href="logout.php">Logout</a></li>

                            </ul>
                        </li><?php } ?>
                    </ul>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

    </div>