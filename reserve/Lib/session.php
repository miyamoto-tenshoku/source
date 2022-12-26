<?php

namespace Lib;

require_once '../vendor/autoload.php';

class session {

    //ログイン処理を行う関数
    static function login (int $user_id): void{
        //セッションIDの固定化対策
        session_regenerate_id(true);

        //セッション値になんか入れる
        $_SESSION['user_id'] = $user_id;
        $_SESSION['time'] = time();
    }

    //ログイン処理が行われているか、また
    //セッションのタイムアウト時間が経過していないかチェックする関数
    //どちらも満たしている場合はtrue、そうれない場合はfalseを返す
    static function check (): bool{
        $now = time();

        if(! isset($_SESSION['time'])){
            return false;
        }

        if(\Conf\param::SESSION_TIMEOUT < ($now - $_SESSION['time'])){
            return false;
        }

        $_SESSION['time'] = $now;
        return true;
    }
}