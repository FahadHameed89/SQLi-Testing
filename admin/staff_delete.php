<?php

// Connect to Database    
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
if( $connection->connect_errno ) {
    die('Connection failed:' . $connection->connect_error);
}
    
// Check the Connection

    if( $connection->connect_errno ) {
        die('Connection failed:' . $connection->connect_error);
    }

// Prepare a DELETE Statement

    $delete_statement = $mysqli->prepare("DELETE Staff WHERE StaffID=?");

// Check if Prepare() failed
    if (false === $delete_statement) {
    error_log('mysqli prepare() failed!');
    exit();
    }

// Bind Values to the prepared statement

    $bind = $delete_statement->bind_param('s', $value);

// Check to see if Bind_param() failed.
    if ( false === $bind ) {
        error_log('bind_param() failed.');
        exit();
    }

// Execute the Query

$execute = $delete_statement->execute();

// Check if the execute failed

if( false === $execute) {
    error_log('mysqli execute() failed...');
    exit();
}

// Close the prepared statement

$delete_statement->close();

$connection->close();

    if( $_POST ) {
        if( $statement = $connection->prepare("DELETE Staff WHERE StaffID=?")) {
            if( $statement->bind_param("i", $_POST['staff_id']) ) {
                if( $statement->execute() ) {
                   $message = "You have successfully deleted this staff member..!"; 
                } else {
                    exit("There was a problem with the execute");
                }
            } else {
                exit("There was a problem with the bind_param");
            }
        } else {
            exit("There was a problem with the prepare statement");
        }
        $statement->close();
    }

    // If we don't have a staff id, do not continue
    if( !isset($_GET['staff_id']) || $_GET['staff_id'] === "" ) {
        exit("You have reached this page by mistake");
    }

    // If the staff id is not an INT, do not continue
    if( filter_var($_GET['staff_id'], FILTER_VALIDATE_INT ) ) {
        $staff_id = $_GET['staff_id'];
    } else {
        exit("An incorrect value was passed");
    }

    $sql = "SELECT * FROM Staff where StaffID = $staff_id";
    $sql_animals_in_care = "SELECT COUNT(animal.AnimalID) AS NumberOfAnimals FROM animal INNER JOIN staff USING (StaffID) WHERE staff.StaffID = $staff_id";

// SELECT COUNT(animal.AnimalID) AS NumberOfAnimals, staff.StaffID FROM animal INNER JOIN staff USING (StaffID) WHERE staff.StaffID = $staff_id;
// SELECT COUNT(animal.AnimalID) AS NumberOfAnimals FROM animal INNER JOIN staff USING (StaffID) WHERE staff.StaffID = $staff_id



    $result = $connection->query($sql);
    if( !$result ) {
        exit('There was a problem fetching results');
    }
    if( 0 === $result->num_rows ) {
        exit("There was no staff with that ID");
    }

    while( $row = $result->fetch_assoc() ) {
        $first_name = $row['FirstName'];
        $last_name = $row['LastName'];
    }
    $connection->close();

    $result_animal = $connection2->query($sql_animals_in_care);
    if( !$result_animal ) {
        exit('There was a problem fetching results');
    }
    if( $result_animal->num_rows === 0 ) {
        exit("This staff member has too many animals in their care to delete!");
    }

    $connection2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Delete Page</title>
</head>
<body>
    <h1>Staff Deletion Page!</h1>
    <?php include 'admin_menu.php' ?>
    <form action="#" method="POST" enctype="multipart/form-data">
    <p>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
    </p>
    <p>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
        <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
    </p>
    <p>
        <input type="submit" value="Delete This Staff Member!">
    </p>
    </form>
</body>
</html>