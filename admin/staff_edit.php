<?php
    require '../constants.php';
    $staff_id = null;
    $first_name = null;
    $last_name = null;
    $message = null;
    
    $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if( $connection->connect_errno ) {
        die('Connection failed:' . $connection->connect_error);
    }

    if( $_POST ) {
        if( $statement = $connection->prepare("UPDATE Staff SET FirstName=?, LastName=? WHERE StaffID=?")) {
            if( $statement->bind_param("ssi", $_POST['first_name'], $_POST['last_name'], $_POST['staff_id']) ) {
                if( $statement->execute() ) {
                   $message = "You have updated successfully"; 
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo - Staff Edit</title>
</head>
<body>
    <?php include 'admin_menu.php' ?>
    <h1>Edit Staff Member</h1>
    <?php if($message) echo $message; ?>
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
        <input type="submit" value="Submit edits">
    </p>
    </form>
</body>
</html>