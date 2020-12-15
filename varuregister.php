<?php
$conn = include 'helpers/helpermain.php';
if($_SESSION['admin'] == true){
    echo "<script>  window.location.href = '/varuregisterAdmin.php';</script>";
}
$conn = include "setup.php";
?>
<!DOCTYPE html>
<html lang="se">
<head>
    <meta charset="UTF-8">
    <title>Varor</title>

    <style>
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
            width: 80%;
            max-width: 80%;
            display: grid;
            grid-template-columns: auto auto auto;
            grid-auto-flow: row;
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
<div class="title-container">
    <div class="left-alligned">Varor</div>

    <div class="right-alligned">
		<form action="varuregister.php" method="get">
            <label for="sorting">Sortera med:</label>
            <select name="sorting" id="sorting">
                <option value="namn">Namn</option>
                <option value="pris">Pris</option>
                <option value="betyg">Betyg</option>
                <option value="populärt">Populärt</option>
            </select>
			
			<select name="order" id="order">
				<option value="ASC">Minst först</option>
				<option value="DESC">Störst först</option>
			</select>

            <input type="submit" value="Uppdatera">
        </form>
    </div>
	
<a href='beställning.php'><button style='font-size: 20px; margin: 10px; padding: 10px;'>Mot beställningar</button></a>
	
</div>
<div class="grid-container">

		<?php
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
        include "setup.php";
		$stmt = $conn->prepare($select);
		
		if ( $stmt===false ) {
			die('prepare() failed: ' . htmlspecialchars($conn->error));
		}
		
		$stmt->execute();

		$res = $stmt->get_result();
		while(($row = $res->fetch_assoc()) != false){
			echo "<div class='grid-item'>";
			echo "<a href=resource/{$row['VaruID']}/vara.php> <img src='{$row['ResourceURL']}' alt='{$row['Namn']}' style='height:300px;'>";
			echo "<br>" .$row['Namn'] ."</a>";
			echo "<br> Pris: " .$row['Pris'] ."kr";
			echo "<br> Betyg: " .$row['Betyg'];
			echo "</div>";
		}
		?>

</div>
</div>

<?php
    $conn->close();	
?>

</body>
</html>
