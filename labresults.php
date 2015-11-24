<?php include('patientcommon.html');?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Simple Id Query #2</title>
</head>

<body>
    <body>
    <form action=""
          method="get">
        <fieldset>
            <legend>Which Date?</legend>
            <p>
                <label for="p_id">Patient's id:</label>
                <label for="p_date">Lab Test Date:</label>
                <input name="p_date" type="date" />
                
            </p>
            
            <p>
                <input type="submit" value="Submit" />
            </p>
        </fieldset>
    </form>
</body>
    <?php
        function constructTable($data)
        {
            // We're going to construct an HTML table.
            print "    <table border='1'>\n";
                 print "        <tr>\n";
                print "            <th>REPORT ID</th>\n";
                print "            <th>DATE</th>\n";
                print "            <th>PATIENT ID</th>\n";
                print "            <th>PATIENT NAME</th>\n";
                print "            <th>RESULTS</th>\n";
                print "            <th>DOCTOR NAME</th>\n";
                print "            <th>LAB TECHNICIAN NAME</th>\n";
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
    session_start();
        $id = $_SESSION["id"];
       // $date = filter_input(INPUT_GET, "p_date");
        
        try {
            if (empty($id)) {
                throw new Exception("Missing input values. Both fields are mandatory");
            }
                
            //print "<h1>Patient with id $id with reports on $date</h1>\n";
        
            // Connect to the database.
           include('connection.php');
            
            $query = "SELECT l.lab_report_id,l.date,p.p_id, p.p_name, l.results,d.d_name,t.Name FROM lab_report l,patient p,doctor d,employee t WHERE l.d_id=d.d_id AND l.p_id=p.p_id AND l.t_id=t.EID AND l.p_id = :id ";
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':id' => $id));
            $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                        
            // $data is an array.
            if (count($data) > 0) {
                constructTable($data);
            }
            else {
                print "<h3>You have no lab reports.</h3>\n";
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
