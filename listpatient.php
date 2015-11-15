<?include('adminCommon.html');?>
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

class patient
{
    private $p_dob;
    private $p_id;
    private $p_name;
    private $p_email;
    private $p_weight;
    private $p_address;
    private $p_gender;

    public function getdob() {return $this->p_dob; }
    public function getid() {return $this->p_id; }
    public function getname() {return $this->p_name; }
    public function getemail() {return $this->p_email; }
    public function getweight() {return $this->p_weight; }
    public function getaddress() {return $this->p_address;}
    public function getgender() {return $this->p_gender;}

}

function createtablerow(patient $p,& $header)
{
    if($header)
    {
        print "<table class='table table-bordered'>";
        print <<<here
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Street Address</th>
    <th>Email Address</th>
    <th>Gender</th>
    <th>Date of Birth</th>
    <th>Weight</th>
    <th>Options</th>
    </tr>
here;
        $header=false;
    }
    $pid=$p->getid();
    print "<tr>";
    print "<td>". $p->getid()      . "</td>";
    print "<td>". $p->getname()    . "</td>";
    print "<td>". $p->getaddress() . "</td>";
    print "<td>". $p->getemail()   . "</td>";
    print "<td>". $p->getgender()  . "</td>";
    print "<td>". $p->getdob()     . "</td>";
    print "<td>". $p->getweight()  . "</td>";
    print "<td>&emsp;<a href=updatepatient.php?eid=$pid><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a href=deletepatient.php?eid=$pid><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
    print "</tr>";

}

try
{
    $header=true;

    // Connect to the database.
    include('connection.php');

    $query = "SELECT * FROM patient;";

    $ps = $con->prepare($query);

    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "patient");

    // $data is an array.
    if ($ps->rowCount() > 0)
    {
        // Construct the HTML table row by row.
        while ($employee  = $ps->fetch())
        {
            createtablerow($employee,$header);
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
}
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/15/15
 * Time: 1:07 AM
 */
?>
    </div>
</div>
<?include('footer.html');?>