<div class="form-group">
    Listing all Rooms that has been added by Room Owners<br>
    <label for="" class="control-label">Category</label>
    <select class="form-control form-control-sm select2" name="material_category" id="category_select" required>
        <option></option>
        <?php
        $unique_categories = $conn->query("SELECT DISTINCT material_category FROM material ORDER BY material_category ASC");
        while ($row = $unique_categories->fetch_assoc()):
            ?>
            <option><?php echo ucwords($row['material_category']) ?></option>
        <?php endwhile; ?>
    </select>
</div>
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
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Room Owner</th>
						<th>Full/Not Full</th>
						<th>Price</th>
						<th>Max Capacity</th>
						<th>Current Capacity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
                $i = 1;
                $stat = array("Teacher","Hod","Lipik","Principal", "Done");
                $where = "";
                if($_SESSION['login_user_type_id'] == 2){
                  $where = " WHERE letter_creator_user_id = '{$_SESSION['login_user_id']}'";
                }
                elseif($_SESSION['login_user_type_id'] == 3){
                  $where = " WHERE letter_creator_user_id = '{$_SESSION['login_user_id']}' OR letter_creator_user_id IN ( SELECT user_id FROM gpd_teacher WHERE department_id = ( SELECT department_id FROM gpd_hod WHERE user_id = '{$_SESSION['login_user_id']}' ))";
                }
                elseif($_SESSION['login_user_type_id'] == 4){
                  $where = " WHERE letter_status = '3'";
                }
                elseif($_SESSION['login_user_type_id'] == 5){
                  $where = " WHERE letter_status = '4'";
                }
                $qry = $conn->query("SELECT * FROM gpd_letters $where order by letter_creator_user_id asc");
                while($row = $qry->fetch_assoc()):
                  $status = $row['letter_status'];
                  $prog = ($status == 4) ? 100 : ($status * 20); // Assuming Done is 100%
                
                ?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>
							<p><b><?php echo ucwords($row['letter_title']) ?></b></p>
							<p class="truncate"></p>
						</td>
						<td><b><?php echo date("M d, Y",strtotime($row['letter_created_date'])) ?></b></td>
						<td><b><?php echo date("M d, Y",strtotime($row['letter_created_date'])) ?></b></td>
						<td class="text-center">
							<?php
							  	echo "<span class='badge badge-success'>{$stat[$row['letter_status'] - 1]}</span>";
							?>
						</td>
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