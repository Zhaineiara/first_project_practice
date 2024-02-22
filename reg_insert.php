<?php
include_once("connection.php");

if(isset($_POST['register'])){
    //Variables
    $fname = $_POST['fname'];
    $mname = $_POST['mname']; 
    $lname = $_POST['lname']; 
    $btday = $_POST['birth']; 
    $adres = $_POST['add'];
    $gender = $_POST['gender'];
    $username = $_POST['uname'];
    $email = $_POST['email']; 
    $pword1 =  ($_POST['pword']);
    $pword2 =  sha1($_POST['pword']);

    //for image
    $img_name = $_FILES['user_img']['name'];
    $temp_img_name = $_FILES['user_img']['tmp_name'];
    $img_size = $_FILES['user_img']['size'];

    $img_dir = "images/user/";
    $imgExt = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    $valid_ext = array('jpeg', 'jpg', 'png', 'gif');
    $img_newname = rand(1000,1000000000) . "." . $imgExt;
    $image_fpath = $img_dir . $img_newname;

    // Check if the username already exists
    $checkUsernameQuery = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $checkUsernameQuery->bindParam(':username', $username);
    $checkUsernameQuery->execute();
    $usernameCount = $checkUsernameQuery->fetchColumn();

    // Check if the email already exists
    $checkEmailQuery = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkEmailQuery->bindParam(':email', $email);
    $checkEmailQuery->execute();
    $emailCount = $checkEmailQuery->fetchColumn();

    // Check if the firstname is one character
    $checkfnameQuery = $conn->prepare("SELECT COUNT(*) FROM users WHERE fname = :firstname");
    $checkfnameQuery->bindParam(':firstname', $fname);
    $checkfnameQuery->execute();
    $firstnameCount = $checkfnameQuery->fetchColumn();

    // Check if the lastname is one character
    $checklnameQuery = $conn->prepare("SELECT COUNT(*) FROM users WHERE lname = :lastname");
    $checklnameQuery->bindParam(':lastname', $lname);
    $checklnameQuery->execute();
    $lastnameCount = $checklnameQuery->fetchColumn();


    $temp = "";
    $name = "";
    $length_fname = strlen($firstnameCount);
    $length_lname = strlen($lastnameCount);

    if($usernameCount > 0){
        $temp .= "Username";
    }

    if($emailCount > 0){
        if(strlen($temp) > 0){
            $temp .= " and ";
        }
        $temp .= "Email";
    }

    if(strlen($temp) > 0){
        echo "<script>alert('$temp already exists. Please use a different $temp.')</script>";
        echo "<script>window.open('register.php','_self')</script>";
    } else {

        //image validation
        if(in_array($imgExt, $valid_ext)){
            if ($img_size < 5000000){
                move_uploaded_file($temp_img_name, $img_dir. $img_newname);
                $query = $conn->prepare("INSERT INTO users (fname, mname, lname, bday, address1, gender, email, username, pword1, pword2, img_name, img_loc) VALUES (:firstname, :midname, :lastname, :bday, :address1, :gender, :email, :username, :pword1, :pword2, :flname, :target_file)");
                $query->bindParam(":firstname", $fname);
                $query->bindParam(":midname", $mname);
                $query->bindParam(":lastname", $lname);
                $query->bindParam(":bday", $btday);
                $query->bindParam(":address1", $adres);
                $query->bindParam(":gender", $gender);
                $query->bindParam(":email", $email);
                $query->bindParam(":username", $username);
                $query->bindParam(":pword1", ($pword1));
                $query->bindParam(":pword2", ($pword2));
                $query->bindParam(":flname", $img_newname);
                $query->bindParam(":target_file", $image_fpath);
                // Execute the query
                $query->execute();
                echo "<script>window.open('success_reg.php','_self')</script>";
            } else {
                echo "<script>alert('Invalid filesize. The maximum filesie=ze is 5mb.')</script>";
                echo "<script>window.open('register.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Invalid filetype. Please use jpeg, jpg, png, and gif.')</script>";
            echo "<script>window.open('register.php','_self')</script>";
        }
        
    }
}

?>




