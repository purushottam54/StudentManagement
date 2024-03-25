<?php
include 'db_connect.php';

// Fetch user data
$qry = $conn->query("SELECT * FROM users where user_id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
    $$k = $v;
}


// Include additional PHP file
include 'new_user.php';
?>
