<?include('adminCommon.html');?>
<div class="content">
    <div class="page-header">
        <h2>Manage Laboratorist</h2>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="listlaboratorist.php">Laboratorist List</a></li>
                    <li><a href="addlaboratorist.php">Add Laboratorist</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="show-table">
        <?php
ini_set('display_errors', 1);

include('classemployee.php');

        function createtablerow(employee $e,& $header)
        {
            if($header)
            {
                print "<table class='table table-bordered'>";
                print <<<here
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Street Address</th>
    <th>Email Address</th>
    <th>Salary</th>
    <th>Options</th>
    </tr>
here;
                $header=false;
            }
            $eid=$e->gete_id();
            print "<tr>";
            print "<td>". $e->gete_id()    . "</td>";
            print "<td>". $e->gete_name()  . "</td>";
            print "<td>". $e->getaddress() . "</td>";
            print "<td>". $e->getemail()   . "</td>";
            print "<td>". $e->getsalary()  . "</td>";
            print "<td>&emsp;<a class=\"btn btn-default btn-sm\" href=updatelaboratorist.php?eid=$eid><span class=\"glyphicon glyphicon-edit\" ></span></a>&emsp;<a class=\"btn btn-default btn-sm\" href=deletelaboratorist.php?eid=$eid><span class=\"glyphicon glyphicon-remove\" ></span></a></td>" ;
            print "</tr>";

        }

try
{
    $header=true;

    // Connect to the database.
    include('connection.php');

    $query = "SELECT * FROM employee e where e.type='Laboratorist';";

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
 * Date: 11/15/15
 * Time: 12:55 AM
 */
?>
    </div>
</div>
<?include('footer.html');?>