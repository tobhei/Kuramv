<?php
include 'helpers/header.php';
$conn = include "setup.php";
?>
<!DOCTYPE html>
<html lang="se">



<head>
    <meta charset="UTF-8">
    <title>Bekräfta beställning</title>

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
			width: 30%;
			float: left;
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

<h1>Bekräfta beställning</h1>

<div class="grid-container">

		<?php
		$total = 0;
		
		if (!isset($_SESSION['userid'])) {
			echo "Ej inloggad";
			return;
		}
		
		$select = "SELECT vk.VaruID, vk.kundnummer, vk.antal, v.VaruID, v.Namn, v.Pris, v.ResourceURL FROM $dbname.varukorg vk INNER JOIN $dbname.varor v ON vk.VaruID = v.VaruID WHERE Kundnummer = '{$_SESSION['userid']}'";
		$stmt = $conn->prepare($select);
		
		if ( $stmt===false ) {
			echo "<h2>Varukorgen verkar vara tom!</h2>Var snäll ursäkta debugg-printing <br>";
			die('prepare() failed: ' . htmlspecialchars($conn->error));
		}
		
		$stmt->execute();
		
		$res = $stmt->get_result();
		
		if(mysqli_num_rows($res) == 0) {
			echo "<div style='font-size: 100px;'>HÖRRU!</div><br>";
			echo "<div style='font-size: 30px;'>Lägg till några varor först!</div>";
			return;
		}
		
		else {
			while(($row = $res->fetch_assoc()) != false){
				echo "<div class='grid-item'>";
				echo "<a href=resource/{$row['VaruID']}/vara.php> <img src='{$row['ResourceURL']}' alt='{$row['Namn']}' style='height:100px;'>";
				echo "<br>" .$row['Namn'] ."</a>";
				echo "<br> Pris: " .$row['Pris'] ." kr /st";
				echo "<br> Antal: " .$row['antal'];
				echo "<br> Totalt: <b>" .$row['Pris'] * $row['antal'] ."</b> kr";
				echo "</div>";
				
				$total = $total + $row['Pris'] * $row['antal'];
			}
		}
		?>

</div>

<div style='width: 50%; font-size: 40px; padding: 30px; float: left;'>

<?php
	// Ifall bekräftad
	if(isset($_POST['bekräfta'])) {
		mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
		$ordernummer = substr(md5(rand()), 0, 8);
		
		$sql = "SELECT vk.VaruID, vk.kundnummer, vk.antal, v.VaruID, v.Namn, v.Pris, v.ResourceURL, v.Antal FROM $dbname.varukorg vk INNER JOIN $dbname.varor v ON vk.VaruID = v.VaruID WHERE Kundnummer = '{$_SESSION['userid']}'";
		$stmt = $conn->prepare($sql);
		if ( $stmt===false ) {
			die('prepare() failed: ' . htmlspecialchars($conn->error));
		}
		
		$stmt->execute();

		$res = $stmt->get_result();
		while(($row = $res->fetch_assoc()) != false){
			if ($row['Antal'] < $row['antal']) { // Kolla ifall fler i varukorgen än i lager
				echo "<div style='font-size:20px'> Ojsan! Det finns inte så många {$row['Namn']} i lager, var snäll minska antalet.</div><br>";
				$conn->close();
				return;
			} else {
				mysqli_query($conn, "INSERT INTO $dbname.bestalldaVaror VALUES ('$ordernummer', '{$row['VaruID']}', '{$row['antal']}')");
				mysqli_query($conn, "UPDATE $dbname.varor SET Antal = '" .($row['Antal'] - $row['antal']) ."' WHERE VaruID = '{$row['VaruID']}'");
			}
		}
		
		$sql = "SELECT usersEmail FROM $dbname.users WHERE userid = '{$_SESSION['userid']}'";
		$stmt = $conn->prepare($sql);
		if ( $stmt===false ) {
			die('prepare() failed: ' . htmlspecialchars($conn->error));
		}
		
		$stmt->execute();

		$res = $stmt->get_result();
		while(($row = $res->fetch_assoc()) != false){
			$userEmail = $row['usersEmail'];
		}
		
		mysqli_query($conn, "INSERT INTO $dbname.bestallningar VALUES ('{$_SESSION['userid']}', '$ordernummer', '" .date('Y-m-d') ."', '$userEmail')");
		
		mysqli_query($conn, "DELETE FROM $dbname.varukorg WHERE kundnummer = '{$_SESSION['userid']}'");
		
		mysqli_commit($conn);
		echo "Beställningen är lagd!";
	}
	
	else {
		// Visa bekräftning
		echo "Totala kostnader: ";
		echo "<b> $total </b>kr";
		
		echo "
		<form action='beställning.php' method='post'>
			<input type='hidden' id='bekräfta' name='bekräfta' value='true'>
			<input type='submit' value='Lägg beställning' style='margin: 20px; padding: 30px; font-size: 30px;'>
		</form>";
	}
?>

</div>

</body>
</html>