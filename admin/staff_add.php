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
        // PREPARED STATEMENT
        // $statement = $connection->prepare("INSERT INTO Staff (FirstName, LastName) VALUES(?,?)");
        // $statement->bind_param("ss", $_POST['first_name'], $_POST['last_name']);
        // if( $statement->execute() ) {
        //     echo "Yay! We've added a staff member to the database";
        // } else {
        //     echo "There was a problem adding a staff member to the database";
        // }
        // $statement->close();

        // WITHOUT A PREPARED STATEMENT
        $first_name = $connection->real_escape_string($_POST['first_name']);
        $last_name = $connection->real_escape_string($_POST['last_name']);
        $sql = "INSERT INTO Staff (FirstName, LastName) VALUES('$first_name', '$last_name')";
        if( !$result = $connection->query($sql) ) {
            die("Could not add staff member to the database");
        }

        $connection->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo - Add Staff</title>
</head>
<body>
    <h1>Add a staff member</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <p>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name">
    </p>
    <p>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name">
    </p>
    <p>
        <input type="submit" value="Add new staff member">
    </p>
    </form>
</body>
</html>