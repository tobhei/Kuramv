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
		
		
		// Generera ny .php-fil för att visa varans sida
		$varuSida = fopen("resource/{$varuID}/vara.php", "w");
		
		$txt = "<!DOCTYPE html>
<html lang=\"se\">

<head>
	
	<title> {$_POST["Varunamn"]} </title>
	
	<style>
		
		* {
			box-sizing: border-box;
		}
		
		.head {
			font-size: 40px;
			text-align: left;
			padding: 20px;
		}
		
		<?php
		echo \"
		.attribute {
			font-size: 40px;
			margin: 20px;
			padding: 20px;
			background-color: hsl(\" .rand(0, 360) .\", 60%, 80%);
			border: 3px solid black;
		}
		\";
		?>
		
	</style>
	
</head>

<body>
	
	<?php
	
	\$conn = include '../../setup.php';
	
	\$select = \"SELECT VaruID, Namn, Pris, Betyg, ResourceURL FROM \$dbname.Varor WHERE VaruID = '{$varuID}'\";
	
	\$stmt = \$conn->prepare(\$select);
		
	if ( \$stmt===false ) {
		die('prepare() failed: ' . htmlspecialchars(\$conn->error));
	}
	
	\$stmt->execute();

	\$res = \$stmt->get_result();
	while((\$row = \$res->fetch_assoc()) != false){
		echo \"<div class='attribute' style='float: left; width: 50%;'>\";
		echo \$row['Namn'];
		echo \"<br> <img src='\" .basename(\$row['ResourceURL']) .\"' alt='{\$row['Namn']}' style='height: 300px;'>\";
		echo \"</div>\";
		
		echo \"<div class='attribute' style='float: left; width: 20%;'>\";
		echo \"Pris: \" .\$row['Pris'] .\"kr\";
		echo \"<br> Betyg: \" .\$row['Betyg'];
		if (isset(\$_SESSION['userid'])) {
		echo \"<form action='/varukorgUpdate.php' method='post' >

			<input type='hidden' id='kundnummer' name='kundnummer' value=\".\$_SESSION['userid'].\">
			<input type='hidden' id='varuid' name='varuid' value='{$varuID}'>
			<input type='hidden' id='antal' name='antal' value=1>                  
			<input type='submit' value='Lägg till i varukorgen'> 
			</form>\";
		}
		echo \"</div>\";
	}
	
	
	
	\$noReview = true;
	echo \"<div class='attribute' style='float: left; width: 50%; font-size: 20px'>\";
	// --- Recension gjord ---
	if (isset(\$_POST['betyg'])) {
		if (strlen(\$_POST[\"recension\"]) > 500) {
			echo \"Du tror att någon kommer läsa en recension på över 500 tecken HHHHHHHHAHA\";
		}
		
		else {
			\$noReview = false;
			
			\$sql = \"SELECT kundnummer, VaruID FROM \$dbname.recensioner WHERE kundnummer ='{\$_SESSION[\"userid\"]}' AND VaruID = '{$varuID}';\";
			\$result = \$conn->query(\$sql);

			if (\$result->num_rows > 0) {
				if (!empty(\$_POST[\"recension\"])) {
					\$sql = \$conn->prepare(\"UPDATE \$dbname.recensioner SET recension = ?, betyg = '{\$_POST[\"betyg\"]}', datum = '\".date('Y-m-d').\"' WHERE recensioner.kundnummer = {\$_SESSION[\"userid\"]} AND recensioner.VaruID = '{$varuID}'\");
					
					\$sql->bind_param(\"s\", \$_POST['recension']);
					
					if ( \$sql===false ) {
						die('prepare() failed: ' . htmlspecialchars(\$conn->error));
					} else {
						echo \"Tack för din recension!\";
					}
					
					\$sql->execute();
					
					\$sql->close();
					
				} else {
					\$sql = \"UPDATE \$dbname.recensioner SET betyg = '{\$_POST[\"betyg\"]}', datum = '\".date('Y-m-d').\"' WHERE recensioner.kundnummer = {\$_SESSION[\"userid\"]} AND recensioner.VaruID = '{$varuID}'\";
					
					if (\$conn->query(\$sql) === TRUE) {
						echo \"Tack för din recension!\";
					} else {
						echo \"Error: \" . \$sql . \"<br>\" . \$conn->error;
					}
				}
			} else {
				\$sql = \$conn->prepare(\"INSERT INTO \$dbname.recensioner (kundnummer, VaruID, recension, betyg, datum)
					VALUES ('{\$_SESSION[\"userid\"]}', '{$varuID}', ?, '{\$_POST[\"betyg\"]}', '\".date('Y-m-d').\"');\");
					
				\$sql->bind_param(\"s\", \$_POST['recension']);
					
				if ( \$sql===false ) {
					die('prepare() failed: ' . htmlspecialchars(\$conn->error));
				} else {
					echo \"Tack för din recension!\";
				}
				
				\$sql->execute();
				
				\$sql->close();
			}
			
			// --- Uppdatera betyg på produkten ---
			\$sql = \"SELECT betyg FROM \$dbname.recensioner WHERE VaruID ='{$varuID}'\";
			\$result = \$conn->query(\$sql);
			
			if (\$result->num_rows == 0) {
				\$slutBetyg = \$_POST['betyg'];
			} else {
				\$totaltBetyg = 0;
				while((\$row = \$result->fetch_assoc()) != false){
					\$totaltBetyg = \$totaltBetyg + \$row['betyg'];
				}
				\$slutBetyg = \$totaltBetyg / \$result->num_rows;
			}
			
			\$sql = \"UPDATE \$dbname.Varor SET betyg = '{\$slutBetyg}' WHERE VaruID = '{$varuID}'\";
			
			if (\$conn->query(\$sql) === FALSE) {
				echo \"Error with calculations somehow????: \" . \$sql . \"<br>\" . \$conn->error;
			}
			
			echo \"</div>\";
		}
	}
	
	if (\$noReview) { // --- Visa recensionsform ---
		echo \"<form action='vara.php' method='POST' enctype='multipart/form-data'>\";
		if (isset(\$_SESSION[\"userid\"])) {
			\$isformDisabled = \"\";
			echo \"Tyck till om produkten vetja\";
		} else {
			\$isformDisabled = \"disabled\";
			echo \"Du måste vara inloggad för att betygsätta produkten\";
		}
		echo \"<br> <textarea name='recension' style='width: 50%;' {\$isformDisabled}></textarea>\";
		echo \"<br>\";
		for (\$i = 0; \$i <= 5; \$i = \$i + 1) {
			echo \"<input type='radio' id='{\$i}stars' name='betyg' value='{\$i}' {\$isformDisabled}>\";
			echo \"<label for'{\$i}stars' style='font-size: 20px'>{\$i}</label><br>\";
		}
		echo \"<input type='submit' value='Recensera' style='font-size: 30px; padding: 10px; float: right;' {\$isformDisabled}>\";
		echo \"</div>\";
		echo \"</form>\";
	}
	
	// --- Visa andra recensioner ---
	\$select = \"SELECT r.kundnummer, r.recension, r.betyg, r.datum, u.usersuid FROM \$dbname.recensioner r INNER JOIN \$dbname.users u ON r.kundnummer = u.userid WHERE VaruID = '{$varuID}'\";
	
	\$stmt = \$conn->prepare(\$select);
		
	if ( \$stmt===false ) {
		die('prepare() failed: ' . htmlspecialchars(\$conn->error));
	}
	
	\$stmt->execute();
	
	\$res = \$stmt->get_result();
	while((\$row = \$res->fetch_assoc()) != false){
		echo \"<div class='attribute' style='float: left; width: 50%;'>\";
		echo \"Recension från: {\$row[\"usersuid\"]}\";
		echo \"<div style='float: right'> {\$row[\"datum\"]} </div>\";
		echo \"<br>{\$row[\"betyg\"]}/5 stjärnor <br> {\$row[\"recension\"]}\";
		echo \"</div>\";
	}
	
	\$conn->close();
	?>
	
</body>";
	
		fwrite($varuSida, $txt);
		fclose($varuSida);
	}
	?>
	
</body>