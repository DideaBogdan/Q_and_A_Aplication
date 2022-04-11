<?php

function emptyInputSignup($name, $email, $username, $password, $passwordrepeat) {
    $result=false;
    if(empty($name)  || empty($email) || empty($username) || empty($password) || empty($passwordrepeat)){
        $result= true;
    }
    else{
        $result= false;
    }
    return $result;
}

function invalidUsername($username) {
    $result=false;
    if(!preg_match(" /^[a-zA-Z0-9]*$/ ", $username)){
        $result = true;
    }
    else{
        $result= false;
    }
    return $result;
}

function invalidEmail($email){
    $result=false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result= true;
    }
    else{
        $result= false;
    }
    return $result;
}

function passwordMatch($password, $passwordrepeat){
    $result=false;
    if($password !== $passwordrepeat){
        $result= true;
    }
    else{
        $result= false;
    }
    return $result;
}

function usernameExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?;"; 
    $statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($statement, $sql)){
        header("location: ../sign-up.php?error=statementfailed");
        exit();
    }

    mysqli_stmt_bind_param($statement, "ss", $username, $email);
    mysqli_stmt_execute($statement);
    
    $resultData = mysqli_stmt_get_result($statement);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($statement);

}

function createUser($conn, $name, $email, $username, $password){
    $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?);"; 
    $statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($statement, $sql)){
        header("location: ../sign-up.php?error=statementfailed");
        exit();
    }

    $hasedpassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($statement, "ssss", $name, $email, $username, $hasedpassword);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    header("location: ../sign-up.php?error=none");
    exit();

}


function emptyInputLogin($username, $password){
    $result=false;
    if(empty($username) || empty($password)){
        $result= true;
    }
    else{
        $result= false;
    }
    return $result;

}

function loginUser($conn, $username, $password){
    $userExists = usernameExists($conn, $username, $username);

    if($userExists === false) {
        header("location: ../log-in.php?error=wronglogin");
        exit();
    }

    $passwordhashed = $userExists["password"];
    $checkpassword = password_verify($password, $passwordhashed);

    if($checkpassword === false) {
        header("location: ../log-in.php?error=wronglogin");
        exit();
    }
    else if ($checkpassword === true) {
        session_start();
        $_SESSION["userid"] = $userExists["usersId"];
        $_SESSION["useruid"] = $userExists["username"];
        header("location: ../index.php");
        exit();
    }
}
