<?php include('adminCommon.html');?>
<div class="content">
    <div class="page-header">
        <h2>Manage Patient</h2>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="listpatient.php">Patient List</a></li>
                    <li class="active"><a href="addpatient.php">Add Patient</a></li>
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
            $gender = filter_input(INPUT_POST, "gender");
            $dob = filter_input(INPUT_POST, "dob");
            $weight = filter_input(INPUT_POST, "weight");
            $id = NULL;
            $password = filter_input(INPUT_POST, "email");

            try {
                if (empty($name) || empty($email) || empty($address) || empty($gender) || empty($dob) || empty($weight)) {
                    throw new Exception("Missing Details.");
                }

                // Connect to the database.
                include('connection.php');

                $query = "INSERT INTO patient (p_name, emailid, p_address, p_gender, p_dob, p_weight, p_id, password)
              VALUES (:name, :email, :address, :gender, :dob, :weight, :id, :password)";

                $ps = $con->prepare($query);
                $ps->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':gender' => $gender, ':dob' => $dob, ':weight' => $weight, ':id' => $id, ':password' => $password));

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
 * Date: 11/15/15
 * Time: 1:21 AM
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
                <label class="control-label" for="gender">Gender</label>
                <div class="controls">

                    <div class="radio">
                        <label class="radio-custom" data-initialize="radio" for="gender-0">
                            <input id="gender-0" name="gender" type="radio" value="M" checked="checked">
                            M
                        </label>

                        <label class="radio-custom" data-initialize="radio" for="gender-1">
                            <input id="gender-1" name="gender" type="radio" value="F">
                            F
                        </label>
                    </div>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="dob">Date of Birth</label>
                <div class="controls">
                    <input id="dob" name="dob" type="date" placeholder="Enter Date of Birth" class=" form-control" required>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="weight">Weight</label>
                <div class="controls">
                    <input id="weight" name="weight" type="number" placeholder="Enter Weight" class=" form-control" required>

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