<?php
 session_start();
 ?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Q&A</title>
  <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>

<body>
  <nav class = "topnav">
    <div>
      <ul>
        <li><a hrfer="index.php">Q&A(logo)</a></li>
        <li><a href="index.php">Home</a></li>
        <?php
          if(isset($_SESSION["useruid"])){
            echo '<li><a href="profile-page.php" class="user-buttons">Profile page</a></li>';
            echo '<li><a href="includes/log-out.inc.php" class="user-buttons">Log out</a></li>';    
          }
          else {
            echo '<li><a href="sign-up.php" class="user-buttons">Sign up</a></li>';
            echo '<li><a href="log-in.php" class="user-buttons">Log in</a></li>';
          }
        ?>
      </ul>       
    </div>
  </nav>
