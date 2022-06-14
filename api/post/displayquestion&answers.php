<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Question.php';
    include_once '../../api/models/Answer.php';
    include_once '../../api/models/Session.php';

    $database = new Database();
    $db = $database->connect();

    $question = new Question($db);
    $answer = new Answer($db);

    $data = json_decode(file_get_contents("php://input"));

    $question->id= $data->id;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $resultquestion = $question->displayquestion();
        
        $resultanswers = $answer->displayanswers($question->id);

        echo json_encode(array_merge($resultquestion, $resultanswers));
    }