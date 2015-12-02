<?include('adminCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Receptionist</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="listreceptionist.php">Receptionist List</a></li>
                        <li><a href="addreceptionist.php">Add Receptionist</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);

include('classemployee.php');

$eid = filter_input(INPUT_GET, "eid");

try {

    // Connect to the database.
    include('connection.php');

$h=new employee();
    $ename=$h->gete_name();

    print"<form action=\"\" method=\"post\" class=\"form-horizontal\">

            <div class=\"control-group\">
                <label class=\"control-label\" for=\"name\">Name</label>
                <div class=\"controls\">
                    <input id=\"name\" name=\"name\" value='\".$ename. \"'type=\"text\" placeholder=\"Enter Full Name\" class=\" form-control\" required>

                </div>
            </div>

            <div class=\"control-group\">
                <label class=\"control-label\" for=\"email\">Email</label>
                <div class=\"controls\">
                    <input id=\"email\" name=\"email\" value='\".$h->getemail(). \"'type=\"email\" placeholder=\"Enter Email Address\" class=\" form-control\" required>

                </div>
            </div>

            <div class=\"control-group\">
                <label class=\"control-label\" for=\"address\">Address</label>
                <div class=\"controls\">
                    <input id=\"address\" name=\"address\" value='\".$h->getaddress(). \"'type=\"text\" placeholder=\"Enter Street Address\" class=\" form-control\" required>

                </div>
            </div>

            <div class=\"control-group\">
                <label class=\"control-label\" for=\"salary\">Salary</label>
                <div class=\"controls\">
                    <input id=\"salary\" name=\"salary\" value='\".$h->getsalary(). \"'type=\"number\" placeholder=\"Enter Salary\" class=\" form-control\" required>

                </div>
            </div>

            <div class=\"control-group\">
                <label class=\"control-label\" for=\"submit\"></label>
                <div class=\"controls\">
                    <button id=\"submit\" name=\"submit\" class=\"btn btn-primary\">Submit</button>
                </div>
            </div>

        </form>";

    $query = "UPDATE employee SET Name='$' WHERE id=2 WHERE eid=:eid";

    $ps = $con->prepare($query);
    $ps->execute(array(':eid' => $eid));

    // print "<div style=\"text-align: center;\"><h3>Successfully Deleted</h3></div>\n";

//    header('Location: listreceptionist.php');

} catch (PDOException $ex) {
    echo 'ERROR: ' . $ex->getMessage();
} catch (Exception $ex) {
    echo 'ERROR: ' . $ex->getMessage();
}

/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/30/15
 * Time: 2:45 AM
 */
?>

</div>
    </div>
<?include('footer.html');?>