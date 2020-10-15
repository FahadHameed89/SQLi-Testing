<?php
    require 'constants.php';

    // Create connection
    $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $number_of_exhibits = 0;
    $exhibit_message = "";

    // Did we have errors connecting?
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    }
    
    $sql = "SELECT * FROM Exhibit WHERE NOW() BETWEEN StartDate AND EndDate";
    
    $result = $connection->query($sql);
    
    $number_of_exhibits = $result->num_rows;

    if( $result->num_rows > 0 ) {
        
        while( $row = $result->fetch_assoc() ){
            $exhibit_message .= sprintf('
                    <h3>%s</h3>
                    <p>%s</p>
                    <p><a href="exhibit_animals.php?exhibit_id=%d">View animals</a></p>
                ',
                $row['ExhibitName'],
                $row['ExhibitDescription'],
                $row['ExhibitID'],
            );
        }


    } else {
        echo "There are no exhibits";
    }
    
    $connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechCareers Zoo</title>
</head>
<body>
    <h1>Welcome to Tech Careers Zoo</h1>
    <h2>Exhibits</h2>
    <p>We currently have <?php echo $number_of_exhibits; ?> exhibit(s) for you to visit</p>
    <?php echo $exhibit_message; ?>
</body>
</html>