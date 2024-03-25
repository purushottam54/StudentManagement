<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	// $type_arr = array('',"Admin","Project Manager","Employee");
	$type_arr = array('',"Admin","Teacher","HOD", "Lipik", "Principal");

	$qry = $conn->query("SELECT *,concat(user_name,' ',user_surname) as name FROM gpd_users where user_id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<div class="card card-widget widget-user shadow">
      <div class="widget-user-header bg-dark">
        <h3 class="widget-user-username"><?php echo ucwords($user_name) ?></h3>
        <h5 class="widget-user-desc"><?php echo $user_email ?></h5>
      </div>
      <div class="widget-user-image">
      	<?php if(empty($user_profile_pic) || (!empty($user_profile_pic) && !is_file('assets/uploads/'.$user_profile_pic))): ?>
      	<span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px;height:90px"><h4><?php echo strtoupper(substr($user_name, 0,1).substr($user_surname, 0,1)) ?></h4></span>
      	<?php else: ?>
        <img class="img-circle elevation-2" src="assets/uploads/<?php echo $user_profile_pic ?>" alt="User Avatar"  style="width: 90px;height:90px;object-fit: cover">
      	<?php endif ?>
      </div>
      <div class="card-footer">
        <div class="container-fluid">
        	<dl>
        		<dt>Role</dt>
        		<dd><?php echo $type_arr[$user_type_id] ?></dd>
        	</dl>
        </div>
    </div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>