<?php
    require 'constants.php';

    $exhibit_id = null;
    $animals = "";
    $exhibit_name = "";
    $exhibit_description = "";
    $message = "";

    if( !isset( $_GET['exhibit_id'] ) || $_GET['exhibit_id'] === "" ) {
        echo "You have reached this page by mistake.";
        exit();
    }
    $exhibit_id = $_GET['exhibit_id'];

    $animal_sql = "SELECT Name, CommonName, ScientificName
    FROM Animal
    INNER JOIN ExhibitAnimal USING(AnimalID)
    INNER JOIN Species USING(SpeciesID)
    WHERE ExhibitID = $exhibit_id
    ORDER BY Name ASC";

    $exhibit_sql = "SELECT ExhibitName, ExhibitDescription
    FROM Exhibit
    WHERE ExhibitID = $exhibit_id";

    $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if( $connection->connect_errno ) {
        die("Connection failed: ". $connection->connect_error);
    }

    if( !$animal_result = $connection->query($animal_sql) ) {
        echo "Something went wrong with the animal query";
        exit();
    }

    if( !$exhibit_result = $connection->query($exhibit_sql) ) {
        echo "Something went wrong with the exhibit query";
        exit();
    }

    $connection->close();

    if( 0 === $animal_result->num_rows ) {
        $message = "<p>There are no animals on this exhibit</p>";
    } else {
        while( $animal = $animal_result->fetch_assoc() ) {
            $animals .= sprintf('
            <h3>%s - %s</h3>
            <p>%s</p>',
            $animal['Name'],
            $animal['CommonName'],
            $animal['ScientificName'],
            );
        }
    }
    

    if( 0 === $exhibit_result->num_rows ) {
        $message .= "<p>There is no exhibit with that ID</p>";
    } else  {
        while( $exhibit = $exhibit_result->fetch_assoc() ) {
            $exhibit_name = $exhibit['ExhibitName'];
            $exhibit_description = $exhibit['ExhibitDescription'];
        }
    }

    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechCareers Exhibit Animals</title>
</head>
<body>
    <h1>Animals in the <?php echo $exhibit_name; ?> Exhibit</h1>
    <p><?php echo $exhibit_description; ?></p>
    <?php echo $message; ?>
    <?php echo $animals; ?>
</body>
</html>