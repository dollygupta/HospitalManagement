<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Add a Patient</title>
</head>

<body>
<?php
ini_set('display_errors', 1);

$name = filter_input(INPUT_POST, "name");
$email = filter_input(INPUT_POST, "email");
$address = filter_input(INPUT_POST, "address");
$gender = filter_input(INPUT_POST, "gender");
$dob = filter_input(INPUT_POST, "dob");
$weight = filter_input(INPUT_POST, "weight");
$id = NULL;
$password = filter_input(INPUT_POST, "email");

try
{
    if (empty($name) || empty($email) || empty($address) || empty($gender) || empty($dob) || empty($weight)) {
        throw new Exception("Missing Details.");
    }

    // Connect to the database.
    $con = new PDO("mysql:host=localhost;dbname=hos_m","root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO patient (p_name, p_email, p_address, p_gender, p_dob, p_weight, p_id, p_password)
              VALUES (:name, :email, :address, :gender, :dob, :weight, :id, :password)";

    $ps = $con->prepare($query);
    $ps->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':gender' => $gender, ':dob' => $dob, ':weight' => $weight, ':id' => $id, ':password' => $password));

    // echo $name, $email, $address, $gender, $dob, $weight, $id, $password;
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
 * Time: 1:21 AM
 */
?>
</body>
</html>