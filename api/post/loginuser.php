<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/User.php';
    include_once '../../api/models/Session.php';
    
    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    if($data->username == ''){
        $user->email = $data->email;
    } else {
        $user->username = $data->username;
    }
    $user->password = $data->password;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($user = $user->loginuser()){
            $arruser = json_decode(json_encode($user), true);
            $session = new Session();
            $session->login($arruser[0]);
        }
      
    }
    
