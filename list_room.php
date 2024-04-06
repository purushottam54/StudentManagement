<!-- <div class="form-group">
    <label for="" class="control-label">Category</label>
    <select class="form-control form-control-sm select2" name="material_category" id="category_select" required>
        <option></option>
        <?php
        // $unique_categories = $conn->query("SELECT DISTINCT material_category FROM material ORDER BY material_category ASC");
        // while ($row = $unique_categories->fetch_assoc()):
            ?>
            <option><?php 
			// echo ucwords($row['material_category']) 
			
			?></option>
        <?php
		
	// endwhile;
		
		?>
    </select>
</div> -->
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
					<col width="28%">
					<col width="28%">
					<col width="29%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Room Price</th>
						<th>Max Number</th>
						<th>Current Available</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
                $i = 1;
                $where = "";
                if($_SESSION['login_user_type_id'] == 3){
                  $where = " WHERE room_user_id = '{$_SESSION['login_user_id']}'";
                }
                $qry = $conn->query("SELECT * FROM room $where order by room_user_id asc");
                while($row = $qry->fetch_assoc()):
                ?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>
							<p><b><?php echo ucwords($row['room_price']) ?></b></p>
							<p class="truncate"></p>
						</td>
						<td><b><?php echo $row['room_max'] ?></b></td>
						<td><b><?php echo $row['room_current'] ?></b></td>

						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_room&id=<?php echo $row['room_id'] ?>" data-id="<?php echo $row['room_id'] ?>">View</a>
								<div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_room&id=<?php echo $row['room_id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['room_id'] ?>">Delete</a>
		                    </div>
						</td>
					</tr>	
				<?php 
			
			endwhile;
			 ?>
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
			url:'ajax.php?action=delete_room',
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