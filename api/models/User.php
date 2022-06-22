<?php
    class User {
        private $conn;

        public $id='';
        public $username='';
        public $password='';
        public $firstname='';
        public $lastname='';
        public $email='';
        public $admin='';


        public function __construct($db){
            $this->conn = $db;
        }

        public function create() {
            
            $stmt = $this->conn->prepare("CALL used_username(:username, :email)");

            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

            $stmt->execute();
            $count = 0;
            while ($stmt->fetch())
            {
                $count++;
            }

            if($count != 0){
                echo json_encode(array('message' => 'Username or email already in use'));
                return false;
            }

            $stmt = $this->conn->prepare("CALL create_user(:username, :password, :firstname, :lastname, :email)");
            
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            
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
           

            $stmt = $this->conn->prepare("CALL login_by_username(:username)");
            
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt-> fetchAll(PDO::FETCH_ASSOC);
            if($result != null){
                $vf_pass=$result[0]["password"];
                if(password_verify($this->password, $vf_pass)){
                    echo json_encode(array('message'=> 'Logged into the account!'));
                    return $result;
                } else {
                    echo json_encode(array('message'=> 'Username or password are incorect!'));
                    return false;
                }    
             }else {
                    echo json_encode(array('message'=> 'Username or password are incorect!'));
                    return false;
                }
        }

         public function getid($username){
            $stmt = $this->conn->prepare("CALL get_user_id(:username)");
            $stmt->bindParam(':username', $username);

            $stmt->execute();
            $result = $stmt-> fetch(PDO::FETCH_ASSOC);
            return $result;
         }

         public function verifyadmin(){

            $stmt = $this->conn->prepare("CALL verify_admin(:id)");
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()){
                return true;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                return false;
            }
            
         }
         public function updateuser($data) {
            
            $stmt = $this->conn->prepare("CALL used_username(:username, :email)");

            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

            $stmt->execute();
            $count = 0;
            while ($stmt->fetch())
            {
                $count++;
            }

            if($count != 0){
                echo json_encode(array('message' => 'Username or email already in use'));
                return false;
            }


            $stmt = $this->conn->prepare("CALL update_user(:oldusername, :username, :password, :firstname, :lastname, :email)");
            
            $stmt->bindParam(':oldusername', $data, PDO::PARAM_STR);
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
         
            
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Account updated'));
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'Account Not updated'));
                return false;
            }
        }

    }


