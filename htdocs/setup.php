<?php
      //  $dbname = "D0018ELABB";

/*         $servername = "dbserver";
        $username = "root";
        $password = "admin";
        $dbname = "D0018ELABB"; */

       // $servername = "localhost";
      //  $username = "990907";
        //$password = "990907";
        
        //philips specialare
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "D0018ELABB";
        

// Create connection
        $conn = new mysqli($servername, $username, $password);
        $conn->select_db($dbname);

// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
       // echo "Connected successfully";
        $initLang = "SET lc_time_names = sv_SE";
        $res = $conn->query($initLang);
        if (!($res === TRUE)) {
          echo "Error creating Database: " . $conn->error."\n";
        }
        return $conn;




?>