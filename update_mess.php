<?php 
if (!isset($conn)) { 
    include 'db_connect.php'; 
}

$qry = $conn->query("SELECT mess_id FROM mess WHERE mess_user_id =".$_SESSION['login_user_id']);
$row4 = $qry->fetch_assoc();
    $row2 = ["user_name" => $_SESSION['login_user_name'], "user_surname" => $_SESSION['login_user_surname']];
?>

<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-project">
                <input type="hidden" name="mess_user_id" value="<?php echo isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : '' ?>">
                <input type="hidden" name="mess_id" value="<?php echo $row4['mess_id'] ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Name</label>
                            <input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($row2["user_name"]) ? $row2["user_name"] . " " . $row2["user_surname"] : '' ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Price</label>
                            <input type="number" class="form-control form-control-sm" autocomplete="off" name="mess_price" value="<?php echo isset($mess_date) ? date("Y-m-d", strtotime($mess_date)) : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php if($_SESSION['login_user_type_id'] == 4): ?>
						<div class="form-group">
							<label for="" class="control-label">Mess Type</label>
							<select  name="mess_type" id="type" <?php echo (isset($user_type_id) && $user_type_id == 1) ? 'disabled' : '' ?> class="custom-select custom-select-sm" onchange="checkuser(this)">
								<option value="1">VEG</option>
								<option value="2">NONVEG</option>
								<option value="3">VEG - NONVEG</option>
							</select>
						</div>
                <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Image</label>
                            <!-- File input field -->
                            <input type="file" class="form-control-file" id="fileUpload" name="mess_pictures" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-info">
                    <div class="d-flex w-100 justify-content-center align-items-center">
                        <button class="btn btn-flat bg-gradient-primary mx-2" form="manage-project">Update</button>
                        <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=letter_list'">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
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

        $('#manage-project').submit(function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.forEach(function(value, key) {
                console.log(key + ": " + value);
            });
            start_load();
            $.ajax({
                url: 'ajax.php?action=save_mess',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(resp) {
                    console.log(resp);
                    if (resp == 1) {
                        alert_toast('Data successfully saved', "success");
                        setTimeout(function() {
                            location.href = 'index.php?page=update_mess';
                        }, 2000);
                    }
                    if (resp == 2) {
                        alert_toast('Error', "error");
                        setTimeout(function() {
                            location.href = 'index.php?page=save_project';
                        }, 2000);
                    }
                }
            });
        });
    });
</script>
