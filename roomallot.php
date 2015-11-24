<?php include('doctorcommon.html');?>
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
                        <input id="pid" name="pid" type="text" class=" form-control" required="">

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="date">Date of admission: </label>
                   
                        <input name="date" type="date" placeholder="Enter date: " value="yyyy-mm-dd" required="">

                   
                </div>

                <div class="control-group">
                    <label class="control-label" for="roomtype">RoomType: </label>
                    <div class="controls">
                        <select name="roomtype"> 
                            <?php
                            try
                            {
                            include('connection.php');
  $query = "select * from room";
 
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
                        ?>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Room No: ">Room No:</label>
                    <div class="controls">
                    	<select name="roomno">
                        <?php
                            try
                            {
                            include('connection.php');
  $query = "select * from room where status = 'empty' or status = 'Empty'";
 
            $ps = $con->prepare($query);

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
                        ?>

                    </div>
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
                    <label class="control-label" for="submit"></label>
                    <div class="controls">
                        <button id="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

        </form>

    </div>

<?include('footer.html');?>