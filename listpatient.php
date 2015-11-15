<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>List all Patients</title>
</head>

<body>
<?php
ini_set('display_errors', 1);

class patient
{
    private $p_dob;
    private $p_id;
    private $p_name;
    private $p_email;
    private $p_weight;
    private $p_address;
    private $p_gender;

    public function getdob() {return $this->p_dob; }
    public function getid() {return $this->p_id; }
    public function getname() {return $this->p_name; }
    public function getemail() {return $this->p_email; }
    public function getweight() {return $this->p_weight; }
    public function getaddress() {return $this->p_address;}
    public function getgender() {return $this->p_gender;}

}

function createtablerow(patient $p,& $header)
{
    if($header)
    {
        print "<table border ='1'>";
        print "<col width='150'>";
        print "<col width='150'>";
        print "<col width='300'>";
        print "<col width='250'>";
        print "<col width='150'>";
        print "<col width='150'>";
        print "<col width='150'>";
        print <<<here
    <tr>
    <th>Patient ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Address</th>
    <th>Gender</th>
    <th>Date of Birth</th>
    <th>Weight</th>
    </tr>
here;
        $header=false;
    }
    print "<tr>";
    print "<td>". $p->getid()      . "</td>";
    print "<td>". $p->getname()    . "</td>";
    print "<td>". $p->getemail()   . "</td>";
    print "<td>". $p->getaddress() . "</td>";
    print "<td>". $p->getgender()  . "</td>";
    print "<td>". $p->getdob()     . "</td>";
    print "<td>". $p->getweight()  . "</td>";
    print "</tr>";

}

try
{
    $header=true;

    print "<h2>List of all Patients</h2>\n";

    // Connect to the database.
    $con = new PDO("mysql:host=localhost;dbname=hos_m","root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM patient;";

    $ps = $con->prepare($query);

    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "patient");

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
 * Time: 1:07 AM
 */
?>
</body>
</html>