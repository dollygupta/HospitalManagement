<?php include('patientcommon.html'); ?>

<html>
<body>
<div class="content">
   <div class="page-header">
      <h2>Manage Appointments </h2>
    </div>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">View Appointment</a></li>
        <li><a href="addappointment.php">Add Appointment</a></li>
      </ul>
    </div>
  </div>
</nav>
</body>
</html>
<?php
        session_start();
        $id=$_SESSION["id"];
        function constructTable($data)
        {
            // We're going to construct an HTML table.
            print "    <table border='1'>\n";
            print "<col width=30>";
                 print "        <tr>\n";
                print "            <th>DOCTOR ID</th>\n";
                print "            <th>DOCTOR NAME</th>\n";
                print "            <th>APPOINTMENT REASON</th>\n";
                print "            <th>APPOINTMENT TIME</th>\n";
                print "            <th>APPOINTMENT DATE</th>\n";
                print "        </tr>\n";
           // Construct the HTML table row by row.
            $doHeader = true;
            foreach ($data as $row) {
                print "        <tr>\n";
                foreach ($row as $name => $value) {
                    print "            <td>$value</td>\n";
                }
                print "        </tr>\n";
            }
            
            print "    </table>\n";
        }
 
       
        
        try {
            if (empty($id) ) {
                throw new Exception("Missing input values. Please enter both fields.");
            }
                
           
        
            // Connect to the database.
           include('connection.php');
            $query = "select d.d_id,d.d_name,a.appt_reason,a.time,a.date from patient p, doctor d, appointment a where p.p_id=a.p_id and d.d_id=a.d_id and a.p_id= :id and a.date>=current_date()";
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':id' => $id));
            $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                        
            // $data is an array.
            if (count($data) > 0) {
                constructTable($data);
            }
            else {
                print "<h3>No Appointments made</h3>\n";
            }
        }
        catch(PDOException $ex) {
            echo 'ERROR: '.$ex->getMessage();
        }    
        catch(Exception $ex) {
            echo 'ERROR: '.$ex->getMessage();
        }
?>