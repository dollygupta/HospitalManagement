<?php include('adminCommon.html');?>
<div class="content">
    <h2>Doctor Dashboard</h2>
    <?php
    echo "HI";
$name=filter_input(INPUT_GET, "email");
echo $name;
    ?>
</div>
<?php include('footer.html');?>
    