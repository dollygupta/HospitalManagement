<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>List all Nurses</title>
</head>

<body>
<?php
ini_set('display_errors', 1);

class employee
{
    private $EID;
    private $Address;
    private $Name;
    private $Email;
    private $Salary;
    private $type;


    public function gete_id() {return $this->EID; }
    public function getaddress() {return $this->Address; }
    public function gete_name() {return $this->Name; }
    public function getemail() {return $this->Email; }
    public function getsalary() {return $this->Salary; }
    public function gete_type() {return $this->type;}
}

function createtablerow(employee $e,& $header)
{
    if($header)
    {
    print "<table border ='1'>";
    print "<col width='150'>";
    print "<col width='250'>";
    print "<col width='150'>";
    print "<col width='300'>";
    print "<col width='150'>";
    print "<col width='150'>";
        print <<<here
    <tr>
    <th>Employee ID</th>
    <th>Address</th>
    <th>Employee Name</th>
    <th>Email</th>
    <th>Salary</th>
    <th>Employee Type</th>
    </tr>
here;
        $header=false;
    }
    print "<tr>";
    print "<td>". $e->gete_id()    . "</td>";
    print "<td>". $e->getaddress() . "</td>";
    print "<td>". $e->gete_name()  . "</td>";
    print "<td>". $e->getemail()   . "</td>";
    print "<td>". $e->getsalary()  . "</td>";
    print "<td>". $e->gete_type()  . "</td>";

    print "</tr>";

}

try
{
    $header=true;

    print "<h2>List of all Nurses</h2>\n";

    // Connect to the database.
    $con = new PDO("mysql:host=localhost;dbname=hos_m","root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM employee e where e.type='Nurse';";

    $ps = $con->prepare($query);

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
 * Date: 11/14/15
 * Time: 6:15 PM
 */
?>
</body>
</html>