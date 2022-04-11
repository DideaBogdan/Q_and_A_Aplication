<?php

    $servername = "localhost";
    $databaseUsername = "root";
    $databasePassword = "";
    $databaseName = "q&a_app";

    $conn = mysqli_connect($servername, $databaseUsername, $databasePassword, $databaseName);

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

