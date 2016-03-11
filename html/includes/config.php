<?php
    $mysql_user = "sc_admin"; 
    $mysql_password = "cecs550softwaredesign"; 
    $mysql_hostname = "security-camera-db-instance.cvwrmvrn1lsl.us-west-2.rds.amazonaws.com"; 
    $mysql_database = "security_camera"; 
     
    $bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password,$mysql_database) or die("Failed to connect to server");
?>
