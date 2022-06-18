<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';
  include_once '../Q_and_A_Aplication/api/config/Database.php';


  $session = new Session();

  $database = new Database();
  $db = $database->connect();

  $username = $_SESSION['user_id'] ?? null;
  $error = null;

  if(isset($_SESSION['user_id'])){
    $statement = $db->prepare('SELECT id FROM users WHERE username = :username');
  $statement->bindValue(':username',$username);
  $statement->execute();
  $user_id = $statement->fetch();

  $statement = $db->prepare('SELECT COUNT(*) FROM questions WHERE user = :id');
  $statement->bindValue(':id',$user_id[0]);
  $statement->execute();
  $total_questions = $statement->fetch();

  $statement = $db->prepare('SELECT COUNT(*) FROM answers WHERE user = :id');
  $statement->bindValue(':id',$user_id[0]);
  $statement->execute();
  $total_answers = $statement->fetch();

  $statement_question = $db->prepare('SELECT * FROM questions WHERE user = :id');
  $statement_question->bindValue(':id',$user_id[0]);
  $statement_question->execute();
  $questions = $statement_question->fetchAll(PDO::FETCH_ASSOC);

  $statement_answer = $db->prepare('SELECT * FROM answers WHERE user = :id');
  $statement_answer->bindValue(':id',$user_id[0]);
  $statement_answer->execute();
  $answers = $statement_answer->fetchAll(PDO::FETCH_ASSOC);

  $statement = $db->prepare('SELECT * FROM users WHERE id = :id');
  $statement->bindValue(':id',$user_id[0]);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $db->prepare('SELECT username, email FROM users WHERE id != :id');
  $statement->bindValue(':id',$user_id[0]);
  $statement->execute();
  $allUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

  $password = $user['password'];
  $firstname = $user['firstname'];
  $lastname = $user['lastname'];
  $email = $user['email'];

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    foreach($allUsers as $userinfo):  
    if($userinfo['email'] == $email || $userinfo['username'] == $username){
      $error = "Username or email already taken!";
    }
    endforeach; 

    if($error == null){
      $statement = $db->prepare("UPDATE users SET username = :username, password = :password, firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");

      $_SESSION['user_id'] = $username;

      $statement->bindValue(':username', $username);
      $statement->bindValue(':password', $password);
      $statement->bindValue(':firstname', $firstname);
      $statement->bindValue(':lastname', $lastname);
      $statement->bindValue(':email', $email);
      $statement->bindValue(':id',$user_id[0]);
      $statement->execute();

    }
  }

  }

  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User profile</title>
    <meta charset="UTF-8">
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
    <?php
      if(isset($_SESSION['user_id']))
      {
        echo ' <p class="welcome"> Hello '. $_SESSION['user_id'].' <p>'; ?>
        <div class="profile-body">
        <div class="badges">
          <p>Badges</p>
        </div>
        <div class="questions">
          <h3>Your questions</h3>
          <p>total questions: <?php echo $total_questions[0]; ?></p>
          <div class="scroll-data">
            <?php foreach($questions as $question):  ?>
              <a href="detailed.php?id=<?php echo $question['id'] ?>"> <?php echo $question['text']; ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="answers">
          <h3>Your answers</h3>
          <p>total answers: <?php echo $total_answers[0] ?></p>
          <div class="scroll-data">
          <?php foreach($answers as $answer):  ?>
              <a href="detailed.php?id=<?php echo $answer['question'] ?>"> <?php echo $answer['text']; ?></a>
            <?php endforeach; ?>
      </div>
        </div>
        <div class="update-info">
        <form action="" method="post">
          <?php if($_SERVER['REQUEST_METHOD'] == 'POST' && $error == null){ ?>
            <h2>Data saved successfully!</h2>
         <?php } 
          ?>
            <h3>Edit your info</h3>
            <span id="msg">
              <?php if($error != null){
                echo $error;
              } ?>
            </span>

            <label for="username">Username</label>
            <input type="text"  id="username" name="username" value="<?php echo $username ?>" required >

            <label for="username">First Name</label>
            <input type="text"  id="first" name="firstname" value="<?php echo $firstname ?>" required>

            <label for="username">Last Name</label>
            <input type="text"  id="last" name="lastname" value="<?php echo $lastname ?>" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email"  value="<?php echo $email ?>" required>

            <label for="password">Password</label>
            <input type="password"  id="password" name="password" value="<?php echo $password ?>" required minlength="8">

            <button id="button">Save</button>

        </form>
        </div>



        </div>



<?php
      } else {
        echo '<div class="shouldnt-be-here"><p>HOOPS!</p> You shouldnt be here, go back to the <a href="home.php"> mainpage</a> or <a href="login.php">login</a> first.</div>';
      }
        

        // badges - adaugare info - apar intrebarile si raspunsurile userului
    ?>
</body>
</html>