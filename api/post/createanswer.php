<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Answer.php';
    include_once '../../api/models/User.php';
    include_once '../../api/models/Session.php';

    $database = new Database();
    $db = $database->connect();

    $answer = new Answer($db);
    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $answer->text = $data->answer;
    $answer->question = $data->question;
    $answer->user = $data->username;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rez = $user->getid($answer->user);
        $answer->createanswer();
        $user->id= $rez["id"];
        print_r($user);
        $user->verifyadmin();
    }