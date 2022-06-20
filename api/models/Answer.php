<?php
    class Answer {
        private $conn;

        public $id ='';
        public $question = "";
        public $text = '';
        public $user = '';
        public $created_at = '';


        public function __construct($db){
            $this->conn = $db;
        }

        public function createanswer(){
            if(!isset($this->user)){
                $stmt = $this->conn->prepare("CALL create_anonymous_answer(:text, :question)");
                $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);
                $stmt->bindParam(':question', $this->question, PDO::PARAM_STR);
            } else {
                $stmt = $this->conn->prepare("CALL create_answer(:text, :user, :question)");
                $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);
                $stmt->bindParam(':user', $this->user, PDO::PARAM_STR);
                $stmt->bindParam(':question', $this->question, PDO::PARAM_STR);
            }
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Answer created'));
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Answer Not Created'));
                return false;
            }
        }

        public function  displayanswers($id){
            $stmt = $this->conn->prepare("CALL get_answers(:id)");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }

        public function  updateanswer(){
            $stmt = $this->conn->prepare("CALL update_answer(:id, :text)");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);

            $stmt->execute();
          
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Answer updated'));
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Answer Not Updated'));
                return false;
            }

        }

        public function  deleteanswer(){
            $stmt = $this->conn->prepare("CALL delete_answer(:id)");
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array("message"=>"Answer deleted"));
            return $result;

        }
    }