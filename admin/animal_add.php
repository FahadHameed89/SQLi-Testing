<?php
    require '../constants.php';
    $species_select_options = null;
    $staff_select_options = null;
    $species_sql = "SELECT SpeciesID, CommonName FROM Species";
    $staff_sql = "SELECT StaffID, FirstName, LastName FROM Staff";
    $message = null;

    $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);
    if( $connection->connect_errno ) {
        die('Connection failed: ' . $connection->connect_error);
    }
    if( !$species_result = $connection->query($species_sql) ) {
        echo "Something went wrong with the species query";
        exit();
    }
    if( !$staff_result = $connection->query($staff_sql) ) {
        echo "Something went wrong with the staff query";
        exit();
    }

    

    if( $species_result->num_rows > 0 ) {
        while( $species = $species_result->fetch_assoc() ) {
            $species_select_options .= sprintf('<option value="%s">%s</option>',
                $species['SpeciesID'],
                $species['CommonName']
            );
        }
    }

    if( $staff_result->num_rows > 0 ) {
        while( $staff = $staff_result->fetch_assoc() ) {
            $staff_select_options .= sprintf('<option value="%s">%s %s</option>',
                $staff['StaffID'],
                $staff['FirstName'],
                $staff['LastName']
            );
        }
    }

    if( $_POST ) {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        if( $insert = $connection->prepare("INSERT INTO Animal(AnimalID, StaffID, Name, SpeciesID, Gender, Origin, WeightLbs, DateOfBirth, DateOfDeparture, DepartureCirumstances)
        VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, NULL, NULL)")) {
            if( $insert->bind_param("isissds", $_POST['staff'], $_POST['name'], $_POST['species'], $_POST['gender'], $_POST['origin'], $_POST['weight_lbs'], $_POST['date_of_birth']) ) {
                if( $insert->execute() ) {
                   $message = "You have added " . $_POST['name'] . " to the database"; 
                } else {
                    exit("There was a problem with the execute");
                }
            } else {
                exit("There was a problem with the bind_param");
            }
        } else {
            exit("There was a problem with the prepare statement");
        }


    }
    $connection->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo - Add animal</title>
</head>
<body>
    <h1>Add an animal</h1>
    <?php if($message) echo $message; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <p>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </p>
        <p>
            <label for="gender">Gender:</label>
            <input type="radio" name="gender" value="F" checked> Female
            <input type="radio" name="gender" value="M" checked> Male
        </p>
        <p>
            <label for="origin">Origin</label>
            <input type="text" name="origin" id="origin">
        </p>
        <p>
            <label for="weight_lbs">Weight (lbs)</label>
            <input type="number" step="any" name="weight_lbs" id="weight_lbs">
        </p>
        <p>
            <label for="date_of_birth">Date of birth</label>
            <input type="date" name="date_of_birth" min="1900-01-01" max="<?php echo date('Y-m-d'); ?>">
        </p>
        <p>
            <label for="species">Species</label>
            <select name="species" id="species">
                <option value="">Select a species</option>
                <?php echo $species_select_options; ?>
            </select>
        </p>
        <p>
            <label for="staff">Staff member</label>
            <select name="staff" id="staff">
                <option value="">Select a staf member</option>
                <?php echo $staff_select_options; ?>
            </select>
        </p>
        <p>
            <input type="submit" value="Add an animal">
        </p>
    </form>

</body>
</html>