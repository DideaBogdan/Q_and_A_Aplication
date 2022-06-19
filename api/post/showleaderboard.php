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
            ///gets the answers-count given by every user


            $stmt = $db->prepare("CALL get_ledearboard_q()");

            $stmt->execute();
            $rezultat2=[];
            do{
                $rez= $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $rezultat2 = array_merge($rezultat2, $rez);
            }while($stmt->nextRowSet());
                ///gets the questions-count given by every user

                $stmt = $db->prepare("CALL get_statistics()");

            $stmt->execute();
            $rezultat3=[];
            do{
                $rez= $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $rezultat3 = array_merge($rezultat3, $rez);
            }while($stmt->nextRowSet());
                //gets left statistics

            echo json_encode(array($rezultat, $rezultat2, $rezultat3));

        
    }