<?include('adminCommon.html');?>
    <div class="content">
        <div class="page-header">
            <h2>Manage Department</h2>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="listdepartment.php">Department List</a></li>
                        <li><a href="adddepartment.php">Add Department</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="show-table">
<?php
ini_set('display_errors', 1);

class department
{
    private $dept_id;
    private $dept_name;
    private $no_of_doctors;
    private $dept_desc;

    public function getdeptid() {return $this->dept_id; }
    public function getdeptname() {return $this->dept_name; }
    public function gettotal() {return $this->no_of_doctors; }
    public function getdesc() {return $this->dept_desc; }

}

function createtablerow(department $de,& $header)
{
    if($header)
    {
        print "<table class='table table-bordered'>";
        print <<<here
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Total No. of Doctors</th>
    <th>Description</th>
    <th>Options</th>
    </tr>
here;
        $header=false;
    }
    $deid=$de->getdeptid();
    print "<tr>";
    print "<td>". $de->getdeptid()    . "</td>";
    print "<td>". $de->getdeptname()  . "</td>";
    print "<td>". $de->gettotal() . "</td>";
    print "<td>". $de->getdesc()   . "</td>";
    print "<td>&emsp;<a href=updatedepartment.php?deid=$deid><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a href=deletedepartment.php?deid=$deid><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
    print "</tr>";

}

try
{
    $header=true;

    // Connect to the database.
    include('connection.php');

    $query = "SELECT * FROM department;";

    $ps = $con->prepare($query);

    // Fetch the matching row.
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "department");

    // $data is an array.
    if ($ps->rowCount() > 0)
    {
        // Construct the HTML table row by row.
        while ($department  = $ps->fetch())
        {
            createtablerow($department,$header);
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
 * Date: 11/30/15
 * Time: 1:32 AM
 */
?>
        </div>
    </div>
<?include('footer.html');?>