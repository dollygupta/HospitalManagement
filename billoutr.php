<?php include('receptionistCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Patient</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="billoutr.php">Out Patient Bill</a></li>
                        <li><a href="billinr.php">In Patient Bill</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);

class outbill
{
    private $p_id;
    private $appt_id;
    private $doctor_fees;
    private $lab_report_id;
    private $test_Amount;
    private $Total_fees;


    public function getp_id() {return $this->p_id; }
    public function getappt_id() {return $this->appt_id; }
    public function getdoctor_fees() {return $this->doctor_fees; }
    public function getlab_report_id() {return $this->lab_report_id; }
    public function gettest_Amount() {return $this->test_Amount;}
    public function getTotal_fees() {return $this->Total_fees; }
}

function createtablerow(outbill $o,& $header)
{
    if($header)
    {
        print "<table class='table table-bordered'>";
        print <<<here
    <tr>
    <th>Patient ID</th>
    <th>Appointment ID</th>
    <th>Doctor Fees</th>
    <th>Lab Report ID</th>
    <th>Test Amount</th>
    <th>Total Fees</th>
    </tr>
here;
        $header=false;
    }
//    $pid=$p->getid();
    print "<tr>";
    print "<td>". $o->getp_id()      . "</td>";
    print "<td>". $o->getappt_id()    . "</td>";
    print "<td>". $o->getdoctor_fees() . "</td>";
    print "<td>". $o->getlab_report_id()   . "</td>";
    print "<td>". $o->gettest_Amount()  . "</td>";
    print "<td>". $o->getTotal_fees()     . "</td>";
//    print "<td>&emsp;<a href=updatepatient.php?pid=$pid><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a href=deletepatient.php?pid=$pid><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
    print "</tr>";

}

try
{
    $header=true;

    // Connect to the database.
    include('connection.php');

    $query = "select p.p_id,a.appt_id,d.doctor_fees,l.lab_report_id,sum(ifnull(t.test_amount,0)) AS 'test_Amount',sum(ifnull(t.test_amount,0)) + d.doctor_fees AS 'Total_fees' from  lab_report l
join lab_test t on l.test_id=t.test_id  right join patient p on l.p_id=p.p_id join appointment a on a.p_id=p.p_id join doctor d on a.d_id=d.d_id where a.date < now() group by p.p_id,a.appt_id ;";

    $ps = $con->prepare($query);

    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "outbill");

    // $data is an array.
    if ($ps->rowCount() > 0)
    {
        // Construct the HTML table row by row.
        while ($outbill  = $ps->fetch())
        {
            createtablerow($outbill,$header);
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
 * Time: 2:21 PM
 */
?>
        </div>
    </div>
<?php include('footer.html');?>