 <?php
 // Create A Connection
 $connection = new mysqli('localhost', 'root', '', 'zoo');
 
if ($connection->connect_error) {
    die('Connection Failed: ' . $connection->connect_error);
}

echo 'Connected Successfully, you can now perform queries';

$connection->close();

 ?> 