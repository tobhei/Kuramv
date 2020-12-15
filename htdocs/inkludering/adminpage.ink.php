<?php
    require 'dbpek.ink.php';
    $userid = $_GET['userId'];
    $query = mysqli_query($conn,"SELECT * FROM users WHERE userId='$userid'");
    $data = mysqli_fetch_array($query);

    if (isset($_POST['uppdatera'])) {
        $fnamn = $_POST['fnamn'];
        $enamn = $_POST['enamn'];
        $email = $_POST['email'];
            
        $ändra = mysqli_query($conn,"UPDATE users SET usersFname='$fnamn', usersEname='$enamn', usersEmail='$email' where userId='$userid' ");
            
        if($ändra) {
                header("location: ../adminpage.php");
                exit;
            } else {
                echo mysqli_error();
            }    	
    } 
?>

<h3>Uppdatera uppgifter</h3>

<form method="POST">
  <input type="text" name="fnamn" value="<?php echo $data['usersFname'] ?>" placeholder="Skriv förnman" Required><br>
  <input type="text" name="enamn" value="<?php echo $data['usersEname'] ?>" placeholder="Skriv efternamn" Required><br>
  <input type="text" name="email" value="<?php echo $data['usersEmail'] ?>" placeholder="fyll i epost" Required><br>
  <input type="submit" name="uppdatera" value="uppdatera">
</form>