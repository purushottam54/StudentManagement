<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;
	public function __construct() {
	ob_start();
   	include 'db_connect.php';
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
			$qry = $this->db->query("SELECT *, concat(user_name,' ',user_surname) as name FROM users where user_email = '".$email."' and user_password = '".$password."'  ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'user_password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 2;
		}
	}



	public function print_letter() {

		include 'db_connect.php';
		extract($_POST);
		$qry3 = $conn->query("SELECT *  FROM gpd_users  WHERE user_id = ( SELECT letter_creator_user_id FROM gpd_letters WHERE letter_id = ".$letter_id.")")->fetch_array();
		foreach($qry3 as $k => $v){
			$$k = $v;
		}
		if ($user_type_id == 2) {
			$qry2 = $conn->query("SELECT *  FROM gpd_teacher  WHERE user_id = ( SELECT letter_creator_user_id FROM gpd_letters WHERE letter_id = ".$letter_id.")")->fetch_array();
		}elseif($user_type_id == 3)
		{
			$qry2 = $conn->query("SELECT *  FROM gpd_hod  WHERE user_id = ( SELECT letter_creator_user_id FROM gpd_letters WHERE letter_id = ".$letter_id.")")->fetch_array();
		}
		$qry = $conn->query("SELECT * FROM gpd_letters where letter_id = ".$letter_id)->fetch_array();

		foreach($qry as $k => $v){
			$$k = $v;
		}
		foreach($qry2 as $k => $v){
			$$k = $v;
		}

		include './letters/index.php';
        return json_encode($letter_content);
    }
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function save_user(){
		$department = 0;
		$eemail = "";
		$user_type = "";
		$user_id = "";
		extract($_POST);
		$data = "";
		
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if($k == "department") {
					$department = $v;
					continue;
				} else {
					if($k == "user_email") {
						$eemail = $v;   
					}
					if($k == "user_type_id") {
						$user_type = $v;
					}
					if(empty($data)){
						$data .= " $k='$v' ";
					} else {
						$data .= ", $k='$v' ";
					}
				}
			}
		}
		
		if(!empty($password)){
			$data .= ", user_password=md5('$password') ";
		}
		$user_id = $id;
		$check = $this->db->query("SELECT * FROM gpd_users where user_email ='$eemail' ".(!empty($id) ? " and user_id != {$id} " : ''))->num_rows;
		
		if($check > 0){
			return 2;
			exit;
		}
		
		if(isset($_FILES['user_profile_pic']) && $_FILES['user_profile_pic']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['user_profile_pic']['name'];
			$move = move_uploaded_file($_FILES['user_profile_pic']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", user_profile_pic = '$fname' ";
		}
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO gpd_users SET $data");
			$qry =  $this->db->query("SELECT user_id FROM gpd_users WHERE user_email = '$eemail'");
			
			if ($qry->num_rows > 0) {
				$row = $qry->fetch_assoc();
				$user_id = $row['user_id'];
				
				if ($user_type == "2" ) {
					$save = $this->db->query("INSERT INTO gpd_teacher (teacher_id, user_id, department_id) VALUES (NULL, $user_id, $department)");
				} elseif ($user_type == "3" ) {
					$save = $this->db->query("INSERT INTO gpd_hod (hod_id, user_id, department_id) VALUES (NULL, $user_id, $department)");
				}
			} else {
				return null;
			}
		} else {
			$save = $this->db->query("UPDATE gpd_users SET $data WHERE user_id = $id");
			$qry = $this->db->query("SELECT * FROM gpd_teacher WHERE user_id = '$id'");
			$qry2 = $this->db->query("SELECT * FROM gpd_hod WHERE user_id = '$id'");
			if (!($qry->num_rows > 0)) {
				if ($user_type == "2" ) {
					$save = $this->db->query("INSERT INTO gpd_teacher (teacher_id, user_id, department_id) VALUES (NULL, '$user_id', '$department')");
				}
			}
			else{
				if($user_type == 2 )
					$save = $this->db->query("UPDATE gpd_teacher SET department_id = $department WHERE user_id = $id");
			}
			if (!($qry2->num_rows > 0)) {
				if ($user_type == "3" ) {
					$save = $this->db->query("INSERT INTO gpd_hod (hod_id, user_id, department_id) VALUES (NULL, '$user_id', '$department')");
				}
			}
			else{
				if($user_type == 3 )
				$save = $this->db->query("UPDATE gpd_hod SET department_id = $department WHERE user_id = $id"); 
			}
		}
		if($save){
			return 1;
		} else {
			return "error";
		}
	}
	
	function signup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
				if($k =='password'){
					if(empty($v))
						continue;
					$v = md5($v);

				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}

		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['user_profile_pic']) && $_FILES['user_profile_pic']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['user_profile_pic']['name'];
			$move = move_uploaded_file($_FILES['user_profile_pic']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", user_profile_pic = '$fname' ";
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_user_id'] = $id;
				if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('user_id','user_password','table','user_password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}

		// echo "user id is {$user_id}";
		$check = $this->db->query("SELECT * FROM gpd_users where user_email ='$user_email' ".(!empty($user_id) ? " and user_id != {$user_id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['user_profile_pic']) && $_FILES['user_profile_pic']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['user_profile_pic']['name'];
			$move = move_uploaded_file($_FILES['user_profile_pic']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", user_profile_pic = '$fname' ";
		}
		if(!empty($user_password))
			$data .= " ,user_password=md5('$user_password') ";
		// echo "This is userid {$user_id}";
		if(empty($user_id)){
			$save = $this->db->query("INSERT INTO gpd_users set $data");
		}else{
			$save = $this->db->query("UPDATE gpd_users set $data where user_id = $user_id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'user_password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM gpd_users where user_id = '$id'");
		if($delete)
			return 1;
	}
	function save_system_settings(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if($_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fname);
			$data .= ", cover_img = '$fname' ";
		}
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set $data where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set $data");
		}
		if($save){
			foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					$_SESSION['system'][$k] = $v;
				}
			}
			if($_FILES['cover']['tmp_name'] != ''){
				$_SESSION['system']['cover_img'] = $fname;
			}
			return 1;
		}
	}
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));
			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;
			}
		}
	}
	function save_project() {
		extract($_POST);
		$data = [];
		$data2 = "";
		$manage = "";
		foreach ($_POST as $k => $v) {
			if ($k === 'name' || $k === 'material_id') {
				continue;
			}
			if (empty($data2)){
				$data2 .= " $k='$v' ";
			} else {
				$data2 .= ", $k='$v' ";
			}
			$data[$k] = $v;
		}
		$save = false;
		if(isset($_FILES['material_path']) && $_FILES['material_path']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['material_path']['name'];
			$move = move_uploaded_file($_FILES['material_path']['tmp_name'],'./assets/uploads/materials/'. $fname);
			$data["material_path"] = $fname;
		}
		if ($material_id == '#') {
			$columns = implode(", ", array_keys($data));
			$values = "'" . implode("', '", array_values($data)) . "'";
			
			$sql = "INSERT INTO material ($columns) VALUES ($values)";
			// return $sql;
			$save = $this->db->query($sql);
		} else {
			$sql = "UPDATE gpd_letters SET $data2 WHERE letter_id = $letter_id";
			$save = $this->db->query($sql);
		}

		return $save ? 1 : 2;
	}
	
	function delete_project(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM gpd_letters where letter_id = $id");
		if($delete){
			return 1;
		}
	}
	function save_task(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('letter_id')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($letter_id)){
			return 2;
		}else{
			$save = $this->db->query("UPDATE gpd_letters set $data where letter_id = $letter_id");
		}
		if($save){
			return 1;
		}
	}
	function delete_task(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM gpd_letters where letter_id = $letter_id");
		if($delete){
			return 1;
		}
	}
	function save_progress(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'comment')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$dur = abs(strtotime("2020-01-01 ".$end_time)) - abs(strtotime("2020-01-01 ".$start_time));
		$dur = $dur / (60 * 60);
		$data .= ", time_rendered='$dur' ";
		// echo "INSERT INTO user_productivity set $data"; exit;
		if(empty($id)){
			$data .= ", user_id={$_SESSION['login_user_id']} ";
			
			$save = $this->db->query("INSERT INTO user_productivity set $data");
		}else{
			$save = $this->db->query("UPDATE user_productivity set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_progress(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM user_productivity where id = $id");
		if($delete){
			return 1;
		}
	}
	function get_report(){
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id where date(t.date_created) between '$date_from' and '$date_to' order by unix_timestamp(t.date_created) desc ");
		while($row= $get->fetch_assoc()){
			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
			$row['name'] = ucwords($row['name']);
			$row['adult_price'] = number_format($row['adult_price'],2);
			$row['child_price'] = number_format($row['child_price'],2);
			$row['amount'] = number_format($row['amount'],2);
			$data[]=$row;
		}
		return json_encode($data);

	}
}