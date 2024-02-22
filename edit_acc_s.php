<?php
session_start();
include_once("session.php");

$uid = $_GET['uid'];

$select = $conn->prepare("SELECT fname, mname, lname, bday, address1, gender, email, username, pword1, pword2, img_name, img_loc FROM users WHERE id = :id");
$select->bindParam(":id", $uid);
$select->execute();

while ($row = $select->fetch()) {
    $firstN = $row['fname'];
    $middle = $row['mname'];
    $last = $row['lname'];
    $birth = $row['bday'];
    $adres = $row['address1'];
    $gender = $row['gender'];
    $mail = $row['email'];
    $Username = $row['username'];
    $ps1 = $row['pword1'];
    $ps2 = $row['pword2'];
    $userImg = $row['img_name'];
    $userLoc = $row['img_loc'];
}

if (isset($_POST['update'])) {
    $firstname = $_POST['fname'];
    $middlename = $_POST['mname'];
    $lastname = $_POST['lname'];
    $BDay = isset($_POST['birth']) ? $_POST['birth'] : '';
    $Address1 = $_POST['address1'];
    $Gender = $_POST['gender'];
    $Email = $_POST['email'];
    $UserName = $_POST['uname'];
    $Password1 = ($_POST['pword']);
    $Password2 = sha1($_POST['pword']);

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
    $checkUsernameQuery->bindParam(':username', $UserName);
    $checkUsernameQuery->execute();
    $usernameCount = $checkUsernameQuery->fetchColumn();
    
    // Check if the email already exists
    $checkEmailQuery = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkEmailQuery->bindParam(':email', $Email);
    $checkEmailQuery->execute();
    $emailCount = $checkEmailQuery->fetchColumn();


    $temp = "";

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
        echo "<script>window.open('edit_acc_s.php?uid=$id','_self')</script>";
    } else {

        //image validation
        if(in_array($imgExt, $valid_ext)){
            if ($img_size < 5000000){
                move_uploaded_file($temp_img_name, $img_dir. $img_newname);
                $query = $conn->prepare("UPDATE users SET fname = :firstname, mname = :midname, lname = :lastname, bday = :bday, address1 = :address1, gender = :gender, email = :email, username = :username, pword1 = :pword1, pword2 = :pword2, img_name = :flname, img_loc = :target_file  WHERE id = :uid");
                
                
                $query->bindParam(":firstname", $firstname);
                $query->bindParam(":midname", $middlename);
                $query->bindParam(":lastname", $lastname);
                $query->bindParam(":bday", $BDay);
                $query->bindParam(":address1", $Address1);
                $query->bindParam(":gender", $Gender);
                $query->bindParam(":email", $Email);
                $query->bindParam(":username", $UserName);
                $query->bindParam(":pword1", $Password1);
                $query->bindParam(":pword2", $Password2);
                $query->bindParam(":flname", $img_newname);
                $query->bindParam(":target_file", $image_fpath);
                $query->bindParam(":uid", $uid);
                
                // Execute the query
                $query->execute();

                echo "<script>alert('Success Update')</script>";
                echo "<script>window.open('seller.php','_self')</script>";
            } else {
                echo "<script>alert('Invalid filesize. The maximum filesie=ze is 5mb.')</script>";
                echo "<script>window.open('edit_acc_s.php?uid=$id','_self')</script>";
            }
        } else{
            echo "<script>alert('Invalid filetype. Please use jpeg, jpg, png, and gif.')</script>";
            echo "<script>window.open('edit_acc_s.php?uid=$id','_self')</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="images/mifamilia_w.png"/>
        <link rel="stylesheet" href="design/register.css"/>	
        <title>Mi Familia - Edit</title>
    </head>

    <body>
        <form action="" method="post" enctype="multipart/form-data">
            <div id="register_modal" class="modal-container2">
                <div class="modal-content2">
                    <div class="modal-left2">
                        <img id="panda2" src="images/panda2.jpg" alt="Panda">
                    </div>

                    <div class="modal-right2">
                        <span id="x-button3" class="close-button2">&times;</span>
                        <div id="register-title">EDIT ACCOUNT</div>
                            <table class="register_table">
                            <tr class="table_row">
                                <td class="register_label">Firstname</td>
                                <td class="register_label">Gender</td>
                            </tr>

                            <tr>
                                <td><input type="text" name="fname" placeholder="Enter First Name" class="input_box"
                                        value="<?php echo isset($firstN) ? $firstN : ''; ?>" required></td>
                                <td><input type="radio" id="gender_f" name="gender" class="radio_btn"
                                        value="Female" <?php echo (isset($gender) && $gender === 'Female') ? 'checked' : ''; ?>
                                        required>
                                    <label for="gender_f" id="gender_f">Female</label><br>
                                    <input type="radio" id="gender_m" name="gender" class="radio_btn" value="Male"
                                        <?php echo (isset($gender) && $gender === 'Male') ? 'checked' : ''; ?> required>
                                    <label for="gender_m" id="gender_m">Male</label><br>
                                </td>
                            </tr>

                            <tr>
                                <td class="register_label">Middlename</td>
                                <td class="register_label">Username</td>
                            </tr>

                            <tr>
                                <td><input type="text" name="mname" placeholder="Enter Middlename" class="input_box"
                                        value="<?php echo isset($middle) ? $middle : ''; ?>"></td>
                                <td><input type="text" name="uname" placeholder="Enter Username" class="input_box"
                                        value="<?php echo isset($Username) ? $Username : ''; ?>" required></td>
                            </tr>

                            <tr>
                                <td class="register_label">Lastname</td>
                                <td class="register_label">Email</td>
                            </tr>

                            <tr>
                                <td><input type="text" name="lname" placeholder="Enter Last Name" class="input_box"
                                        value="<?php echo isset($last) ? $last : ''; ?>" required></td>
                                <td><input type="email" name="email" placeholder="Enter Email" class="input_box"
                                        value="<?php echo isset($mail) ? $mail : ''; ?>" required></td>
                            </tr>

                            <tr>
                                <td class="register_label">Birthday</td>
                                <td class="register_label">Password</td>
                            </tr>

                            <tr>
                                <td><input type="date" name="birth" placeholder="Enter Birthday" class="input_box"
                                        value="<?php echo isset($birth) ? $birth : ''; ?>" required></td>
                                <td><input type="password" name="pword" placeholder="Enter Password" class="input_box"
                                        value="<?php echo isset($ps1) ? $ps1 : ''; ?>" required></td>
                            </tr>

                            <tr>
                                <td class="register_label">Address</td>
                                <td class="register_label">Picture</td>
                            </tr>

                            <tr>
                                <td><input type="text" name="address1" placeholder="Enter Address" class="input_box"
                                        value="<?php echo isset($adres) ? $adres : ''; ?>" required></td>
                                <td>
                                    <input type='file' id="img" name="user_img" accept="image/*" style="display:none" class="input_box" required />
                                    <label for="img" id="img_button">Choose Image</label>
                                </td>
                                    
                            </tr>
                        </table>

                        <input type="submit" name="update" value="Update" class="submit_button">
            
                    </div>
                </div>
            </div>
        </form>
    </body>

    <script>
        // JavaScript function to close the edit_acc_s.php window and go back to seller.php
        function closeAndGoBack() {
            // Close the current window or tab
            window.close();
            // Alternatively, you can use the following to close the current window in certain browsers
            // window.open('', '_self').close();

            // Redirect to seller.php
            window.location.href = 'seller.php';
        }

        // Attach the function to the close button
        document.getElementById('x-button3').addEventListener('click', closeAndGoBack);
    </script>
