<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Reaction.php';
    include_once '../../api/models/Session.php';

    $database = new Database();
    $db = $database->connect();

    $reaction = new Reaction($db);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $reaction->getreactions();
        
    }
