# Rese（リーズ）
架空企業のグループ会社の飲食店予約サービス。
ユーザーは会員登録後、飲食店の予約をしたり、レビューを投稿したりできる。
![images/shop_all.png](/images/shop_all.png)

## 作成した目的
laravel学習のために作成した。
外部の飲食店予約サービスは手数料をとられるので自社サービスを持ちたい、というクライアントの要望を想定しています

## アプリケーションURL


## 機能一覧
- 登録店舗の一覧取得、検索(エリア、ジャンル、店名)
- 登録店舗の詳細取得
- 会員登録・ログイン/ログアウト機能
- メールによる本人確認
- QRコードに紐づいた、予約情報の確認
- 権限別機能
    - 一般ユーザー
        - お気に入り店舗の一覧取得、追加、削除
        - 入店予約の追加、変更、削除
        - レビューの取得、登録
    - 店舗代表者
        - 店舗情報の作成、更新
        - 予約情報の確認
    - 管理者
        - 店舗代表者の作成
        - 利用者全員にお知らせメールの一斉送信

## ページ一覧
画像貼る

## 使用技術(実行環境)
- Laravel v8.83.27
- PHP 7.4.9 (cli)
- mysql  Ver 8.0.26 for Linux on x86_64
- nginx version: nginx/1.21.1
- Docker version 24.0.2
- Composer version 2.7.7

## テーブル設計
### テーブル一覧
Users/Shops/Reservations/Reviews
### テーブル詳細
画像はる

## ER図
画像を貼る

## 環境構築
### Dockerを利用して、必要パッケージをインストールする
任意のディレクトリにクローンした後、Dockerを起動してください
```
$ git clone git@github.com:jasyko0523b/rese.git
$ docker-compose up -d --build
```
PHPコンテナにアクセスし、composer.json に記載されたパッケージをインストールします
```
$ docker-compose exec php bash
```
```
// PHP コンテナ内
# composer install
```
### .env ファイルを作成する
`src`ディレクトリ内の`.env.example`をコピーして`.env`を作成します
```
$ cp src/.env.example src/.env
```
`.env`が作成出来たら、下記のように修正してください
```
// 前略

DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
+ DB_HOST=mysql
DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=root
- DB_PASSWORD=
+ DB_DATABASE=laravel_db
+ DB_USERNAME=laravel_user
+ DB_PASSWORD=laravel_pass

// 後略
```
### キーを作成する
phpコンテナにアクセスして、アプリケーションキーを生成してください
```
// php コンテナ内
# php artisan key:generate
```
ブラウザより`127.0.0.0`にアクセスして動作を確認してください
## 他に記載することがあれば記載する
## アカウントの種類（テストユーザーなど）
user@sample.com/user
owner@sample.com/owner
admin@sample.com/admin