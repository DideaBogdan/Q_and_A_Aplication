<?php

    if(!isset($_POST["submit"])){
        
        $name = $_POST["name"];
        $email = $_POST["email"];
        $username = $_POST["uid"];
        $password = $_POST["pwd"];
        $passwordrepeat = $_POST["pwdrepeat"];

        require_once 'database.inc.php';
        require_once 'functions.inc.php';

        if(emptyInputSignup($name, $email, $username, $password, $passwordrepeat) !== false){
            header("location: ../sign-up.php?error=emptyinput");
            exit();
        }
        
        if(invalidUsername($username) !== false){
            header("location: ../sign-up.php?error=invaliduser");
            exit();
        }
        
        if(invalidEmail($email) !== false){
            header("location: ../sign-up.php?error=invalidemail");
            exit();
        }
        
        if(passwordMatch($password, $passwordrepeat) !== false){
            header("location: ../sign-up.php?error=differentpasswords");
            exit();
        }
        
        if(usernameExists($conn, $username, $email) !== false){
            header("location: ../sign-up.php?error=usernametaken");
            exit();
        }

        createUser($conn, $name, $email, $username, $password);
    }
    else 
    {
       header("location: ../sign-up.php");
    }