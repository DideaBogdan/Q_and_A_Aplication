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
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    
    <script defer type="text/javascript" src="assets/js/scripts.js"></script>

  </head>
  <!--Nav bar-->
  <?php
    
    echo 
    '<div id="topnav">
      <a class="active" href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="about.php">About</a>';
      if(!isset($_SESSION['user_id'])){
        echo'
          <a style="float:right;" href="sign-up.php">Sign Up</a>
          <a style="float:right;" href="login.php">Log In</a>
        </div>';
      } else {
        if(isset($_SESSION['user_id'])){
          echo ' 
          <a style="float:right;" href="profile.php?username='.$_SESSION['user_id'] .'">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
        </div>';
        } else{
          echo ' 
          <a style="float:right;" href="profile.php">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
          </div>';
        }
      }

  ?>

  <!--this is used to get the @_SESSION variable -->
  <input type="hidden" id="session_var" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '' ?>"/>
  <input type="hidden" id="session_var_id" value="<?php echo isset($_SESSION['user_username']) ? $_SESSION['user_username'] : '' ?>"/>

  <body>  

  <?php 
    if(isset($_SESSION['user_id']))
      echo ' <p class="welcome"> Hello '. $_SESSION['user_id'].' <p>';
  ?>

    <div id="title">
      <h1>Knowledge Bag</h1>
      <p>Raspunsuri la toate intrebarile posibile</p>
    </div>

    <div id="containerpopup">
        <div id="popUp">
          <button id="close">&times;</button>
          <p id = "content">You must have an account to react to posts!</p>
          <button id="buttons" onclick="window.location.href='login.php'">Log in</button>
          <button id="buttons" onclick="window.location.href='sign-up.php'">Sign in</button>
        </div>
      </div>
    

    <div class="main-page">
      <div class="left-pannel">
        <div id="leaderboard_answer" >
          <h3>Cele mai multe raspunsuri date</h3>
        </div>
        <div id="leaderboard_questions">
          <h3>Cele mai curioase persoane</h3>
        </div>
      </div>
      <div class="line"></div>
  
      <div id="main-pannel">
          <button type="button" id="formbutton">Ask a question</button>
          <form id="formquestion" name="formquestion">
            <select name="category" id="category" required>
              <option value="">Select one category to post this question to:</option>
              <textarea  type="text" placeholder="Type your question here..." id="question" name="question" role="textbox" maxlength="5000" required></textarea>
            <button id="button">Submit</button>
          </form>
          <script src="../Q_and_A_Aplication/assets/js/createquestion.js"></script>
          <script type="text/javascript" src="assets/js/displayquestions.js"></script>
      </div>
     <div class="line"></div>
      <div class="right-pannel">
        <div id="statistics">
          <h3>Statistici</h3>
        </div>
      </div>
      <script type="text/javascript" src="assets/js/createleaderboard.js"></script>
 
    </div>     
    <button onclick="topFunction()" id="topBtn">Top</button>
   
  </body>
</html>