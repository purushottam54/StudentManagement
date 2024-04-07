<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where user_id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="user_id" value="<?php echo isset($meta['user_id']) ? $meta['user_id']: '' ?>">
		<div class="form-group">
			<label for="name">First Name</label>
			<input type="text" name="user_name" id="firstname" class="form-control" value="<?php echo isset($meta['user_name']) ? $meta['user_name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">Last Name</label>
			<input type="text" name="user_surname" id="lastname" class="form-control" value="<?php echo isset($meta['user_surname']) ? $meta['user_surname']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="text" name="user_email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="user_password" id="password" class="form-control" value="" autocomplete="off">
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		</div>
		<div class="form-group">
			<label for="" class="control-label">user profile</label>
			<div class="custom-file">
              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
		</div>
		<div class="form-group d-flex justify-content-center">
			<img src="<?php echo isset($meta['user_profile_pic']) ? 'assets/uploads/'.$meta['user_profile_pic'] :'' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
		</div>
		

	</form>
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
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}


	var email = $('#email').val().trim();
    var password = $('#password').val().trim();

    // Set trimmed values back to the input fields
    $('#email').val(email);
    $('#password').val(password);
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				console.log(resp);
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_load()
				}
			}
		})
	})

</script>