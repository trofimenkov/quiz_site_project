<?php 
    session_start();
    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("BASE", "db_school");
    $connect = mysqli_connect(HOST, USER, PASSWORD, BASE) or die('error connect');
    mysqli_set_charset($connect, 'utf8') or die('error charset');
    function closeConnection($connect) {
        mysqli_close($connect); 
    }
    function addUser($connect, $user_name, $user_password) {
        mysqli_query($connect, "INSERT INTO `users`(`user_id`, `user_name`, `user_password`) VALUES (NULL,'$user_name','$user_password')");
    }
    function checkUser($connect, $user_name, $user_password = NULL){
        return $user_password==NULL?mysqli_query($connect, "SELECT * FROM `users` WHERE `user_name` = '$user_name'"):
            mysqli_query($connect, "SELECT * FROM `users` WHERE `user_name` = '$user_name' AND `user_password` = '$user_password'");
    }
    function startUserSession($user_id, $user_name, $user_admin) {
            $_SESSION['user'] = array(
                "id" => $user_id,
                "name" => $user_name,
                "admin" => $user_admin
            );
    }
?>