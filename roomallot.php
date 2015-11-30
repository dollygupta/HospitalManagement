<?php include('doctorcommon.html');?>
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



    <div class="show-table">

<?php
ini_set('display_errors', 1);

if(isset($_POST['submit'])) {
    $pid = filter_input(INPUT_POST, "pid");
    $roomno = filter_input(INPUT_POST, "roomno");
    $nurseid = filter_input(INPUT_POST, "nurseid");
    $date = filter_input(INPUT_POST, "date");
   

    try {

        // Connect to the database.
        include('connection.php');

        $query = "INSERT INTO `inpatient` ( `date_admission`, `p_id`, `room_id`, `nurse_id`) VALUES (:date,:pid,:roomno,:nurseid);";

        $ps = $con->prepare($query);
        $ps->execute(array(':date' => $date, ':pid' => $pid, ':nurseid' => $nurseid, ':roomno' => $roomno));

         $query1 = "update room set status = 'full' where room_id = :roomno;";

        $ps1 = $con->prepare($query1);
        $ps1->execute(array(':roomno' => $roomno));

        // echo $name, $email, $address, $salary, $id, $emptype, $password;
        print "<div style=\"text-align: center;\"><h3>Room is Allotted</h3></div>\n";
    } catch (PDOException $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    } catch (Exception $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    }
}

?>
        <form action="" method="post" class="form-horizontal">


                <div class="control-group">
                    <label class="control-label" for="pid">Pid: </label>
                    <div class="controls">
                        <input id="pid" name="pid" type="text" class=" form-control" required>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="date">Date of admission: </label>
                   
                        <input name="date" type="date" placeholder="Enter date: " value="yyyy-mm-dd" required>


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
            if(!(is_null($_POST["my_option"])))
            {
                $type=$_POST["my_option"];
                print "<option value = '".$type."' SELECTED>".$type."</option>";
            }
           
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
        RoomNo:
      <select name = "roomno">

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
  
   <div class="control-group">
                    <label class="control-label" for="pid">Patient Name: </label>
                   <?php
                   session_start();
                   $id=$_SESSION["did"];
                   include('connection.php');
                 
        print "<p><td> <select name='pid'>   ";
        $query = "select a.p_id AS pid,p.p_name AS pname from appointment a,patient p where  a.p_id=p.p_id and d_id=:id";
       $ps = $con->prepare($query);
       $ps->bindParam(':id',$id);

        // Fetch the matching row.
        $ps->execute();
        $data = $ps->fetchAll();
        
        foreach ($data as $row) 
        {
        print "<option value = '".$row['pid']."'>".$row['pname']."</option>";
        }
        print "</select>";
                   ?>
                </div>

                <div class="control-group">
                    <label class="control-label" for="salary">Nurse Id: </label>
                    <div class="controls">
                        <select name="nurseid">
                        <?php
                            try
                            {
                            include('connection.php');
  $query = "select * from employee e where e.EID not in (select nurse_id from inpatient) and e.Type = 'Nurse'";
 
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
            foreach ($data as $row) {
              print "<option value = '".$row['EID']."'>".$row['Name']."</option>";
            }
            print "</select>";
        }
        catch(Exception $ex)   {
        echo $ex->getMessage();
    }
                        ?>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="date">Date of admission: </label>
                   
                        <input name="date" type="date" placeholder="Enter date: " value="yyyy-mm-dd" required="">

                   
                </div>

                <div class="control-group">
                    <label class="control-label" for="submit"></label>
                    <div class="controls">
                        <button id="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

        </form>
          <form method="post" style ="display:none" action""  id="my_form">
      <input type="text" id="my_option" name="my_option"/>
    </form>

    </div>

<?include('footer.html');?>