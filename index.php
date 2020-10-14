 <?php

 require 'constants.php';

 // Create A Connection
 $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
 
if ($connection->connect_error) {
    die('Connection Failed: ' . $connection->connect_error);
}

$sql = "SELECT * FROM Exhibit";

$result = $connection->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo '<pre>';
        print_r($row);
        echo '</pre>'; 
    }

} else {
        echo "there are no exhibits...";
    }

$connection->close();

 ?> 