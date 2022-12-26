<?php

//厳格な変数の型チェック
declare(strict_types=1);

require_once '../vendor/autoload.php';

session_start();

if(isset($_POST['login'])){
    $user_name = (string)filter_input(INPUT_POST, 'user_name');
    $password = (string)filter_input(INPUT_POST, 'password');

    $db = new Lib\db();
    $user_id = $db->passCheck($user_name, $password);

    if($user_id !== false){

        Lib\session::login($user_id);

        header('Location: reserve.php');
        exit;
    } else {
        $err_msg = 'ユーザ名またはパスワードが異なります';
    }
}

require_once 'login.html';