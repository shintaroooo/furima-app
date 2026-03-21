# フリマアプリ
商品を出品・購入できるフリマアプリです。
ユーザー登録・ログイン後、商品出品、購入、いいね、コメントなどの機能を利用できます。
また、Stripeによる決済機能、配送先変更機能も実装しています。

## 環境構築
Dockerビルド<br>
・git clone git@github.com:shintaroooo/furima-app.git<br>
・docker compose up -d --build<br>


Laravel環境構築<br>
・docker compose exec php bash<br>
・composer install<br>
・cp .env.example .env<br>
・php artisan key:generate<br>
・php artisan migrate:fresh --seed<br>
・php artisan storage:link<br>

開発環境
・商品一覧画面：http://localhost:8081/<br>
・商品詳細画面：http://localhost:8081/item/{item_id}<br>
・会員登録：http://localhost:8081/register<br>
・ログイン：http://localhost:8081/login<br>
・マイページ：http://localhost:8081/mypage<br>
・出品画面：http://localhost:8081/sell<br>
・購入画面：http://localhost:8081/purchase/{item_id}<br>
・Mailhog：http://localhost:8025<br>
・phpMyAdmin：http://localhost:8080<br>

## 使用技術（実行環境）
・PHP / Laravel<br>
・Laravel Breeze（認証・メール認証）<br>
・MySQL<br>
・Docker / docker-compose<br>
・Blade / CSS / JavaScript<br>
・Stripe（決済機能）<br>
・PHPUnit（単体テスト）<br>

## ER図
![ER図](./docs/ER.png)

## URL
開発環境を参照

# 動作確認手順
１. 商品一覧<br>
http://localhost:8081/にアクセス<br>
商品一覧が表示されることを確認<br>
検索フォームにキーワードを入力し、該当商品が表示されることを確認<br>

２. 会員登録 → メール認証<br>
http://localhost:8081/registerにアクセス<br>
必要情報を入力して登録<br>
Mailhog（http://localhost:8025）で認証メールを確認<br>
認証リンクをクリックし、プロフィール設定画面に遷移することを確認<br>

３. ログイン<br>
http://localhost:8081/loginにアクセス<br>
登録済みユーザーでログイン<br>
商品一覧画面に遷移することを確認<br>

４. 商品詳細<br>
商品一覧から商品をクリック<br>
商品詳細画面が表示されることを確認<br>
いいね数・コメント数が表示されることを確認<br>

５. いいね機能<br>
商品詳細画面でハートボタンをクリック<br>
いいねが追加・解除できることを確認<br>

６. コメント機能<br>
商品詳細画面でコメントを入力<br>
コメントが一覧に表示されることを確認<br>

７. 商品出品<br>
http://localhost:8081/sellにアクセス<br>
商品情報を入力し「出品する」をクリック<br>
商品一覧に反映されることを確認（※自分の商品は一覧には表示されない仕様）<br>

８. 商品購入<br>
商品詳細画面から「購入手続きへ」<br>
支払い方法を選択<br>
Stripeの決済画面へ遷移することを確認<br>

９. 配送先変更<br>
購入画面から「変更する」をクリック<br>
住所を入力し更新<br>
購入画面に反映されることを確認<br>

１０. マイページ<br>
http://localhost:8081/mypageにアクセス<br>
出品商品一覧が表示されることを確認<br>
購入商品一覧が表示されることを確認<br>

１１. ログアウト<br>
ヘッダーのログアウトをクリック<br>
ログイン画面へ遷移することを確認<br>

## テスト
### テスト用環境ファイル作成
cp .env.example .env.testing<br>

### テスト用DB設定
.env.tesitngを編集<br>
DB_CONNECTION=mysql<br>
DB_HOST=mysql<br>
DB_PORT=3306<br>
DB_DATABASE=freemarket_test<br>
DB_USERNAME=root<br>
DB_PASSWORD=root<br>

### テスト用APP_KEY生成
php artisan key:gererate --env=testing<br>

### テスト用DB作成
mysqlに入る<br>
docker compose exec mysql bash<br>
MySQLにログイン<br>
mysql -u root -p<br>
DB作成<br>
CREATE DATABASE freemarket_test;<br>
### マイグレーション
php artisan migrate --env=testing<br>
### テスト実行
php artisan test<br>

## 注意事項
・Stripeはテストモードで動作<br>
・メール認証はMailhogで確認<br>
・自分が出品した商品は一覧に表示されない<br>

# 作成者
名前：楠　慎太郎
