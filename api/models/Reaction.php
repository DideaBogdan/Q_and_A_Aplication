<?php
    class Reaction {
        private $conn;

        public $is_question = '';
        public $like = '';
        public $dislike = '';
        public $report ='';
        public $user;
        public $id_post = '';

        public function __construct($db){
            $this->conn = $db;
        }


        public function createreaction(){
            
            $stmt = $this->conn->prepare("CALL create_reaction(:is_question,:like, :dislike, :report, :user, :id_post)");
            
            $stmt->bindParam(':is_question', $this->is_question);
            $stmt->bindParam(':like', $this->like);
            $stmt->bindParam(':dislike', $this->dislike);
            $stmt->bindParam(":user", $this->user);
            $stmt->bindParam(":report", $this->report);
            $stmt->bindParam(':id_post', $this->id_post, PDO::PARAM_STR);

            if($stmt->execute()){
              
                return json_encode(array('message'=> 'Reaction created'));
            } else {
                printf("ERROR: %s. \n", $stmt->error);     
                return  json_encode(array('message'=> 'Reaction Not Created'));
            }
        }

        public function deletereaction(){
            $stmt = $this->conn->prepare("CALL delete_reaction(:user, :like, :dislike, :report, :id_post, :is_question)");
            $stmt->bindParam(':id_post', $this->id_post, PDO::PARAM_STR);
            $stmt->bindParam(':user', $this->user, PDO::PARAM_STR);
            $stmt->bindParam(':like', $this->like);
            $stmt->bindParam(':dislike', $this->dislike);
            $stmt->bindParam(":report", $this->report);
            $stmt->bindParam(':is_question', $this->is_question, PDO::PARAM_STR);

            if($stmt->execute()){
                echo json_encode(array('message'=> 'Reaction deleted'));
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Reaction Not deleted'));
                return false;
            }

        }

        public function getreactions(){
            $stmt = $this->conn->prepare("CALL get_reactions()");
            
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                return false;
            }
        }

        public function getreaction(){
            $stmt = $this->conn->prepare("CALL get_reaction_count(:report, :id_post, :is_question)");
            
            $stmt->bindParam(":report", $this->report);
            $stmt->bindParam(':id_post', $this->id_post, PDO::PARAM_STR);
            $stmt->bindParam(':is_question', $this->is_question);

            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                return false;
            }
        }

    }