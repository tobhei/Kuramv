<?php
header("location: /varuregister.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .igrid-con {
            display: grid;
            grid-template-areas:
            'head head head'
            'kategori varuregister varukorg'
            'foot foot foot';
            grid-gap: 10px;
            background-color: #ffffff;
            padding: 10px;
        }
        .head{
            grid-area: head;
        }
        .kategori{
            grid-area: kategori;
            min-width: 10%;
            width: 300px;
            border: black;

        }
        .varuregister{
            grid-area: varuregister;
            max-width: 60%;
        }
        .varukorg{
            grid-area: varukorg;
        }
        .foot{
            grid-area: foot;
        }



    </style>

</head>
<!-- credit https://www.expertsphp.com/include-multiple-html-file-into-single-html-file/" !-->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
    $(function (){
       // $("#varuregister").load("varuregister.php")
      //  $("#varukorg").load("varukorg.php")
    })
</script>
<body>
<?php

?>
    <div class="igrid-con">
        <div id="varuregister" class="varuregister">
        <?php include('varuregister.php')?>
        </div>
        <div id="head" class="head">

        </div>
        <div id="varukorg" class="varukorg">
            <?php include('varukorg.php')?>
        </div>
        <div id="varor" class="varor">

        </div>

        <div id="kategori" class="kategori">
            <a>Kategori</a>
        </div>
        <div id="foot" class="foot"></div>
</div>
</body>
</html>