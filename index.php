<?php
include_once("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="images/mifamilia_w.png"/>
        <link rel="stylesheet" href="design/front-design.css"/>	
        <title>Mi Familia</title>
    </head>

    <body>
            <header>
                <!--MI familia title at center-->
                <div 
                    id="title">
                    MI FAMILIAAAA
                </div>

                <!--MI familia tagline-->
                <div 
                    id="tagline">
                    Sip, Savor, and Celebrate
                </div>

                <!--3 buttons header-->
                <nav class="navigation">
                    <a id="home-btn" class="first_header_button" href="index.php">Home</a>
                    <a id="about-btn" class="first_header_button" href="about.php">About</a>
                    <button id="login-btn" class="second_header_button" href="index.php">LOGIN</button>

                </nav>

                <div id="overlay"></div>

                <form action="login_validation.php" method="post">
                    <div id="login_modal" class="modal-container">
                        <div class="modal-content">
                            <div class="modal-left">
                                <img id="panda" src="images/panda.jpg" alt="Panda">
                            </div>

                            <div class="modal-right">
                                <span id="x-button1" class="close-button">&times;</span>
                                <div id="login-title">LOG IN</div>

                                <div class="description">Email</div>
                                <div class="input-container">
                                    <input type="text" placeholder="Enter your email" name="email" required>
                                    <div class="icon">
                                        <img src="feather-light/mail.svg" alt="Mail icon">
                                    </div>
                                </div>

                                <div class="description">Password</div>
                                <div class="input-container">
                                    <input type="password" placeholder="Enter your password" name="pword" required>
                                    <div class="icon">
                                        <img src="feather-light/lock.svg" alt="Lock icon">
                                    </div>
                                </div>

                                <a href="forgot_ps.php" class="forgot-password">Forgot password?</a>

                                <input type="submit" name="login" class="login-button" value="Log in">

                                <div class="register-description">Don't have an account? <a href="register.php" id="highlight"><span>Register now</span></a></div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </header>
    </body>
    <script src="process/myscript/script.js"></script>
</html>