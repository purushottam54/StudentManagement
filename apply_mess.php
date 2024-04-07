
<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
   		<?php 
    		$array = [1, 4, 5];
    		if (!in_array($_SESSION['login_user_type_id'], $array)): ?>
    			<div class="card-tools">
        			<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_letter">
		           		<i class="fa fa-plus"></i> Add New letter
        			</a>
    			</div>
    	<?php endif; ?>
		</div>

		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="35%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Mess Owner</th>
						<th>Price</th>
						<th>Mess Type</th>
						<th>Action</th>
						
					</tr>
				</thead>
				<tbody>
				<?php
				$mess_type = ["Veg", "Non-Veg"];
                $i = 1;
                $qry = $conn->query("SELECT * FROM mess order by mess_type asc");
                while($row = $qry->fetch_assoc()):
                ?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>
						<?php
							$qry1 = $conn->query("SELECT concat(user_name,' ',user_surname) as name FROM users WHERE user_id = ".$row['mess_user_id']);
							$row4 = $qry1->fetch_assoc()
						?>
							<p><b><?php echo ucwords($row4['name']) ?></b></p>
							<p class="truncate"></p>
						</td>
						<td><b><?php echo $row['mess_price'] ?> Rs</b></td>
						<td><b><?php echo $mess_type[$row['mess_type']] ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_letter&id=<?php echo $row['mess_id'] ?>" data-id="<?php echo $row['mess_id'] ?>">View</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	
	$('.delete_project').click(function(){
	_conf("Are you sure to delete this letter?","delete_project",[$(this).attr('data-id')])
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>