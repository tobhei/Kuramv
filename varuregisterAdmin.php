<?php
include 'helpers/header.php';
$conn = include "setup.php";
?>
<!DOCTYPE html>
<html lang="se">



<head>
    <meta charset="UTF-8">
    <title>Varor Admin</title>

    <style>
	
		* {
			box-sizing: border-box;
		}
		
		.tableBox {
			float: left;
			padding: 30px;
		}

		.table {
			clear: both;
			display: table;
			width: 100%;
		}
	
		.head {
			font-size: 40px;
		}
		
		.registerform {
			background-color: #f1f1f1;
			font-size: 20px;
			margin: 20px;
		}
		
        .title-container{
            display: grid;
            grid-template-columns: auto auto;
        }
        .left-alligned{
            font-size: 32px;
            display: grid;
            text-align: left;
        }
        .right-alligned{
            font-size: 32px;
            display: grid;
            text-align: right;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            grid-gap: 10px;
            background-color: #ffffff;
            padding: 10px;
        }

        .grid-item {
            display: grid;
            padding: 20px;
            font-size: 30px;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.8);
        }
    </style>

</head>
<body>

<?php

if(!array_key_exists('vara', $_GET)) {

echo "

<div class='title-container'>
    <div class='left-alligned'>Administrering varor</div>

    <div class='right-alligned'>
		<form action='varuregisterAdmin.php' method='get'>
            <label for='sorting'>Sortera med:</label>
            <select name='sorting' id='sorting'>
                <option value='namn'>Namn</option>
                <option value='pris'>Pris</option>
                <option value='betyg'>Betyg</option>
                <option value='populärt'>Populärt</option>
            </select>
			
			<select name='order' id='order'>
				<option value='ASC'>Minst först</option>
				<option value='DESC'>Störst först</option>
			</select>

            <input type='submit' value='Uppdatera'>
        </form>
    </div>

</div>
<div class='grid-container'>

";
		
		$select = "SELECT VaruID, Namn, Pris, Betyg, ResourceURL from $dbname.Varor";
		
		if (isset($_GET["sorting"])) {
			switch ($_GET["sorting"]) {
				case "namn":
					$select = $select ." ORDER BY Namn " .$_GET['order'];
				break;
				
				case "pris":
					$select = $select ." ORDER BY Pris " .$_GET['order'];
				break;
				
				case "betyg":
					$select = $select ." ORDER BY Betyg " .$_GET['order'];
				break;
				
				default:
					echo "NOT YET IMPLEMENTED (PROBABLY)";
			}
		}
		
		$stmt = $conn->prepare($select);
		
		if ( $stmt===false ) {
			die('prepare() failed: ' . htmlspecialchars($conn->error));
		}
		
		$stmt->execute();

		$res = $stmt->get_result();
		while(($row = $res->fetch_assoc()) != false){
			echo "<div class='grid-item'>";
			echo "<form method='get'>";
			echo "<button style='font-size: 30px; padding: 20px' type='submit' name='vara' class='button' value='{$row['VaruID']}'>";
			echo "<img src='{$row['ResourceURL']}' alt='{$row['Namn']}' style='height:300px;'>";
			echo "<br>" .$row['Namn'] ."</button>";
			echo "<br> Pris: " .$row['Pris'] ."kr";
			echo "<br> Betyg: " .$row['Betyg'];
			echo "</form>";
			echo "</div>";
		}
}

else {
	
	$currentVaruID = "";
	$currentVarunamn = "";
	
	$uppdaterad = "Varans ";
	
	$errorNamn = "";
	$uppdateratNamn = false;
	
	$errorPris = "";
	$uppdateratPris = false;
	
	$errorBild = "";
	$uppdateratBild = false;
	
	echo "<a href='varuregisterAdmin.php'>
	<button style='font-size: 20px; padding: 20px'>Tillbaka</button>
	</a>";
	
	$select = "SELECT VaruID, Namn, Pris, Betyg, ResourceURL FROM $dbname.Varor WHERE VaruID = '{$_GET['vara']}'";
	
	$stmt = $conn->prepare($select);
		
		if ( $stmt===false ) {
			die('prepare() failed: ' . htmlspecialchars($conn->error));
			echo "UH OH STINKY varan finns inte längre";
		}
	
	$stmt->execute();

	$res = $stmt->get_result();
	while(($row = $res->fetch_assoc()) != false) {
		
		$currentVaruID = $row['VaruID'];
		$currentVarunamn = $row['Namn'];
		
		echo "
			<div class='table'>
				<div class='tableBox'>
					<form action='varuregisterAdmin.php?vara={$row['VaruID']}' method='POST' enctype='multipart/form-data'>
					<fieldset class='registerform'>
					<legend class='head'>Ändra/ta bort en vara</legend>
					
					<div class='registerform'>
						<label for='Varunamn'>Varunamn:</label><br>
						<input type='text' id='Varunamn' name='Varunamn'><br>
						"; echo $errorNamn ."
					</div>
					
					<div class='registerform'>
						<label for='Pris'>Pris:</label><br>
						<input type='number' id='Pris' name='Pris'> kr<br>
						"; echo $errorPris ."
					</div>
					
					<div class='registerform'>
						<label for='Varubild'>Bild på varan:</label><br>
						<input type='file' id='Varubild' name='Varubild'><br>
						"; echo $errorBild ."
					</div>
					
					<input type='submit' value='Ändra' name='Ändra' style='padding:20px; margin:20px;'>
					<input type='submit' value='Ta bort' name='Ta_bort' style='padding:20px; margin:20px;'>
					</fieldset>
					</form>
				</div>
				
				<div class='tableBox' style='font-size: 18px'>
				<img src='{$row['ResourceURL']}' alt='{$row['Namn']}' style='height:300px;'> <br>
				Nuvarande varunamn: <b>{$row['Namn']}</b> <br>
				Nuvarande pris: <b>{$row['Pris']} kr </b> <br>
				
				</div>
			</div>
		";
	}
	
	if (isset($_POST["Varunamn"])) {
		if (!empty($_POST["Varunamn"])) {
			$uppdateratNamn = true;
		}
		
		if (strlen($_POST["Varunamn"]) > 60) {
			$errorNamn = "Varans namn kan inte vara större än 60 tecken.";
		}
	}
	
	if (isset($_POST["Pris"])) {
		if (!empty($_POST["Pris"])) {
			$uppdateratPris = true;
		}
		
		if (($_POST["Pris"]) > PHP_INT_MAX) {
			$errorPris = "Jag tror inte någon kommer köpa varan vid det priset.";
		}
	}
	
	if(isset($_FILES["Varubild"]['name'])) {
		if (!empty($_FILES["Varubild"]['name'])) {
			$uppdateratBild = true;
			
			$target_dir = "resource/{$currentVaruID}/";
			if(!file_exists($target_dir)) mkdir("resource/{$currentVaruID}/");
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
				if (!move_uploaded_file($_FILES["Varubild"]['tmp_name'], $target_file)) {
					echo "Oops, nåt gick fel";
				}
			}
		}
	}
	
	if (isset($_POST['Ändra'])) {
		if (($uppdateratNamn || $uppdateratPris || $uppdateratBild) && 
		(strlen($errorNamn) == 0 && strlen($errorPris) == 0 && strlen($errorBild) == 0)) {
			
			$sql = "UPDATE {$dbname}.Varor SET ";
			
			if ($uppdateratNamn) {
				$currentVarunamn = $_POST['Varunamn'];
				$sql = $sql ."Namn = '{$_POST['Varunamn']}'";
				
				$uppdaterad = $uppdaterad ."namn";
				if ($uppdateratPris || $uppdateratBild) {
					$sql = $sql .", ";
					$uppdaterad = $uppdaterad ." + ";
				}
			}
			
			if ($uppdateratPris) {
				$sql = $sql ."Pris = '{$_POST['Pris']}'";
				
				$uppdaterad = $uppdaterad ."pris";
				if ($uppdateratBild) {
					$sql = $sql .", ";
					$uppdaterad = $uppdaterad ." + ";
				}
			}
			
			if ($uppdateratBild) {
				$uppdaterad = $uppdaterad ."bild";
				$sql = $sql ."ResourceURL = '{$target_file}'";
			}
			
			$sql = $sql ."WHERE VaruID = '{$currentVaruID}'";
			$uppdaterad = $uppdaterad ." har uppdaterats";
			
			if ($conn->query($sql) === TRUE) {
				echo "<h1>" .$uppdaterad ."</h1>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			
			// --- Uppdatera varans .php-sida ---
			$varuSida = fopen("resource/{$currentVaruID}/vara.php", "w");
		
		$txt = "<!DOCTYPE html>
<html lang=\"se\">

<head>
	
	<title> {$currentVarunamn} </title>
	
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
	
	\$select = \"SELECT VaruID, Namn, Pris, Betyg, ResourceURL FROM \$dbname.Varor WHERE VaruID = '{$currentVaruID}'\";
	
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
			<input type='hidden' id='varuid' name='varuid' value='{$currentVaruID}'>
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
			
			\$sql = \"SELECT kundnummer, VaruID FROM \$dbname.recensioner WHERE kundnummer ='{\$_SESSION[\"userid\"]}' AND VaruID = '{$currentVaruID}';\";
			\$result = \$conn->query(\$sql);

			if (\$result->num_rows > 0) {
				if (!empty(\$_POST[\"recension\"])) {
					\$sql = \$conn->prepare(\"UPDATE \$dbname.recensioner SET recension = ?, betyg = '{\$_POST[\"betyg\"]}', datum = '\".date('Y-m-d').\"' WHERE recensioner.kundnummer = {\$_SESSION[\"userid\"]} AND recensioner.VaruID = '{$currentVaruID}'\");
					
					\$sql->bind_param(\"s\", \$_POST['recension']);
					
					if ( \$sql===false ) {
						die('prepare() failed: ' . htmlspecialchars(\$conn->error));
					} else {
						echo \"Tack för din recension!\";
					}
					
					\$sql->execute();
					
					\$sql->close();
					
				} else {
					\$sql = \"UPDATE \$dbname.recensioner SET betyg = '{\$_POST[\"betyg\"]}', datum = '\".date('Y-m-d').\"' WHERE recensioner.kundnummer = {\$_SESSION[\"userid\"]} AND recensioner.VaruID = '{$currentVaruID}'\";
					
					if (\$conn->query(\$sql) === TRUE) {
						echo \"Tack för din recension!\";
					} else {
						echo \"Error: \" . \$sql . \"<br>\" . \$conn->error;
					}
				}
			} else {
				\$sql = \$conn->prepare(\"INSERT INTO \$dbname.recensioner (kundnummer, VaruID, recension, betyg, datum)
					VALUES ('{\$_SESSION[\"userid\"]}', '{$currentVaruID}', ?, '{\$_POST[\"betyg\"]}', '\".date('Y-m-d').\"');\");
					
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
			\$sql = \"SELECT betyg FROM \$dbname.recensioner WHERE VaruID ='{$currentVaruID}'\";
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
			
			\$sql = \"UPDATE \$dbname.Varor SET betyg = '{\$slutBetyg}' WHERE VaruID = '{$currentVaruID}'\";
			
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
	\$select = \"SELECT r.kundnummer, r.recension, r.betyg, r.datum, u.usersuid FROM \$dbname.recensioner r INNER JOIN \$dbname.users u ON r.kundnummer = u.userid WHERE VaruID = '{$currentVaruID}'\";
	
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
		
		else {
			echo "<h1> Du fyllde inte ens i ett enda fält bruh </h1>";
		}
	}
	
	if (isset($_POST['Ta_bort'])) {
		$sql = "DELETE FROM {$dbname}.Varor WHERE VaruID = '{$currentVaruID}'";
		if ($conn->query($sql) === TRUE) {
			echo "<h1> Varan har borttagits från databasen </h1>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

$conn->close();
?>

</body>
</html>