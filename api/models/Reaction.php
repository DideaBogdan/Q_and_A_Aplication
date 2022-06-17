<?php
    class Reaction {
        private $conn;

        public $id = '';
        public $like = '';
        public $dislike = '';
        public $user = '';
        public $id_post = '';

        public function __construct($db){
            $this->conn = $db;
        }

        public function exists(){
            $stmt = $this->conn->prepare("CALL verify_reaction(:like, :dislike, :user, :id_post)");
            
            $stmt->bindParam(':like', $this->like, PDO::PARAM_STR);
            $stmt->bindParam(':dislike', $this->dislike, PDO::PARAM_STR);
            $stmt->bindParam(':user', $this->user, PDO::PARAM_STR);
            $stmt->bindParam(':id_post', $this->id_post, PDO::PARAM_STR);

            if($stmt->execute()){
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                return false;
            }
        }

        public function createreaction(){
            
            $stmt = $this->conn->prepare("CALL create_reaction(:like, :dislike, :user, :id_post)");
            
            $stmt->bindParam(':like', $this->like, PDO::PARAM_STR);
            $stmt->bindParam(':dislike', $this->dislike, PDO::PARAM_STR);
            $stmt->bindParam(':user', $this->user, PDO::PARAM_STR);
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

    }