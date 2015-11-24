<?php include('patientcommon.html')?>
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
<div class="content">
    <div class="page-header">
        <h2>Manage Appointment</h2>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="patientappointment.php">View Appointment</a></li>
                    <li class="active"><a href="addappointment.php">Add Appointment</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="show-table">

<?php
ini_set('display_errors', 1);




        if(isset($_POST['submit'])) {

            $d_id = filter_input(INPUT_POST, "did");
            $date = filter_input(INPUT_POST, "date");
            $time = filter_input(INPUT_POST, "time");
            $reason = filter_input(INPUT_POST, "reason");
             session_start();
             $p_id=$_SESSION["id"];

             echo $d_id ;
           
            try {

                // Connect to the database.
                include('connection.php');

                $query = "INSERT INTO appointment (p_id, appt_reason, date, time, d_id, r_id)
              VALUES (:pid, :reason, :date, :time, :did, null)";

                $ps = $con->prepare($query);
                $ps->execute(array(':pid' => $p_id, ':reason' => $reason, ':date' => $date, ':time' => $time, ':did' => $d_id));

                // echo $name, $email, $address, $gender, $dob, $weight, $id, $password;
                print "<div style=\"text-align: center;\"><h3>Appointment is scheduled.</h3></div>\n";
            } catch (PDOException $ex) {
                echo 'ERROR: ' . $ex->getMessage();
            } catch (Exception $ex) {
                echo 'ERROR: ' . $ex->getMessage();
            }
        }
//We need to first list the time and date that particular doctor has appointments and ask the patient to choose others.
?>

<html>
<body>
<form action="" method="post" class="form-horizontal">

                <div class="control-group">
                    

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

                <div class="control-group">
                    <label class="control-label" for="date">Date: </label>
                   
                        <input name="date" type="date" placeholder="Enter date: " value="yyyy-mm-dd" required="">

                   
                </div>

                        <p>
                        Time :
                        <input id="time" name="time" type="time" placeholder="Enter time: " class=" form-control" value = "hh:mm:ss" required="">
                        </p>
               
                <div class="control-group">
                    <label class="control-label" for="reason">Reason</label>
                    <div class="controls">
                        <input id="reason" name="reason" type="text" placeholder="Enter Reason" class=" form-control" required="">

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="submit"></label>
                    <div class="controls">
                        <button id="submit" name="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>

        </form>

</div>
</div>

</body>
</html>
