<?php
include_once("connection.php");

if(isset($_SESSION['cid'])){
	$uid = $_SESSION['cid'];
	$userQuery = $conn->prepare("SELECT id, fname, mname, lname, bday, address1, gender, email, username, pword2, img_loc, user_role FROM users WHERE id = :uid");
	$userQuery->bindParam(':uid', $uid);
	$userQuery->execute();
	
	while($data = $userQuery->fetch()){
		$id = $data['id'];
		$first_name = $data['fname'];
		$mid_name = $data['mname'];
		$last_name = $data['lname'];
		$birth_day = $data['bday'];
		$address = $data['address1'];
		$gender = $data['gender'];
		$email = $data['email'];
		$uname = $data['username'];
		$psword = $data['pword2'];
		$user_pic = $data['img_loc'];
		$userrole = $data['user_role'];
	}
} else {
	header("Location:index.php");
	die();
}
?>

