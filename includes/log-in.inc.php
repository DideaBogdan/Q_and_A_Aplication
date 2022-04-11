<?php

    if(!isset($_POST["submit"])){

        $username = $_POST["name"];
        $password = $_POST["pwd"];

        require_once 'database.inc.php';
        require_once 'functions.inc.php';

        if(emptyInputLogin( $username, $password) !== false){
            header("location: ../log-in.php?error=emptyinput");
            exit();
        }

        loginUser($conn, $username, $password);
    }
    else {
        header("location: ../log-in.php");
        exit();
    }