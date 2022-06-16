<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>QAW - Scholarly HTML</title>
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <script src="assets/js/about.js"></script>
  </head>
  <?php
    
    echo 
    '<div id="topnav">
      <a  href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a class="active" href="about.php">About</a>';
      if(!isset($_SESSION['user_id'])){
        echo'
          <a style="float:right;" href="sign-up.php">Sign Up</a>
          <a style="float:right;" href="login.php">Log In</a>
        </div>';
      } else {
        echo ' 
          <a style="float:right;" href="profile.php">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
        </div>';
      }
  ?>
</html>
