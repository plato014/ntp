<?php

 $host = "localhost";
    $user = "admin";
    $password = "1234";
    $database = "natthaphong014";
    $port = "3307";

    $conn = mysqli_connect($host, $user, $password, $database,$port);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
?>