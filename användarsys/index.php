<?php
    include_once 'header.php';  
?>
<section>
<?php
    if (isset($_SESSION["useruid"])) {
        echo "<p>Nämen tjena " . $_SESSION["useruid"] . "</p>";
        }
?>
</section>
