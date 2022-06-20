<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

    include_once '../../api/config/Database.php';
    include_once '../../api/models/User.php';
    include_once '../../api/models/Session.php';


    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $username = $data->username;
    $error = null;
    $is_top_questioner = 0;
    $is_top_answerer = 0;

    $arraytosend = [];

    $statement = $db->prepare('SELECT id FROM users WHERE username = :username');
    $statement->bindValue(':username',$username);
    $statement->execute();
    $user_id = $statement->fetch(PDO::FETCH_ASSOC);  /// ia id user in array ==== user_id[0]

    $statement = $db->prepare('SELECT * FROM badges WHERE category = :category');
    $statement->bindValue(':category',"questions");
    $statement->execute();
    $question_badges = $statement->fetchAll(PDO::FETCH_ASSOC); /// aici ia toate info despre  badges -intrebari

    $arraytosend = array_merge($user_id, array("question_badges"=> $question_badges));
    
    $statement = $db->prepare('SELECT * FROM badges WHERE category = :category');
    $statement->bindValue(':category',"answers");
    $statement->execute();
    $answer_badges = $statement->fetchAll(PDO::FETCH_ASSOC);   /// aici ia toate info despre  badges - rasp

    $arraytosend = array_merge($arraytosend, array("answer_badges"=> $answer_badges));


    $statement = $db->prepare('SELECT * FROM badges WHERE category = :category');
    $statement->bindValue(':category',"locked");
    $statement->execute();
    $locked_badge = $statement->fetch(PDO::FETCH_ASSOC);     /// aici ia toate info despre locked badges badges

    $arraytosend = array_merge($arraytosend, array("locked_badge"=> $locked_badge));

    $statement = $db->prepare('SELECT user, COUNT(user) FROM questions GROUP BY user HAVING COUNT(user) =( SELECT MAX(mycount) FROM ( SELECT user, COUNT(user) mycount FROM questions GROUP BY user) as md);');
    $statement->execute();
    $top_questioners = $statement->fetchAll(PDO::FETCH_ASSOC);   ///aici ii ia pe cei cu cele mai multe intrebari

    $arraytosend = array_merge($arraytosend, array("top_questioners"=> $top_questioners));

    foreach($top_questioners as $top_questioner){
        if($top_questioner['user'] == $user_id['id']){
        $is_top_questioner = true;
        }
    }

    $arraytosend = array_merge($arraytosend, array("is_top_questioner"=> $is_top_questioner));

    $statement = $db->prepare('SELECT user, COUNT(user) FROM answers GROUP BY user HAVING COUNT(user) =( SELECT MAX(mycount) FROM ( SELECT user, COUNT(user) mycount FROM answers GROUP BY user) as md);');
    $statement->execute();
    $top_answerers = $statement->fetchAll(PDO::FETCH_ASSOC);  ///aici ii ia pe cei cu cele mai multe raspunsuri

    $arraytosend = array_merge($arraytosend, array("top_answerers"=> $top_answerers));

    foreach($top_answerers as $top_answerer){
        if($top_answerer['user'] == $user_id['id']){
        $is_top_answerer = true;
        }
    }
    
    $arraytosend = array_merge($arraytosend, array("is_top_answerer"=> $is_top_answerer));
  

    $statement = $db->prepare('SELECT COUNT(*) FROM questions WHERE user = :id');
    $statement->bindValue(':id',$user_id['id']);
    $statement->execute();
    $total_questions = $statement->fetch(PDO::FETCH_ASSOC);   /// count(intrebari)-pt userul curent

    $arraytosend = array_merge($arraytosend, array("total_questions"=> $total_questions));

    $statement = $db->prepare('SELECT COUNT(*) FROM answers WHERE user = :id');
    $statement->bindValue(':id',$user_id['id']);
    $statement->execute();
    $total_answers = $statement->fetch(PDO::FETCH_ASSOC);   /// count (raspunsuri)-pt userul curent

    $arraytosend = array_merge($arraytosend, array("total_answers"=> $total_answers));

    $statement_question = $db->prepare('SELECT * FROM questions WHERE user = :id');
    $statement_question->bindValue(':id',$user_id['id']);
    $statement_question->execute();
    $questions = $statement_question->fetchAll(PDO::FETCH_ASSOC); ///intrebarile userului

    $arraytosend = array_merge($arraytosend, array("questions"=> $questions));

    $statement_answer = $db->prepare('SELECT * FROM answers WHERE user = :id');
    $statement_answer->bindValue(':id',$user_id['id']);
    $statement_answer->execute();
    $answers = $statement_answer->fetchAll(PDO::FETCH_ASSOC);  ///raspunsurile userului

    $arraytosend = array_merge($arraytosend, array("answers"=> $answers));

    $statement = $db->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindValue(':id',$user_id['id']);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);  /// toate informatiile userului

    $arraytosend = array_merge($arraytosend, array("user"=> $user));


    $statement = $db->prepare('SELECT username, email FROM users WHERE id != :id');
    $statement->bindValue(':id',$user_id['id']);
    $statement->execute();
    $allUsers = $statement->fetchAll(PDO::FETCH_ASSOC); /// asta ia toti userii si email - ul   === pentru verificare

    $arraytosend = array_merge($arraytosend, array("allUsers"=> $allUsers));

    ///pana aici e partea de informatii

    echo json_encode($arraytosend);
/*
    $password = null;
    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $email = $user['email'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        foreach($allUsers as $userinfo):  
        if($userinfo['email'] == $email || $userinfo['username'] == $username){
        $error = "Username or email already taken!";
        }
        endforeach; 

        if($error == null){
        if($password != null){
            $statement = $db->prepare("UPDATE users SET username = :username, password = :password, firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");

            $_SESSION['user_id'] = $username;
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            $statement->bindValue(':username', $username);
            $statement->bindValue(':password', $hashed_password);
            $statement->bindValue(':firstname', $firstname);
            $statement->bindValue(':lastname', $lastname);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':id',$user_id[0]);
            $statement->execute();
        }
        else{
            $statement = $db->prepare("UPDATE users SET username = :username, firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");

            $_SESSION['user_id'] = $username;
    
            $statement->bindValue(':username', $username);
            $statement->bindValue(':firstname', $firstname);
            $statement->bindValue(':lastname', $lastname);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':id',$user_id[0]);
            $statement->execute();
        }
        }
       
    }
     */