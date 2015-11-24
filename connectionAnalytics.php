<?php
 $con = new PDO("mysql:host=localhost;dbname=hospitalanalytics","root", "admin");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>