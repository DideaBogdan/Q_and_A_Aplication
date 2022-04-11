<?php 
  include_once 'header.php'
?>

    <section class="sign-up-form">
        <div class="form-signup">
            <h2>Log in</h2>
            <form action="includes/log-in.inc.php" method="post">
                <input type="text" name="name" placeholder="Usenamer or email">
                <input type="password" name="pwd" placeholder="Password">
                </br>
                <button type = "submit" name="sumbit">Log in</button>
            </form>
        </div>  
        <?php
            if(isset($_GET["error"])){
                if($_GET["error"] == "emptyinput"){
                    echo "<p> Fill in all fiels!</p>";
                }
                else if($_GET["error"] == "wronglogin"){
                    echo "<p> Incorrect log in information!</p>";
                }
            }
            ?>  
    </section>



<?php
  include_once 'footer.php'
?>