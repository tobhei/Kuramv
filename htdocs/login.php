<?php include "helpers/header.php"?>
    <section>
    <link rel="stylesheet" href="style.css">
    <body>
    <div class="navbar">
    <a href="index.php">HEM</a>
    <?php
    
    if (isset($_SESSION["useruid"])) {
    echo "<a href='profilsida.php'> Profilsida </a> ";
    echo "<a href='inkludering/logout.ink.php'> logga ut </a> ";
    } else {
    echo "<a href='signup.php'> Skapa konto </a> ";
    }
    ?>
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