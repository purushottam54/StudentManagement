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
				$isFull = ["Full"];
                $qry = $conn->query("SELECT * FROM room order by room_id asc");
                while($row = $qry->fetch_assoc()):                
                ?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>

						<?php
							$qry1 = $conn->query("SELECT concat(user_name,' ',user_surname) as name FROM users WHERE user_id = ".$row['room_user_id']);
							$row4 = $qry1->fetch_assoc()
						?>
							<p><b><?php echo ucwords($row4['name']) ?></b></p>
							<p class="truncate"></p>
						</td>
						<td><b><?php 
						
							if (($row['room_max'] - $row['room_current']) == 0) {
								echo "Room Is FUll";
							}
							else{
								echo $row['room_max'] - $row['room_current']." Remaining";
							}
						?></b></td>
						<td><b><?php echo $row['room_price'] ?></b></td>
						<td><b><?php echo $row['room_max'] ?></b></td>
						<td class="text-center">
							<?php
							  	echo $row['room_current'];
							?>
						</td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
							<div class="dropdown-menu" style="">
		                      <a class="dropdown-item apply_room" id="check1" href="javascript:void(0)" data-id="<?php echo $row['room_id'] ?>">Apply</a>
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

<?php
	$qry1 = $conn->query("SELECT student_id FROM students WHERE stud_user_id = '".$_SESSION['login_user_id']."'");
	$row5 = $qry1->fetch_assoc();
?>
	$(document).ready(function(){
		$('#list').dataTable()
	
	$('.apply_room').click(function(){
	_conf("Are you sure to apply this Room?","delete_project",[$(this).attr('data-id'), <?php echo $row5['student_id']?>])
	})
	})

	
	function delete_project($room_id, $student_id){
		
		start_load();
		
		
		$.ajax({
			url:'ajax.php?action=apply_room',
			method:'POST',
			data:{room_id:$room_id, student_id:$student_id},
			success:function(resp){
				console.log(resp);
				if(resp==1){
					alert_toast("Student Alerady In Room (ANY)",'danger')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				if(resp==0){
					alert_toast("Student Successfully Applied For Room",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				if(resp==3){
					alert_toast("Room is full!!",'danger')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				if(resp==2){
					alert_toast("DB Error",'danger')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	}
</script>