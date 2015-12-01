<?php
include('pharmacommon.html');

?>
<html>
<body>
<fieldset>
<legend>Medicine Details</legend>
<form  action="" method="post">
<p>
Medicine Id:
<input type="text" name = "medid" />
</p>
<p>
Medicine Name:
<input type="text" name = "name" />
</p>
<p>
Medicine Type:
<input type="text" name = "type" />
</p>
<p>
Supplier Id:
<input type="text" name = "supid" />
</p>
<p>
Date:
<input type="text" name="date" />
</p>
<p>
Quantity:
<input type="text" name="qty" />
</p>
<p>
<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Save">
</p>
</form>
<?php
if (isset($_POST['Submit1']))
{
 			$name = filter_input(INPUT_POST, "name");
            $medid = filter_input(INPUT_POST, "medid");
            $type = filter_input(INPUT_POST, "type");
            $supid = filter_input(INPUT_POST, "supid");
            $date = filter_input(INPUT_POST, "date");
            $qty= filter_input(INPUT_POST, "qty");
            try {

                // Connect to the database.
                include('connection.php');

                $query = "INSERT INTO medicine VALUES (:id, :name, :type, :supid, :date, :qty)";

                $ps = $con->prepare($query);
                $ps->execute(array(':id' => $medid, ':name' => $name, ':type' => $type, ':supid' => $supid, ':date' => $date, ':qty' => $qty));

                // echo $name, $email, $address, $gender, $dob, $weight, $id, $password;
                print "<div style=\"text-align: center;\"><h3>$name was Successfully Inserted</h3></div>\n";
            } catch (PDOException $ex) {
                echo 'ERROR: ' . $ex->getMessage();
            } catch (Exception $ex) {
                echo 'ERROR: ' . $ex->getMessage();
            }
        }
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/15/15
 * Time: 1:21 AM
 */
?>
</fieldset>
<fieldset>
<legend>Particular Medicine Id: </legend>
<form action = "" method = "post">
Medicine Id: <input type = "text" name="medid" />
<input type="Submit" Name="Search" value="submit" />
</form>
<?php
if(isset($_POST["Search"]) && !empty($_POST["medid"]))
{
	echo "Searching";
}
else if(isset($_POST["Search"]) && empty($_POST["medid"]))
{
	echo "Input is empty!";
}
?>
</fieldset>

<fieldset>
<legend>View All Medicines</legend>
<form acion="" method = "post">
<input type="Submit" name="Refresh" value="Refresh" />
</form>
<?php
if(isset($_POST["Refresh"]))
{
	 

            try {

                // Connect to the database.
                include('connection.php');

                $query = "Select * from medicine";

                $ps = $con->prepare($query);
                $ps->execute();
                $ps->setFetchMode(PDO::FETCH_ASSOC);
                if (count($ps) > 0) {
    // output data of each row
    while($row = $ps->fetch()) {
    	echo "<table border = '1'>";
        echo "<tr><td> id: " . $row["medid"]. "</td><td> Name: " . $row["medname"]. "</td><td>Type: " . $row["medtype"]. "</td><td> SupplierId: " . $row["supid"] . "</td><td>Ordered date: " . $row["date"] .  "</td><td> Stock: " . $row["stock"] .  "</td></tr>";
        echo "</table>";
    }
	} 
	else {
    echo "0 results";
	}


                // echo $name, $email, $address, $gender, $dob, $weight, $id, $password;
              
            } catch (PDOException $ex) {
                echo 'ERROR: ' . $ex->getMessage();
            } catch (Exception $ex) {
                echo 'ERROR: ' . $ex->getMessage();
            }
        }
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/15/15
 * Time: 1:21 AM
 */

?>
</fieldset>

</body>
</html>





