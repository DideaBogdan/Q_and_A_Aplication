<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';
  include_once '../Q_and_A_Aplication/api/config/Database.php';


  $session = new Session();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User profile</title>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link type="text/css" rel="stylesheet" href="assets/css/profile.css">
    
</head>

<?php
    
    echo 
    '<div id="topnav">
      <a href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="about.php">About</a>';
      if(!isset($_SESSION['user_id'])){
        echo '
          <a style="float:right;" href="sign-up.php">Sign Up</a>
          <a style="float:right;" href="login.php">Log In</a>
        </div>';
      } else {
        echo '
          <a style="float:right;"  class="active1" href="profile.php">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
        </div>';
      }


  ?>

<body>  
<script defer src="../Q_and_A_Aplication/assets/js/userinfo.js"></script>
    <div id="containerpopup">
      <div id="popUp">
        <button id="close">&times;</button>
        <p id = "content"></p>
      </div>
    </div>

    <?php
      if(isset($_SESSION['user_id']))
      {
        echo ' <p class="welcome"> Hello '. $_SESSION['user_id'].' <p>'; ?>
        <div class="profile-body">
       
        <div class="questions">
          <h3>Your questions</h3>
          <p id="q_numb">total questions: </p>
          <div class="scroll-data">
          </div>
        </div>
        <div class="answers">
          <h3>Your answers</h3>
          <p id="a_numb">total answers: </p>
          <div class="scroll-data">
          </div>
        </div>
        <div class="badges">
            <p>Badges</p>
          <div>
            <div id="container_questions">
                <div class="badge-item">
                </div>
            </div>
          <div id="container_answers">
                <div class="badge-item">
                </div>
          </div>
        </div>
        </div>
        <!--
        <div class="update-info">
        <form id="update" name="update">
            <h3>Update your info</h3>
            <span id="msg"></span>

            <label for="username">Username</label>
            <input type="text"  id="username" name="username"  required >

            <label for="username">First Name</label>
            <input type="text"  id="first" name="firstname" required>

            <label for="username">Last Name</label>
            <input type="text"  id="last" name="lastname" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email"  required>

            <label for="password">Password</label>
            <input type="password"  id="password" name="password" placeholder="You can provide a new password" minlength="8">

            <button id="button">Save</button>

        </form>
        </div>
      -->



        </div>



<?php
      } else {
        echo '<div class="shouldnt-be-here"><p>HOOPS!</p> You shouldnt be here, go back to the <a href="home.php"> mainpage</a> or <a href="login.php">login</a> first.</div>';
      }
    ?>
</body>
</html>