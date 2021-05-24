<?php

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'goread';
    $conn = mysqli_connect($host, $user, $pass, $db);
        
    if(!$conn){
        die('nie udało się połączyć z bazą - '.mysqli_error());
        echo "connection errors";
    }

?>