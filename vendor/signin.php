<?php
    session_start();
    
    require_once("connect.php");
    require_once("defines.php");

    $user_data = $_POST;

    if(isset($user_data['do_signin']))
    {
        $user_query = checkUser($connect, $user_data['user_name'], md5($user_data['user_password']));

        if(mysqli_num_rows($user_query)>0){
            $user = mysqli_fetch_assoc($user_query);
            startUserSession($user['user_id'], $user['user_name'], $user['user_admin']);
            Header('Location: ../');
        }
        else {
            $_SESSION['message'] = SIGNIN_FAILED;
            Header('Location: ../index.php');
        }
    }
    
?>