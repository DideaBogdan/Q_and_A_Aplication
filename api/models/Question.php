<?php
    class Question {
        private $conn;

        public $id ='';
        public $user_id ='';
        public $text = '';
        public $category = '';
        //public $created_at = '';


        public function __construct($db){
            $this->conn = $db;
        }

        public function createquestion(){
            if(!isset($this->user_id)){
                $stmt = $this->conn->prepare("CALL create_anonymous_question(:text, :category)");
                $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);
                $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
            } else {
                $stmt = $this->conn->prepare("CALL create_question(:text, :user_id, :category)");
                $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_STR);
                $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
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
        public function  displayquestion(){
            $stmt = $this->conn->prepare("CALL get_question(:id)");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        }

        public function  updatequestion(){
            $stmt = $this->conn->prepare("CALL update_question(:id, :text)");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':text', $this->text, PDO::PARAM_STR);

            $stmt->execute();
          
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Question updated'));
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Question Not Updated'));
                return false;
            }

        }

        public function  deletequestion(){

            $stmt = $this->conn->prepare("CALL get_question(:id)");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $this->conn->prepare("CALL delete_question(:id)");
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
          
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Question deleted'));
                return $result;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Question not deleted'));
                return false;
            }

        }
    }