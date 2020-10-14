<?php
require '../constants.php';

$staff_members = null;

 // Create A Connection
 $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ( $connection->connect_errno ) {
        die("Connection Failed: " . $connection->connect_errono );
    }
    $sql = "SELECT * FROM Staff";

    if( ! $result = $connection->query($sql) ) {
        echo "Crap! We've made a horrible mistake!";
        exit();
    }

    if ( 0 === $result->num_rows) {
        $staff_members = '<tr><td colspan="4">There are no Staff members...</td></tr>';
    } 
    
    $connection->close();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Staff List</title>
</head>
<body>
    <h1>List of Staff Members</h1>
        <table>
            <?php ?>
        </table>

</body>
</html>