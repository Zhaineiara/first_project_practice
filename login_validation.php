<?php
include_once("connection.php");
if(isset($_POST['login'])){
	
	$mail = $_POST['email'];
	$password = sha1($_POST['pword']);
	
	session_start();
	
	$statement = $conn->prepare("SELECT id, user_role FROM users WHERE email = :mail AND pword2 = :psword order by id asc");
	$statement->bindParam(':mail',$mail);
	$statement->bindParam(':psword',$password);
	$statement->execute();
	
	$count = $statement->rowCount();
	
	if($count > 0){
		while($row = $statement->fetch()){
			$id = $row['id'];
			$_SESSION['cid'] = $id;

			$userrole = $row['user_role'];
			$_SESSION['UserRole'] = $userrole;
            if($_SESSION['UserRole'] =='A'){
                header("Location:seller.php");
				exit();
            }else{
                header("Location:buyer.php");}		
				exit();
		}
	} else {
		echo "<script>alert('Sorry, Wrong Username or Password')</script>";
		echo "<script>window.open('index.php','_self')</script>";
	}
	
}
?>
