# ph1 POSSE課題 サンプル
## サンプルサイト
### ■ トップページ
https://posse-ap.github.io/sample-ph1-website/

```
【参照ソースコード】
/index.html
/assets/styles/common.css
```

### ■ クイズページ
https://posse-ap.github.io/sample-ph1-website/quiz/
```
【参照ソースコード】
/quiz/index.html
/assets/styles/common.css
/assets/scripts/quiz.js
```

#### JavaScriptで問題文をループ出力
https://posse-ap.github.io/sample-ph1-website/quiz2/
```
【参照ソースコード】
/quiz2/index.html
/assets/styles/common.css
/assets/scripts/quiz2.js
```

#### JavaScriptで問題をランダムに並び替えて出力
https://posse-ap.github.io/sample-ph1-website/quiz3/
```
【参照ソースコード】
/quiz3/index.html
/assets/styles/common.css
/assets/scripts/quiz3.js
```





### sql実行方法
1. dbコンテナに接続する
```
docker compose exec db bash
```
2. dbコンテナの中でディレクトリを移動する
```
cd var/www/html
```
3. mysqlに接続し、作成したsqlを実行する
```
mysql -u root -p < week18-1.sql

password;root
//
```
4. エラーが出なければ `select * from books;` を実行する。実行した結果、以下のようにbooks一覧が表示されれば完了。
select * from quiz_answers;
**注意**
ここでエラーが出た場合、修正箇所を修正後、再度3.のコマンドを実行する

 