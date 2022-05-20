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



    <div id="contact-title"><h3>Contact</h3></div>
    <div id="contact">
      <div class="formular">
        <form id="form" method="POST" action="https://script.google.com/macros/s/AKfycbxt7GT3aGm1mIY-0PjFFUSWSOMGi7Rax2yxixBxTgHRc3mDTHMj1hOiTnpacI33jKeKng/exec">
  
          <div id="form-col1">
          <label>Nume: </label>
          <input type="text" id="name" name="name" placeholder="Introduceti numele" required>
          <!---!> <label for="region">Judet: </label>
         <select id="region" name="region">
            <option value="Alba">Alba</option>
            <option value="Arad">Arad</option>
            <option value="Arges">Arges</option>
            <option value="Bacau">Bacau</option>
            <option value="Bihor">Bihor</option>
            <option value="Bistrita">Bistrita</option>
            <option value="Botosani">Botosani</option>
            <option value="Brasov">Brasov</option>
            <option value="Braila">Braila</option>
            <option value="Bucuresti">București</option>
            <option value="Caras-Severin">Caraș-Severin</option>
            <option value="Calarasi">Călărași</option>
            <option value="Cluj">Cluj</option>
            <option value="Constanta">Constanța</option>
            <option value="Covasna">Covasna</option>
            <option value="Dambovita">Dâmbovița</option>
            <option value="Dolj">Dolj</option>
            <option value="Galati">Galați</option>
            <option value="Giurgiu">Giurgiu</option>
            <option value="Gorj">Gorj</option>
            <option value="Harghita">Harghita</option>
            <option value="Hunedoara">Hunedoara</option>
            <option value="Ialomita">Ialomița</option>
            <option value="Iasi">Iasi</option>
            <option value="Ilfov">Ilfov</option>
            <option value="Maramures">Maramureș</option>
            <option value="Mehedinti">Mehedinți</option>
            <option value="Mures">Mureș</option>
            <option value="Neamt">Neamț</option>
            <option value="Olt">Olt</option>
            <option value="Prahova">Prahova</option>
            <option value="Satu Mare">Satu Mare</option>
            <option value="Salaj">Sălaj</option>
            <option value="Sibiu">Sibiu</option>
            <option value="Suceava">Suceava</option>
            <option value="Teleorman">Teleorman</option>
            <option value="Timis">Timiș</option>
            <option value="Tulcea">Tulcea</option>
            <option value="Vaslui">Vaslui</option>
            <option value="Valcea">Valcea</option>
            <option value="Vrancea">Vrancea</option>
          </select> 
          <--->
          <label>Email: </label>
          <input type="email" id="email" name="email" placeholder="exemplu@gmail.com" required>
          
          <label >Telefon: </label>
          <input type="text" id="phone" name="phone" placeholder="+40712309876" required>
        </div>
  
        <div id="form-col2">
          <label for="subject">Subiect: </label>
          <textarea id="subject" name="subject" placeholder="Informatii" style="height:200px"></textarea>
        </div>
  
        <div id="form-col3">
          <input type="submit" value="Submit">
        </div>
      
        </form>
      </div>
      <div class="more-info">
        <h3>Pentru mai multe informatii, nu ezitati sa ne contactati prin:</h3>
        <p><strong>Telefon:</strong> +40 232 201090</p>
        <p><strong>Mail:</strong> Q&A_everything@gmail.com</p>
        <p><strong>Fax:</strong> +40 21 243 0578</p>
      </div>
    </div>

  

</div>
<script  src="https://smtpjs.com/v3/smtp.js"> </script>
  <script>
    function sendEmail(){
      Email.send({
      Host : "smtp.gmail.com",
      Username : "qa.knowledge.bag@gmail.com",
      Password : "TW2022QA", //DF6777516F92220606BED0D0BF62F832B09D
      To : "qa.knowledge.bag@gmail.com",
      From : document.getElementById("email").value,
      Subject : "New contact:",
      Body : "Name: " + document.getElementById("name").value
      +"<br> Email: " + document.getElementById("email").value
      +"<br> Telefon: " + document.getElementById("phone").value
      +"<br> Mesaj: " + document.getElementById("subject").value
      
      }).then(
          message => alert("Message succesfull!")
          );
    }
  </script>
  <script type="text/javascript" src="assets/js/scripts.js"></script>
  <script> src="https://smtpjs.com/v3/smtp.js" </script>
  <script>
    function sendEmail(){
      Email.send({
      Host : "smtp.gamil.com",
      Username : "username",
      Password : "password",
      To : 'qa.knowledge.bag@gmail.com',
      From : document.getElementById("email").value,
      Subject : "New contact:",
      Body : "Name: " + document.getElementById("name").value
      +"<br> Email: " + document.getElementById("email").value
      +"<br> Telefon: " + document.getElementById("phone").value
      +"<br> Mesaj: " + document.getElementById("subject").value
      
      }).then(
          message => alert(subject)
          );
    }
  </script>
</body>
</html>