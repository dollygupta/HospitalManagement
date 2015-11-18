<?php include('adminCommon.html');?>
<div class="content">
    <h2>Doctor Dashboard</h2>
    <?php
    session_start();
    echo "username is " . $_SESSION["username"];
    ?>
</div>
<?php include('footer.html');?>
    