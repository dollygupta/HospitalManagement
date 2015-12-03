<?php include('adminCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Department</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="listdepartment.php">Department List</a></li>
                        <li class="active"><a href="adddepartment.php">Add Department</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);

if(isset($_POST['submit'])) {

    $name = filter_input(INPUT_POST, "name");
    $description = filter_input(INPUT_POST, "description");
    $id = NULL;
    $count = 0;

    try {
        if (empty($name) || empty($description)) {
            throw new Exception("Missing Details.");
        }

        // Connect to the database.
        include('connection.php');

        $query = "INSERT INTO department (dept_name, dept_desc, dept_id, no_of_doctors)
              VALUES (:name, :description, :id, :count)";

        $ps = $con->prepare($query);
        $ps->execute(array(':name' => $name, ':description' => $description, ':id' => $id, ':count' => $count));

        // echo $name, $email, $address, $gender, $dob, $weight, $id, $password;
        print "<div style=\"text-align: center;\"><h3>$name was Successfully Inserted</h3></div>\n";
    } catch (PDOException $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    } catch (Exception $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    }
}

/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/30/15
 * Time: 2:20 AM
 */

?>
            <form action="" method="post" class="form-horizontal">

                <div class="control-group">
                    <label class="control-label" for="name">Name</label>
                    <div class="controls">
                        <input id="name" name="name" type="text" placeholder="Enter Department Name" class=" form-control" required>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="description">Description</label>
                    <div class="controls">
                        <input id="description" name="description" type="text" placeholder="Enter Description" class=" form-control" required>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="submit"></label>
                    <div class="controls">
                        <button id="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>


        </div>
    </div>
<?php include('footer.html');?>