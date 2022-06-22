<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/User.php';
    include_once '../../api/models/Session.php';


    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $data = file_get_contents("php://input");
    print_r($data);