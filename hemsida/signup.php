<?php session_start(); ?>
<!DOCTYPE html>
    <section>
    <link rel="stylesheet" href="style.css">
    <body>
    <div class="navbar">
    <a href="varuregister.php">Home</a>
    <?php
    if (isset($_SESSION["useruid"])) {
    echo "<a href='profilsida.php'> Profil sida </a> ";
    echo "<a href='helpers/logout.ink.php'> logga ut </a> ";
    } else {
    echo "<a href='login.php'> Logga in</a> ";
    }
    ?>
    </div>
    </body>
        <div class="signupform">
        <h1>Skapa konto</h1>
        <form action="helpers/signup.ink.php" method="post">
            <input class="inputbox" type="text" name="fnamn" placeholder="Förnamn">
            <input class="inputbox" type="text" name="enamn" placeholder="Efternamn">
            <input class="inputbox" type="email" name="email" placeholder="E-mailadress">
            <input class="inputbox" type="text" name="uid" placeholder="Användarnamn">
            <input class="inputbox" type="password" name="pwd" placeholder="Lösenord">
            <input class="inputbox" type="password" name="pwdrepeat" placeholder="upprepa lösenord">
            <button class="signupknapp" type="submit" name="submit">Skapa konto</button>
            <p class="eller">ELLER</p>
            <p>Har du redan ett <a href="helpers/login.ink.php">konto?</a></p>
        </form>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fyll i alla fält</p>";
            } else if ($_GET["error"] == "invaliduid") {
                echo "<p>Välj ett riktigt användarnamn</p>";

            } else if ($_GET["error"] == "passwordsdontmatch") {
                echo "<p>Lösenorden överensstämmer inte</p>";

            } else if ($_GET["error"] == "stmtfailed") {

                echo "<p>Hoppsan någt gick fel</p>";

            } else if ($_GET["error"] == "usernametaken") {
                echo "<p>Användarnamn finns redan</p>";

            } else if ($_GET["error"] == "none") {
                echo "<p>Du har skapat ett konto</p>";
            }
        }
        ?>
    </section>

