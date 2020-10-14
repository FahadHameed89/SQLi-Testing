 <?php

 require 'constants.php';

 // Create A Connection
 $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
 $number_of_exhibits = 0;
 $exhibit_message = "";
 $exhibitID = "";

if ($connection->connect_error) {
    die('Connection Failed: ' . $connection->connect_error);
}

$sql = "SELECT * FROM Exhibit WHERE NOW() BETWEEN `StartDate` AND `EndDate`";

$result = $connection->query($sql);
$number_of_exhibits = $result->num_rows;
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        // echo '<pre>';
        // print_r($row);
        // echo '</pre>'; 
        $exhibit_message .= sprintf('
            <h3>%s</h3>
            <p>%s</p>
            <p><a href="exhibit_animals.php?exhibit_id=%d">View Animals $GET</a></p>
        ',
        $row['ExhibitName'],
        $row['ExhibitDescription'],
        $row['ExhibitID']
    );
    }

} else {
        echo "there are no exhibits...";
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
    <h1>Welcome to the TechCareers Zoo!</h1>
    <h1>Exhibits</h1>
    <p>We currently have <?php echo $number_of_exhibits; ?> exhibit(s) for you to visit!</p>
    <h2>North American Animals</h2>
    <?php echo $exhibit_message; ?>

 </body>
 </html>