<?php
    include_once 'header.php';  
?>
<link rel="stylesheet" href="style.php">
<body>
        <div class="header">
            <h1><a href="index.php">Shoppaloss</a></h1>
        </div>
<div class="navbar">
<?php
if (isset($_SESSION["useruid"])) {
  echo "<a href='profilsida.php'> Profil sida </a> ";
  echo "<a href='inkludering/logout.ink.php'> logga ut </a> ";
  } else {
  echo "<a href='login.php'> Logga in</a> ";
  echo "<a href='signup.php'> Skapa konto </a> ";
  }
  ?>
</div>
</body>
<?php
    include_once 'footer.php';  
?>
</html>
