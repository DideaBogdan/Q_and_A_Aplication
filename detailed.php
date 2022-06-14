<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';

  $session = new Session();

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Bag</title>
    <link rel="stylesheet" href="assets/css/detailed.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Palette+Mosaic&family=Updock&display=swap" rel="stylesheet">
  <!--Search bar icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer type="text/javascript" src="assets/js/scripts.js"></script>
    

  </head>

  <!--Nav bar-->
  <?php
    
    echo 
    '<div id="topnav">
      <a href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="about.php">About</a>';
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

  <!--this is used to get the @_SESSION variable -->
  <body>  
    <div class="search-box">
      <input type="text" name="name" class="search-txt" placeholder="Type to search" />
      <a class="search-btn" href="#">
        <i class="fa fa-search" aria-hidden="true"></i>
      </a>
    </div>
    <div id="main-pannel">
      <input type="hidden" id="question_id" value="<?php echo $_GET['id']?>"/>
      <?php
        if(isset($_SESSION['user_id']))
          echo '<input type="hidden" id="user_answer" value="'. $_SESSION['user_id'] .'"/>';
      ?>
      <script type="text/javascript" src="assets/js/displayquestion&answers.js"></script>
    </div> 
    <button onclick="topFunction()" id="topBtn">Top</button>
  </body>
</html>