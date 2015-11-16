<?include('adminCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Laboratorist</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="listlaboratorist.php">Laboratorist List</a></li>
                        <li><a href="addlaboratorist.php">Add Laboratorist</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);

$eid = filter_input(INPUT_GET, "eid");

try {

    // Connect to the database.
    include('connection.php');

    $query = "DELETE FROM employee WHERE eid=:eid";

    $ps = $con->prepare($query);
    $ps->execute(array(':eid' => $eid));

    // echo $name, $email, $address, $salary, $id, $emptype, $password;
    print "<div style=\"text-align: center;\"><h3>Successfully Deleted</h3></div>\n";
} catch (PDOException $ex) {
    echo 'ERROR: ' . $ex->getMessage();
} catch (Exception $ex) {
    echo 'ERROR: ' . $ex->getMessage();
}

/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/16/15
 * Time: 5:00 AM
 */
?>

</div>
</div>
<?include('footer.html');?>