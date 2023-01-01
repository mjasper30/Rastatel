 <?php
// session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsuid']==1)) {
  header('location:logout.php');
  } else{
      
?>
 <!DOCTYPE HTML>
 <html>

 <head>
     <title>View Booking Detail - Rastatel</title>
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
     <script language="javascript" type="text/javascript">
     function f2() {
         window.close();
     }

     function f3() {
         window.print();
     }
     </script>
     
     <style>
        @media print { 
            input, a, p backbtn, footer, header{ 
              display: none!important;
            } 
        }
        @page { margin: 0; }
        @media print {
          @page { margin: 0; }
          body { margin: 1.6cm; }
        }
         
     </style>
 </head>

 <body>
     <a href="my-booking.php" class="btn btn-warning" style="margin: 20px;"><p class="backbtn" style="text-align: center;font-size: 20px;">Back</p></a>
     <div class="typography">
         <!-- container-wrap -->
         <div class="container">
             <div class="typography-info">
                 <h2 class="type">Invoice</h2>
             </div>
             <!--<p>My Hotel Booking Detail.</p>-->
             <div class="bs-docs-example">
                 <?php
                    $invid=$_GET['invid'];
                    $sql="SELECT hrs_tblbooking.BookingNumber,hrs_tbluser.FullName,DATEDIFF(hrs_tblbooking.CheckoutDate,hrs_tblbooking.CheckinDate) as ddf,hrs_tbluser.MobileNumber,hrs_tbluser.Email,hrs_tblbooking.IDType,hrs_tblbooking.Gender,hrs_tblbooking.ArrivalTime,hrs_tblbooking.CheckinDate,hrs_tblbooking.CheckoutDate,hrs_tblbooking.BookingDate,hrs_tblbooking.Remark,hrs_tblbooking.Status,hrs_tblbooking.UpdationDate,hrs_tblcategory.CategoryName,hrs_tblcategory.Description,hrs_tblcategory.Price,hrs_tblroom.RoomName,hrs_tblroom.MaxAdult,hrs_tblroom.MaxChild,hrs_tblroom.RoomDesc,hrs_tblroom.NoofBed,hrs_tblroom.Image,hrs_tblroom.RoomFacility 
                    from hrs_tblbooking 
                    join hrs_tblroom on hrs_tblbooking.RoomId=hrs_tblroom.ID 
                    join hrs_tblcategory on hrs_tblcategory.ID=hrs_tblroom.RoomType 
                    join hrs_tbluser on hrs_tblbooking.UserID=hrs_tbluser.ID  
                    where hrs_tblbooking.ID='$invid'";

                    if($rs=$conn->query($sql)){
                        $cnt=1;
                        if($rs->num_rows>0){
                            while($row=$rs->fetch_assoc()){
                                ?>
                 <table border="1"
                     class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                     <tr>
                         <th colspan="5" style="text-align: center;color: red;font-size: 20px">Booking Number:
                             <?php  echo $row['BookingNumber'];?>
                         </th>
                     </tr>


                     <tr>
                         <th>Customer Name</th>
                         <td><?php  echo $row['FullName'];?></td>
                         <th>Mobile Number</th>
                         <td colspan="2"><?php  echo $row['MobileNumber'];?></td>
                     </tr>
                     <tr>
                         <th>Email</th>
                         <td><?php  echo $row['Email'];?></td>
                         <th>Booking Date - (yyyy/mm/dd) Time</th>
                         <td colspan="2"><?php  echo $row['BookingDate'];?></td>
                     </tr>
                     <tr>
                         <th>Room Type</th>
                         <td><?php  echo $row['CategoryName'];?></td>
                         <th>Room Image</th>
                         <td><img src="admin/images/<?php echo $row['Image'];?>" width="100" height="100"
                                 value="<?php  echo $row['Image'];?>"></td>
                     </tr>
                     <tr>
                         <th>Room Price(perday)</th>
                         <td>₱ <?php  echo $row['Price'];?></td>
                         <th>Total No. of Days</th>
                         <td colspan="2"><?php  echo $row['ddf'];?></td>
                     </tr>
                     <table border="1"
                         class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                         <tr>
                             <th colspan="5" style="text-align: center;color: red;font-size: 20px">Invoice Detail</th>
                         </tr>
                         <tr>
                             <th style="text-align: center;">Total Days</th>

                             <th style="text-align: center;">Room Price</th>
                             <th style="text-align: center;">Total Price</th>
                         </tr>
                         <tr>
                             <td style="text-align: center;"><?php  echo $ddf=$row['ddf'];?></td>

                             <td style="text-align: center;">₱ <?php  echo $tp= $row['Price'];?></td>
                             <td style="text-align: center;">₱ <?php  echo $total= $ddf*$tp;?></td>

                         </tr>

                         <?php 
                            $grandtotal+=$total;
                            $cnt=$cnt+1;
                            }
                        }
                    }
                    else{
                        die("Error:".$conn->error);
                    }
                    ?>
                     </table>
                 </table>
                 <p style="text-align: center;font-size: 20px">
                     <input type="submit" class="btn btn-warning" style="color: white;font-size: 20px;"
                         value="Print" onClick="return f3();" style="cursor: pointer;" />
                 </p>
                 
             </div>

         </div>
         <!-- //container-wrap -->
     </div>
     <!-- //typography -->

     <?php //include_once('includes/getintouch.php');?>
     </div>
     <!--footer-->
     <?php //include_once('includes/footer.php');?>
 </body>

 </html>
 <?php }  ?>