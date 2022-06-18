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
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $stmt = $db->prepare("CALL get_ledearboard_a()");

            $stmt->execute();
            $rezultat=[];
            do{
                $rez= $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $rezultat = array_merge($rezultat, $rez);
            }while($stmt->nextRowSet());
            echo json_encode(array($rezultat));

        
    }