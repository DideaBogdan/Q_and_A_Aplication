<?php 
  include_once 'header.php'
?>

    <section class="sign-up-form">
        <div class="form-signup">
            <h2>Sign up</h2>
            <form action="includes/sign-up.inc.php" method="post">
                <input type="text" name="name" placeholder="Full name">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwdrepeat" placeholder=" Repeat password">
                </br>
                <button type = "submit" name="sumbit">Sign up</button>
            </form>
       
        
            <?php
            if(isset($_GET["error"])){
                if($_GET["error"] == "emptyinput"){
                    echo "<p> Fill in all fiels!</p>";
                }
                else if($_GET["error"] == "invaliduser"){
                    echo "<p> Choose a proper username!</p>";
                }
                else if($_GET["error"] == "invalidemail"){
                    echo "<p> Choose a valid email!</p>";
                }
                else if($_GET["error"] == "differentpasswords"){
                    echo "<p> Passwords are different!</p>";
                }
                else if($_GET["error"] == "usernametaken"){
                    echo "<p> Username already taken, choose another!</p>";
                }
                else if($_GET["error"] == "none"){
                    echo "<p> You have signed up!</p>";
                }
            }
            ?>
        </div>  
    </section>



<?php

  include_once 'footer.php'

?>