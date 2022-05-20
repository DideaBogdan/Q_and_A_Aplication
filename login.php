<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';

  $session = new Session();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log In</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <script defer src="assets/js/login.js"></script>
    
</head>
<?php
    
    echo 
    '<div id="topnav">
      <a href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="about.php">About</a>';
      if(!isset($_SESSION['user_id'])){
        echo'
          <a style="float:right;" href="sign-up.php">Sign Up</a>
          <a style="float:right;" class="active1" href="login.php">Log In</a>
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
    <form id="login" name="login">
        <h3>Login Here</h3>

        <span id="msg-login"></span>

        <label for="username">Username or Email</label>
        <input type="text" placeholder="Username or Email" id="username" name="username" required >
        
        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password" required minlength="8">

        <button id="button">Log In</button>
        
  
    </form>
</body>
</html>

<?php
   session_destroy();
?>
