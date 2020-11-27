<!DOCTYPE html>
<html lang="se">

<head>
	
	<title> Registrera en vara </title>
	
	<style>
		
		.head {
			font-size: 40px;
		}
		
		.registerform {
			font-size: 20px;
			margin: 20px;
		}
		
	</style>
	
</head>

<body>

	<!-- Kolla ifall den fyllts i -->
	
	<?php
	$registrerat = "";
	$errorNamn = "";
	$errorPris = "";
	$errorBild = "";
	
	if (isset($_POST["Varunamn"])) {
		$varuID = md5($_POST["Varunamn"]);
		$varuID = substr($varuID, 0, 8);
		
		if (empty($_POST["Varunamn"])) {
			$errorNamn = "Varan behöver ett namn.";
		}
		
		if (strlen($_POST["Varunamn"]) > 60) {
			$errorNamn = "Varans namn kan inte vara större än 60 tecken.";
		}
	}
	
	if (isset($_POST["Pris"])) {
		if (empty($_POST["Pris"])) {
			$errorPris = "Varan måste ha ett pris.";
		}
		
		if (($_POST["Pris"]) > PHP_INT_MAX) {
			$errorPris = "Jag tror inte någon kommer köpa varan vid det priset.";
		}
	}
	
	if(isset($_FILES["Varubild"]['name'])) {
		if (empty($_FILES["Varubild"]['name'])) {
			$errorBild = "Varan behöver en bild.";
		}
		
		else {
			$target_dir = "resource/{$varuID}/";
			if(!file_exists($target_dir)) mkdir("resource/{$varuID}/");
			$target_file = $target_dir . basename($_FILES["Varubild"]['name']);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$check = getimagesize($_FILES["Varubild"]['tmp_name']);
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
			} else if (strlen($errorNamn) == 0 && strlen($errorPris) == 0) {
				if (move_uploaded_file($_FILES["Varubild"]['tmp_name'], $target_file)) {
					$registrerat = "Varan " .$_POST["Varunamn"] ." har registrerats.";
				} else {
					echo "Oops, nåt gick fel";
				}
			}
		}
	}
	?>

	<form action="varuregistrering.php" method="POST" enctype="multipart/form-data">
		<fieldset class="registerform">
			<legend class="head">Registrera en vara</legend>
			
			<div class="registerform">
			<label for="Varunamn">Varunamn:</label><br>
			<input type="text" id="Varunamn" name="Varunamn"><br>
			<?php
			echo $errorNamn;
			?>
			</div>
			
			<div class="registerform">
			<label for="Pris">Pris:</label><br>
			<input type="number" id="Pris" name="Pris"> kr<br>
			<?php
			echo $errorPris;
			?>
			</div>
			
			<div class="registerform">
			<label for="Varubild">Bild på varan:</label><br>
			<input type="file" id="Varubild" name="Varubild"><br>
			<?php
			echo $errorBild;
			?>
			</div>
			
			<input type="submit" value="Submit" style="padding:20px; margin:20px;">
		</fieldset>
	</form>
	
	<?php
	if (strlen($registrerat) > 0) {
		
		$conn = include 'setup.php';
		
		$sql = "INSERT INTO " .$dbname .".Varor (VaruID, Namn, Pris, ResourceURL)
				VALUES ('{$varuID}', '{$_POST["Varunamn"]}', {$_POST["Pris"]}, '{$target_file}');"; 
				
		if ($conn->query($sql) === TRUE) {
			echo "<h1>" .$registrerat ."</h1>";
		} else {
			
			do {
				$str=rand();
				$varuID = md5($str);
				$varuID = substr($varuID, 0, 8);
				
				$sql = "INSERT INTO " .$dbname .".Varor (VaruID, Namn, Pris, ResourceURL)
						VALUES ('{$varuID}', '{$_POST["Varunamn"]}', {$_POST["Pris"]}, '{$target_file}');"; 
			} while ($conn->query($sql) === FALSE);
			
			echo "<h1>" .$registrerat ."</h1>";
		}
		
		$conn->close();	
	}
	?>
	
</body>