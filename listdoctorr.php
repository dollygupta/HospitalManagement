<?php include('receptionistCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Doctor</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="listdoctorr.php">Doctor List</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);

class doctor
{
    private $d_id;
    private $d_name;
    private $d_phone;
    private $dept_id;
    private $doctor_fees;
    private $emailid;
    private $salary;
    private $address;

    public function getid() {return $this->d_id; }
    public function getname() {return $this->d_name; }
    public function getphone() {return $this->d_phone; }
    public function getdeptid() {return $this->dept_id; }
    public function getfees() {return $this->doctor_fees;}
    public function getemail() {return $this->emailid;}
    public function getsalary() {return $this->salary;}
    public function getaddress() {return $this->address;}

}

function createtablerow(doctor $d,& $header)
{
    if($header)
    {
        print "<table class='table table-bordered'>";
        print <<<here
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Department</th>
    <th>Street Address</th>
    <th>Email Address</th>
    <th>Phone No</th>
    <th>Salary</th>
    <th>Consultation Fees</th>
    </tr>
here;
        $header=false;
    }
    //$did=$d->getid();
    $deptid=$d->getdeptid();
    print "<tr>";
    print "<td>". $d->getid()    . "</td>";
    print "<td>". $d->getname()  . "</td>";
    include('connection.php');

    $deptfetch = "select * from department where dept_id = $deptid";

    $ps = $con->prepare($deptfetch);

    // Fetch the matching row.
    $ps->execute();
    $data = $ps->fetchAll();

    foreach ($data as $row) {
        print "<td>".$row['dept_name']."</td>";
    }

    print "<td>". $d->getaddress() . "</td>";
    print "<td>". $d->getemail()   . "</td>";
    print "<td>". $d->getphone()   . "</td>";
    print "<td>". $d->getsalary()  . "</td>";
    print "<td>". $d->getfees()  . "</td>";
    //print "<td>&emsp;<a href=doctor_update.php?did=$did><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a href=doctor_delete.php?did=$did><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
    print "</tr>";

}

try
{
    $header=true;

    // Connect to the database.
    include('connection.php');

    $query = "SELECT * FROM doctor;";

    $ps = $con->prepare($query);

    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "doctor");

    // $data is an array.
    if ($ps->rowCount() > 0)
    {
        // Construct the HTML table row by row.
        while ($doctor  = $ps->fetch())
        {
            createtablerow($doctor,$header);
        }
        print "</table>";
    }
    else {
        print "<h3>(No match.)</h3>\n";
    }
}

catch(PDOException $ex) {
    echo 'ERROR: '.$ex->getMessage();
}

catch(Exception $ex) {
    echo 'ERROR: '.$ex->getMessage();
}/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 12/1/15
 * Time: 10:46 AM
 */

?>
        </div>
    </div>
<?php include('footer.html');?>