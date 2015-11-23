<?include('adminCommon.html');?>
<div class="content">
    <div class="page-header">
        <h2>Monitor Hospital</h2>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="moniter1.php">Lab Test</a></li>
                    <li class=""><a href="">Rooms</a></li>
                     <li class=""><a href="">Drugs</a></li>

                </ul>
            </div>
        </div>
    </nav>

     <?php
      include('connectionAnalytics.php');
      $query1 = "SELECT d_name FROM doctor";
            $ps = $con->prepare($query1);
            $ps->execute();
            $data1 = $ps->fetchAll(PDO::FETCH_ASSOC);

        $query2 = "select distinct test_name from lab_report;";
            $ps = $con->prepare($query2);
            $ps->execute();
            $data2 = $ps->fetchAll(PDO::FETCH_ASSOC);
     print <<<here
     <form>
     Doctor Name:
here;
        echo '<select id="d_name" name="d_name">
        <option value="%">--</option>'; 
        foreach ($data1 as $row){
             foreach ($row as $name => $value){
                echo '<option value="'.$value.'">'.$value.'</option>';
             }
        }
        echo '</select>';
        echo 'Test Name';
        echo '<select id="test_name" name="test_name">
         <option value="%">--</option>'; 
        foreach ($data2 as $row){
             foreach ($row as $name => $value){
                echo '<option value="'.$value.'">'.$value.'</option>';
             }
        }
        echo '</select>';
        echo'Duration:  <select id="duration" name="duration">
        <option value="%">--</option>
        <option value="year">year</option>
        <option value="quarter">quarter</option>
        <option value="month">month</option>
        </select>';  
           echo '<input type="button" value="OK" onclick="sendtoTable()" />
        </form>';                  
    ?>  
     <div id="analysisTable"></div>
     </div>

</div>
<script type="text/javascript">
function sendtoTable(){
    var d_name=document.getElementById('d_name').value;
    var test_name=document.getElementById('test_name').value;
    var duration=document.getElementById('duration').value;
   sendAjax(d_name,test_name,duration);
}


function sendAjax(d_name,test_name,duration){
    
    var xttp = new XMLHttpRequest();
    xttp.open("GET", "testFact.php?d_name="+d_name+"&test_name="+test_name+"&duration="+duration, true);
    xttp.onreadystatechange = function() { 
    if (xttp.readyState == XMLHttpRequest.DONE && xttp.status == 200) {
    var result=xttp.responseText.trim();
    document.getElementById("analysisTable").innerHTML = result;
    }
    }
    xttp.send();
}
</script>
<?include('footer.html');?>