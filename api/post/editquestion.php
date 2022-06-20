<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Question.php';
    include_once '../../api/models/Session.php';
    include_once '../../api/models/User.php';

    $database = new Database();
    $db = $database->connect();

    $question = new Question($db);
    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));
    

    $question->id = $data->id;

    if(isset($data->text)){
        $question->text = $data->text;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data->op == "update") {
        $question->updatequestion();
        return true;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data->op == "delete") {
        $user = $question->deletequestion();
        $useraux = new User(($db));
        $rez= $useraux->getid($user[0]["username"]);
        $user2 = new User($db);
        $user2->id = $rez["id"]; 
        $user2->verifyadmin();
        return true;
    }