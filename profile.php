       
        <html lang="en-US">
        <head>
        <meta charset="UTF-8">
        <title>Admin Page</title>
        </head>

        <body>
        <?php
        include('doctorcommon.html');
        print '<BR><BR>';
        ini_set('display_errors', 1);
        session_start();
        $d_id=$_SESSION["did"];
        #$d_id=2;
        #Full texts   d_id  d_d_name  d_phone   dept_id   doctor_fees   emailid   password  salary Address
        class doctor_list
        {

        private $d_id;
        private $d_name;
        private $d_phone;
        private $dept_id;
        private $doctor_fees;
        private $emailid;
        private $password;
        private $salary;
        private $Address;
        private $profilepic;

        public function getd_id() {return $this->d_id; }
        public function getd_phone() {return $this->d_phone; }
        public function getdept_id(){return $this->dept_id;}
        public function getAddress() {return $this->Address; }
        public function getd_name() {return $this->d_name; }
        public function getemailid() {return $this->emailid; }
        public function getpassword() {return $this->password; }
        public function getsalary() {return $this->salary; }
        public function getdoctor_fees() {return $this->doctor_fees; }
        public function getprofilepic() {return $this->profilepic; }

        }

        function createtablerow(doctor_list $h,& $header)
        {
        include('connection.php');
        print "<form method='post' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data'>";
        print "Profile Pic:";
        header("Content-Type : image/jpeg");
        #echo $a['mime'];

        echo '<img src="data:image/jpeg;base64,'.base64_encode(  $h->getprofilepic() ).'"/>';
        print "<p>Id: <input name='id' readonly='readonly' value='".$h->getd_id(). "'      size=15 readonly/></p>"; 
        print "                                                      <tr>\n";
        print "<p>Name: <input name='name' value='".$h->getd_name(). "'      size=15/></p> "; 
        print "<p>Address: <td><input name='Address' value='".$h->getAddress(). "'      size=15/></p>"; 
        print "<p>dept_id: <td><input name='dept_id'  value='".$h->getdept_Id(). "'      size=15/></p>"; 
        print "<p>Department:<td> <select name='dept'>   ";
        $query = "select * from department";
        $result = "select * from department where dept_id = $h->getdept_Id";
        $ps1=$con->prepare($result);

        $ps = $con->prepare($query);

        // Fetch the matching row.
        $ps->execute();
        $data = $ps->fetchAll();
        foreach ($data as $row) 
        {
        print "<option value = '".$row['dept_id']."'>".$row['dept_name']."</option>";
        }
        print "</select>";
        print "<p>Phone: <input name='phone' value='".$h->getd_phone(). "'      size=15/></p>"; 
        print "<p>Email Id: <input name='emailid' value='".$h->getemailid(). "'      size=15/></p>"; 
        print "<p>Password: <input name='password' value='".$h->getpassword(). "'      size=15/></p>"; 
        print "<p>Salary: <input name='salary' value='".$h->getsalary(). "'      size=15/></p>"; 
        print "<p>Doctor Fees: <input name='doctor_fees' value='".$h->getdoctor_fees(). "'      size=15/></p>"; 
        
        print "<BR>Select image to upload:";
        print " <input type='file' name='fileToUpload' id='fileToUpload'>";
        print "<p><input type=submit value='Update' name='submit'/></p>";
        print "</form>"; 
        $header=false;

        }

        function constructTable($row,& $header)
        {
        print "<table border='1'>";

        if($header)
        {
        print "<tr>";
        foreach ($row as $d_name => $value) {
        print "<th>$d_name</th>\n";
        }
        print "        </tr>\n";
        $header=false;                 
        }             
        print "</table>";    
        }

        try
        {
        $header=true;


        // Connect to the database.
        #$con = new PDO("mysql:host=localhost;dbname=hospital","root", "admin");
        #$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        include('connection.php');
        $query = "SELECT * from doctor where d_id = :did;";


        $ps = $con->prepare($query);

        // Fetch the matching row.
        $ps->bindParam(':did', $d_id);
        $ps->execute();
        $ps->setFetchMode(PDO::FETCH_CLASS, "doctor_list");

        // $data is an array.
        if ($ps->rowCount() > 0) 
        {
        // Construct the HTML table row by row.
        while ($doctor_list  = $ps->fetch())
        {
        print "        <tr>\n";
        createtablerow($doctor_list,$header);



        print "        </tr>\n";
        }  
        }  
        else {
        print "<h3>(No match.)</h3>\n";
        }
              if(isset($_POST["submit"]))
        {

        $id= $_POST["id"];
        $d_name=$_POST["name"];
        $d_phone=$_POST["phone"];
        $dept_id=$_POST["dept"];
        $doctor_fees=$_POST["doctor_fees"];
        $emailid=$_POST["emailid"];
        $password=$_POST["password"];
        $salary=$_POST["salary"];
        $Address=$_POST["Address"];
       
       //Change the target directory
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(is_null($imageFileType))
            echo "Not done";
       // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        //if($check !== false) 
        //{
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
        {
        $blob = fopen($target_file,'rb');
       
        include('connection.php');
        $query = "UPDATE doctor SET d_name='$d_name',d_phone=$d_phone,dept_id=$dept_id,doctor_fees='$doctor_fees',emailid='$emailid',password='$password',salary='$salary',Address='$Address',profilepic=:blob WHERE d_id=:id";
        # This is the sql query for delete you should write the trigger code here 

        #$query = "delete from doctor  WHERE d_id=$id";
        $ps = $con->prepare($query);
        $ps->bindParam(':id',$id);
        $ps->bindParam(':blob',$blob,PDO::PARAM_LOB);

        $ps->execute();
        echo "Successfully Updated";
        }
        else
        {
       include('connection.php');
        $query = "UPDATE doctor SET d_name='$d_name',d_phone=$d_phone,dept_id=$dept_id,doctor_fees='$doctor_fees',emailid='$emailid',password='$password',salary='$salary',Address='$Address' WHERE d_id=:id";
        # This is the sql query for delete you should write the trigger code here 

        #$query = "delete from doctor  WHERE d_id=$id";
        $ps = $con->prepare($query);
        $ps->bindParam(':id',$id);
       $ps->execute();
        echo "Successfully Updated";
       
    }
    
}
        }

        catch(PDOException $ex) {
        echo 'ERROR: '.$ex->getMessage();
        }

        catch(Exception $ex) {
        echo 'ERROR: '.$ex->getMessage();
        }
        ?>
        </body>
        </html>
