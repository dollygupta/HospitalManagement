<!DOCdoctor_fees html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
</head>

<body>
<?php
include('adminCommon.html');
print '<BR><BR>';
ini_set('display_errors', 1);
$d_id = filter_input(INPUT_GET, "did");
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
/*  print "<table border ='1'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";
  print "<col width='150'>";

 

  if($header)
  {
    print <<<here
    <tr> 
    <th>Doctor Id</th>
    <th>Address</th>
    <th>Full d_name</th>
    <th>Dept_Id</th>
    <th>Phone</th>
    <th>emailid Address</th>
    <th>Password</th>
    <th>salary</th>
    <th>Doctor Fees</th>
   
    </tr>
here;
    $header=false;
  }
  $d_id = $h->getd_id();
  print "<tr>";
  print "<td>". $h->getd_id() . "</td>";
  print "<td>". $h->getAddress() . "</td>";
  print "<td>". $h->getd_name() . "</td>";
  print "<td>". $h->getdept_Id() . "</td>";
    print "<td>". $h->getd_phone() . "</td>";
  print "<td>". $h->getemailid() . "</td>";
   print "<td>". $h->getpassword() . "</td>";
  
  print "<td>". $h->getsalary(). "</td>";
  print "<td>". $h->getdoctor_fees(). "</td>";
 // print "<td>". "<a href=hos_labreport.php?inpid=$inpid>Lab Report for Inpatient with ID $inpid</a>". "</td>";


  print "</tr>";
  print "</table>";
*/
  include('connection.php');
print "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
  print "<p>Id: <input name='id' readonly='readonly' value='".$h->getd_id(). "'      size=15 readonly/></p>"; 
print "                                                      <tr>\n";
  print "<p>Name: <input name='name' value='".$h->getd_name(). "'      size=15/></p> "; 
 print "<p>Address: <td><input name='Address' value='".$h->getAddress(). "'      size=15/></p>"; 
 print "<p>dept_id: <td><input name='dept_id'  value='".$h->getdept_Id(). "'      size=15/></p>"; 
 print "<p>Department:<td> <select name='dept'>   ";
  $query = "select * from department";
  $result = "select dept_name from department where dept_id = $h->getdept_Id";
  $ps1=$con->prepare($result);
  
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
            foreach ($data as $row) {
              print "<option value = '".$row['dept_name']."'>".$row['dept_name']."</option>";
            }
            print "</select>";
       

 
 
print "<p>Phone: <input name='phone' value='".$h->getd_phone(). "'      size=15/></p>"; 
 print "<p>Email Id: <input name='emailid' value='".$h->getemailid(). "'      size=15/></p>"; 
print "<p>Password: <input name='password' value='".$h->getpassword(). "'      size=15/></p>"; 
print "<p>Salary: <input name='salary' value='".$h->getsalary(). "'      size=15/></p>"; 
print "<p>Doctor Fees: <input name='password' value='".$h->getdoctor_fees(). "'      size=15/></p>"; 

print "<p><input type=submit value='Update' /></p>";
print "</form>"; 
$header=false;

}

function constructTable($row,& $header)
{
  print "<table border='1'>";

  if($header)
  {
    print "<tr>";
    foreach ($row as $d_name => $value) {
      print "<th>$d_name</th>\n";
    }
    print "        </tr>\n";
    $header=false;                 
   }             
  print "</table>";    
}
    
try
{
  $header=true;

 
  // Connect to the database.
  #$con = new PDO("mysql:host=localhost;dbname=hospital","root", "admin");
  #$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
include('connection.php');
  $query = "SELECT * from doctor where d_id = :did;";
  
  if(isset($_POST["id"]))
  			{
  			$id= $_POST["id"];
  			$d_name=$_POST["name"];
  		$query = "UPDATE doctor SET d_name='$d_name' WHERE d_id=$id";
  		# This is the sql query for delete you should write the trigger code here 

  		#$query = "delete from doctor  WHERE d_id=$id";
  		$ps = $con->prepare($query);
  		$ps->execute();
  		echo "Successfully Updated";
  	}
  $ps = $con->prepare($query);

  // Fetch the matching row.
   $ps->bindParam(':did', $d_id);
  $ps->execute();
 	$ps->setFetchMode(PDO::FETCH_CLASS, "doctor_list");
	
  // $data is an array.
  if ($ps->rowCount() > 0) 
  {
  // Construct the HTML table row by row.
    while ($doctor_list  = $ps->fetch())
    {
      print "        <tr>\n";
  		createtablerow($doctor_list,$header);
  		
  		
  		
      print "        </tr>\n";
    }  
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
</body>
</html>
