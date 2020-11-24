<?php
    session_start();
?>
<DOCTYPE! html>
    <html>
        <head>
            <nav>
                <ul>
                    <?php
                        if (isset($_SESSION["useruid"])) {
                            echo "<li><a href='profil.php'>Profil sida</a></li>";
                            echo "<li><a href='inkludering/logout.ink.php'>logga ut</a></li>";
                        } else {
                            echo "<li><a href='login.php'>Logga in</a></li>";
                            echo "<li><a href='signup.php'>Skapa konto</a></li>";
                        }
                    ?>
                </ul>
            </nav>
        </head>
    </html>