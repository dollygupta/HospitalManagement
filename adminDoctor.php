<?include('adminCommon.html');?>
<div class="content">
   <div class="page-header">
      <h2>Manage Doctor</h2>
    </div>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="http://localhost/HospitalManagement/adminDoctor.php">Doctor List</a></li>
        <li><a href="#">Add Doctor</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="show-table">
  <?include('doctorList.php');?>
</div>
</div>
<?include('footer.html');?>