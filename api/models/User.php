<?php
    class User {
        private $conn;
        private $table = 'users';

        public $id='';
        public $username='';
        public $password='';
        public $firstname='';
        public $lastname='';
        public $email='';


        public function __construct($db){
            $this->conn = $db;
        }

        public function create() {

            $exists = 'SELECT username, email FROM ' . $this->table . ' WHERE "' .
            $this->username . '" = username or email = "' . $this->email . '";';
            
            $stmt = $this->conn->prepare($exists);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                echo json_encode(array('message' => 'Username or email already in use'));
                return false;
            } 
            $query = 'INSERT INTO ' . $this->table . 
            '(username, password, firstname, lastname, email) VALUES ( "'
            . $this->username . '","' . $this->password . '","' 
            . $this->firstname . '","' . $this->lastname . '","' . $this->email . '");';
           
            $stmt = $this->conn->prepare($query);
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Account created'));
                return $this->username;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'User Not Created'));
                return false;
            }
        }

        public function loginuser() {
            if($this->username != ''){
                $query = 'SELECT id, username, password FROM ' . $this->table . ' WHERE ' . 
                'username = "' . $this->username . '" and password = "' . $this->password . '";';
            }
            else {
                $query = 'SELECT id, email, password FROM ' . $this->table . ' WHERE ' . 
                'email = "' . $this->email . '" and password = "' . $this->password . '";';
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            
            if($result){
                echo json_encode(array('message'=> 'Logged into the account!'));
                return $result;
            } else {
                echo json_encode(array('message'=> 'Username/Email or password are incorect!'));
                return false;
            }
           
         }
    }