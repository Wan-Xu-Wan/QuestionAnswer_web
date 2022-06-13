<?php
      
    session_start();
  
  
    $hostName = "localhost";
    $databaseName = "tax101_revised";
    $username = "root";
    $password = "";

    $connect = mysqli_connect($hostName, $username, $password, $databaseName) or die ('Could not connect:'.mysqli_error($connect));
?>