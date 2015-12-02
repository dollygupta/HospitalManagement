<?php include('receptionistCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Patient</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="listappointmentr.php">Appointment List</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);
// | appt_id | appt_reason  | time     | date       | r_id | d_id | p_id | slotid |



class appointment
{
    private $appt_id;
    private $appt_reason;
    private $time;
    private $date;
    private $r_id;
    private $d_id;
    private $p_id;
    private $slotid;


    public function getappt_id() {return $this->appt_id; }
    public function getappt_reason() {return $this->appt_reason; }
    public function gettime() {return $this->time; }
    public function gettdate() {return $this->date; }
    public function getr_id() {return $this->r_id; }
    public function getd_id() {return $this->d_id;}
    public function getp_id() {return $this->p_id; }
    public function getslotid() {return $this->slotid;}

}

function createtablerow(appointment $a,& $header)
{
    if($header)
    {
        print "<table class='table table-bordered'>";
        print <<<here
    <tr>
    <th>ID</th>
    <th>Reason</th>
    <th>Time</th>
    <th>Date</th>
    <th>Doctor Name</th>
    <th>Patient Name</th>
    </tr>
here;
        $header=false;
    }
//    $pid=$p->getid();
    $did=filter_input(INPUT_POST, "doctor");
    $pid=$a->getp_id();
    print "<tr>";
    print "<td>". $a->getappt_id()      . "</td>";
    print "<td>". $a->getappt_reason()      . "</td>";
    print "<td>". $a->gettime()      . "</td>";
    print "<td>". $a->gettdate()      . "</td>";


    include('connection.php');

    $roomfetch = "select * from doctor where d_id = $did";

    $ps = $con->prepare($roomfetch);

    // Fetch the matching row.
    $ps->execute();
    $data = $ps->fetchAll();

    foreach ($data as $row) {
        print "<td>".$row['d_name']."</td>";
    }

    include('connection.php');

    $patientfetch = "select * from patient where p_id = $pid";

    $ps = $con->prepare($patientfetch);

    // Fetch the matching row.
    $ps->execute();
    $data = $ps->fetchAll();

    foreach ($data as $row) {
        print "<td>".$row['p_name']."</td>";
    }



//    print "<td>&emsp;<a href=updatepatient.php?pid=$pid><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a href=deletepatient.php?pid=$pid><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
    print "</tr>";

}

try
{

    if(isset($_POST['submit'])) {
        $did=filter_input(INPUT_POST, "doctor");

        $header = true;

        // Connect to the database.
        include('connection.php');

        $query = "SELECT * FROM appointment WHERE d_id = $did;";

        $ps = $con->prepare($query);

        // Fetch the matching row.
        $ps->execute();
        $ps->setFetchMode(PDO::FETCH_CLASS, "appointment");

        // $data is an array.
        if ($ps->rowCount() > 0) {
            // Construct the HTML table row by row.
            while ($appointment = $ps->fetch()) {
                createtablerow($appointment, $header);
            }
            print "</table>";
        } else {
            print "<h3>(No match.)</h3>\n";
        }
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
 * Date: 12/2/15
 * Time: 10:59 AM
 */
?>
            <form action="" method="post" class="form-horizontal">

<?php
include('connection.php');
print "<div class=\"control-group\">
                    <label class=\"control-label\" for=\"doctor\">Select Doctor</label>
                    <div class=\"controls\">
                        <select id=\"doctor\" name=\"doctor\" class=\" form-control\" required>";

$doctfetch = "select * from doctor";

$ps = $con->prepare($doctfetch);

// Fetch the matching row.
$ps->execute();
$data = $ps->fetchAll();

foreach ($data as $row) {
    print "<option value = '".$row['d_id']."'>".$row['d_name']."</option>";
}
print "</select>

                    </div>
                </div>";

?>

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