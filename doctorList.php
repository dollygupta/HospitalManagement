<?php include('adminCommon.html');?>
<div class="content">
   <div class="page-header">
      <h2>Manage Doctor</h2>
    </div>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="http://localhost/HospitalManagement/doctorList.php">Doctor List</a></li>
        <li><a href="http://localhost/HospitalManagement/adddoctor.php">Add Doctor</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="show-table">
<?php
ini_set('display_errors', 1);
 #Full texts   d_id  d_d_name  d_phone   dept_id   doctor_fees   emailid   password  salary Address
class doctor_list
{
  private $d_id;
  private $d_name;
  private $d_phone;
  private $dept_id;
  private $doctor_fees;
  private $emailid;
  private $password;
  private $salary;
  private $Address;

  public function getd_id() {return $this->d_id; }
  public function getd_phone() {return $this->d_phone; }
  public function getdept_id(){return $this->dept_id;}
  public function getAddress() {return $this->Address; }
  public function getd_name() {return $this->d_name; }
  public function getemailid() {return $this->emailid; }
  public function getpassword() {return $this->password; }
  public function getsalary() {return $this->salary; }
  public function getdoctor_fees() {return $this->doctor_fees; }
}

function createtablerow(doctor_list $h,& $header)
{
  if($header)
  {
    print <<<here
    <tr> 
    <th>Doctor Id</th>
    <th>Address</th>
    <th>Full d_name</th>
    <th>Deptartment Name</th>
    <th>Phone</th>
    <th>emailid Address</th>
    <th>Password</th>
    <th>salary</th>
    <th>Doctor Fees</th>
    <th>Option</th>
    </tr>
here;
    $header=false;
  }
  $d_id = $h->getd_id();
  print "<tr>";
  print "<td>". $h->getd_id() . "</td>";
  print "<td>". $h->getAddress() . "</td>";
  print "<td>". $h->getd_name() . "</td>";
   include('connection.php');

    $deptfetch = "select * from department where dept_id = :dept_id";

    $ps = $con->prepare($deptfetch);
    $ps->bindParam(":dept_id",$h->getdept_id());

    // Fetch the matching row.
    $ps->execute();
    $data = $ps->fetchAll();

    foreach ($data as $row) {
        print "<td>".$row['dept_name']."</td>";
    }
    print "<td>". $h->getd_phone() . "</td>";
  print "<td>". $h->getemailid() . "</td>";
   print "<td>". $h->getpassword() . "</td>";
  
  print "<td>". $h->getsalary(). "</td>";
  print "<td>". $h->getdoctor_fees(). "</td>";
  print "<td><a href=doctor_update.php?did=$d_id><img src='update.jpeg'  /></a><a href=doctor_delete.php?did=$d_id><img src = 'delete.jpeg'  /></a></td>" ;
 // print "<td>". "<a href=hos_labreport.php?inpid=$inpid>Lab Report for Inpatient with ID $inpid</a>". "</td>";


  print "</tr>";
}
    
try
{
  $header=true;

  print "<h2>List of Current doctors:</h2>\n";

  include('connection.php'); 
  $query = "SELECT * from doctor;";
  
  
  $ps = $con->prepare($query);

  // Fetch the matching row.
  $ps->execute();
  $ps->setFetchMode(PDO::FETCH_CLASS, "doctor_list");

  // $data is an array.
  if ($ps->rowCount() > 0) 
  {
  // Construct the HTML table row by row.
     print "<table class='table table-bordered'>";
    while ($doctor_list  = $ps->fetch())
    {
      print "        <tr>\n";
      createtablerow($doctor_list,$header);
      print "        </tr>\n";
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
?>
</div>
</div>
<?include('footer.html');?>
