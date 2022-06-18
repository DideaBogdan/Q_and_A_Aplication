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
    
    $user->username = $data->username; 
    $user->password = password_hash($data->password,  PASSWORD_DEFAULT);;
    $user->firstname = $data->firstname;
    $user->lastname = $data->lastname;
    $user->email = $data->email;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user->username = $user->create();
        $session = new Session();
        $session->login($user);
        
    }