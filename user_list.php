<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Add New User</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$type = array('',"Admin","Student","Room Owner", "Mess");
					$qry = $conn->query("SELECT *,concat(user_name,' ',user_surname) as name FROM users order by concat(user_name,' ',user_surname) asc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo $row['user_email'] ?></b></td>
						<td><b><?php echo $type[$row['user_type_id']] ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      
		                      <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['user_id'] ?>">Delete</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
    $(document).ready(function(){
        $('#list').dataTable();

        // Use event delegation for dynamically added elements
        $(document).on('click', '.view_user', function(){
            uni_modal("<i class='fa fa-id-card'></i> User Details","view_user.php?id="+$(this).attr('data-id'));
        });

		$(document).on('click', '.delete_user', function(){
			var userId = $(this).attr('data-id');
			console.log("Deleting user with ID: " + userId); // Debugging: Check if userId is correct
			_conf("Are you sure to delete this USER ?","delete_user", [userId]);
		});

    });

    function delete_user(userId){
		console.log("called");
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_user',
            method: 'POST',
            data: {id: userId},
            success: function(resp){
                console.log(resp);
                if(resp == 1){
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>

