<?php

namespace Lib;

class validate{

    //日付の整合性をチェックする関数
    static function datatime(string $str): bool{
        if(!preg_match('#\A\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:00\z#u', $str)){
            return false;
        }

        $y = substr($str, 0, 4);
        $m = substr($str, 5, 2);
        $d = substr($str, 8, 2);

        if(!checkdate($m, $d, $y)){
            return false;
        }

        $h = (int)substr($str, 11, 4);
        if($h<9 || $h>18){
            return false;
        }

        $i = substr($str, 14, 2);
        if( $i !== '00' && $i !== '30'){
            return false;
        }

        return true;

    }

    //文字列がTEXTの容量を超えていないかチェックする関数
    static function memo(string $str): bool{

        //MariaDB TEXTの最大サイズ
        define('TEXT_MAX', 65535);

        if(strlen($str) > TEXT_MAX){
            return false;
        }

        return true;
    }
}