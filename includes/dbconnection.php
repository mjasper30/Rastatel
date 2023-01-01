<?php
    $server="localhost"; // server IP address
    $user="ytoovumw_bscs3a";
    $pass="kaAGi]gz8H2*";
    $dbname="ytoovumw_bscs3a";
    $conn= new mysqli($server,$user,$pass,$dbname);
    if($conn->connect_error){
        die("Connection Failed:". $conn->connect_error);
    }
?>