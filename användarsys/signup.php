<?php
    include_once 'header.php';  
?>
    <section>
        <h2>Skapa konto</h2>
        <form action="inkludering/signup.ink.php" method="post">
            <input type="text" name="fnamn" placeholder="Förnamn">
            <input type="text" name="enamn" placeholder="Efternamn">
            <input type="email" name="email" placeholder="E-mailadress">
            <input type="text" name="uid" placeholder="Användarnamn">
            <input type="password" name="pwd" placeholder="Lösenord">
            <input type="password" name="pwdrepeat" placeholder="upprepa lösenord">
            <button type="submit" name="submit">Skapa konto</button>
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

