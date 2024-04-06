<?php 
if (!isset($conn)) { 
    include 'db_connect.php'; 
}

if (isset($material_id)) {
    // $qry = $conn->query("SELECT * FROM users WHERE user_id = (SELECT m	FROM gpd_letters WHERE letter_id = $letter_id)");
    // $row2 = $qry->fetch_assoc();
} else {
    $row2 = ["user_name" => $_SESSION['login_user_name'], "user_surname" => $_SESSION['login_user_surname']];
}
?>

<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-project">
                <input type="hidden" name="room_user_id" value="<?php echo isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : '' ?>">
                <input type="hidden" name="room_id" value="<?php echo isset($material_id) ? $material_id : '#' ?>">
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
                            <input type="number" class="form-control form-control-sm" autocomplete="off" name="room_price" value="<?php echo isset($material_date) ? date("Y-m-d", strtotime($material_date)) : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Max Student Capacity</label>
                            <input type="number" class="form-control form-control-sm" autocomplete="off" name="room_max" value="<?php echo isset($material_date) ? date("Y-m-d", strtotime($material_date)) : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Current Capacity</label>
                            <input type="number" class="form-control form-control-sm" autocomplete="off" name="room_current" value="<?php echo isset($material_date) ? date("Y-m-d", strtotime($material_date)) : '' ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Image</label>
                            <!-- File input field -->
                            <input type="file" class="form-control-file" id="fileUpload" name="room_pictures" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-info">
                    <div class="d-flex w-100 justify-content-center align-items-center">
                        <button class="btn btn-flat bg-gradient-primary mx-2" form="manage-project">Save</button>
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
                url: 'ajax.php?action=save_room',
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
                            location.href = 'index.php?page=list_room';
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
