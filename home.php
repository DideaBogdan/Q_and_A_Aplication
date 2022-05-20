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


<!--
    <div id="title">
      <h1>Knowledge Bag</h1>
      <p>Raspunsuri la toate intrebarile posibile</p>
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
      <div class="main-pannel">
        <div class="question-form">
          <h3 class="question-title">
            <p class="username">Username</p>
            <p>intreaba :</p>
          </h3>
          <div class="question-box"><p>Un model pentru intrebare?</p></div>
        </div>
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
    -->
    <script type="text/javascript" src="assets/js/scripts.js"></script>
  </body>
</html>