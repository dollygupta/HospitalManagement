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

    
        $d_name = $_GET["d_name"];
        $test_name = $_GET["test_name"];
		$duration = $_GET["duration"];
        try {
            if (empty($d_name) || empty($test_name) || empty($duration)) {
                throw new Exception("Missing value.");
            }
                
            print "<h3>Analysis report of Lab Test Results are: </h3>\n";
        
            // Connect to the database.
            include('connectionAnalytics.php');
            
            if($duration=="year"){
                 $query = "select d.d_name as 'Doctor Name',l.test_name as 'Test Name', C.Year as 'Year',count(p.p_id)as no_of_patient, sum(lf.TestAmount) as total_amount
                      from patient p, labtestfacttable lf, Doctor d, Lab_Report l,
                      Calendar C where
                      p.p_key = lf.p_key and
                      l.test_key = lf.testkey and
                      d.doctor_key=lf.doctorkey and
                      C.CalendarKey =lf.lab_test_date_key and
                      d.d_name LIKE :d_name and
                      l.test_name LIKE :test_name 
                      group by C.Year, d.d_name, l.test_name;";

            }
            else if($duration=="quarter"){
                 $query = "select d.d_name as 'Doctor Name',l.test_name as 'Test Name', C.Quarter as 'Quarter',count(p.p_id)as no_of_patient, sum(lf.TestAmount) as total_amount
                      from patient p, labtestfacttable lf, Doctor d, Lab_Report l,
                      Calendar C where
                      p.p_key = lf.p_key and
                      l.test_key = lf.testkey and
                      d.doctor_key=lf.doctorkey and
                      C.CalendarKey =lf.lab_test_date_key and
                      d.d_name LIKE :d_name and
                      l.test_name LIKE :test_name 
                      group by C.Quarter, d.d_name, l.test_name;";

            }
            else if($duration=="month"){
                 $query = "select d.d_name as 'Doctor Name',l.test_name as 'Test Name', C.Month as 'Month',count(p.p_id)as no_of_patient, sum(lf.TestAmount) as total_amount
                      from patient p, labtestfacttable lf, Doctor d, Lab_Report l,
                      Calendar C where
                      p.p_key = lf.p_key and
                      l.test_key = lf.testkey and
                      d.doctor_key=lf.doctorkey and
                      C.CalendarKey =lf.lab_test_date_key and
                      d.d_name LIKE :d_name and
                      l.test_name LIKE :test_name 
                      group by C.Month, d.d_name, l.test_name;";

            }
            else{
                 $query = "select d.d_name as 'Doctor Name',l.test_name as 'Test Name', C.Date as 'Date',count(p.p_id)as no_of_patient, sum(lf.TestAmount) as total_amount
                      from patient p, labtestfacttable lf, Doctor d, Lab_Report l,
                      Calendar C where
                      p.p_key = lf.p_key and
                      l.test_key = lf.testkey and
                      d.doctor_key=lf.doctorkey and
                      C.CalendarKey =lf.lab_test_date_key and
                      d.d_name LIKE :d_name and
                      l.test_name LIKE :test_name
                      group by C.Date, d.d_name, l.test_name;";
            }                   
           
            
        $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':d_name' => $d_name,':test_name'=>$test_name));
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
