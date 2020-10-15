<?php 

    require '../constants.php';
    $staff_id = null;
    $first_name = null;
    $last_name = null;
    $show_form = true;
    $message = null;

    $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);
    if( $connection->connect_errno ) {
        die("Connection failed:" . $connection->connect_error);
    }

    if( !$_POST ) {
        if( !isset($_GET['staff_id']) || $_GET['staff_id'] === "" ) {
            exit("You have reached this page by mistake");
        }
        if( filter_var($_GET['staff_id'], FILTER_VALIDATE_INT) ) {
            $staff_id = $_GET['staff_id'];
        } else {
            exit("An incorrect value for Staff ID was used");
        }
        $sql = "SELECT * FROM Staff WHERE StaffID=$staff_id";
        $result = $connection->query($sql);
        if( !$result ) {
            exit("There was a problem fetching results");
        }
        if( 0 === $result->num_rows ) {
            exit("The staff id provided did not match anyone in the database");
        }

        while( $row = $result->fetch_assoc() ) {
            $first_name = $row['FirstName'];
            $last_name = $row['LastName'];
        }
    }

    if( $_POST ) {
        $show_form = false;
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';




        $staff_id = $_POST['staff_id'];
        if( filter_var($_POST['staff_id'], FILTER_VALIDATE_INT) ) {
            $staff_id = $_POST['staff_id'];
        } else {
            exit("An incorrect value for Staff ID was used");
        }

        $animal_sql = "SELECT Name FROM Animal WHERE StaffID = $staff_id";
        $result = $connection->query($animal_sql);
        if( !$result ) {
            exit("There was a problem fetching results");
        }
        if( 0 === $result->num_rows ) {
            $delete_sql = "DELETE FROM Staff WHERE StaffID = $staff_id";
            if( !$result= $connection->query($delete_sql)) {}
            $message = "Staff Member deleted";
        } else {
            $message = "This staff member is assigned to look after the following animals: ";
            while( $row = $result->fetch_assoc() ) {
                $message .= sprintf("%s, ", $row['Name'] );
            }
            $message .= " and they cannot be removed. Change who looks after these animals and try again.";
        }

    }

    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo - Remove Staff Member</title>
</head>
<body>
    <?php include 'admin_menu.php'; ?>
    <h1>Remove Staff Member</h1>
    <?php if( $show_form ): ?>
        <form action="#" method="POST" enctype="multipart/form-data">
            <p>Are you certain you want to remove <?php echo $first_name . ' ' . $last_name; ?></p>
            <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
            <input type="submit" value="Yes, remove staff member">
        </form>
    <?php else: ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>