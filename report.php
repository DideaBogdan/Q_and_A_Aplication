<!DOCTYPE html>
<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';
  include_once '../Q_and_A_Aplication/api/config/Database.php';

  $session = new Session();

  $db = new Database();
  $pdo =$db ->connect();

  $time_period = $_GET['time'] ?? null;
  $category_criteria = $_GET['question-category'] ?? null;


  $statement = $pdo->prepare('SELECT name FROM categories');
  $statement->execute();
  $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

  $statement = $pdo->prepare('SELECT * FROM questions');
  $statement->execute();
  $questions = $statement->fetchAll(PDO::FETCH_ASSOC);

  $statement = $pdo->prepare('SELECT * FROM answers');
  $statement->execute();
  $answers = $statement->fetchAll(PDO::FETCH_ASSOC);

  if($category_criteria && $category_criteria!='any'){
    if($time_period && $time_period!='since forever'){
       switch($time_period){
        case 'last hour':
          $statement = $pdo->prepare('SELECT * FROM  questions WHERE created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR) AND category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
          $statement = $pdo->prepare('SELECT answers.* FROM  answers JOIN questions ON answers.question=questions.id WHERE answers.created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR) AND questions.category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
          break;
        case 'last day':
          $statement = $pdo->prepare('SELECT * FROM questions WHERE created_at >= DATE_SUB(NOW(),INTERVAL 1 day) AND category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
          $statement = $pdo->prepare('SELECT answers.* FROM  answers JOIN questions ON answers.question=questions.id WHERE answers.created_at >= DATE_SUB(NOW(),INTERVAL 1 day) AND questions.category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
          break;
        case 'last week':
          $statement = $pdo->prepare('SELECT * FROM questions WHERE created_at >= DATE_SUB(CURDATE(),INTERVAL 7 day) AND category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
          $statement = $pdo->prepare('SELECT answers.* FROM  answers JOIN questions ON answers.question=questions.id WHERE answers.created_at >= DATE_SUB(CURDATE(),INTERVAL 7 day) AND questions.category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
          break;
        case 'last month':
          $statement = $pdo->prepare('SELECT * FROM questions WHERE created_at > (NOW() - INTERVAL 1 MONTH) AND category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
          $statement = $pdo->prepare('SELECT answers.* FROM  answers JOIN questions ON answers.question=questions.id WHERE answers.created_at > (NOW() - INTERVAL 1 MONTH) AND questions.category=:category');
          $statement->bindValue(':category',$category_criteria);
          $statement->execute();
          $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
          break;
       }
    }
    else{
      $statement = $pdo->prepare('SELECT * FROM  questions WHERE category=:category');
      $statement->bindValue(':category',$category_criteria);
      $statement->execute();
      $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
      $statement = $pdo->prepare('SELECT answers.* FROM  answers JOIN questions ON answers.question=questions.id WHERE questions.category=:category');
      $statement->bindValue(':category',$category_criteria);
      $statement->execute();
      $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
  }
  else if($time_period && $time_period!='since forever'){
    switch($time_period){
      case 'last hour':
        $statement = $pdo->prepare('SELECT * FROM  questions WHERE created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR)');
        $statement->execute();
        $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement = $pdo->prepare('SELECT * FROM  answers WHERE created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR)');
        $statement->execute();
        $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
        break;
      case 'last day':
        $statement = $pdo->prepare('SELECT * FROM questions WHERE created_at >= DATE_SUB(NOW(),INTERVAL 1 day)');
        $statement->execute();
        $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement = $pdo->prepare('SELECT * FROM  answers WHERE created_at >= DATE_SUB(NOW(),INTERVAL 1 day)');
        $statement->execute();
        $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
        break;
      case 'last week':
        $statement = $pdo->prepare('SELECT * FROM questions WHERE created_at >= DATE_SUB(CURDATE(),INTERVAL 7 day)');
        $statement->execute();
        $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement = $pdo->prepare('SELECT * FROM  answers WHERE created_at >= DATE_SUB(CURDATE(),INTERVAL 7 day)');
        $statement->execute();
        $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
        break;
      case 'last month':
        $statement = $pdo->prepare('SELECT * FROM questions WHERE created_at > (NOW() - INTERVAL 1 MONTH)');
        $statement->execute();
        $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement = $pdo->prepare('SELECT * FROM  answers WHERE created_at > (NOW() - INTERVAL 1 MONTH)');
        $statement->execute();
        $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
        break;
     }

  }



?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>App report</title>
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/report.css">
  </head>
  <!--Nav bar-->
  <?php
    
    echo 
    '<div id="topnav">
      <a href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="about.php">About</a>
      <a class="active" href="report.php">Report</a>';
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

  <body>
    <h3>App activity</h3>
    <div class="criteria">
        <h4>Select report criteria</h4>
        <form>
          <label for="time">Period of time:</label>
          <select id="time" name="time">
            <option value="last hour">last hour</option>
            <option value="last day">last day</option>
            <option value="last week">last week</option>
            <option value="last month">last months</option>
            <option value="since forever" selected>since forever</option>
          </select>
          <label for="question-category">Category:</label>
          <select id="question-category" name="question-category">
            <option value="any" selected>any</option>
            <?php foreach($categories as $categorie){ ?>
              <option value="<?php echo $categorie['name'] ?>"><?php echo $categorie['name'] ?></option>
            <?php } ?>
          </select>
          <button>Show</button>
        </form>
    </div>
    <table class="table">
  <thead>
    <tr>
      <caption>Questions</caption>
    </tr>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Question</th>
      <th scope="col">Category</th>
      <th scope="col">Answers</th>
      <th scope="col">Create Date</th>
      <th scope="col">Likes</th>
      <th scope="col">Dislikes</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($questions as $i => $question){?>
    <tr>
      <th scope="row"><?php echo $i+1?></th>
      <td><?php echo $question['text'] ?></td>
      <td><?php echo $question['category'] ?></td>
      <td><?php 
      $statement = $pdo->prepare('SELECT COUNT(*) FROM answers WHERE question=:question');
      $statement->bindValue(':question',$question['id']);
      $statement->execute();
      $count_answers = $statement->fetch();
      echo $count_answers[0] ?></td>
      <td><?php echo $question['created_at'] ?></td>
      <td><?php
      $statement = $pdo->prepare('SELECT COUNT(*) FROM reactions  WHERE id_post=:id_post AND is_question=1 AND reactions.like=1');
      $statement->bindValue(':id_post',$question['id']);
      $statement->execute();
      $count_likes = $statement->fetch();
      echo $count_likes[0] ?></td>
      <td><?php
      $statement = $pdo->prepare('SELECT COUNT(*) FROM reactions  WHERE id_post=:id_post AND is_question=1 AND reactions.dislike=1');
      $statement->bindValue(':id_post',$question['id']);
      $statement->execute();
      $count_dislikes = $statement->fetch();
      echo $count_dislikes[0] ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>


<table class="table">
  <thead>
    <tr>
      <caption>Answers</caption>
    </tr>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Answer</th>
      <th scope="col">Question</th>
      <th scope="col">Category</th>
      <th scope="col">Create Date</th>
      <th scope="col">Likes</th>
      <th scope="col">Dislikes</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($answers as $i => $answer){?>
    <tr>
      <th scope="row"><?php echo $i+1?></th>
      <td><?php echo $answer['text'] ?></td>
      <td><?php
      $statement = $pdo->prepare('SELECT text FROM questions WHERE id=:id');
      $statement->bindValue(':id',$answer['question']);
      $statement->execute();
      $specific_question = $statement->fetch();
      echo $specific_question[0] ?></td>
      <td><?php 
      $statement = $pdo->prepare('SELECT category FROM questions WHERE id=:id');
      $statement->bindValue(':id',$answer['question']);
      $statement->execute();
      $specific_category = $statement->fetch();
      echo $specific_category[0] ?></td>
      <td><?php echo $answer['created_at'] ?></td>
      <td><?php
      $statement = $pdo->prepare('SELECT COUNT(*) FROM reactions  WHERE id_post=:id_post AND is_question=0 AND reactions.like=1');
      $statement->bindValue(':id_post',$answer['id']);
      $statement->execute();
      $count_likes = $statement->fetch();
      echo $count_likes[0] ?></td>
      <td><?php
      $statement = $pdo->prepare('SELECT COUNT(*) FROM reactions  WHERE id_post=:id_post AND is_question=0 AND reactions.dislike=1');
      $statement->bindValue(':id_post',$answer['id']);
      $statement->execute();
      $count_dislikes = $statement->fetch();
      echo $count_dislikes[0] ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>


  </body>

</html>