<?php

namespace Conf;

enum param {
  //DB接続情報
  public const DSN = 'mysql:dbname=/* DB名 */;host=localhost;charset=utf8;';
  public const DB_USER = /* DBユーザ名 */;
  public const DB_PASS = /* DBパスワード */;

  //sessionのタイムアウト時間　単位は秒
  public const SESSION_TIMEOUT = 300;
}