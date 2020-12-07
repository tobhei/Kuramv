<?php
session_start();
$conn = include 'setup.php';
echo "<head>
        <meta charset='UTF-8'>
        <title>Title</title>
       </head>
       <body>
        <style> 
        .igrid-con {
            display: grid;
            grid-template-areas:
            'head head head'
            'kategori hmcontent varukorg'
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
        .hmcontent{
         grid-area: hmcontent; 
        }
        .varukorg{
         grid-area: varukorg; 
        }
        .foot{
         grid-area: foot; 
        }
        
        
        
        </style></body>";
echo "<div class=igrid-con>";
echo "<div class=head>";
include_once "helpers/header.php";
echo "</div> <div class=kategori>";
include_once "kategory.php";
echo "</div> <div class=varukorg>";
include_once "varukorg.php";
echo "</div> <div class=hmcontent>";
return $conn;
