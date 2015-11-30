<html>
  <head>
    <title>My list</title>
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

    Select a room type
    <br/>
    <select id="my_select" onchange="send_option();">
      <option>Select an option</option>
<?php
ini_set('display_errors', 1);
//----------------------------------------------------------------
// LIST FILLED FROM DATABASE (ALLEGEDLY).
 try
                            {
                            include('connection.php');
  $query = "select DISTINCT type from room";
 
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
            foreach ($data as $row) {
              print "<option value = '".$row['type']."'>".$row['type']."</option>";
            }
            print "</select>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }
//----------------------------------------------------------------
?>
    
    <br/> 
    <br/>
    <table>
      <select name = "room_type">

<?php
//----------------------------------------------------------------
// TABLE FILLED FROM DATABASE ACCORDING TO SELECTED OPTION.
if ( IsSet( $_POST["my_option"] ) ) // IF USER SELECTED ANY OPTION.
{
      try
                            {
                            include('connection.php');
  $query = "select * from room where type = :type and status in( 'empty','Empty')";
 
            $ps = $con->prepare($query);
            $ps->bindParam(':type', $_POST["my_option"]);

            // Fetch the matching row.
            $ps->execute();

            $data = $ps->fetchAll();
            foreach ($data as $row) {
              print "<option value = '".$row['room_id']."'>".$row['room_id']."</option>";
            }
            print "</select>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }

}

//----------------------------------------------------------------
?>
</select>
    </table>

<!-- FORM TO SEND THE SELECTED OPTION. -->
    <form method="post" style ="display:none" action""  id="my_form">
      <input type="text" id="my_option" name="my_option"/>
    </form>

  </body>
</html>