## このページについて
このページでは下記サイトのソースコードを掲載しています。
- [メール送信フォーム（laravelテストサイト）](https://miyamoto-tenshoku.site/laravel/sendmail)
- [DB出力テスト（laravelテストサイト）](https://miyamoto-tenshoku.site/laravel/outputdb)
- [QRコード作成フォーム](https://miyamoto-tenshoku.site/flask/)
- [会議室予約サイト](https://miyamoto-tenshoku.site/reserve/login.php)
- [リアルタイム顔認識アプリ](https://miyamoto-tenshoku.site/stream/)


使っているサーバの構成情報は下記の通りです。

OS：ubuntu22.04

webサーバ：nginx

データベース：mariadb

メールサーバ：postfix


## フォルダlaravelについて
[メール送信フォーム（laravelテストサイト）](https://miyamoto-tenshoku.site/laravel/sendmail)、
[DB出力テスト（laravelテストサイト）](https://miyamoto-tenshoku.site/laravel/outputdb)
のソースコードです。

これらのサイトはphpのフレームワークlaravelとbootstrapを用いて作成しました。

送信されるメールが迷惑メールと判断されないために送信ドメイン認証（SPF/DKIM/DMARC）を
設定しています。

## フォルダmakeQrについて
[QRコード作成フォーム](https://miyamoto-tenshoku.site/flask/)のソースコードです。

このサイトはpythonのフレームワークflaskを用いて作成しました。


## フォルダreserveについて
[会議室予約サイト](https://miyamoto-tenshoku.site/reserve/login.php)のソースコードです。

このサイトはphpとjavascriptを用いて作成しました。

IPA「安全なウェブサイトの作り方」に沿ってセキュリティ対策を実装しています。

## フォルダstreamについて
[リアルタイム顔認識アプリ](https://miyamoto-tenshoku.site/stream/)のソースコードです。

このサイトはpythonのフレームワークstreamlitを用いて作成しました。
