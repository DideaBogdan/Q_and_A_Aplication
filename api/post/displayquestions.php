<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Question.php';
    include_once '../../api/models/Session.php';

    $database = new Database();
    $db = $database->connect();

    $question = new Question($db);

    
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $question->displayquestions();
    }