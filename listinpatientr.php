<?include('receptionistCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Patient</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="listpatientr.php">Patient List</a></li>
                        <li class="active"><a href="listinpatientr.php">In Patient List</a></li>
                        <li><a href="addpatientr.php">Add Patient</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);
// | inpatient_id | date_admission | date_discharge | p_id | room_id | nurse_id |


class inpatient
{
    private $inpatient_id;
    private $date_admission;
    private $date_discharge;
    private $p_id;
    private $room_id;
    private $nurse_id;

    public function getinpatient_id() {return $this->inpatient_id; }
    public function getdate_admission() {return $this->date_admission; }
    public function getdate_discharge() {return $this->date_discharge; }
    public function getp_id() {return $this->p_id; }
    public function getroom_id() {return $this->room_id; }
    public function getnurse_id() {return $this->nurse_id;}

}

function createtablerow(inpatient $p,& $header)
{
    if($header)
    {
        print "<table class='table table-bordered'>";
        print <<<here
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Date of Admission</th>
    <th>Date of Discharge</th>
    <th>Room No</th>
    <th>Room Type</th>
    <th>Nurse Appointed</th>
    </tr>
here;
        $header=false;
    }
//    $pid=$p->getid();
    $pid=$p->getp_id();
    $roomid=$p->getroom_id();
    $nurseid=$p->getnurse_id();
    print "<tr>";
    print "<td>". $p->getinpatient_id()      . "</td>";

    include('connection.php');

    $patientfetch = "select * from patient where p_id = $pid";

    $ps = $con->prepare($patientfetch);

    // Fetch the matching row.
    $ps->execute();
    $data = $ps->fetchAll();

    foreach ($data as $row) {
        print "<td>".$row['p_name']."</td>";
    }

    print "<td>". $p->getdate_admission()    . "</td>";
    print "<td>". $p->getdate_discharge() . "</td>";
    print "<td>". $p->getroom_id()   . "</td>";


    include('connection.php');

    $roomfetch = "select * from room where room_id = $roomid";

    $ps = $con->prepare($roomfetch);

    // Fetch the matching row.
    $ps->execute();
    $data = $ps->fetchAll();

    foreach ($data as $row) {
        print "<td>".$row['type']."</td>";
    }


    include('connection.php');

    $nursefetch = "select * from employee where EID = $nurseid";

    $ps = $con->prepare($nursefetch);

    // Fetch the matching row.
    $ps->execute();
    $data = $ps->fetchAll();

    foreach ($data as $row) {
        print "<td>".$row['Name']."</td>";
    }


//    print "<td>&emsp;<a href=updatepatient.php?pid=$pid><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a href=deletepatient.php?pid=$pid><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
    print "</tr>";

}

try
{
    $header=true;

    // Connect to the database.
    include('connection.php');

    $query = "SELECT * FROM inpatient;";

    $ps = $con->prepare($query);

    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "inpatient");

    // $data is an array.
    if ($ps->rowCount() > 0)
    {
        // Construct the HTML table row by row.
        while ($inpatient  = $ps->fetch())
        {
            createtablerow($inpatient,$header);
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
 * Date: 12/1/15
 * Time: 1:34 PM
 */
?>
        </div>
    </div>
<?include('footer.html');?>