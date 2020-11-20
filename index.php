<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .grid-con {
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
        }
        .varuregister{
            grid-area: varuregister;
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
        $("#varuregister").load("varuregister.php")
        $("#varukorg").load("varukorg.php")
    })
</script>
<body>
    <div class="grid-con">
        <div id="varuregister" class="varuregister">

        </div>
        <div id="head" class="head">

        </div>
        <div id="varukorg" class="varukorg">

        </div>
        <div id="varor" class="varor">

        </div>

        <div id="kategori" class="kategori">

        </div>
        <div id="foot" class="foot"></div>
</div>
</body>
</html>