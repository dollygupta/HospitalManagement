<html>
<head>

<script type="text/javascript">
//----------------------------------------------------------------
// SENDS SELECTED OPTION TO RETRIEVE DATA TO FILL TABLE.
function send_option () {
var sel = document.getElementById( "my_select" );
var txt = document.getElementById( "my_optiondoc" );
txt.value = sel.options[ sel.selectedIndex ].value;
var frm = document.getElementById( "my_form" );
frm.submit();
}
//----------------------------------------------------------------
    </script>
</head>
<body>

 //Doctor List filled from database
<div class="control-group">
                    
<select id="my_select" onchange="send_option();">
                    <div class="controls">
                        <p>
                            <b>Doctor Name: </b>
                          <select name="did"> 
                            <?php
                            try
                            {
                            include('connection.php');
  $query = "select * from doctor";
 
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
            foreach ($data as $row) {
              print "<option value = '".$row['d_id']."'>".$row['d_name']."</option>";
            }
            print "</select>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }
                        ?>
                    </div>
                </p>
                </div>
//Form with doctor name to be submitted
  <form method="post" style ="display:none" action""  id="my_form">
      <input type="text" id="my_optiondoc" name="my_optiondoc"/>
    </form>

//After the doctor name is submitted, we need to select a date

<input type=date name="date" id="my_date" onclick=""/>



</body>
</html>