<?php
    class Question {
        private $conn;

        public $id = '';
        public $user_id = '';
        public $text = '';
        //public $created_at = '';


        public function __construct($db){
            $this->conn = $db;
        }

        public function createquestion(){
            if($this->user_id = ''){
                $stmt = $this->conn->prepare("CALL create_anonymous_question(:text)");
                $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);
            } else {
                $stmt = $this->conn->prepare("CALL create_question(:text, :user_id)");
                $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_STR);
            }
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Question created'));
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Question Not Created'));
                return false;
            }
        }

        public function  displayquestions(){
            $stmt = $this->conn->prepare("CALL get_questions()");

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);

        }
    }