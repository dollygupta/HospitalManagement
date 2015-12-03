        <html lang="en-US">
        <head>
        <meta charset="UTF-8">
        <title>Admin Page</title>
        </head>

        <body>
        <?php
        include('adminCommon.html');
        print '<BR><BR>';
        ini_set('display_errors', 1);
        #$d_id = filter_input(INPUT_GET, "did");
        $d_id=2;
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

        function formtoadd()
        {
        include('connection.php');
        print "<form method='post' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data'>";
        print "<p>SSN: <input name='id' size=15 /></p>"; 
        print "                                                      <tr>\n";
        print "<p>Name: <input name='name'     size=15/></p> "; 
        print "<p>Address: <td><input name='Address'      size=15/></p>"; 
        print "<p>Department:<td> <select name='dept'>   ";
        $query = "select * from department";
       
        $ps = $con->prepare($query);

        // Fetch the matching row.
        $ps->execute();
        $data = $ps->fetchAll();
        foreach ($data as $row) 
        {
        print "<option value = '".$row['dept_id']."'>".$row['dept_name']."</option>";
        }
        print "</select>";
        print "<p>Phone: <input name='phone'      size=15/></p>"; 
        print "<p>Email Id: <input name='emailid' size=15/></p>"; 
        print "<p>Password: <input name='password'    size=15/></p>"; 
        print "<p>Salary: <input name='salary'     size=15/></p>"; 
        print "<p>Doctor Fees: <input name='doctor_fees'   size=15/></p>"; 
        print "<BR>Select image to upload for profilepic:";
        print " <input type='file' name='fileToUpload' id='fileToUpload'>";
        print "<p><input type=submit value='Add' name='submit'/></p>";
        print "</form>"; 
        }

        
        try
        {
       


        // Connect to the database.
        #$con = new PDO("mysql:host=localhost;dbname=hospital","root", "admin");
        #$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        include('connection.php');
        formtoadd();
       
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
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
        {
        $blob = fopen($target_file,'rb');
       
        include('connection.php');
        $query= "insert into doctor (d_id,d_name,d_phone,dept_id,doctor_fees,emailid,password,salary,Address,profilepic) values($id,'$d_name',$d_phone,$dept_id,'$doctor_fees','$emailid','$password',$salary,'$Address',:blob)";
       
        # This is the sql query for delete you should write the trigger code here 

        #$query = "delete from doctor  WHERE d_id=$id";
        $ps = $con->prepare($query);
        $ps->bindParam(':blob',$blob,PDO::PARAM_LOB);

        $ps->execute();

         $query= "update department set no_of_doctors=no_of_doctors+1 where dept_id=$dept_id";
       
        # This is the sql query for delete you should write the trigger code here 

        #$query = "delete from doctor  WHERE d_id=$id";
        $ps = $con->prepare($query);
       

        $ps->execute();


        echo "Successfully Inserted";
        }
        else
        {

       
        include('connection.php');
        $query= "insert into doctor (d_id,d_name,d_phone,dept_id,doctor_fees,emailid,password,salary,Address) values($id,'$d_name',$d_phone,$dept_id,'$doctor_fees','$emailid','$password',$salary,'$Address')";
       
        # This is the sql query for delete you should write the trigger code here 

        #$query = "delete from doctor  WHERE d_id=$id";
        $ps = $con->prepare($query);
       

        $ps->execute();

          $query= "update department set no_of_doctors=no_of_doctors+1 where dept_id=$dept_id";
       
        # This is the sql query for delete you should write the trigger code here 

        #$query = "delete from doctor  WHERE d_id=$id";
        $ps = $con->prepare($query);
       

        $ps->execute();

        echo "Successfully Inserted";
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

<?php include('footer.html');?>
>>>>>>> 9661c9af9013c5c5d11cb2311bf321f7fb9a26c6
