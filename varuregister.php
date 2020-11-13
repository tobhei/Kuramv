<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Varukorg</title>

    <style >
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
            grid-template-columns:
    auto auto auto auto auto;
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

    <div class="right-alligned"><form action="/varukorg.php">
            <label for="sorting">Sortera med:</label>
            <select name="sorting" id="sorting">
                <option value="namn">Namn</option>
                <option value="pris">Pris</option>
                <option value="rating">Rating</option>
                <option value="populärt">Populärt</option>
            </select>

            <input type="submit" value="Uppdatera">
        </form>
    </div>

</div>
<div class="grid-container">
    <div class="grid-item">1</div>
    <div class="grid-item">2</div>
    <div class="grid-item">3</div>
    <div class="grid-item">4</div>
    <div class="grid-item">5</div>
</div>

    <?php
    $conn = include 'setup.php';
    $sql = "CREATE DATABASE testdatadb";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }
    $conn->close();
    ?>




</div>


</body>
</html>