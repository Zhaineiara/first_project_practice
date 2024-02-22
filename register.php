<?php
include_once("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="images/dazai.png"/>
        <link rel="stylesheet" href="design/register.css"/>	
        <title>Mi Familia - Register</title>
    </head>

    <body>
        <form action="reg_insert.php" method="post" enctype="multipart/form-data">
            <div id="register_modal" class="modal-container2">
                <div class="modal-content2">
                    <div class="modal-left2">
                        <img id="panda2" src="images/girl.jpg" alt="Panda">
                    </div>

                    <div class="modal-right2">
                        <span id="x-button2" class="close-button2">&times;</span>
                        <div id="register-title">REGISTER</div>

                            <table class="register_table">
                                <!--1st column-->
                                <tr class="table_row">
                                    <td class="register_label">Firstname</td>
                                    <td class="register_label">Gender</td>
                                </tr>
                                
                                <tr>
                                    <td><input type="text" name="fname" placeholder="Enter First Name" class="input_box" required>      
                                    <td><input type="radio" id="gender_f" name="gender" class="radio_btn" value="Female" required>
                                    <label for="gender_f" id="gender_f">Female</label><br>                           
                                    <input type="radio" id="gender_m" name="gender" class="radio_btn" value="Male" required>
                                    <label for="gender_m" id="gender_m">Male</label><br></td>
                                </tr>

                                <tr>
                                    <td class="register_label">Middlename</td>
                                    <td class="register_label">Username</td>
                                </tr>

                                <tr>
                                    <td><input type="text" name="mname" placeholder="Enter Middlename" class="input_box"></td>
                                    <td><input type="text" name="uname" placeholder="Enter Username" class="input_box" required></td>
                                </tr>

                                <tr>
                                    <td class="register_label">Lastname</td>
                                    <td class="register_label">Email</td>
                                </tr>

                                <tr>
                                    <td><input type="text" name="lname" placeholder="Enter Last Name" class="input_box" required></td>
                                    <td><input type="email" name="email" placeholder="Enter Email" class="input_box" required></td>
                                </tr>

                                <tr>
                                    <td class="register_label">Birthday</td>
                                    <td class="register_label">Password</td>
                                </tr>

                                <tr>
                                    <td><input type="date" name="birth" placeholder="Enter Birthday" class="input_box" required></td>
                                    <td><input type="password" name="pword" placeholder="Enter Password" class="input_box" required></td>
                                </tr>

                                <tr>
                                    <td class="register_label">Address</td>
                                    <td class="register_label">Picture</td>
                                </tr>

                                <tr>
                                    <td><input type="text" name="add" placeholder="Enter Address" class="input_box" required></td>
                                    <td><input type='file' id="img" name= "user_img" accept= image/* style="display:none" class="input_box" required/>
                                    <label for="img" id="img_button">Choose Image</label></td>
                                </tr>

                            </table>
                        <input type="submit" name="register" value="Submit" class="submit_button">
            
                    </div>
                </div>
            </div>
        </form>
    </body>

    <script>
        console.log("Script is running");
        var closeModalButton2 = document.getElementById("x-button2");
        closeModalButton2.addEventListener("click", function() {
        window.location.href = "index.php";
        });
    </script>
</html>