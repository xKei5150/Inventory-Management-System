<?php 
include_once('../data/admin_session.php');
include_once('../include/header.php'); ?>
<?php include_once('../include/banner.php'); ?>

  <nav class="navbar navbar-inverse" style="margin-top:-18px;">
  	<div class="container-fluid navbar-custom">
   	 
  	  <ul class="nav navbar-nav">
  	    <li>
          <a href="index.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
        </li>
     
  	    <li>
          <a href="item.php"><i class="fa-solid fa-file-invoice"></i></span> Item</a>
        </li>

  	    <li class="active">
          <a href="employee.php"><i class="fa-solid fa-users"></i> Employee</a>
        </li>

        <li>
          <a href="position.php"><i class="fa-solid fa-user-tie"></i> Position</a>
        </li>

        <li>
          <a href="office.php"><i class="fa-solid fa-city"></i> Office</a>
        </li>

  	    <li>
          <a href="request.php"><i class="fa-solid fa-paperclip"></i> Request</a>
        </li>

  	    <li>
          <a href="report.php"><i class="fa-solid fa-clipboard-list"></i> Report</a>
        </li>
        <li>
        <a href="#qrModal" data-toggle="modal" ><i class="fa-solid fa-qrcode"></i> QR Scanner</a>
        </li>
  	  </ul>
  	  <ul class="nav navbar-nav navbar-right">
         <li class="dropdown">
            <a class="dropdown-toggle" id="admin-account" data-toggle="dropdown" href="#">
            </a>
            <ul class="dropdown-menu">
              <li><a href="#modal-changepass" data-toggle="modal">Change Password</a></li>
              <li><a href="../data/admin_logout.php">Logout</a></li>
            </ul>
          </li>
      </ul>
 	 </div>
	</nav>

	<div id="right_content" >
		<div class="panel-group">
 			 <div class="panel panel-primary">

 			 	<div class="panel-heading">
        <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
        List of Employee</div>
  	  			<div class="panel-body">
                                  <button href="#modal-add-employee" id="add-employee-menu"
                                  style="float: right;" class="btn btn-danger mb-2"
                                  data-toggle="modal">
                                  <span class="glyphicon glyphicon-user"></span>
                                  Add Employee</button>
              <!-- main content -->
              <div id="all_employee"></div>
              <!-- /main content -->
              <br />
  	  			</div>
 			 </div>
  
		</div>
	</div>

<!-- navigation menu -->
<!-- <?php require_once('side-menu.php'); ?> -->
<!-- navigation menu -->

<!-- load all modals here -->
<?php require_once('load_modals.php'); ?>
<!-- /load all modals here -->
  

</div>


<?php require_once('../include/footer.php'); ?>

</body>
</html>	

