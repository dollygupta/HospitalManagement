<?php include('pharmacommon.html'); ?>
<html>
<head>
  <script type="text/javascript">
//----------------------------------------------------------------
// SENDS SELECTED OPTION TO RETRIEVE DATA TO FILL TABLE.
function send_option () {
var sel = document.getElementById( "my_select" );
var txt = document.getElementById( "my_option" );
txt.value = sel.options[ sel.selectedIndex ].value;
var frm = document.getElementById( "my_form" );
frm.submit();
}
//----------------------------------------------------------------
    </script>
</head>
<body>

 <form action="" method="post" >
<p>
               Select a medicine
   
    <select id="my_select" onchange="send_option();">
      <option>Select a medicine: </option>
<?php
ini_set('display_errors', 1);
//----------------------------------------------------------------
// LIST FILLED FROM DATABASE (ALLEGEDLY).
 try
                    {
                            include('connection.php');
  $query = "select medname  from medicine";
 
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
            if(!(is_null($_POST["my_option"])))
            {
                $type=$_POST["my_option"];
                print "<option value = '".$type."' SELECTED>".$type."</option>";
            }
           
            foreach ($data as $row) {
              print "<option value = '".$row['medname']."'>".$row['medname']."</option>";
            }
            print "</select>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }
//----------------------------------------------------------------
?>
    
</p>
</form>

 <p>
       


<?php
//----------------------------------------------------------------
// TABLE FILLED FROM DATABASE ACCORDING TO SELECTED OPTION.
if ( IsSet( $_POST["my_option"] ) ) // IF USER SELECTED ANY OPTION.
{
      try
                            {
                            include('connection.php');
   print "<form action='' method='post'>";
  $medname= $_POST["my_option"];
  $query = "select medtype,price from medicine where medname = :name";
 
            $ps = $con->prepare($query);
            $ps->bindParam(':name', $_POST["my_option"]);

            // Fetch the matching row.
            $ps->execute();

            $data = $ps->fetchAll();
            foreach ($data as $row) {
            	print "<input type='hidden' value='".$medname." ' name='medname'/>";
              print "Med Type: <input type='text' value= '".$row['medtype']."' readonly/><BR />";
               print "Price: <input type='text' value= '".$row['price']."' name= 'price' readonly/><BR />";
            }
           print "<p>Patient ID:<input type='text' value='' name='pid' /></p>";
           print "<p>Quantity: <input type='text' value='' name='qty' /></p>";
            print "<p>Transaction ID:<input type='text' value='' name='tid' /></p>";
           print "<input type='submit' value='Calculate' name='calculate' />";
            print "</form>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }

}

//----------------------------------------------------------------
?>

</p>

<p>
<?php
//----------------------------------------------------------------
// TABLE FILLED FROM DATABASE ACCORDING TO SELECTED OPTION.
if ( IsSet( $_POST["calculate"] ) ) // IF USER SELECTED ANY OPTION.
{
      try
                            {
                            include('connection.php');
   
   $pid=filter_input(INPUT_POST,"pid");
   $price=filter_input(INPUT_POST, "price");
   $qty=filter_input(INPUT_POST,"qty");
   $tid=filter_input(INPUT_POST, "tid");
   $medname=filter_input(INPUT_POST, "medname");

$query="select stock from medicine where medname='$medname'";
     $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $ps->bindColumn(1, $stock);
            $ps->fetch(PDO::FETCH_BOUND);

            if($stock < $qty)
            {
            	print "There is no stock! Place an order";
            }

            else
{
   $query="INSERT into medcinebill VALUES($tid,$pid,now(),$price*$qty)";
     $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();

print "Successfully Inserted";
  $query="update  medicine set stock=stock-$qty where medname= :name";

     $ps = $con->prepare($query);
     $ps->bindParam(':name', $medname);

            // Fetch the matching row.
            $ps->execute();

    
            print "Updated Stock!";

}
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }

}

?>

</p>

          <form method="post" style ="display:none" action""  id="my_form">
      <input type="text" id="my_option" name="my_option"/>
    </form>



</body>
</html>