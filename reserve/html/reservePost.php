<?php

//厳格な変数の型チェック
declare(strict_types=1);

require_once '../vendor/autoload.php';

session_start();

if(! Lib\session::check()){
    header('Location: logout.php');
    exit;
}

//トークンチェック
$token = (string)filter_input(INPUT_POST, 'token');
if(
    ! isset($_SESSION['token'])
    || $token !== $_SESSION['token']
){
    header('Location: logout.php');
    exit;
}

$db = new Lib\db();

//スケジュールの削除処理
if(isset($_POST['delete'])){

    $schedule_id = (string)filter_input(INPUT_POST, 'schedule_id');
    $db->scheduleDelete($schedule_id , $_SESSION['user_id']);

//スケジュールの登録処理
} else if (isset($_POST['register'])){
    $start = (string)filter_input(INPUT_POST, 'start');
    $end = (string)filter_input(INPUT_POST, 'end');
    $memo = (string)filter_input(INPUT_POST, 'memo');

    $err_msg = [];

    if(! Lib\validate::datatime($start)){
        $err_msg[]= '予約開始時刻に誤りがあります';
    }

    if(! Lib\validate::datatime($end)){
        $err_msg[]= '予約終了時刻に誤りがあります';
    }

    if(! Lib\validate::memo($memo)){
        $err_msg[]= '備考への入力文字が多すぎます';
    }

    if(! $db->overlapCheck($start, $end)){
        $err_msg[]= '重複している予定があります';
    }

    if(count($err_msg) === 0){
        $db->scheduleRegist($start, $end, $memo, $_SESSION['user_id']);
    }else {
        $_SESSION['err_msg'] = '';
        foreach($err_msg as $msg){
            $_SESSION['err_msg'] .= $msg.'\n';
        }
    }
}

$week = filter_input(INPUT_POST, 'week', FILTER_VALIDATE_INT ,[
    'options' => [
        'default'=>0,
    ]
]);

header(sprintf('Location: reserve.php?week=%s', Lib\lib::e($week)));
exit;