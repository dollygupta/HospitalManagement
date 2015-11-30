<?php include('patientcommon.html');?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
   
</head>

<body>
<?php
ini_set('display_errors', 1);

class inpatient_list
{
  private $inpatient_id;
  private $p_id;
  private $date_admission;
  private $room_id;
  private $name;
  private $p_name;
  private $d_name;

  public function getinpatient_id() {return $this->inpatient_id; }
  public function getp_id() {return $this->p_id; }
  public function getdate_admission() {return $this->date_admission; }
  public function getroom_id() {return $this->room_id; }
  public function getnurse_name() {return $this->name; }
  public function getp_name() {return $this->p_name; }
  public function getd_name() {return $this->d_name; }
}

function createtablerow(inpatient_list $h,& $header)
{
  print "<table border ='1'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";

  if($header)
  {
    print <<<here
    <tr> 
    <th>InPatient_ID</th>
    <th>Patient_ID</th>
    <th>Date_of_Admission</th>
    <th>Room_No</th>
    <th>Nurse_Name</th>
    </tr>
here;
    $header=false;
  }
  $inpid = $h->getinpatient_id();
  print "<tr>";
  print "<td>". $h->getinpatient_id() . "</td>";
  print "<td>". $h->getp_id() . "</td>";
  print "<td>". $h->getdate_admission() . "</td>";
  print "<td>". $h->getroom_id() . "</td>";
  print "<td>". $h->getnurse_name() . "</td>";
  print "<td>". $h->getd_name(). "</td>";
    print "</tr>";
  print "</table>";
}

function constructTable($row,& $header)
{
  print "<table border='1'>";

  if($header)
  {
    print "<tr>";
    foreach ($row as $name => $value) {
      print "<th>$name</th>\n";
    }
    print "        </tr>\n";
    $header=false;                 
   }             
  print "</table>";    
}
    
try
{
  $header=true;

session_start();
$id=$_SESSION["id"];

  // Connect to the database.
 include('connection.php');

  $query = "SELECT i.inpatient_id ,p.p_id , i.date_admission, r.room_id , e.name FROM inpatient i,patient p,room r,employee e WHERE i.p_id=p.p_id AND r.room_id=i.room_id AND e.eid=i.nurse_id AND i.date_discharge is NULL and p.p_id = :pid";
  
  $ps = $con->prepare($query);
 $ps->bindParam(':pid', $id);
  // Fetch the matching row.
  $ps->execute();
 	$ps->setFetchMode(PDO::FETCH_CLASS, "inpatient_list");

  // $data is an array.
  if ($ps->rowCount() > 0) 
  {
  // Construct the HTML table row by row.
    while ($inpatient_list  = $ps->fetch())
    {
      print "        <tr>\n";
  		createtablerow($inpatient_list,$header);
      print "        </tr>\n";
    }  
  }  
  else {
  print "<h3>You were never admitted!</h3>\n";
  }
}

catch(PDOException $ex) {
  echo 'ERROR: '.$ex->getMessage();
}

catch(Exception $ex) {
  echo 'ERROR: '.$ex->getMessage();
}
?>
</body>
</html>
