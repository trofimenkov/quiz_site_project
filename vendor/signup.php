<?php
    session_start();

    require_once("connect.php");
    require_once("defines.php");

    $user_data = $_POST;

    if(isset($user_data['do_signup']))
    {
        $errors = array();
        mysqli_num_rows(checkUser($connect, $user_data['user_name'], NULL))<=0 or $errors[] = EXIST_ERROR;
        !empty($user_data['user_name']) or $errors[] = LOGIN_ERROR;
        !empty($user_data['user_password']) or $errors[] = PASSWORD_ERROR;
        $user_data['user_password'] == $user_data['user_password_confirm'] or $errors[] = PASSWORD_CONFIRM_ERROR;  
    }
    if(empty($errors))
    {
        addUser($connect, $user_data['user_name'], md5($user_data['user_password']));
        $_SESSION['message'] = SIGNUP_DONE;
        header('Location: ../index.php');
    }
    else {
        $_SESSION['message'] = array_shift($errors);
        header('Location: ../register.php');
    }
?>