<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Question.php';
    include_once '../../api/models/Session.php';

    $database = new Database();
    $db = $database->connect();

    $question = new Question($db);

    $data = json_decode(file_get_contents("php://input"));

    $question->text = $data->question;
    $question->user_id = $data->user_id;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question->createquestion();
        
        
    }