<?php

namespace Lib;

require_once '../vendor/autoload.php';

class db {

    private $dbh;

    //インスタンス生成時にDBへ接続
    function __construct() {
        try {
            //PDOオプション値
            $opt = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                //エラーが発生した場合例外をスロー

                \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
                //複文の実行を禁止

                \PDO::ATTR_EMULATE_PREPARES => false,
                //動的プレースフォルダを禁止
            ];

            $this->dbh = new \PDO(\Conf\param::DSN, \Conf\param::DB_USER,
                                        \Conf\param::DB_PASS, $opt);

        }catch (\PDOException $e){
            exit('データベースの接続に失敗しました');
        }
    }

    //ユーザ名とパスワードを登録されているものと合致するgあチェックする関数
    //合致した場合はuser_idを、そうでない場合はfalseを返す
    function passCheck(string $user_name, string $password): bool|int{
        try{
            $sql = <<< EOM
            SELECT * FROM users WHERE name = :name ;
            EOM;

            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':name', $user_name, \PDO::PARAM_STR);
            $sth->execute();
            $result = $sth->fetch(\PDO::FETCH_ASSOC);

            if (
                $result !== false
                && password_verify($password, $result['password'])
            ){
                return $result['user_id'];
            } else {
                return false;
            }

        }catch (\PDOException $e){
            exit('データベース処理エラー');
        }
    }

    //$start～$endの間に存在するスケジュールを返す関数
    function scheduleOut(\DateTime $start, \DateTime $end): array{
        try{
            $sql = <<< EOM
            SELECT S.id, S.start, S.end, S.memo, S.user_id, U.name
            FROM schedules AS S INNER JOIN users AS U
            ON S.user_id = U.user_id
            WHERE S.start >= :start AND S.end <= :end
            ORDER BY S.start ASC
            ;
            EOM;

            $sth = $this->dbh->prepare($sql);

            $sth->bindValue(':start', $start->format('Y-m-d').' 09:00', \PDO::PARAM_STR);
            $sth->bindValue(':end', $end->format('Y-m-d').' 18:00', \PDO::PARAM_STR);
            $sth->execute();
            return $sth->fetchAll(\PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            exit('データベース処理エラー');
        }
    }

    //スケジュールの登録を行う関数
    function scheduleRegist(string $start, string $end,  string $memo,  int $user_id): void{
        try{
            $sql = <<< EOM
            INSERT INTO schedules (start, end, memo, user_id)
            VALUES ( :start, :end , :memo , :user_id )
            ;
            EOM;

            $sth = $this->dbh->prepare($sql);

            $sth->bindValue(':start', $start, \PDO::PARAM_STR);
            $sth->bindValue(':end', $end, \PDO::PARAM_STR);
            $sth->bindValue(':memo', $memo, \PDO::PARAM_STR);
            $sth->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
            $sth->execute();

        }catch (\PDOException $e){
            exit('データベース処理エラー');
        }
    }

    //スケジュールの削除を行う関数
    function scheduleDelete(string $id, int $user_id): void{
        try{
            $sql = <<< EOM
            DELETE FROM schedules
            WHERE id = :id AND user_id = :user_id
            ;
            EOM;

            $sth = $this->dbh->prepare($sql);

            $sth->bindValue(':id', $id, \PDO::PARAM_INT);
            $sth->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
            $sth->execute();

        }catch (\PDOException $e){
            echo $e;
            exit('データベース処理エラー');
        }
    }

    //$start～$endの間にスケジュールが存在するかチェックする関数
    //存在しない場合はtrue、そうでない場合はfalseを返す
    function overlapCheck(string $start, string $end): bool{

        try{
            $sql = <<< EOM
            SELECT COUNT( * ) FROM schedules
            WHERE start < :end AND end > :start
            ;
            EOM;

            $sth = $this->dbh->prepare($sql);

            $sth->bindValue(':start', $start, \PDO::PARAM_STR);
            $sth->bindValue(':end', $end, \PDO::PARAM_STR);
            $sth->execute();

            $count = $sth->fetch(\PDO::FETCH_NUM);

            if($count[0] === 0){
                return true;
            } else {
                return false;
            }
        }catch (\PDOException $e){
            exit('データベース処理エラー');
        }
    }
}