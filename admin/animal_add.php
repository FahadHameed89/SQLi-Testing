<?php
    require '../constants.php';
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

        $sql_species = "SELECT SpeciesID, CommonName
                        FROM species;";
        
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