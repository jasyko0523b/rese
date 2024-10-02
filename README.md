# Rese（リーズ）
架空企業のグループ会社の飲食店予約サービス。
ユーザーは会員登録後、飲食店の予約をしたり、レビューを投稿したりできる。
![images/shop_all.png](/images/shop_all.png)

## 作成した目的
laravel学習のために作成した。
外部の飲食店予約サービスは手数料をとられるので自社サービスを持ちたい、というクライアントの要望を想定しています

## アプリケーションURL
http://ec2-54-250-90-239.ap-northeast-1.compute.amazonaws.com

## 機能一覧
- 登録店舗の一覧取得、検索(エリア、ジャンル、店名)
- 登録店舗の詳細取得
- 会員登録・ログイン/ログアウト機能
- メールによる本人確認
- QRコードに紐づいた、予約情報の確認
- タスクスケジューラーによる、予約情報の自動送信
- 権限別機能
    - 一般ユーザー
        - お気に入り店舗の一覧取得、追加、削除
        - 入店予約の追加、変更、削除、QRコード作成
        - レビューの取得、登録
    - 店舗代表者
        - 店舗情報の作成、更新
        - 予約情報の確認
        - Stripeを利用した決済
    - 管理者
        - 店舗代表者の確認、作成
        - 利用者全員にお知らせメールの一斉送信

## ページ一覧
- 非会員でもアクセス可能
	- 予約情報確認ページ
	- 飲食店一覧ページ
	- 飲食店詳細ページ
	- 会員登録完了ページ
	- ログインページ
	- 会員登録ページ
- 会員登録後アクセス可能
	- マイページ
	- Email確認ページ
	- 予約確認QR表示ページ
	- 予約完了ページ
- Owner権限が必要
	- 予約確認ページ
	- 店舗詳細ページ
	- 会計金額入力画面
	- カード情報入力画面
	- 決済完了画面
- Admin権限が必要
	- 店舗代表者一覧ページ
	- 店舗代表者登録ページ
	- メール作成ページ

## 使用技術(実行環境)
- Laravel v8.83.27
- PHP 8.3.0 (cli)
- mysql  Ver 15.1 Distrib 10.11.6-MariaDB
- nginx version: nginx/1.21.1
- Docker version 24.0.2
- Composer version 2.7.7

## テーブル設計
### テーブル一覧
- 基本機能
    - Usersテーブル
    - Areasテーブル
    - Genresテーブル
    - Shopsテーブル
    - Reservationsテーブル
    - Reviewsテーブル
- ユーザー権限
    - Rolesテーブル
    - Permissionsテーブル
    - Model_has_rolesテーブル
    - Model_has_permissionsテーブル
    - Role_has_permissionsテーブル
### テーブル詳細
![images/rese_table1.jpg](/images/rese_table1.jpg)
![images/rese_table2.jpg](/images/rese_table2.jpg)
![images/rese_table3.jpg](/images/rese_table3.jpg)

## ER図
![images/rese_ER1.jpg](/images/rese_ER1.jpg)
![images/rese_ER2.jpg](/images/rese_ER2.jpg)

## 環境構築
### Dockerを利用して、必要パッケージをインストールする
任意のディレクトリにクローンした後、Dockerを起動してください
```
$ git clone git@github.com:jasyko0523b/rese.git
$ docker-compose up -d --build
```
### PHPコンテナにアクセスしてコマンドを実行する
下記コマンドを実行しPHPコンテナにアクセスします
```
$ docker-compose exec php bash
```
以降はPHPコンテナ内でのコマンド実行になります
composer.json に記載されたパッケージをインストールします

```
# composer install
```

`src`ディレクトリ内の`.env.development`をコピーして`.env`を作成します

```
# cp .env.development .env
```

アプリケーションキーを作成する

```
# php artisan key:generate
```

ストレージへのシンボリックリンクを作成します
```
# php artisan storage:link
```

マイグレーションとシーディングを実行する

```
# php artisan migrate
# php artisan db:seed
```

PHPコンテナから抜けます

```
# exit
```
### src以下のアクセス権限を変更する
```
$ sudo chmod 777 -R src/*
```

ブラウザより`127.0.0.0`にアクセスして動作を確認してください

### タスクスケジューラーの登録
cronを使用して、タスクスケジュールの実行をする
```
// php コンテナ内
# service cron restart
```
毎朝8時に、ユーザーに予約確認メールが送信されます。

## アカウントの種類（テストユーザーなど）
テストユーザ一覧
- 【一般利用者】
    - email: user`{number}`@sample.com
    - password: user`{number}`
    - `{number}` には`1~19`の数字を入れてください
    - 例： email: user1@sample.com / password:  user1
- 【店舗代表者】
    - email: owner`{number}`@sample.com
    - password: owner`{number}`
    - `{number}` には`1~19`の数字を入れてください
    - 例： email: owner1@sample.com / password:  owner1
- 【サイト管理者】
    - email: admin@sample.com
    - password: admin
