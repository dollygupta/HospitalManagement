<?php include('adminCommon.html');?>
<div class="content">
   <div class="page-header">
      <h2>Manage Laboratorist</h2>
    </div>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="http://localhost/HospitalManagement/Laboratorist_List.php">Laboratorist List</a></li>
        <li><a href="#">Add Laboratorist</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="show-table">
<?php
ini_set('display_errors', 1);

class laboratorist_list
{
  private $EID;
  private $Address;
  private $Name;
  private $Email;
  private $Salary;
  private $Type;

  public function getEID() {return $this->EID; }
  public function getAddress() {return $this->Address; }
  public function getName() {return $this->Name; }
  public function getEmail() {return $this->Email; }
  public function getSalary() {return $this->Salary; }
  public function getType() {return $this->Type; }
}

function createtablerow(laboratorist_list $h,& $header)
{

  if($header)
  {
    print <<<here
    <tr> 
    <th>Employee Id</th>
    <th>Address</th>
    <th>Full Name</th>
    <th>Email Address</th>
    <th>Salary</th>
    <th>Profile</th>
    </tr>
here;
    $header=false;
  }
  $eid = $h->getEID();
  print "<tr>";
  print "<td>". $h->getEID() . "</td>";
  print "<td>". $h->getAddress() . "</td>";
  print "<td>". $h->getName() . "</td>";
  print "<td>". $h->getEmail() . "</td>";
  print "<td>". $h->getSalary(). "</td>";
  print "<td>". $h->getType(). "</td>";
 // print "<td>". "<a href=hos_labreport.php?inpid=$inpid>Lab Report for Inpatient with ID $inpid</a>". "</td>";


  print "</tr>";
}


    
try
{
  $header=true;

  print "<h2>List of Current Laboratorists:</h2>\n";

  // Connect to the database.
  include('connection.php'); 
 

  $query = "SELECT e.EID, e.Address,e.Name,e.Email,e.Salary,e.Type from employee e where e.Type = 'Laboratorist';";
  
  
  $ps = $con->prepare($query);

  // Fetch the matching row.
  $ps->execute();
 	$ps->setFetchMode(PDO::FETCH_CLASS, "laboratorist_list");

  // $data is an array.
  if ($ps->rowCount() > 0) 
  {
  // Construct the HTML table row by row.
     print "<table class='table table-bordered'>";
    while ($laboratorist_list = $ps->fetch())
    {
      print "        <tr>\n";
  		createtablerow($laboratorist_list,$header);
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
<?php include('footer.html');?>
