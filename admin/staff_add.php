<?php
    require '../constants.php';
    if( $_POST) {
        echo '<pre>';
        print_r($_POST);
        echo "The form was successfully submitted...! Thanks for the data sucker!";
        echo '</pre>';
        $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);
        if ( $connection->connect_errno ) {
            die('Connection Failed!: ' . $connection->connect_error);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo - Add Staff Member</title>
</head>
<body>
    <h1>Add a Staff Member!</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-sata">
    <p>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name">
    </p>
    <p>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name">
    </p>
    <p>
        <input type="submit" value="Add new staff member!">
    </p>

    </form> 
</body>
</html>