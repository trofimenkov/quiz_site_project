<?php 
session_start();
require_once "vendor/connect.php";
require_once "vendor/defines.php";

if(isset($_SESSION['user'])) Header("Location: /profile.php");

?>
<html>
    <head>
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <div class="header_wrapper"> <?php include "templates/header.php"; ?> </div>
        <div class="auth_wrapper">
            <form action="vendor/signup.php" method="post">
                <h1>Створення аккаунту</h1>
                <label>Логін</label>
                <input type="text" name="user_name" placeholder="Логін">
                <label>Пароль</label>
                <input type="password" name="user_password" placeholder="Пароль">
                <label>Підтвердіть пароль</label>
                <input type="password" name="user_password_confirm" placeholder="Пароль">
                <button type="submit" name="do_signup">Створити</button>
                <p>Вже зареєстровані? - <a href="/index.php">Авторизуватись</a></p>
                <?php
                    if($_SESSION['message']) {
                        if($_SESSION['message']!=EXIST_ERROR) {
                            echo '<p class="msg_error"> '. $_SESSION['message'] .' </p>'; } 
                        else {
                            echo '<p class="msg_alert"> '. $_SESSION['message'] .' </p>'; } }
                    unset($_SESSION['message']);
                ?>
            </form>
        </div>
    </body>
</html>