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
        // PREPARED STATEMENT EXAMPLE
        // $statement = $connection->prepare("INSERT INTO Staff (FirstName, LastName) VALUES(?,?)");
        // $statement->bind_param("ss", $_POST['first_name'], $_POST['last_name'] );
        // if ( $statement->execute() ) {
        //     echo "Yay! New Staff member added!";
        // }  else {
        //     echo "There was an issue adding a new staff member...";
        // }
        // $statement->close();

        // $connection->close();
            $first_name = $connection->real_escape_string($_POST['first_name']);
            $last_name = $connection->real_escape_string($_POST['last_name']);
            $sql = "INSERT INTO Staff (FirstName, LastName) VALUES($first_name, $last_name)";
            if (!$result = $connection->query($sql) ) {
                die("Could not add a staff member to the database");
            }
            echo '<pre>';
            print_r($result);
            echo '</pre>';

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