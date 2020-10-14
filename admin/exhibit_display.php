<?php
require '../constants.php';

$animal_list = null;

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

    if ( 0 == $result->num_rows) {
        $animal_list = '<tr><td colspan="4">There are no Animals...</td></tr>';
    } else {
        while( $row = $result->fetch_assoc() ) {
            // echo '<pre>';
            // print_r($row);
            // echo '</pre>';
            $animal_list .= sprintf('
            <tr>
                <td><a href="exhibit_display.php?exhibit_id=%d">View Animals</a></td></tr>
            ', 
            $row['StaffID']
        );
        }
    }
    
    $connection->close();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Exhibit List</title>
</head>
<body>
    <h1>Welcome to the TechCareers Zoo!</h1>
    <h1>Exhibits</h1>
    <p>We currently have 1 exhibit(s) for you to visit!</p>
    <h2>North American Animals</h2>
    <p>A collection of animals native to North America</p>
        <table>
        <tr>

        </tr>
            <?php echo $animal_list ?>
        </table>
</body>
</html>