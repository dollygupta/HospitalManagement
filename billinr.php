<?php include('receptionistCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Patient</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="billoutr.php">Out Patient Bill</a></li>
                        <li class="active"><a href="billinr.php">In Patient Bill</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);

class inbill
{
    private $p_id;
    private $inpatient_id;
    private $appt_id;
    private $doctor_fees;
    private $Lab_Test_Amount;
    private $Room_fees;
    private $Total_fees;


    public function getp_id() {return $this->p_id; }
    public function getinp_id() {return $this->inpatient_id; }
    public function getappt_id() {return $this->appt_id; }
    public function getdoctor_fees() {return $this->doctor_fees; }
    public function getLab_Test_Amount() {return $this->Lab_Test_Amount; }
    public function getRoom_fees() {return $this->Room_fees;}
    public function getTotal_fees() {return $this->Total_fees; }
}

function createtablerow(inbill $o,& $header)
{
    if($header)
    {
        print "<table class='table table-bordered'>";
        print <<<here
    <tr>
    <th>Patient ID</th>
    <th>InPatient ID</th>
    <th>Appointment ID</th>
    <th>Doctor Fees</th>
    <th>Lab Test Amount</th>
    <th>Room Fees</th>
    <th>Total Fees</th>
    </tr>
here;
        $header=false;
    }
//    $pid=$p->getid();
    print "<tr>";
    print "<td>". $o->getp_id()      . "</td>";
    print "<td>". $o->getinp_id()      . "</td>";
    print "<td>". $o->getappt_id()    . "</td>";
    print "<td>". $o->getdoctor_fees() . "</td>";
    print "<td>". $o->getLab_Test_Amount()   . "</td>";
    print "<td>". $o->getRoom_fees()  . "</td>";
    print "<td>". $o->getTotal_fees()     . "</td>";
//    print "<td>&emsp;<a href=updatepatient.php?pid=$pid><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a href=deletepatient.php?pid=$pid><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
    print "</tr>";

}

try
{
    $header=true;

    // Connect to the database.
    include('connection.php');

    $query = "select p.p_id,ip.inpatient_id,a.appt_id,d.doctor_fees,sum(ifnull(t.test_amount,0)) AS 'Lab_Test_Amount',DATEDIFF(now(),ip.date_admission)*r.room_fees AS 'Room_fees'
,sum(ifnull(t.test_amount,0)) + d.doctor_fees + DATEDIFF(now(),ip.date_admission)*r.room_fees AS 'Total_fees' from  lab_report l join lab_test t on l.test_id=t.test_id  right join patient p
 on l.p_id=p.p_id join appointment a on a.p_id=p.p_id join doctor d on a.d_id=d.d_id join inpatient ip on p.p_id=ip.p_id join room r on ip.room_id=r.room_id where p.p_id IS NOT NULL and a.date< now()
 and ip.date_admission< now() group by p.p_id;";

    $ps = $con->prepare($query);

    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "inbill");

    // $data is an array.
    if ($ps->rowCount() > 0)
    {
        // Construct the HTML table row by row.
        while ($inbill  = $ps->fetch())
        {
            createtablerow($inbill,$header);
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
 * Date: 12/2/15
 * Time: 3:12 PM
 */
?>
        </div>
    </div>
<?php include('footer.html');?>