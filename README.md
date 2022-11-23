# makanai_webapp
### 初めに
以前，アルバイト先のまかないを決めるAndroidアプリを作成したが，
データベースの正規化を行っていなかったり，ネイティブアプリのためメニューが切り替わってもアプリ側での対応が難しい，Android以外で同等のサービスを提供するには１から開発する必要があるため，平行して開発を行うのは個人では非常に困難である．
などの問題があったため，メニューなどの情報の編集がしやすく， プラットフォームを問わず利用できるwebアプリでのサービスを提供を目指して開発を始めた．

### 開発状況  
- 11/24現在，設定の選択数以外の項目とホームの最近選んだメニューカードは機能が未実装のためレイアウトの確認用のダミーです．  
- 抽選ページは開発中のためレイアウトは仮ののものです．
### 環境構築手順
#### 前提
- WSL2上で動作するLinuxディストリビューションが存在する  
- Docker Desktopがインストールされており，WSL2で利用可能になっている.  
- WSL上のLinux系ファイルシステムにアクセス可能な状態のVS Code

#### Windowsの場合
リポジトリをLinuxファイルシステム上にクローンし，ターミナルで以下のコマンドを実行する
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

クローン完了後```.env```ファイルを作成し，```.env.example```の内容をコピーする  
ターミナルで以下の順にコマンドを実行する  
```
./vendor/bin/sail up -d  
./vendor/bin/sail php artisan key:generate  
./vendor/bin/sail artisan migrate  
./vendor/bin/sail npm install  
./vendor/bin/sail artisan db:seed  
```
以上で環境構築が完了するので
```./vendor/bin/sail npm run dev```  
をターミナル上で実行し，サーバーの起動を行う  
起動後```http://localhost```にアクセスしても何も表示されないので
public/hotの中身を 
```http://0.0.0.0:5173``` から ```http://localhost:5173```  
に書き変える  

## 仕様言語，フレームワーク
- バックエンド:Laravel9(Laravel Sail)  
- 認証機能: Laravel Breeze  
- フロントエンド:Vue.js  
- UIフレームワーク:Ant Design Vue  

## License

- The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
