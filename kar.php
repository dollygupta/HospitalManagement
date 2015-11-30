<?php
//Change the target directory
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check !== false) 

{
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
{

	try
{
include('connection.php');

$blob = fopen($target_file,'rb');

$sql = "INSERT INTO files(mime,data) VALUES(:mime,:data)";
$stmt = $con->prepare($sql);
$mime="image/jpeg";

$stmt->bindParam(':mime',$mime);
$stmt->bindParam(':data',$blob,PDO::PARAM_LOB);

$stmt->execute();
}
catch(PDOException $ex) 
{
        echo 'ERROR: '.$ex->getMessage();
    }    
    catch(Exception $ex) {
        echo 'ERROR: '.$ex->getMessage();
    }
} 

else echo "There was a problem uploading";

}


else {
    echo "File is not an image.";
    $uploadOk = 0;
}

}
?> 

