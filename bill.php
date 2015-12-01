<?php include('patientcommon.html'); ?>
<html>
<body>
<?php
session_start();
$pid=$_SESSION["id"];
include('connection.php');
$query="select DATE,SUM(AMOUNT) AS TOTAL from medcinebill where P_ID=1 group by DATE";

 $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();

  $ps->setFetchMode(PDO::FETCH_ASSOC);
     if (count($ps) > 0) {
     	echo "<table border = '1'>";
     	echo "<th>Date </th><th>  Meicine Bill Amount</th>";
    // output data of each row
    while($row = $ps->fetch()) {
    	
        echo "<tr><td>  " . $row["DATE"]. "</td><td> " . $row["TOTAL"]. "</td></tr>";
        echo "</table>";
    }
	} 
	else {
    echo "No Bill Details Found";
	}


?>

</body>
</html>