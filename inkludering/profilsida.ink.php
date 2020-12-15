<?php
require 'dbpek.ink.php';
$userid = $_GET['userId'];
$query = mysqli_query($conn,"SELECT * FROM users WHERE userId='$userid'");
$data = mysqli_fetch_array($query);

if (isset($_POST['uppdatera'])) {
    $fnamn = $_POST['fnamn'];
    $enamn = $_POST['enamn'];
    $email = $_POST['email'];
        
    if (empty($_FILES["profilbild"]['name'])) {
        $errorBild = "Varan behöver en bild.";
    }
    
    else {
        $target_dir = "../Bilder/{$userid}/";
        if(!file_exists($target_dir)) mkdir("../Bilder/{$userid}/");
        $target_file = $target_dir . basename($_FILES["profilbild"]['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        $check = getimagesize($_FILES["profilbild"]['tmp_name']);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $errorBild = "Filen är inte en bild.";
            $uploadOk = 0;
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $errorBild = "Enbart jpg, jpeg och png-filer är tillåtna.";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            $errorBild = "Oops, nåt gick fel <br>" .$errorBild;
        } else {
            if (move_uploaded_file($_FILES["profilbild"]['tmp_name'], $target_file)) {
            } else {
                echo "Oops, nåt gick fel";
            }
        }
}
$target_file = "Bilder/{$userid}/" . basename($_FILES["profilbild"]['name']);
$ändra = mysqli_query($conn,"UPDATE users SET usersFname='$fnamn', usersEname='$enamn', usersEmail='$email', profilePic='$target_file' where userId='$userid' ");
if($ändra) {
    header("location: ../profilsida.php");
    exit;
} else {
    echo mysqli_error();
}	
} 

?>

<h3>Uppdatera uppgifter</h3>

<form method="POST" enctype="multipart/form-data">
<input type="text" name="fnamn" value="<?php echo $data[1] ?>" placeholder="Skriv förnman" Required>
<input type="text" name="enamn" value="<?php echo $data[2] ?>" placeholder="Skriv efternamn" Required>
<input type="text" name="email" value="<?php echo $data[3] ?>" placeholder="fyll i epost" Required>
<input type="file" id="profilbild" name="profilbild">
<input type="submit" name="uppdatera" value="uppdatera">
</form>

