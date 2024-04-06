<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($user_id) ? $user_id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<input type="text" name="user_name" class="form-control form-control-sm" required value="<?php echo isset($user_name) ? $user_name : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Last Name</label>
							<input type="text" name="user_surname" class="form-control form-control-sm" required value="<?php echo isset($user_surname) ? $user_surname : '' ?>">
						</div>
						<?php if($_SESSION['login_user_type_id'] == 1): ?>
						<div class="form-group">
							<label for="" class="control-label">User Role</label>
							<select  name="user_type_id" id="type" <?php echo (isset($user_type_id) && $user_type_id == 1) ? 'disabled' : '' ?> class="custom-select custom-select-sm" onchange="checkuser(this)">
								<option value="4" <?php echo isset($user_type_id) && $user_type_id == 4 ? 'selected' : '' ?>>Mess</option>
								<option value="3" <?php echo isset($user_type_id) && $user_type_id == 3 ? 'selected' : '' ?>>Room Owner</option>
								<option value="2" <?php echo isset($user_type_id) && $user_type_id == 2 ? 'selected' : '' ?>>Student</option>
								<option value="1" <?php echo isset($user_type_id) && $user_type_id == 1  ? 'selected readonly="true"' : '' ?>>Administrator</option>
							</select>
						</div>

						<?php else: ?>
							<input type="hidden" name="type" value="3">
						<?php endif; ?>
						<div class="form-group">
							<label for="" class="control-label">Profile Picture</label>
							<div class="custom-file">
		                      <input type="file"  accept="image/jpeg, image/png"  class="custom-file-input" id="customFile" name="user_profile_pic" onchange="displayImg(this,$(this))">
		                      <label class="custom-file-label" for="customFile">Choose file</label>
		                    </div>
						</div>
						<div class="form-group d-flex justify-content-center align-items-center">
							<img src="<?php echo isset($user_profile_pic) ? 'assets/uploads/'.$user_profile_pic :'./assets/uploads/no-image-available.png' ?>" alt="Avatar" id="cimg" class="img-fluid img-thumbnail ">
						</div>
					</div>
					<div class="col-md-6">
						
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="user_email" required value="<?php echo isset($user_email) ? $user_email : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Password</label>
							<input type="password" class="form-control form-control-sm" name="password" <?php echo !isset($user_id) ? "required":'' ?>>
							<small><i><?php echo isset($user_id) ? "Leave this blank if you dont want to change you password":'' ?></i></small>
						</div>
						<div class="form-group">
							<label class="label control-label">Confirm Password</label>
							<input type="password" class="form-control form-control-sm" name="cpass" <?php echo !isset($user_id) ? 'required' : '' ?>>
							<small id="pass_match" data-status=''></small>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})

	function checkuser(data)
	{
		if(data.value == "2" || data.value == "3" )
		{
			element = document.getElementById("hoddept");
			element.removeAttribute("hidden");
		}
		else {
        var element = document.getElementById("hoddept");
        element.setAttribute("hidden", true);
    }

		
	}
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_user').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('[name="password"]').val() != '' && $('[name="cpass"]').val() != ''){
			if($('#pass_match').attr('data-status') != 1){
				if($("[name='password']").val() !=''){
					$('[name="password"],[name="cpass"]').addClass("border-danger")
					end_load()
					return false;
				}
			}
		}

		// Log form data before submitting
        var formData = new FormData($(this)[0]);
        formData.forEach(function(value, key){
            console.log(key + ": " + value);
        });


		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				console.log(resp);
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=user_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="user_email"]').addClass("border-danger")
					end_load()
					alert_toast('Email already exist!',"error");
				}
			}
			
		})
	})
</script>