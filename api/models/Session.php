<?php
class Session{
      private $logged_in=false;
      public $user_id;
      public $user_username;
      public $admin;

      function __construct() {
          session_start();
          $this->check_login();
      }

      public function is_logged_in() {
        return $this->logged_in;
      }

      public function login($user) {
      // database should find user based on username/password
      if($user){
        $this->user_id = $_SESSION['user_id'] = $user["username"];
        $this->user_username = $_SESSION['user_username'] = $user["id"];
        $this->admin = $_SESSION['admin'] = $user["admin"];
        $this->logged_in = true;
        }
      }

      public function logout() {
      unset($_SESSION['user_id']);
      unset($this->user_id);
      unset($_SESSION['user_id']);
      unset($_SESSION['admin']);
      $this->logged_in = false;
      }

      private function check_login() {
      if(isset($_SESSION['user_id'])) {
        $this->user_id = $_SESSION['user_id'];
        $this->logged_in = true;
      } else {
        unset($this->user_id);
        $this->logged_in = false;
      }
      }

}