<?php include('adminCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Patient</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="listpatient.php">Patient List</a></li>
                        <li><a href="addpatient.php">Add Patient</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);


$pid = filter_input(INPUT_GET, "pid");

if(isset($_POST['buttondec'])) {

    $decision=filter_input(INPUT_POST, "buttondec");
    if($decision==0){
        header('Location: listpatient.php');
    }
    else{
        try {

            // Connect to the database.
            include('connection.php');

            $query = "DELETE FROM patient WHERE p_id=:pid";

            $ps = $con->prepare($query);
            $ps->execute(array(':pid' => $pid));

            // print "<div style=\"text-align: center;\"><h3>Successfully Deleted</h3></div>\n";

            header('Location: listpatient.php');

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
 * Date: 11/30/15
 * Time: 12:17 AM
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