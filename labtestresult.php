    <?php
        function constructTable($data)
        {
            // We're going to construct an HTML table.
            print "    <table border='1'>\n";
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
    
        $d_name = filter_input(INPUT_POST, "d_name");
        $test_name = filter_input(INPUT_POST, "test_name");
		$Month = filter_input(INPUT_POST, "duration");
        echo $d_name;
        try {
            if (empty($d_name) || empty($test_name) || empty($Month)) {
                throw new Exception("Missing value.");
            }
                
            print "<h1>Analysis report of Lab Test Results are: </h1>\n";
        
            // Connect to the database.
            $con = new PDO("mysql:host=localhost;dbname=hospitalanalyticalrecent",
                           "root", "admin");
            $con->setAttribute(PDO::ATTR_ERRMODE,
                               PDO::ERRMODE_EXCEPTION);
                               
            $query = "select d.d_name as 'Doctor Name',l.test_name as 'Test Name', C.Month as 'Month',count(p.p_id)as no_of_patient, sum(lf.TestAmount) as total_amount
                      from patient p, labtestfacttable lf, Doctor d, Lab_Report l,
                      Calendar C where
                      p.p_key = lf.p_key and
                      l.test_key = lf.testkey and
                      d.doctor_key=lf.doctorkey and
                      C.CalendarKey =lf.lab_test_date_key and
                      d.d_name = :d_name and
                      l.test_name= :test_name  and
                      C.month = :Month;";
            
        $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':d_name' => $d_name,':test_name'=>$test_name, ':Month' =>$Month));
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
