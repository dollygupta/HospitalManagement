<?php
        function constructTable($data)
        {
            // We're going to construct an HTML table.
            print "    <table class='table table-bordered'>\n";
            $doHeader = true;
            foreach ($data as $row) {
                if ($doHeader) {
                    print "        <tr>\n";
                    foreach ($row as $name => $value) {
                        print "            <th>$name</th>\n";
                    }
                    print "        </tr>\n";
                    $doHeader = false;
                }

                print "        <tr>\n";
                foreach ($row as $name => $value) {
                    print "            <td>$value</td>\n";
                }
                print "        </tr>\n";
            }
            
            print "    </table>\n";
        }

    
        $dept_name = $_GET["dept_name"];
        $room_type = $_GET["room_type"];
		    $duration = $_GET["duration"];
        try {
            if (empty($dept_name) || empty($room_type) || empty($duration)) {
                throw new Exception("Missing value.");
            }
                
            print "<h3>Analysis report of Room Fact Results are: </h3>\n";
        
            // Connect to the database.
            include('connectionAnalytics.php');
            
            if($duration=="year"){
                $query = "select d.dept_name as 'Department Name', i.room_type as 'Room Type',C.Year as 'Year',count(i.inp_id)as no_of_patient, sum(lr.room_fees) as total_amount
                     from inpatient i, RoomResultsFactTable lr, department d, Calendar C where
                     i.inpatient_key = lr.inpatientkey and
                     d.dept_key=lr.department_key and
                     C.CalendarKey =lr.date_of_admissionkey and
                     d.dept_name LIKE :dept_name and i.room_type LIKE :room_type
                     group by C.Year, d.dept_name, i.room_type;";

            }
            else if($duration=="quarter"){
                 $query = "select d.dept_name as 'Department Name', i.room_type as 'Room Type',C.Quarter as 'Quarter',count(i.inp_id)as no_of_patient, sum(lr.room_fees) as total_amount
                     from inpatient i, RoomResultsFactTable lr, department d, Calendar C where
                     i.inpatient_key = lr.inpatientkey and
                     d.dept_key=lr.department_key and
                     C.CalendarKey =lr.date_of_admissionkey and
                     d.dept_name LIKE :dept_name and i.room_type LIKE :room_type
                     group by C.Quarter, d.dept_name, i.room_type;";

            }
            else if($duration=="month"){
                 $query = "select d.dept_name as 'Department Name', i.room_type as 'Room Type',C.Month as 'Month',count(i.inp_id)as no_of_patient, sum(lr.room_fees) as total_amount
                     from inpatient i, RoomResultsFactTable lr, department d, Calendar C where
                     i.inpatient_key = lr.inpatientkey and
                     d.dept_key=lr.department_key and
                     C.CalendarKey =lr.date_of_admissionkey and
                     d.dept_name LIKE :dept_name and i.room_type LIKE :room_type
                     group by C.Month, d.dept_name, i.room_type;";
            }
            else{
                $query = "select d.dept_name as 'Department Name', i.room_type as 'Room Type',C.Date as 'Date',count(i.inp_id)as no_of_patient, sum(lr.room_fees) as total_amount
                     from inpatient i, RoomResultsFactTable lr, department d, Calendar C where
                     i.inpatient_key = lr.inpatientkey and
                     d.dept_key=lr.department_key and
                     C.CalendarKey =lr.date_of_admissionkey and
                     d.dept_name LIKE :dept_name and i.room_type LIKE :room_type
                     group by C.Date, d.dept_name, i.room_type;";
            }                   
           
            
        $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':dept_name' => $dept_name,':room_type'=>$room_type));
            $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                        
            // $data is an array.
            if (count($data) > 0) {
                constructTable($data);
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
