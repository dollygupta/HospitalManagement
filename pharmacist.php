<?php
include('pharmacommon.html');

?>
<html>
<head>
 <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script> 
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
$.webshims.formcfg = {
en: {
    dFormat: '-',
    dateSigns: '-',
    patterns: {
        d: "yy-mm-dd"
    }
}
};
$(document).ready(function(){
    $('.button').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'ajax.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            alert("action performed successfully");
        });
    });

});
</script>
</head>

<body>
<fieldset>
<legend>Medicine Details</legend>
<form  action="" method="post">
<p>
Medicine Name:
<input type="text" name = "name" />
</p>
<p>
Medicine Type:
<input type="text" name = "type" />
</p>
<p>
Supplier Name:
<select name="supid"> 
<?php
try
                    {
                            include('connection.php');
  $query = "select *  from supplier";
 
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
           
            foreach ($data as $row) {
              print "<option value = '".$row['supplierID']."'>".$row['FirstName']."</option>";
            }
            print "</select>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }
    ?>

</p>
<p>
Date:
<input type="date" name="date" />
</p>
<p>
Price:
<input type="text" name="price" />
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
            $price = filter_input(INPUT_POST, "price");
            $qty= filter_input(INPUT_POST, "qty");
            try {

                // Connect to the database.
                include('connection.php');

                $query = "INSERT INTO medicine(medname,medtype,supid,date,price,stock) VALUES (:name, :type, :supid, :date1, :price, :qty)";

                $ps = $con->prepare($query);
                $ps->execute(array(':name' => $name, ':type' => $type, ':supid' => $supid, ':date1' => $date, ':price' => $price,':qty' => $qty));

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
<p>
Medicine Name:
<select name="medname"> 
<?php
try
                    {
                            include('connection.php');
  $query = "select *  from medicine";
 
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
           
            foreach ($data as $row) {
              print "<option value = '".$row['medname']."'>".$row['medname']."</option>";
            }
            print "</select>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }
    ?>

</p>
<input type="Submit" Name="Search" value="Search" />
</form>
<?php
if(isset($_POST["Search"]) && !empty($_POST["medname"]))
{
	
   try {

                // Connect to the database.
                include('connection.php');
                $name=$_POST["medname"];
                $query = "Select * from medicine where medname = :name";

                $ps = $con->prepare($query);
                $ps->bindParam(':name',$name);
                $ps->execute();
                $ps->setFetchMode(PDO::FETCH_ASSOC);
                if (count($ps) > 0) {
    // output data of each row
                     print "<table class='table table-bordered'>";
                     print "<th>Medicine Id:</th>";
                      print "<th>Medicine Name: </th>";
                       print "<th>Medicine Type: </th>";
                        print "<th>SupplierId: </th>";
                         print "<th>Ordered date: </th>";
                          print "<th> Stock:  </th>";
    while($row = $ps->fetch()) {
       


        print "<tr><td>  " . $row["medid"]. "</td>";
        print "<td>  " . $row["medname"]. "</td>";
        print "<td> " . $row["medtype"]. "</td>";
        print "<td> " . $row["supid"] . "</td>";
        print "<td> " . $row["date"] .  "</td>";
        print "<td>" . $row["stock"] .  "</td></tr>";
        
    }
    print "</table>";
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
        print "<table class='table table-bordered'>";
                     print "<th>Medicine Id:</th>";
                      print "<th>Medicine Name: </th>";
                       print "<th>Medicine Type: </th>";
                        print "<th>SupplierId: </th>";
                         print "<th>Ordered date: </th>";
                          print "<th> Stock:  </th>";
    while($row = $ps->fetch()) {
       


        print "<tr><td>  " . $row["medid"]. "</td>";
        print "<td>  " . $row["medname"]. "</td>";
        print "<td> " . $row["medtype"]. "</td>";
        print "<td> " . $row["supid"] . "</td>";
        print "<td> " . $row["date"] .  "</td>";
        print "<td>" . $row["stock"] .  "</td></tr>";
        
    }
    print "</table>";
}else {
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





