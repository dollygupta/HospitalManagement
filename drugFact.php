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
		    $duration = $_GET["duration"];
        try {
            if (empty($dept_name) || empty($duration)) {
                throw new Exception("Missing value.");
            }
                
            print "<h3>Analysis report of Room Fact Results are: </h3>\n";
        
            // Connect to the database.
            include('connectionAnalytics.php');
            
            if($duration=="year"){
                $query = "select dp.dept_name as 'Department Name', d.drug_name AS 'Drug Name', do.no_of_drugs AS 'No Of Drugs',C.Year as 'Year' from drugs d, drug_orders_fact_table do,department dp,Calendar c where d.drug_key = do.drug_key and do.dept_key = dp.dept_key and do.date_order_key=c.CalendarKey  and dp.dept_name LIKE :dept_name
                    group by dp.dept_name, C.Year, d.drug_name;";

            }
            else if($duration=="quarter"){
                 $query = "select dp.dept_name as 'Department Name', d.drug_name AS 'Drug Name', do.no_of_drugs AS 'No Of Drugs', C.Quarter as 'Quarter' from drugs d, drug_orders_fact_table do,department dp,Calendar c where d.drug_key = do.drug_key and do.dept_key = dp.dept_key and do.date_order_key=c.CalendarKey  and dp.dept_name LIKE :dept_name
                    group by dp.dept_name, C.Quarter,d.drug_name;";

            }
            else if($duration=="month"){
                 $query = "select dp.dept_name as 'Department Name', d.drug_name AS 'Drug Name', do.no_of_drugs AS 'No Of Drugs',C.Month as 'Month' from drugs d, drug_orders_fact_table do,department dp,Calendar c where d.drug_key = do.drug_key and do.dept_key = dp.dept_key and do.date_order_key=c.CalendarKey  and dp.dept_name LIKE :dept_name
                    group by dp.dept_name, C.Month, d.drug_name;";
            }
            else{
                $query = "select dp.dept_name as 'Department Name', d.drug_name AS 'Drug Name', do.no_of_drugs AS 'No Of Drugs',C.Date as 'Date' from drugs d, drug_orders_fact_table do,department dp,Calendar c where d.drug_key = do.drug_key and do.dept_key = dp.dept_key and do.date_order_key=c.CalendarKey  and dp.dept_name LIKE :dept_name
                    group by dp.dept_name, C.Date, d.drug_name;";
            }                   
           
            
        $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':dept_name' => $dept_name));
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