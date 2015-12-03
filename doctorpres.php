<?php
include('doctorcommon.html');
?>
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
<legend>Medicine Details</legend>
<form  action="" method="post">
<p>
Pid:
<input type="text" name = "pid" />
</p>
<p>
Date:
<input type="date" name="date" />
</p>
<p>
Description:
 <textarea rows="4" cols="50" name="desc">

</textarea> 
</p>

<p>
<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Save">
</p>
</form>

<?php
ini_set('display_errors', 1);
session_start();
$did=$_SESSION["did"];

if(isset($_POST['Submit1'])) {
    $pid = filter_input(INPUT_POST, "pid");
    $desc = filter_input(INPUT_POST, "desc");
   
    $date = filter_input(INPUT_POST, "date");
   

    try {

        // Connect to the database.
        include('connection.php');

        $query = "INSERT INTO `checkup_details` ( `date`, `p_id`, `prescription`, `d_id`) VALUES (:date,:pid,:pres,:did);";

        $ps = $con->prepare($query);
        $ps->execute(array(':date' => $date, ':pid' => $pid, ':pres' => $desc, ':did' => $did));

      
        // echo $name, $email, $address, $salary, $id, $emptype, $password;
        print "<div style=\"text-align: center;\"><h3>prescription given!</h3></div>\n";
    } catch (PDOException $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    } catch (Exception $ex) {
        echo 'ERROR: ' . $ex->getMessage();
    }
}

?>
