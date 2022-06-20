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
  $statement->bindValue(':id',$user_id);
  $statement->execute();
  $total_questions = $statement->fetch();

  $statement = $db->prepare('SELECT COUNT(*) FROM answers WHERE user = :id');
  $statement->bindValue(':id',$user_id);
  $statement->execute();
  $total_answers = $statement->fetch();

  $statement_question = $db->prepare('SELECT * FROM questions WHERE user = :id');
  $statement_question->bindValue(':id',$user_id);
  $statement_question->execute();
  $questions = $statement_question->fetchAll(PDO::FETCH_ASSOC);

  $statement_answer = $db->prepare('SELECT * FROM answers WHERE user = :id');
  $statement_answer->bindValue(':id',$user_id);
  $statement_answer->execute();
  $answers = $statement_answer->fetchAll(PDO::FETCH_ASSOC);

  $statement = $db->prepare('SELECT * FROM users WHERE id = :id');
  $statement->bindValue(':id',$user_id);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $db->prepare('SELECT username, email FROM users WHERE id != :id');
  $statement->bindValue(':id',$user_id);
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
      $statement->bindValue(':id',$user_id);
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
        if(isset($_SESSION['user_id'])){
          echo ' 
          <a style="float:right;" href="profile.php?username='.$_SESSION['user_id'] .'" class="active1">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
        </div>';
        } else{
          echo ' 
          <a style="float:right;" href="profile.php" class="active1">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
          </div>';
        }
      }

  ?>
<<<<<<< Updated upstream

<body>  
=======
<body> 
<input type="hidden" id="session_var" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '' ?>"/> 
<input type="hidden" id="session_var_id" value="<?php echo isset($_SESSION['user_username']) ? $_SESSION['user_username'] : '' ?>"/>
<input type="hidden" id="user_username" value="<?php echo isset($_GET['username']) ? $_GET['username'] : '' ?>"/>
<script defer src="../Q_and_A_Aplication/assets/js/userinfo.js"></script>
    <div id="containerpopup">
      <div id="popUp">
        <button id="close">&times;</button>
        <p id = "content"></p>
      </div>
    </div>

>>>>>>> Stashed changes
    <?php
      if(isset($_SESSION['user_id']))
      {
        echo ' <p class="welcome"> Hello '. $_SESSION['user_id'].' <p>'; ?>
<<<<<<< Updated upstream
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
=======
        <div id="formButtons">
        <button id="showUpdateForm" class = "button">Update your info</button>
>>>>>>> Stashed changes
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

            <button class="button">Save</button>

        </form>
<<<<<<< Updated upstream
        </div>
=======
        <form id="hobby" name="hobby">
            <h3>Update your info</h3>
            <span id="msg"></span>
>>>>>>> Stashed changes

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

            <button class="button">Save</button>

        </form>
        </div>

        </div>
        <div class="profile-body"> 
        <div id="user-info">
          <h3>Hello user</h3>
        </div>
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
        </div>



<?php
      } else {
        echo '<div class="shouldnt-be-here"><p>HOOPS!</p> You shouldnt be here, go back to the <a href="home.php"> mainpage</a> or <a href="login.php">login</a> first.</div>';
      }
        

        // badges - adaugare info - apar intrebarile si raspunsurile userului
    ?>
</body>
</html>