<?php
    require '../constants.php';

    $species_select_options = null;
    $staff_select_options = null;
    // Make a statement to select Species
    $species_sql = "SELECT SpeciesID, CommonName FROM Species";

    // Connection string
    $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);
    if( $connection->connect_errno ) {
        die('Connection failed: ' . $connection->connect_error);
    }
    if(!$species_result = $connection->query($species_sql)) {
        echo "Something is wrong with the species query";
        exit();
    }
    // Check if rows > 0 -> IF we do, loop through and opulate options with the select
    if( $species_result->num_rows > 0 ) {
        while( $species = $species_result->fetch_assoc() ) {
            // Populate Options
            $species_select_options .= sprintf('
                <option value="%s">%s</option>
            ',
            $species['SpeciesID'],
            $species['CommonName']
        );
        }
    }




    if( $_POST ) {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);
        if( $connection->connect_errno ) {
            die('Connection failed: ' . $connection->connect_error);
        }
        // WITHOUT A PREPARED STATEMENT
        $animal_name = $connection->real_escape_string($_POST['animal_name']);
        $animal_gender = $connection->real_escape_string($_POST['animal_gender']);
        $animal_origin = $connection->real_escape_string($_POST['animal_origin']);
        $animal_weight = $connection->real_escape_string($_POST['animal_weight']);
        $animal_dob = $connection->real_escape_string($_POST['animal_dob']);
        
        $sql = "INSERT INTO Animal (Name, Gender, Origin, WeightLbs, DateOfBirth) 
                VALUES('$animal_name', '$animal_gender', '$animal_origin', '$animal_weight', '$animal_dob')";
        if( !$result = $connection->query($sql) ) {
            die("Could not add an animal to the database");
        }

        $connection->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add an Animal Page</title>
</head>
<body>
    <p>Hello World!</p>
    <h1>Add an Animal!</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <p>
        <label for="animal_name">Animal Name</label>
        <input type="text" name="animal_name" id=animal_name">
    </p>
    <p>
        <label for="animal_gender">Gender</label>
        <input type="radio" name="animal_gender" id="animal_gender" value="F" checked> Female
        <input type="radio" name="animal_gender" id="animal_gender" value="M" checked> Male

    </p>
    <p>
        <label for="animal_origin">Origin</label>
        <input type="text" name="animal_origin" id="animal_origin">
    </p>
    <p>
        <label for="animal_weight">Weight in Lbs</label>
        <input type="number" step="any" name="animal_weight" id="animal_weight">
    </p>
    <p>
        <label for="animal_dob">Date of Birth</label>
        <input type="date" name="animal_dob" id="animal_dob" min="1900-01-01" max="<?php echo date('Y-m-d'); ?>">
    </p>
    <p>
        <label for="animal_species">Species</label>
        <select name="animal_species" id="animal_species">
        <option value="">Select a Species</option>
        <?php echo $species_select_options?>
        </select> 
    </p>

    <p>
        <label for="staff">Staff Member</label>
        <select name="staff" id="staff">
            <option value="">Select a Staff Member</option>
        </select>
    </p>

    <p>
        <input type="submit" value="Add new Animal">
    </p>
    </form>



</body>
</html>