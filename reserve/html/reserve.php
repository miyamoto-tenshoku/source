<?php

//厳格な変数の型チェック
declare(strict_types=1);

require_once '../vendor/autoload.php';

session_start();

if(! Lib\session::check()){
    header('Location: logout.php');
    exit;
}

$week = filter_input(INPUT_GET, 'week', FILTER_VALIDATE_INT ,[
            'options' => [
                'default'=>0,
            ]
        ]);

$date = new DateTime('today');
$date->modify(sprintf('%+d week', $week));

//月曜日に日付を変更
$date->modify(sprintf('%+d day', 1-$date->format('w')));
$monday = clone $date;

//金曜日に日付を変更
$date->modify('+4 day');
$friday = clone $date;

$db = new Lib\db();
$schedules = $db->scheduleOut($monday, $friday);

//日時の文字列をdatatimeクラスに変換
foreach(array_keys($schedules) as $key){
    $schedules[$key]['start'] = new DateTime($schedules[$key]['start']);
    $schedules[$key]['end'] = new DateTime($schedules[$key]['end']);
}

//トークンの発行
$_SESSION['token'] = bin2hex(random_bytes(24));

//エラーメッセージの表示処理
if(isset($_SESSION['err_msg'])){
    $e = 'Lib\lib::e';

    echo <<< EOM
    <script>
        window.addEventListener("load", function() {
            alert("{$e($_SESSION['err_msg'])}")
        })
    </script>
    EOM;

    unset($_SESSION['err_msg']);
}

require_once 'reserve.html';