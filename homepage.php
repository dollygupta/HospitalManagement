<?php
$user_type= $_GET["user_type"];
$pwd= $_GET["pwd"];
$email= $_GET["email"];
$result="";

try {   
            // Connect to the database.
            include('connection.php');

            if($user_type=="admin")
            {
                if($pwd=="admin" && $email="admin@gmail.com"){
                    echo "admin";
                }
                else{
                    echo "wrong";
                }
            }
            else if($user_type=="doctor")
            {
                $query = "SELECT * FROM doctor WHERE emailid=:email and password=:pwd";
                 $ps = $con->prepare($query);
                 $ps->execute(array(':email' => $email,':pwd' => $pwd));
                 $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                 if (count($data) > 0) {
                    echo "doctor";
                 }
                 else {
                    echo "wrong";
                 }

            }
            else{
                $query = "SELECT * FROM employee WHERE Email=:email and Password=:pwd and type=:type";
                 $ps = $con->prepare($query);
                 $ps->execute(array(':email' => $email,':pwd' => $pwd, ':type' => $user_type));
                 $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                 if (count($data) > 0) {
                    echo $user_type;
                 }
                else {
                    echo "wrong";
                 }
            } 
        }
        catch(PDOException $ex) {
            echo 'ERROR: '.$ex->getMessage();
        }    
        catch(Exception $ex) {
            echo 'ERROR: '.$ex->getMessage();
        }
?>