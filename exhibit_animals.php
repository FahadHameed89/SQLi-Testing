<?php
require 'constants.php';

$exhibit_animals = null;
//$exhibit_id = $_GET['exhibit_id'];
//echo $exhibit_id;

    if ( !isset( $_GET['exhibit_id'] ) || $_GET['exhibit_id'] === "" ) {
        echo"You messed up bruh";
        exit();
    }

    $exhibit_id = $_GET['exhibit_id'];

 // Create A Connection
 $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ( $connection->connect_errno ) {
        die("Connection Failed: " . $connection->connect_errono );
    }
    $sql = "SELECT AnimalID, CommonName, ScientificName
            FROM animal 
            INNER JOIN species USING (SpeciesID)
            WHERE AnimalID IN
                (SELECT AnimalID 
                FROM exhibitanimal
                WHERE exhibitID = 1);";

    if( ! $result = $connection->query($sql) ) {
        echo "Crap! We've made a horrible mistake!";
        exit();
    }

    if ( 0 == $result->num_rows) {
        $exhibit_animals = '<tr><td colspan="4">There are no Animals...</td></tr>';
    } else {
        while( $row = $result->fetch_assoc() ) {
            // echo '<pre>';
            // print_r($row);
            // echo '</pre>';
            $exhibit_animals .= sprintf('
            <tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>

            ', 
            $row['AnimalID'],
            $row['CommonName'],
            $row['ScientificName'],


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
    <title>Zoo Animal List</title>
</head>
<body>
    <h1>List of Animals</h1>
    <h2>Animals in the ExhibitName Exhibit</h2>
    <p>Exhibit Description</p>
    <h3>AnimalName - CommonName</h3>
    <p>Scientific Name</p>
        <table>
        <tr>
            <th>AnimalID</th>
            <th>CommonName</th>
            <th>ScientificName</th>
        </tr>
        <p>This is Exhibit # <?php echo $exhibit_id?></p>
            <?php echo $exhibit_animals ?>
        </table>
</body>
</html>