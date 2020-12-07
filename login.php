<?php
    include 'helpers/header.php';
    //include_once 'header.php';
    $_SESSION["userfnamn"] = $uidExists["usersFnamn"];
    $_SESSION["userenamn"] = $uidExists["usersEnamn"];  
?>
    <section>
    <link rel="stylesheet" href="style.css">

    <body>
</div>
    </div>
    </body>
        <div class="loginform">
        <h2>Inloggning</h2>
        <form action="inkludering/login.ink.php" method="post">
            <input class="inputbox" type="text" name="uid" placeholder="Username/Email">
            <input class="inputbox" type="password" name="pwd" placeholder="Lösenord">
            <button class="signupknapp" type="submit" name="submit">logga in</button>
            <p class="eller">ELLER</p>
            <p>Har du inget <a href="inkludering/signup.ink.php">konto?</a></p>
        </form>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fyll i alla fält</p>";
            } else if ($_GET["error"] == "wronglogin") {
                echo "<p>Felaktigt inlogg</p>";
            }
        }
        ?>
        </div>
    </section>