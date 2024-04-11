<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Scholarship Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$link = array('',"https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51AA54D7A32E4C3B30A","https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51AD7C4C238FF7FAB33","https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51AAC90D4A992C45BAB", "https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51AB6EDCD4985FE7C3A","https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51AC54E5F6E794BD5C1","https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51A8311355D6F13BE56","https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51A1DB822FC15D61FEA","https://mahadbt.maharashtra.gov.in/SchemeData/SchemeData?str=E9DDFA703C38E51A054A8D0DAA702B64");
					$qry = $conn->query("SELECT * FROM scholarship order by scholarship_name asc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['scholarship_name']) ?></b></td>
						
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_user" href="./index.php?page=view_document&id=<?php echo $row['scholarship_id'] ?>" data-id="<?php echo $row['scholarship_id'] ?>">Documents</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="<?php echo $link[$row['scholarship_id']] ?>">Apply</a>
		                      <!-- <div class="dropdown-divider"></div> -->
		                      
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
        // $(document).on('click', '.view_user', function(){
        //     uni_modal("<i class='fa fa-id-card'></i> User Details","view_user.php?id="+$(this).attr('data-id'));
        // });

		// $(document).on('click', '.delete_user', function(){
		// 	var userId = $(this).attr('data-id');
		// 	console.log("Deleting user with ID: " + userId); // Debugging: Check if userId is correct
		// 	_conf("Are you sure to delete this USER ?","delete_user", [userId]);
		// });

    });

    
</script>

