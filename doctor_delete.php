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

$did= filter_input(INPUT_GET, "did");
try{
include('connection.php');
$query = "select d.d_name,a.p_id,a.time,a.date from appointment a,doctor d  where d.d_id=:did and a.d_id=d.d_id;";
$data=$con->prepare($query);
$data->bindParam(':did',$did);
$data->execute();
$data->setFetchMode(PDO::FETCH_CLASS,"patientmessage");
$name = '';
$message1 = '';
  if ($data->rowCount() > 0) 
  {
  // Construct the HTML table row by row.
    $doctor_list  = $data->fetch();
    while ($doctor_list  = $data->fetch())
    {
$message = "Your appointment on ". $doctor_list->getdate() . " at" . $doctor_list->gettime() . " under" . $doctor_list->getd_name() . " has been cancelled as the doctor in unavailable.";
$name = $doctor_list->getd_name();
print $message1;
   $query = "insert into patient_history (p_id,message,prescription) VALUES (:id,:message,'')";

                $ps = $con->prepare($query);
                $ps->execute(array(':id' => $doctor_list->getp_id(), ':message' => $message));


	}

	
	print "All the patients with appointment under ".$name."were notified<BR>";
	



}
$query = "delete from doctor where d_id=:did";
$data=$con->prepare($query);
$data->bindParam(':did',$did);
$data->execute();

}
catch(PDOException $ex) {
  echo 'ERROR: '.$ex->getMessage();
}

catch(Exception $ex) {
  echo 'ERROR: '.$ex->getMessage();
}

?>