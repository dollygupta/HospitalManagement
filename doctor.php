<?php include('doctorcommon.html');?>
<div class="content">
    <h2>Doctor Dashboard</h2>

    <?php 

include('connection.php');


  function constructTable($data)
        {
            // We're going to construct an HTML table.
            print "    <table border='1'>\n";
           
                 print "        <tr>\n";
                print "            <th>Patient Name</th>\n";
                print "            <th> Reason</th>\n";
                print "            <th>time</th>\n";
                print "            <th>date</th>\n";
                print "            <th>Day Of the Week</th>\n";
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
  $username = $_SESSION["username"];
  $sql1 = "select d_name,d_id from doctor where emailid= '$username'" ;
 

 $stmt1 = $con->prepare($sql1);
 #$stmt->execute(array(":id" => $id));
 $stmt1->execute();
 $stmt1->bindColumn(1, $name);
 $stmt1->bindColumn(2, $did);
 $stmt1->fetch(PDO::FETCH_BOUND);

 
 $_SESSION["did"]=$did;
    echo "<B>Hi $name </b> ";

  function selectBlob($id) {
 include('connection.php');
global $username;

  
/*$sql = "SELECT mime, data
 FROM files
 WHERE id = :id";*/

 $sql = "select profilepic from doctor where emailid= '$username'" ;
 

 $stmt = $con->prepare($sql);
 #$stmt->execute(array(":id" => $id));
 $stmt->execute();
 $stmt->bindColumn(1, $mime);
 #$stmt->bindColumn(2, $data, PDO::PARAM_LOB);
 $stmt->fetch(PDO::FETCH_BOUND);
 #header("Content-Type:" . jpg);
 #echo $mime;
 header("Content-Type : image/jpeg");
#echo $a['mime'];

echo '<img src="data:image/jpeg;base64,'.base64_encode(  $mime ).'"/>';
  return array("mime" => $mime);
 #return array("mime" => $mime,
      #"data" => $data);

 
 
}
selectBlob(1);
echo "<BR><BR><BR><BR>";
 echo "This Week's Appointments: <BR><BR>";

    $query = "select p.p_name,a.appt_reason,a.time,a.date,dayname(a.date) from patient p, appointment a where p.p_id=a.p_id and a.d_id= :id and  a.date >= current_date() and a.date<= current_date() + interval 7 day order by a.date; ";
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':id' => $did));
            $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                        
            // $data is an array.
            if (count($data) > 0) {
               constructTable($data);
            }
            else {
                print "<h3>No Appointments made</h3>\n";
            }


?>

</div>
<?php include('footer.html');?>
    