<?php
include('admincommon.html');
class patientmessage
{
  private $d_name;
  private $p_id;
  private $time;
  private $date;


  public function getd_name() {return $this->d_name; }
  public function getp_id() {return $this->p_id; }
  public function gettime(){return $this->time;}
  public function getdate() {return $this->date; }
  
}

$pid= filter_input(INPUT_GET, "pid");
try{
include('connection.php');


$query = "delete from patient where p_id=:pid";
$data=$con->prepare($query);
$data->bindParam(':pid',$pid);
$data->execute();

print "Patient was deleted from the database and if he was an inpatient his room status was updated!";

}
catch(PDOException $ex) {
  echo 'ERROR: '.$ex->getMessage();
}

catch(Exception $ex) {
  echo 'ERROR: '.$ex->getMessage();
}

?>