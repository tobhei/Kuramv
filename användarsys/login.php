
<?php
    include_once 'header.php';  
?>
    <section>
        <h2>Inloggning</h2>
        <form action="inkludering/login.ink.php" method="post">
            <input type="text" name="uid" placeholder="Username/Email">
            <input type="password" name="pwd" placeholder="Lösenord">
            <button type="submit" name="submit">logga in</button>
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
    </section>