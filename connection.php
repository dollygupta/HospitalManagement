<?php
 $con = new PDO("mysql:host=localhost;dbname=hospital","root", "admin");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>