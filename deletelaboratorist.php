<?php include('adminCommon.html');?>
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

if(isset($_POST['buttondec'])) {

    $decision=filter_input(INPUT_POST, "buttondec");
    if($decision==0){
        header('Location: listlaboratorist.php');
    }
    else{
        try {

            // Connect to the database.
            include('connection.php');

            $query = "DELETE FROM employee WHERE eid=:eid";

            $ps = $con->prepare($query);
            $ps->execute(array(':eid' => $eid));

           // print "<div style=\"text-align: center;\"><h3>Successfully Deleted</h3></div>\n";

           header('Location: listlaboratorist.php');

        } catch (PDOException $ex) {
            echo 'ERROR: ' . $ex->getMessage();
        } catch (Exception $ex) {
            echo 'ERROR: ' . $ex->getMessage();
        }

    }
}
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/16/15
 * Time: 5:00 AM
 */
?>

            <form action="" method="post" class="form-horizontal">

                <div class="control-group">
                    <label class="control-label" for="buttonno">Confirm Delete?</label>
                    <div class="controls">
                        <button id="buttonno" name="buttondec" class="btn btn-success" value="0">No</button>
                        <button id="buttonyes" name="buttondec" class="btn btn-danger" value="1">Yes</button>
                    </div>
                </div>


            </form>

</div>
</div>
<?php include('footer.html');?>