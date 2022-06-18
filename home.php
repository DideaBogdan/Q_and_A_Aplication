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
    <link href="https://fonts.googleapis.com/css2?family=Palette+Mosaic&family=Updock&display=swap" rel="stylesheet">
  <!--Search bar icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
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
        echo ' 
          <a style="float:right;" href="profile.php">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
        </div>';
      }
  ?>

  <!--this is used to get the @_SESSION variable -->
  <input type="hidden" id="session_var" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '' ?>"/>
  <input type="hidden" id="session_var_id" value="<?php echo isset($_SESSION['user_username']) ? $_SESSION['user_username'] : '' ?>"/>

  <body>  
    <div class="search-box">
      <input type="text" name="name" class="search-txt" placeholder="Type to search" />
      <a class="search-btn" href="#">
        <i class="fa fa-search" aria-hidden="true"></i>
      </a>
    </div>


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
        <div class="leaderboard">
          <h3>Cele mai multe raspunsuri date</h3>
          <span class="ladeboard-row"><p>1.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>2.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>3.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>4.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>5.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>6.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>7.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>8.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>9.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row" id="row-10th"><p>10.</p><p>Numele</p><p>Scor</p></span>
        </div>
        <div class="leaderboard">
          <h3>Cele mai curioase persoane</h3>
          <span class="ladeboard-row"><p>1.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>2.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>3.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>4.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>5.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>6.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>7.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>8.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row"><p>9.</p><p>Numele</p><p>Scor</p></span>
          <span class="ladeboard-row" id="row-10th"><p>10.</p><p>Numele</p><p>Scor</p></span>
        </div>
      </div>
      <div class="line"></div>
  
      <div id="main-pannel">
        <button type="button" id="formbutton">Ask a question</button>
        <form id="formquestion" name="formquestion">
          <textarea  type="text" placeholder="Type your question here..." id="question" name="question" role="textbox" maxlength="5000" required></textarea>
          <button id="button">Submit</button>
        </form>
        <script src="../Q_and_A_Aplication/assets/js/createquestion.js"></script>
        <script type="text/javascript" src="assets/js/displayquestions.js"></script>
        <!--
        <div id="question-form">
          <h3 id="question-title">
            <p id="username"></p>
            <p>intreaba :</p>
          </h3>
          <div id="question-box"><p></p></div>
        </div>
    -->
      </div>
     <div class="line"></div>
      <div class="right-pannel">
        <div class="statistics">
          <h3>Statistici</h3>
          <p>Utilizatori: <span class="statistic-value">number</span></p>
          <p>Intrebari: <span class="statistic-value">number</span></p>
          <p>Raspunsuri: <span class="statistic-value">number</span></p>
          <p>Intrebari fara raspuns: <span class="statistic-value">number</span></p>
        </div>
      </div>
 
    </div>     
    <button onclick="topFunction()" id="topBtn">Top</button>
   
  </body>
</html>