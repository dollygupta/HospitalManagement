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

<form action="" method="post">
<p>
</p>
<p>
<label> Select Appointment Date: </label>
<input name="apptdate" type="date"  value="yyyy-mm-dd"/>
</p>
<p>
<input type = "submit" value = "Search" name="submit" />
</p>
</form>
<?php
include('connection.php');
if(isset($_POST["submit"]))
{
	function constructTable($data)
        {
            // We're going to construct an HTML table.
            print "    <table border='1'>\n";
           
                 print "        <tr>\n";
                print "            <th>Patient Name</th>\n";
                print "            <th> Reason</th>\n";
                print "            <th>time</th>\n";
                print "            <th>date</th>\n";
                print "            <th>Day Of the Week</th>\n";
                print "<th> Want to Cancel? </th> ";
                print "        </tr>\n";
           // Construct the HTML table row by row.
            $doHeader = true;
            foreach ($data as $row) {
                print "        <tr>\n";
                foreach ($row as $name => $value) {
                    print "            <td>$value</td>\n";
                }
                print "<td> Delete comes here!</td>";
                print "        </tr>\n";
            }
            
            print "    </table>\n";
        }
$date=filter_input(INPUT_POST, "apptdate");
session_start();
$did=$_SESSION["did"];
$query = "select p.p_name,a.appt_reason,a.time,a.date,dayname(a.date) from patient p, appointment a where p.p_id=a.p_id and a.d_id=:did and  a.date = :date ; ";
            $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':did' => $did,':date' => $date));
            $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                        
            // $data is an array.
            if (count($data) > 0) {
			 constructTable($data);
            }
            else {
                print "<h3>No Appointments made</h3>\n";
            }


}
?>

