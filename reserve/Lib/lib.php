<?php

namespace Lib;

class lib{
    //エスケープ処理を行う関数
    static function e($str):string{
        return htmlspecialchars($str, ENT_QUOTES|ENT_HTML5, 'UTF-8', false);
    }
}

