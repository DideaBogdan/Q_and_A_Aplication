<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/Reaction.php';
    include_once '../../api/models/Question.php';
    include_once '../../api/models/Answer.php';
    include_once '../../api/models/Session.php';

    $database = new Database();
    $db = $database->connect();

    $reaction = new Reaction($db);

    $data = json_decode(file_get_contents("php://input"));
    

    $reaction->like = $data->like;
    $reaction->dislike = $data->dislike;
    $reaction->user = $data->user;
    $reaction->report = $data->report;
    $reaction->id_post = $data->id_post;
    $reaction->is_question = $data->is_question;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $resp = $reaction->createreaction();
        if($reaction->report == "1"){
            $result = $reaction->getreaction();
            if($result[0]["number"] == "2"){
                if($reaction->is_question == "1"){
                    $question = new Question($db);
                    $question->id = $reaction->id_post;
                    $question->deletequestionnojson();
                    echo json_encode(array('message'=> 'Question deleted'));
                }
                else if($reaction->is_question == "0"){
                    $answer = new Answer($db);
                    $answer->id = $reaction->id_post;
                    $answer->deleteanswernojson();
                    echo json_encode(array('message'=> 'Answer deleted'));
                }

            }else{
                echo $resp;
            }
        }else {
            echo $resp;
        }
        
    }
