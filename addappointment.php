<?php include('patientcommon.html'); ?>
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

<html>
<body>
    <form action="" method="post">

        <div class="control-group">


            <div class="controls">
                <p>
                    <b>Doctor Name: </b>
                    <select name="did"> 
                        <option>Select a doctor</option>
                        <?php
                        try
                        {
                            include('connection.php');

                            $query = "select * from doctor";
                        if(!(is_null($_POST["did"])))
                            {
                                $did=$_POST["did"];
                                $query = "select * from doctor where d_id=$did";
                            }
                            $ps = $con->prepare($query);

// Fetch the matching row.
                            $ps->execute();
                            $data = $ps->fetchAll();
                            if(!(is_null($_POST["did"])))
            {
                 foreach ($data as $row){
               print "<option value = '".$row['d_id']."' selected>".$row['d_name']."</option>";}
            }
            else{
                            foreach ($data as $row) {
                                print "<option value = '".$row['d_id']."'>".$row['d_name']."</option>";
                            }
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
                <label class="control-label" for="date1">Date: </label>
                 <input name='date' type='date' placeholder='Enter date: ' value='' required=''>

            </div>

                <div class="control-group">
                    <label class="control-label" for="date">Date: </label>
                   
                        <input name="date" type="date" placeholder="Enter date: " value="yyyy-mm-dd" required>


            <div >
                <label class="control-label" for="submit"></label>
                <div >
                    <button id="submit" name="search" class="btn btn-primary">Search Appointment</button>
                </div>
            </div>
        </form>

        
        <form action="" method="post">
             <label class="control-label" for="Time">Time</label>
                
                    <select name="time">
                        <?php
                        session_start();
                        try
                        {  
                            if(isset($_POST["search"]))
                            {

                                include('connection.php');
                                $did=filter_input(INPUT_POST,"did");
                                $date=filter_input(INPUT_POST,"date");
                              
                                $_SESSION["did"]=$did;
                                $_SESSION["date"]=$date;
                                $query="select time from appt_slot b where b.time not in (select distinct appt_slot.time from appointment ,appt_slot where appointment.slotid=appt_slot.slotid and appointment.d_id=:did and appointment.date = :date);";
                                $ps=$con->prepare($query);
                               
                                $ps->execute(array(':did' => $did,':date' => $date));
                                $data = $ps->fetchAll();
                                foreach ($data as $row)
                                {
                                    print "<option value = '".$row['time']."'>".$row['time']."</option>";
                                }

                            }
                        }
                        catch(Exception $ex)   {
                            echo $ex->getMessage();
                        }
                        print "</select>";


                        ?>
                  
                  
                     <div class="control-group">
=======
                        <p>
                        Time :
                        <input id="time" name="time" type="time" placeholder="Enter time: " class=" form-control" value = "hh:mm:ss" required>
                        </p>
               
                <div class="control-group">
>>>>>>> 9661c9af9013c5c5d11cb2311bf321f7fb9a26c6
                    <label class="control-label" for="reason">Reason</label>
                    <div class="controls">
                        <input id="reason" name="reason" type="text" placeholder="Enter Reason" class=" form-control" required>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="submit"></label>
                    <div class="controls">
                        <button id="submit" name="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>

<?php

//Insert into database after form is submitted
ini_set('display_errors', 1);

if(isset($_POST['submit'])) {

    $d_id = $_SESSION["did"];
    $date = $_SESSION["date"];
    $time = filter_input(INPUT_POST, "time");
    $reason = filter_input(INPUT_POST, "reason");
    $p_id=$_SESSION["id"];

    try {

// Connect to the database.
        include('connection.php');

       $query1="select slotid from appt_slot where time = :time";
       $ps1=$con->prepare($query1);
       $ps1->execute(array(':time' => $time));
       $ps1->bindColumn(1, $slot);
 
    $ps1->fetch(PDO::FETCH_BOUND);

        $query = "INSERT INTO appointment (p_id, appt_reason, date, time, d_id, r_id, slotid)
        VALUES (:pid, :reason, :date, :time, :did, null,:slotid)";

        $ps = $con->prepare($query);
        $ps->execute(array(':pid' => $p_id, ':reason' => $reason, ':date' => $date, ':time' => $time, ':did' => $d_id, 'slotid' => $slot));

// echo $name, $email, $address, $gender, $dob, $weight, $id, $password;
        print "<div style=\"text-align: center;\"><h3>Appointment is scheduled.</h3></div>\n";
    } catch (PDOException $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    } catch (Exception $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    }
}

?>


</body>
</html>
