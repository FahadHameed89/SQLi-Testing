<?php
require 'constants.php';

$exhibit_animals = null;
$exhibit_animals = "";
//$exhibit_id = $_GET['exhibit_id'];
//echo $exhibit_id;

    if ( !isset( $_GET['exhibit_id'] ) || $_GET['exhibit_id'] === "" ) {
        echo"You messed up bruh";
        exit();
    }

    $exhibit_id = $_GET['exhibit_id'];

 // Create A Connection

    $animal_sql = "SELECT Name, CommonName, ScientificName
            FROM animal 
            INNER JOIN species USING (SpeciesID)
            WHERE AnimalID IN
                (SELECT AnimalID 
                FROM exhibitanimal
                WHERE exhibitID = $exhibit_id);";

 $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
 if ( $connection->connect_errno ) {
     die("Connection Failed: " . $connection->connect_errono );
 }
    if( ! $animal_result = $connection->query($animal_sql) ) {
        echo "Looks like something went terribly wrong with the Animal Query!";
        exit();
    }

    if ( 0 == $animal_result->num_rows) {
        $exhibit_animals = '<tr><td colspan="4">There are no Animals...</td></tr>';
    } else {
        while( $animal = $animal_result->fetch_assoc() ) {
            // echo '<pre>';
            // print_r($animal);
            // echo '</pre>';
            $exhibit_animals .= sprintf('
            <tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>

            ', 
            $animal['Name'],
            $animal['CommonName'],
            $animal['ScientificName'],


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

        <table>
        <tr>
            <th>Name</th>
            <th>CommonName</th>
            <th>ScientificName</th>
        </tr>
        <p>This is Exhibit # <?php echo $exhibit_id?></p>
            <?php echo $exhibit_animals ?>
        </table>
</body>
</html>