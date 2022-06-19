<?php
    class Category {
        private $conn;

        public $id='';
        public $name = '';
        public $questions_count = '';


        public function __construct($db){
            $this->conn = $db;
        }

        public function getcategories(){

            $stmt = $this->conn->prepare("CALL get_categories()");

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);

        }

    }


