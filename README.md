# makanai_webapp
### 初めに
以前，アルバイト先のまかないを決めるAndroidアプリを作成したが，
データベースの正規化を行っていなかったり，ネイティブアプリのためメニューが切り替わってもアプリ側での対応が難しい，Android以外で同等のサービスを提供するには１から開発する必要があるため，平行して開発を行うのは個人では非常に困難である．
などの問題があったため，メニューなどの情報の編集がしやすく， プラットフォームを問わず利用できるwebアプリでのサービスを提供を目指して開発を始めた．



## 環境構築手順
編集中
### net::ERR_ADDRESS_INVALIDが出る場合の対処
public/hotの中身を 
http://0.0.0.0:5173 から http://localhost:5173 
に書き変える  
参考: https://qiita.com/Mi_tsu_ya/items/90129f44a3ee07b8ea57

## 仕様言語，フレームワーク
バックエンド:Laravel9(Laravel Sail) 
認証機能: Laravel Breeze 
フロントエンド:Vue.js 
UIフレームワーク:Ant Design Vue 

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
