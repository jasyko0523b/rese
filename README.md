# Rese（リーズ）
架空企業のグループ会社の飲食店予約サービス。
ユーザーは会員登録後、飲食店の予約をしたり、レビューを投稿したりできる。
![images/shop_all.png](/images/shop_all.png)

## 作成した目的
laravel学習のために作成した。
外部の飲食店予約サービスは手数料をとられるので自社サービスを持ちたい、というクライアントの要望を想定しています

## アプリケーションURL
~~http://ec2-54-250-90-239.ap-northeast-1.compute.amazonaws.com~~

AWS環境は閉鎖しました
## 機能一覧
- 登録店舗の一覧取得、検索(エリア、ジャンル、店名)、ソート
- 登録店舗の詳細取得
- 会員登録・ログイン/ログアウト機能
- メールによる本人確認
- QRコードに紐づいた、予約情報の確認
- タスクスケジューラーによる、予約情報の自動送信
- 権限別機能
    - 一般ユーザー
        - お気に入り店舗の一覧取得、追加、削除
        - 入店予約の追加、変更、削除、QRコード作成
        - レビューの取得、登録、編集、削除
    - 店舗代表者
        - 店舗情報の作成、更新
        - 予約情報の確認
        - Stripeを利用した決済
    - 管理者
        - 店舗代表者の確認、作成
        - 利用者レビューの削除
        - 画像のアップロード
        - 店舗情報のCSVファイルインポート
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
    - レビュー編集ページ
- Owner権限が必要
	- 予約確認ページ
	- 店舗詳細ページ
	- 会計金額入力画面
	- カード情報入力画面
	- 決済完了画面
- Admin権限が必要
	- 店舗代表者一覧ページ
	- 店舗代表者登録ページ
    - 画像アップロードページ
    - 店舗情報CSVインポートページ
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

## CSVファイルの記述方法
記載例を参考に、CSV形式でインポートしてください
### 記載例
```
name,email,password,area,genre,sentence,image_url
店舗１,test1@sample.com,password1,東京都,寿司,概要１,http://localhost/image1.jpg
店舗２,test2@sample.com,password2,大阪府,焼肉,概要２,http://localhost/image2.jpeg
店舗３,test3@sample.com,password3,福岡県,イタリアン,概要３,http://localhost/image3.png
店舗４,test4@sample.com,password4,東京都,居酒屋,概要４,http://localhost/image4.jpg
店舗５,test5@sample.com,password5,東京都,ラーメン,概要５,http://localhost/image5.jpg
```
### 説明
#### ヘッダー
| name   | email                | password         | area       | genre        | sentence | image_url   | 
| ------ | -------------------- | ---------------- | ---------- | ------------ | -------- | ----------- | 
| 店舗名 | 管理者メールアドレス | 管理者パスワード | 店舗エリア | 店舗ジャンル | 店舗概要 | 店舗画像URL | 
#### 注意事項
- 管理者メールアドレスは重複不可（既存ユーザーを含む）
- 店舗エリアは「東京都」「大阪府」「福岡県」のいずれかのみ入力可能
- 店舗ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかのみ入力可能
- 店舗画像URLには、アクセス可能なURLを入力してください
- 未アップロードの画像を利用したい場合は、先に店舗画像アップロードページ(`/admin/shop_image`)より画像をアップロードして、URLを取得してください