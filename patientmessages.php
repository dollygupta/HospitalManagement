<?php
include('patientcommon.html');
include('connection.php');
session_start();
 $username1 = $_SESSION["username"];
 $id=$_SESSION["id"];
 class patientmessage
{
  private $message;
  public function getMessages() {return $this->message; }
 
  
}
 try
 {
include('connection.php');
  $query = "select message from patient_history where p_id= :id" ;
 $data=$con->prepare($query);
$data->bindParam(':id',$id);
$data->execute();
$data->setFetchMode(PDO::FETCH_CLASS,"patientmessage");

 if ($data->rowCount() > 0) 
  {
  // Construct the HTML table row by row.
   
    while ($patient_list  = $data->fetch())
    {
echo $patient_list -> getMessages()."<BR>";
	}
}

else
{
	echo "You have no new messages!";
}
}
catch(PDOException $ex) {
  echo 'ERROR: '.$ex->getMessage();
}

catch(Exception $ex) {
  echo 'ERROR: '.$ex->getMessage();
}

?>

