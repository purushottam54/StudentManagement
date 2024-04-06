
<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
   		<?php 
    		$array = [1, 4, 5];
    		if (!in_array($_SESSION['login_user_type_id'], $array)): ?>
    			<div class="card-tools">
        			<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_material">
		           		<i class="fa fa-plus"></i> Add New Material
        			</a>
    			</div>
    	<?php endif; ?>
		</div>

		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="25%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Student Name</th>
						<th>Material Category</th>
						<th>Material Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$i = 1;
                $qry = $conn->query("SELECT * FROM material order by material_id asc");
                while($row = $qry->fetch_assoc()):               
                ?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>

						<?php
							$qry1 = $conn->query("SELECT concat(user_name,' ',user_surname) as name FROM users WHERE user_id = ".$row['material_user_id']);
							$row4 = $qry1->fetch_assoc()
						?>
							<p><b><?php echo ucwords($row4['name']) ?></b></p>
							<p class="truncate"></p>
						</td>
						<td><b><?php echo $row['material_category'] ?></b></td>
						<td><b><?php echo date("M d, Y",strtotime($row['material_date'])) ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_letter&id=<?php echo $row['letter_id'] ?>" data-id="<?php echo $row['letter_id'] ?>">View</a>
		                      <?php if($_SESSION['login_user_type_id'] != 4 | $_SESSION['login_user_type_id'] != 5 ): ?>
								<div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_letter&id=<?php echo $row['letter_id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['letter_id'] ?>">Delete</a>
		                  <?php endif; ?>
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