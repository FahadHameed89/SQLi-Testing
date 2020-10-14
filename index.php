 <?php

 require 'constants.php';

 // Create A Connection
 $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
 
if ($connection->connect_error) {
    die('Connection Failed: ' . $connection->connect_error);
}

echo 'Connected Successfully, you can now perform queries';

$connection->close();

 ?> 