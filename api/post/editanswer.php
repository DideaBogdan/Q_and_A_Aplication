<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Answer.php';
    include_once '../../api/models/Session.php';

    $database = new Database();
    $db = $database->connect();

    $answer = new Answer($db);

    $data = json_decode(file_get_contents("php://input"));

    $answer->id = $data->id;
    if(isset($data->text)){
        $answer->text = $data->text;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data->op == "update") {
        $answer->updateanswer();
        return true;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data->op == "delete") {
        $answer->deleteanswer();
        return true;
    }