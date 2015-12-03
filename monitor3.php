<?php include('adminCommon.html');?>
<div class="content">
    <div class="page-header">
        <h2>Monitor Hospital</h2>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div>
                <ul class="nav navbar-nav">
                    <li class=""><a href="moniter1.php">Lab Test</a></li>
                    <li class=""><a href="monitor2.php">Rooms</a></li>
                     <li class="active"><a href="monitor3.php">Drugs</a></li>

                </ul>
            </div>
        </div>
    </nav>

     <?php
      include('connectionAnalytics.php');
      $query1 = "select distinct dept_name FROM department";
            $ps = $con->prepare($query1);
            $ps->execute();
            $data1 = $ps->fetchAll(PDO::FETCH_ASSOC);

     print <<<here
     <form>
     Department Name:
here;
        echo '<select id="dept_name" name="dept_name">
        <option value="%">--</option>'; 
        foreach ($data1 as $row){
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
    var dept_name=document.getElementById('dept_name').value;
    var duration=document.getElementById('duration').value;
   sendAjax(dept_name,duration);
}


function sendAjax(dept_name,duration){
    
    var xttp = new XMLHttpRequest();
    xttp.open("GET", "drugFact.php?dept_name="+dept_name+"&duration="+duration, true);
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