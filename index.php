<?php 
session_start();
require_once "vendor/connect.php";
require_once "vendor/defines.php";

if(isset($_SESSION['user'])) Header("Location: /profile.php");

$currentPage = 'home';

?>
<html>
    <head>
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <div class="header_wrapper"> <?php include "templates/header.php"; ?> </div>
        <div class="auth_wrapper">
            <form action="vendor/signin.php" method="post">
                <h1>Авторизація</h1>
                <label>Логін</label>
                <input type="text" name="user_name" placeholder="Логін">
                <label>Пароль</label>
                <input type="password" name="user_password"  placeholder="Пароль">
                <button type="submit" name="do_signin">Увійти</button>
                <p>Не зареєстровані? - <a href="/register.php">Створити аккаунт</a></p>
                <?php
                    if($_SESSION['message']) {
                        if($_SESSION['message']!=SIGNUP_DONE) {  
                            echo '<p class="msg_error"> '. $_SESSION['message'] .' </p>'; } 
                        else {
                            echo '<p class="msg_done"> '. $_SESSION['message'] .' </p>'; } }
                    unset($_SESSION['message']);
                ?>
            </form>
        </div>
    </body>
    
</html>