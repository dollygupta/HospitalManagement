<?php include('patientcommon.html');?>
<div class="content">
    <h2>Patient Dashboard</h2>
    <?php 
  session_start();
     $username1 = $_SESSION["username"];

    function selectBlob($id) {
 include('connection.php');
$username1 = $_SESSION["username"];
   /* session_start();
    echo "username is " . $_SESSION["username"];
    
/*$sql = "SELECT mime, data
 FROM files
 WHERE id = :id";

 $sql = "select profilepic from doctor where d_name= 'James Watson'"; */

  
  $sql1 = "select p_id,p_name from patient where emailid= '$username1'" ;
 

 $stmt1 = $con->prepare($sql1);
 #$stmt->execute(array(":id" => $id));
 $stmt1->execute();
 $stmt1->bindColumn(1, $id);
 $stmt1->bindColumn(2, $name);
 $stmt1->fetch(PDO::FETCH_BOUND);
    echo "<B>Hi $name </b> ";
/*$sql = "SELECT mime, data
 FROM files
 WHERE id = :id";*/
$_SESSION["id"]=$id;
 $sql = "select profilepic from patient where emailid= '$username1'" ;
 

 $stmt = $con->prepare($sql);
 #$stmt->execute(array(":id" => $id));
 $stmt->execute();
 $stmt->bindColumn(1, $mime);
 #$stmt->bindColumn(2, $data, PDO::PARAM_LOB);
 $stmt->fetch(PDO::FETCH_BOUND);
 #header("Content-Type:" . jpg);
 #echo $mime;
 header("Content-Type : image/jpeg");
#echo $a['mime'];

echo '<img src="data:image/jpeg;base64,'.base64_encode(  $mime ).'"/>';
  return array("mime" => $mime);
 #return array("mime" => $mime,
      #"data" => $data);
 
}



selectBlob(1); 


?>
</div>
<?php include('footer.html');?>
    