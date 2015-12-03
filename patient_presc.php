<?php include('patientCommon.html');?>
<div class="content">
    <div class="page-header">
        <h2> patient prescription</h2>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div>
                <ul class="nav navbar-nav">
                
            </div>
        </div>
    </nav>
    <div class="show-table">
        <?php


class employee
{
    private $date;
    private $prescription;
    private $d_name;
    

    public function getdate() {return $this->date; }
    public function getpres() {return $this->prescription; }
    public function getd_name() {return $this->d_name; }
    
}

ini_set('display_errors', 1);


        function createtablerow(employee $e,& $header)
        {
            if($header)
            {
                print "<table class='table table-bordered' border='1'>";
                print <<<here
    <tr>
    <th>Doctor Name</th>
    <th>Date</th>
    <th>Prescription</th>
    </tr>
here;
                $header=false;
            }
            print "<tr>";
           
            print "<td>". $e->getd_name()  . "</td>";
            print "<td>". $e->getdate() . "</td>";
            print "<td>". $e->getpres()   . "</td>";
           print "</tr>";

        }

try
{
    $header=true;
    session_start();
    $id=$_SESSION["id"];
    // Connect to the database.
    include('connection.php');

    $query = "SELECT c.date,c.prescription,d.d_name from checkup_details c,doctor d where c.d_id=d.d_id and c.p_id=:pid;";

    $ps = $con->prepare($query);
    $ps->bindParam(":pid",$id);
    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "employee");

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
 * Time: 12:48 AM
 */
?>
    </div>
</div>
<?include('footer.html');?>