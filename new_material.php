<?php if(!isset($conn)){ include 'db_connect.php'; }
$qry = $conn->query("SELECT student_id FROM students WHERE stud_user_id = ".$_SESSION['login_user_id']);
$row3 = $qry->fetch_assoc();

if (isset($material_id)) {
	$qry = $conn->query("SELECT student_id FROM students WHERE stud_user_id = (SELECT user_id FROM  WHERE letter_id = $");
	$row2 = $qry->fetch_assoc();
}else{
	$row2 = ["user_name" => $_SESSION['login_user_name'],"user_surname" => $_SESSION['login_user_surname']];
}
?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-project">
        <input type="hidden" name="material_user_id" value="<?php echo isset($row3['student_id']) ? $row3['student_id']: '' ?>">
        <input type="hidden" name="material_id" value="<?php echo isset($material_id) ? $material_id: '#' ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Name</label>
					<input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset( $row2["user_name"]) ? $row2["user_name"]." ".$row2["user_surname"] : '' ?>" readonly>
				</div>
			</div>
			<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="material_date" value="<?php echo isset($material_date) ? date("Y-m-d",strtotime($material_date)) : '' ?>" required>
            </div>
            </div>  </div>
		<div class="row">

        	<?php if($_SESSION['login_user_type_id'] == 2 | $_SESSION['login_user_type_id'] == 3  ): ?>
                <div class="col-md-6">
<div class="form-group">
    <label for="" class="control-label">Category</label>
    <select class="form-control form-control-sm select2" name="material_category" id="category_select" required>
        <option></option>
        <option value="new_category">Add New Category</option>
        <?php
        $managers = $conn->query("SELECT * FROM material ORDER BY material_category ASC ");
        while ($row = $managers->fetch_assoc()):
            ?>
            <option ><?php echo ucwords($row['material_category']) ?></option>
        <?php endwhile; ?>
        <!-- Add an option for a new category -->
    </select>
    <!-- Input box and button for new category -->
    <div id="new_category_row" style="display: none;">
        <input type="text" class="form-control form-control-sm" id="new_category_input" placeholder="Enter New Category">
        <input type="button" class="btn btn-primary btn-sm" id="add_category_button" value="Add">
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category_select').change(function() {
            if ($(this).val() == 'new_category') {
                $('#new_category_row').show();
            } else {
                $('#new_category_row').hide();
            }
        });

        $('#add_category_button').click(function() {
            var newCategory = $('#new_category_input').val().trim();
            if (newCategory !== '') {
                // Add new category option
                $('#category_select').append($('<option>', {
                    value: newCategory,
                    text: newCategory
                }));
                // Select the newly added option
                $('#category_select').val(newCategory);
                // Hide the input box and button
                $('#new_category_row').hide();
            }
        });
    });
</script>

</div>


      <?php else: ?>
      	<input type="hidden" name="login_user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
      <?php endif; ?>
        </div>
		<div class="row">
    <div class="col-md-10">
        <div class="form-group">
            <label for="" class="control-label">Upload</label>
            <!-- File input field -->
            <input type="file" class="form-control-file" id="fileUpload" name="material_path" required>
        </div>
    </div>
</div>
<form id="manage-project">
    <!-- Your other form fields here -->
</form>
<div class="card-footer border-top border-info">
    <div class="d-flex w-100 justify-content-center align-items-center">
        <button class="btn btn-flat bg-gradient-primary mx-2" form="manage-project">Save</button>
        <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=letter_list'">Cancel</button>
    </div>
</div>

</div>
<script>


	$('#manage-project').submit(function(e){


		var formData = new FormData($(this)[0]);
        formData.forEach(function(value, key){
            console.log(key + ": " + value);
        });

		e.preventDefault()
		start_load()

		$.ajax({
			url:'ajax.php?action=save_project',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){

				console.log(resp);
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=home'
					},2000)
				}
				if(resp == 2){
					alert_toast('Yogi tai',"error");
					setTimeout(function(){
						location.href = 'index.php?page=save_project'
					},2000)
				}
			}
		})
	})
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('select[name="principle_id"]').change(function() {
            if ($(this).val() == 'new_category') {
                $('#new_category_input').show();
            } else {
                $('#new_category_input').hide();
            }
        });
    });
</script>
