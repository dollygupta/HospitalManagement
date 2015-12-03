<?php include('adminCommon.html');?>
<div class="content">
    <div class="page-header">
        <h2>Manage Pharmacist</h2>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="listpharmacist.php">Pharmacist List</a></li>
                    <li class="active"><a href="addpharmacist.php">Add Pharmacist</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="show-table">
        <?php
ini_set('display_errors', 1);

        if(isset($_POST['submit'])) {

            $name = filter_input(INPUT_POST, "name");
            $email = filter_input(INPUT_POST, "email");
            $address = filter_input(INPUT_POST, "address");
            $salary = filter_input(INPUT_POST, "salary");
            $id = NULL;
            $emptype = "Pharmacist";
            $password = filter_input(INPUT_POST, "email");

            try {
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
 * Date: 11/15/15
 * Time: 12:49 AM
 */

        ?>
        <form action="" method="post" class="form-horizontal">

            <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                    <input id="name" name="name" type="text" placeholder="Enter Full Name" class=" form-control" required>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input id="email" name="email" type="email" placeholder="Enter Email Address" class=" form-control" required>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="address">Address</label>
                <div class="controls">
                    <input id="address" name="address" type="text" placeholder="Enter Street Address" class=" form-control" required>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="salary">Salary</label>
                <div class="controls">
                    <input id="salary" name="salary" type="number" placeholder="Enter Salary" class=" form-control" required>

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