<?php
    // Connection details
    $host = "localhost";
    $user = "UWASE";
    $pass = "222012874";
    $database = "virtual_support_groups_platforms";

    // Creating connection
    $connection = new mysqli($host, $user, $pass, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
?>
 