            <div class="touch-section">
                <div class="container">
                    <h3>Contact Us</h3>
                    <div class="touch-grids">
                        <?php
            $sql="SELECT * from hrs_tblpage where PageType='contactus'";
            if($rs=$conn->query($sql)){
                if($rs->num_rows>0){
                    while($row=$rs->fetch_assoc()){
                        ?>
                        <div class="col-md-4 touch-grid">
                            <h4>address</h4>
                            <h5><?php echo $row['PageDescription'];?></h5>

                        </div>
                        <div class="col-md-4 touch-grid">
                            <h4>Enquries</h4><br>
                            <p>Telephone : +<?php echo $row['MobileNumber'];?></p>
                            <p>E-mail : <?php echo $row['Email'];?></p>
                        </div><?php $cnt=$cnt+1;
                    }
                }
            }
            else{
                die("Error:".$conn->error);
            }?>

                        <div class="col-md-4 touch-grid">
                            <?php
                $sql="SELECT * from hrs_tblpage where PageType='aboutus'";
                if($rs=$conn->query($sql)){
                    $cnt=1;
                    if($rs->num_rows>0){
                        while($row=$rs->fetch_assoc()){
                            ?>
                            <h4><?php  //echo $row['PageTitle'];?></h4>

                            <p><?php  //echo $row['PageDescription'];?></p>

                        </div><?php $cnt=$cnt+1;
                        }
                    }
                }
                else{
                    die("Error:".$conn->error);
                }?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!--GET IN TOUCH-->