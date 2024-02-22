<?php
// Assuming $conn is your database connection
include_once("connection.php");

// Get the user ID from the query parameters (replace with your actual parameter name)
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch user data based on the provided user ID
    $userQuery = $conn->prepare("
        SELECT fname, lname, address1, gender, bday, username, email, img_loc
        FROM users
        WHERE id = :user_id
    ");
    $userQuery->bindParam(':user_id', $userId);
    $userQuery->execute();
    $userData = $userQuery->fetch(PDO::FETCH_ASSOC);
    
    if (!$userData) {
        // Handle the case when user is not found
        echo 'User not found.';
        exit();
    }
} else {
    // Handle the case when user_id is not provided
    echo 'User ID not provided.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/mifamilia_w.png"/>
    <link rel="stylesheet" href="design/view-cus-profile.css"/>
    <title>Mi Familia - Register</title>
</head>

<body>
    <form action="reg_insert.php" method="post" enctype="multipart/form-data">
        <div id="register_modal" class="modal-container2">
            <div class="modal-content2">
                <div class="modal-left2">
                    <img id="panda2" src="images/panda2.jpg" alt="Panda">
                </div>

                <div class="modal-right2">
                    <span id="x-button2" class="close-button2">&times;</span>

                    <div id="register-title">CUSTOMER PROFILE</div>

                    <table class="register_table">
                        <tr>
                            <td colspan="3"><img id="cus_pic" src="<?= $userData['img_loc'] ?>" alt="Cutomer Picture" height="250px" width="250px"></td>
                        </tr>

                        <tr>
                            <td class="first-c-label">Fullname</td>
                            <td class="sec-c-label">:</td>
                            <td class="third-c-label"><?= $userData['fname'] . ' ' . $userData['lname'] ?></td>
                        </tr>

                        <tr>
                            <td class="first-c-label">Address</td>
                            <td class="sec-c-label">:</td>
                            <td class="third-c-label"><?= $userData['address1'] ?></td>
                        </tr>

                        <tr>
                            <td class="first-c-label">Gender</td>
                            <td class="sec-c-label">:</td>
                            <td class="third-c-label"><?= $userData['gender'] ?></td>
                        </tr>

                        <tr>
                            <td class="first-c-label">Birthday</td>
                            <td class="sec-c-label">:</td>
                            <td class="third-c-label"><?= date('F j, Y', strtotime($userData['bday'])) ?></td>
                        </tr>

                        <tr>
                            <td class="first-c-label">Username</td>
                            <td class="sec-c-label">:</td>
                            <td class="third-c-label"><?= $userData['username'] ?></td>
                        </tr>

                        <tr>
                            <td class="first-c-label">Email</td>
                            <td class="sec-c-label">:</td>
                            <td class="third-c-label"><?= $userData['email'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</body>
</html>


<script>
    console.log("Script is running");
    var closeModalButton2 = document.getElementById("x-button2");
    closeModalButton2.addEventListener("click", function() {
    window.location.href = "order.php";
    });
</script>