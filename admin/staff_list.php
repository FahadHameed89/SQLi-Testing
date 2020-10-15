<?php
require '../constants.php';

$staff_members = null;

// Create connection
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
if( $connection->connect_errno ) {
    die('Connection failed: ' . $connection->connect_error);
}
$sql = "SELECT * FROM Staff";

if( !$result = $connection->query($sql) ) {
    echo "Crap! Something went wrong with the staff query";
    exit();
}

if( 0 === $result->num_rows ) {
    $staff_members = '<tr><td colspan="4">There are no staff members</td></tr>';
} else {
    while( $row = $result->fetch_assoc() ) {
        $staff_members .= sprintf('
            <tr>
                <td>%d</td>
                <td>%s</td>
                <td>%s</td>
                <td><a href="staff_edit.php?staff_id=%d">Edit</a> | <a href="staff_delete.php?staff_id=%d">Remove</a></td>
            </tr>
            ',
            $row['StaffID'],
            $row['FirstName'],
            $row['LastName'],
            $row['StaffID'],
            $row['StaffID'],
         );
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo - Staff List</title>
</head>
<body>
<?php include 'admin_menu.php' ?>
    <h1>Staff Members</h1>
    <table>
        <tr>
            <th>Staff ID</th>    
            <th>First Name</th>
            <th>Last Name</th>
            <th>Actions</th>
        </tr>
        <?php echo $staff_members; ?>
        
    </table>
</body>
</html>