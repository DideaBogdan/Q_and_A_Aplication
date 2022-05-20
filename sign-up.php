<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';
  $session = new Session();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SignUp</title>
    
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
        <link href="assets/css/signup.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/navbar.css">
        <script defer src="assets/js/signup.js"></script>
        
    </head>

    <?php
    
    echo 
    '<div id="topnav">
      <a href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="about.php">About</a>';
      if(!isset($_SESSION['user_id'])){
        echo'
          <a style="float:right;" class="active1" href="sign-up.php">Sign Up</a>
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
        <div class="background"> </div> 
        <form id="register" name="register">
            <h3>Sign Up</h3>
            <span id="msg"></span>

            <label for="username">Username</label>
            <input type="text" placeholder="Email or Phone" id="username" name="username" required >

            <label for="username">First Name</label>
            <input type="text" placeholder="First Name" id="first" name="firstname" required>

            <label for="username">Last Name</label>
            <input type="text" placeholder="Last Name" id="last" name="lastname" required>

            <label for="email">Email Address</label>
            <input type="email" placeholder="Email or Phone" id="email" name="email"  required>

            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" name="password" required minlength="8">

            <button id="button">Sign Up</button>

        </form>
    </body>
</html>
<?php
   session_destroy();
?>