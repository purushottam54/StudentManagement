<?php
include 'db_connect.php';
$stat = array("teacher","hod","lipik","principal", "Done");
$qry = $conn->query("SELECT * FROM gpd_letters where letter_id = ".$_GET['id'])->fetch_array();
$qry2 = $conn->query("SELECT * FROM gpd_users where user_id = (SELECT letter_creator_user_id FROM gpd_letters WHERE letter_id =".$_GET['id']." )");
foreach($qry as $k => $v){
	$$k = $v;
}
$row2 = $qry2->fetch_assoc();
foreach($qry2 as $k1 => $v1){
	$$k1 = $v1;
}

$qry = $conn->query("SELECT * FROM gpd_letters where letter_id =".$_GET['id']." order by letter_id asc");
if($row = $qry->fetch_assoc()){
	$status = $row["letter_status"];
}
?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-12">
			<div class="callout callout-info">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<dl>
								<dt><b class="border-bottom border-primary">Sender Name</b></dt>
								<dd><?php echo ucwords($row2['user_name'])." ".ucwords($row2['user_surname']) ?></dd><br>
								<dt><b class="border-bottom border-primary">Letter Title</b></dt>
								<dd><?php echo html_entity_decode($letter_title) ?></dd><br
								<dt><b class="border-bottom border-primary">Letter Description</b></dt>
								<dd><?php echo html_entity_decode($letter_content) ?></dd>
							</dl>
						</div>
						<div class="col-md-6">
							<dl>
								<dt><b class="border-bottom border-primary">Start Date</b></dt>
								<dd><?php echo date("F d, Y",strtotime($letter_created_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">End Date</b></dt>
								<dd><?php echo date("F d, Y",strtotime($letter_created_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Status</b></dt>
								<dd>
									<?php
									  	echo "<span class='badge badge-success'>{$stat[$status - 1] }</span>";
									?>
								</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Remark List</b></span>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
					<table class="table table-condensed m-0 table-hover">
						<colgroup>
							<col width="5%">
							<col width="25%">
							<col width="30%">
							<col width="15%">
							<?php if ((($row['letter_status'] + 1 ) == $_SESSION['login_user_type_id'] )): ?>

							<col width="15%">
							<?php endif;?>

						</colgroup>
						<thead>
							<th>#</th>
							<th>Remark</th>
							<th>Description</th>
							<th>Status</th>
								<?php if ((($row['letter_status'] + 1 ) == $_SESSION['login_user_type_id'] )): ?>

							<th>Action</th>
							<?php endif;?>
						</thead>
						<tbody>
    <?php 
    $i = 1;
    
    $tasks = $conn->query("SELECT letter_hod_remarks, letter_lipik_remarks, letter_principal_remarks FROM gpd_letters WHERE letter_id = $letter_id order by letter_id asc");
    if($_SESSION['login_user_type_id'] == 2 | $_SESSION['login_user_type_id'] == 1 ){
        // If the user type is 1 (Teacher), display all three remarks sequentially.
        while($row3 = $tasks->fetch_assoc()):
            foreach(['hod', 'lipik', 'principal'] as $type){
                $remark = $row3['letter_'.$type.'_remarks'];
				$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
				unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
				$desc = strtr(html_entity_decode($row['letter_content']),$trans);
				$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
                if(!empty($remark)){ // Check if the remark is not empty.
    ?>
                    <tr>
                        <td class="text-center"><?php echo $type; ?></td>
                        <td><b><?php echo ucwords($remark); ?></b></td>
						
                        <td><p class="truncate"><?php echo strip_tags($desc); ?></p></td>
                        <td><span class='badge badge-success'>
						<?php 
                    if($row['letter_status'] == 1){
                        echo "<span class='badge badge-secondary'>Teacher</span>";
                    }elseif($row['letter_status'] == 2){
                        echo "<span class='badge badge-primary'>Hod</span>";
                    }elseif($row['letter_status'] == 3){
                        echo "<span class='badge badge-success'>Lipik</span>";
                    }elseif($row['letter_status'] == 4){
                        echo "<span class='badge badge-success'>Principal</span>";
                    }elseif($row['letter_status'] == 5){
                        echo "<span class='badge badge-success'>Done</span>";
                    }
                    ?>		
					</span></td>
                    </tr>
    <?php
                }
            }
        endwhile;
    } else {
        // Original logic for other user types.
        while($row3 = $tasks->fetch_assoc()):
            $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
            unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
            $desc = strtr(html_entity_decode($row['letter_content']),$trans);
            $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
    ?>
           <tr>
			                        <td class="text-center"><?php echo $i++ ?></td>
			                        <td class="">
										<b>
											<?php 
									
									echo (!empty(ucwords($row['letter_'.$stat[$_SESSION['login_user_type_id'] - 2].'_remarks'])))? 		ucwords($row['letter_'.$stat[$_SESSION['login_user_type_id'] - 2].'_remarks']) : "<span class='badge badge-danger'>Not Reviewed Yet</span>";					
									
									?></b></td>
			                        <td class=""><p class="truncate"><?php echo strip_tags($desc) ?></p></td>
			                        <td>
			                        	<?php 
			                        	if($row['letter_status'] == 1){
									  		echo "<span class='badge badge-secondary'>Teacher</span>";
			                        	}elseif($row['letter_status'] == 2){
									  		echo "<span class='badge badge-primary'>Hod</span>";
			                        	}elseif($row['letter_status'] == 3){
									  		echo "<span class='badge badge-success'>Lipik</span>";
			                        	}elseif($row['letter_status'] == 4){
									  		echo "<span class='badge badge-success'>Principal</span>";
			                        	}
			                        	?>
			                        </td>

									<?php if ((($row['letter_status']  +1 ) == $_SESSION['login_user_type_id'] )): ?>


			                       <td class="text-center">
										<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
					                      Action
					                    </button>
					                    <div class="dropdown-menu" style="">
					                      <a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $row['letter_id'] ?>"  data-task="<?php echo $row['letter_hod_remarks'] ?>">Add Remark</a>
					                    </div>
									</td>

									<?php  endif;?>
		                    	</tr>
    <?php
        endwhile;
    }
    ?>
</tbody>

					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.users-list>li img {
	    border-radius: 50%;
	    height: 67px;
	    width: 67px;
	    object-fit: cover;
	}
	.users-list>li {
		width: 33.33% !important
	}
	.truncate {
		-webkit-line-clamp:1 !important;
	}
</style>
<script>
$('#new_task').click(function(){
		uni_modal("New Task For <?php echo ucwords($row2['user_name']) ?>","manage_task.php?pid=<?php echo $letter_id ?>","mid-large")
	})
	$('.edit_task').click(function(){
		uni_modal("Add Remark","manage_task.php?pid=<?php echo $letter_id ?>&id="+$(this).attr('data-id'),"mid-large")
	})
	$('.view_task').click(function(){
		uni_modal("Task Details","view_task.php?id="+$(this).attr('data-id'),"mid-large")
	})
	$('#new_productivity').click(function(){
		uni_modal("<i class='fa fa-plus'></i> New Progress","manage_progress.php?pid=<?php echo $letter_id ?>",'large')
	})
	$('.manage_progress').click(function(){
		uni_modal("<i class='fa fa-edit'></i> Edit Progress","manage_progress.php?pid=<?php echo $letter_id ?>&id="+$(this).attr('data-id'),'large')
	})
	$('.delete_progress').click(function(){
	_conf("Are you sure to delete this progress?","delete_progress",[$(this).attr('data-id')])
	})
	function delete_progress($letter_id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_progress',
			method:'POST',
			data:{letter_id:$letter_id},
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