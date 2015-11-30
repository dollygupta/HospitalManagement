<?include('adminCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Doctor</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="listdoctor.php">Doctor List</a></li>
                        <li class="active"><a href="adddoctor.php">Add Doctor</a></li>
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
    $phone = filter_input(INPUT_POST, "phone");
    $consultation = filter_input(INPUT_POST, "consultation");
    $salary = filter_input(INPUT_POST, "salary");
    $dept = filter_input(INPUT_POST, "department");
    $id = NULL;
    $password = filter_input(INPUT_POST, "email");

    try {
        if (empty($name) || empty($email) || empty($address) || empty($phone) || empty($consultation) || empty($salary)) {
            throw new Exception("Missing Details.");
        }

        // Connect to the database.
        include('connection.php');

        $query = "INSERT INTO doctor (d_name, emailid, Address, d_phone, doctor_fees, salary, dept_id, d_id, password)
              VALUES (:name, :email, :address, :phone, :consultation, :salary, :dept, :id, :password)";

        $ps = $con->prepare($query);
        $ps->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':phone' => $phone, ':consultation' => $consultation, ':salary' => $salary, ':dept' => $dept, ':id' => $id, ':password' => $password));

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
 * Time: 1:41 AM
 */
?>
            <form action="" method="post" class="form-horizontal">

                <div class="control-group">
                    <label class="control-label" for="name">Name</label>
                    <div class="controls">
                        <input id="name" name="name" type="text" placeholder="Enter Full Name" class=" form-control" required>

                    </div>
                </div>

                <?php
                include('connection.php');
                print "<div class=\"control-group\">
                    <label class=\"control-label\" for=\"department\">Department</label>
                    <div class=\"controls\">
                        <select id=\"department\" name=\"department\" class=\" form-control\" required>";

                $deptfetch = "select * from department";

                $ps = $con->prepare($deptfetch);

                // Fetch the matching row.
                $ps->execute();
                $data = $ps->fetchAll();

                foreach ($data as $row) {
                    print "<option value = '".$row['dept_id']."'>".$row['dept_name']."</option>";
                }
                print "</select>

                    </div>
                </div>";

                ?>

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
                    <label class="control-label" for="phone">Phone Number</label>
                    <div class="controls">
                        <input id="phone" name="phone" type="tel" placeholder="Enter Phone Number" class=" form-control" required>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="consultation">Consultation Fees</label>
                    <div class="controls">
                        <input id="consultation" name="consultation" type="number" placeholder="Enter Consultation Fees" class=" form-control" required>

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
<?include('footer.html');?>