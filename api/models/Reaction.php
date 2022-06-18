<?php
    class Reaction {
        private $conn;

        public $is_question = '';
        public $like = '';
        public $dislike = '';
        public $user;
        public $id_post = '';

        public function __construct($db){
            $this->conn = $db;
        }


        public function createreaction(){
            
            $stmt = $this->conn->prepare("CALL create_reaction(:is_question,:like, :dislike, :user, :id_post)");
            
            $stmt->bindParam(':is_question', $this->is_question);
            $stmt->bindParam(':like', $this->like);
            $stmt->bindParam(':dislike', $this->dislike);
            $stmt->bindParam(":user", $this->user);
            $stmt->bindParam(':id_post', $this->id_post, PDO::PARAM_STR);

            if($stmt->execute()){
                echo json_encode(array('message'=> 'Reaction created'));
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Reaction Not Created'));
                return false;
            }
        }

        public function deletereaction(){
            $stmt = $this->conn->prepare("CALL delete_reaction(:user, :id_post)");
            
            $stmt->bindParam(':user', $this->user, PDO::PARAM_STR);
            $stmt->bindParam(':id_post', $this->id_post, PDO::PARAM_STR);

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
            
           // $stmt->bindParam(':id_post', $this->id_post, PDO::PARAM_STR);

            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                return false;
            }
        }

    }