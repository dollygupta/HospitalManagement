<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Add a Laboratorist</title>
</head>

<body>
<?php
ini_set('display_errors', 1);

$name = filter_input(INPUT_POST, "name");
$email = filter_input(INPUT_POST, "email");
$address = filter_input(INPUT_POST, "address");
$salary = filter_input(INPUT_POST, "salary");
$id = NULL;
$emptype = "Laboratorist";
$password = filter_input(INPUT_POST, "email");

try
{
    if (empty($name) || empty($email) || empty($address) || empty($salary)) {
        throw new Exception("Missing Details.");
    }

    // Connect to the database.
    include('connection.php');

    $query = "INSERT INTO employee (Name, Email, Address, Salary, EID, type, Password)
              VALUES (:name, :email, :address, :salary, :id, :emptype, :password)";

    $ps = $con->prepare($query);
    $ps->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':salary' => $salary, ':id' => $id, ':emptype' => $emptype, ':password' => $password));

    // echo $name, $email, $address, $salary, $id, $emptype, $password;
    print "<h3>Successfully Inserted</h3>\n";
}

catch(PDOException $ex) {
    echo 'ERROR: '.$ex->getMessage();
}

catch(Exception $ex) {
    echo 'ERROR: '.$ex->getMessage();
}
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/15/15
 * Time: 12:56 AM
 */
?>
</body>
</html>