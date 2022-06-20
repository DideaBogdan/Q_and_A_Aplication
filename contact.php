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
  <title>Q&A - Contact</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/contact.css">
  <script defer src="assets/js/contact.js"></script>
</head>

<body>  
<?php
    
    echo 
    '<div id="topnav">
      <a href="home.php">Home</a>
      <a class="active" href="contact.php">Contact</a>
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

<div id="containerpopup">
        <div id="popUp">
          <button id="close">&times;</button>
          <p id = "content">The message was successfully sent!</p>
          <button id="buttons" onclick="window.location.href='home.php'">Home</button>
        </div>
</div>


<section>
    <div id="contact-title"><h3>Contact</h3></div>
    <div id="contact">
      <div class="formular">
        <form id="contact" name="contact">
  
          <div id="form-col1">
          <label>Nume: </label>
          <input type="text" id="name" name="name" placeholder="Introduceti numele" required>
          
          <label>Email: </label>
          <input type="email" id="email" name="email" placeholder="exemplu@gmail.com" required>
          
          <label >Telefon: </label>
          <input type="text" id="phone" name="phone" placeholder="+40712309876" required>
        </div>
  
        <div id="form-col2">
          <label for="subject">Subiect: </label>
          <textarea id="subject" name="subject" placeholder="Informatii" style="height:200px"></textarea>
        </div>
        <button id="button">Submit</button>
    
        </form>
      </div>

      <div class="more-info">
        <h3>Pentru mai multe informatii, nu ezitati sa ne contactati prin:</h3>
        <p><strong>Telefon:</strong> +40 232 201090</p>
        <p><strong>Mail:</strong> qa.knowledge.bag@gmail.com</p>
        <p><strong>Fax:</strong> +40 21 243 0578</p>
      </div>
    </div>
</section>
  
  
</body>
</html>