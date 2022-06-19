<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';

  $session = new Session();

  unset($_SESSION['user_id']);
  unset($_SESSION['user_username']);
  header("Location: http://localhost/Q_and_A_Aplication/home.php");
  exit();
?>

