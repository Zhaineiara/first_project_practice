<?php
session_start();
include_once("session.php");
?>

        <div class="upper">
            <div class="first_header">
                <!--1st column-->
                <img id="buyer_img" src="<?php echo $user_pic ?>" alt="Seller Image" width="40px" height="40px">

                <!--?php foreach ($data as $user): ?>
                    <img id="buyer_img" src="<php echo $user['img_loc'] ?>" alt="Seller Image" width="40px" height="40px">
                <php endforeach; ?-->

                <!--2nd column-->
                <div class="acc-dropdown">
                <button class="acc-btn"><?php echo $first_name . ' ' . $last_name; ?></button>

                    <!--?php foreach ($data as $user): ?>
                        <button class="acc-btn"><php echo $user['fname'] . ' ' . $user['lname']; ?></button>
                    <php endforeach; ?-->
                    <div class="acc-dropdown-content">
                        <a id="edit-profile" href="edit_acc_b.php?uid=<?php echo $id;?>">Edit Profile</a>
                        <a id="logout-profile" href="logout.php">Logout</a>
                    </div>
                </div>

                <!--3rd column-->
                <img id="logo_img" src="images/mifamilia_w.png" alt="Panda" width="70px">

                <!--4th column-->
                <div class="search-container">
                    <input type="text" placeholder="Search...">
                    <button class="search-button"><img src="feather-light/search.svg" alt="Mail icon" class="header-icon"></button>
                </div>

                <!--5th column-->
                <div class="bag-container">
                    <button id="bag-button"><img src="feather-light/shopping-bag.svg" alt="Mail icon" class="header-icon"></button>
                </div>

                <!--6th column-->
                <div class="cart-container">
                    <button id="cart-button"><img src="feather-light/shopping-cart.svg" alt="Mail icon" class="header-icon"></button>
                </div>
            </div>

            <div class="second_header">
                <!--1st column-->
                <div class="sec.content-container">
                    <button id="menu-button">Menu</button>
                </div>

                <!--2nd column-->
                <div class="sec.content-container">
                    <button id="silog-button">Silog Meals</button>
                </div>

                <!--3rd column-->
                <div class="sec.content-container">
                    <button id="snack-button">Snacks</button>
                </div>

                <!--4th column-->
                <div class="sec.content-container">
                    <button id="drink-button">Drinks</button>
                </div>

                <!--5th column-->
                <div class="sec.content-container">
                    <button id="additional-button">Additionals</button>
                </div>


            </div>
        </div>
