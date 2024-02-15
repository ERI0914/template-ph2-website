<?php
$dsn = 'mysql:host=db;dbname=posse;charset=utf8';
$user = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $user, $password);
    // echo 'Connection success!';
} catch (PDOException $e) {
     echo 'Connection failed: ' . $e->getMessage();
}

// SQL ステートメント
// $sql = 'SELECT * FROM quiz';

//テーブル内のレコードを順番に出力
// foreach ($dbh->query($sql) as $row) {
//     echo $row['id'];
//     echo $row['content'];
//     echo $row['image'];
//     echo $row['supplement'];
// }


// //SQL ステートメント
// $sql = 'SELECT * FROM quiz_answers';

// //テーブル内のレコードを順番に出力
// foreach ($dbh->query($sql) as $row) {
//   echo $row['id'];
//   echo $row['question_id'];
//   echo $row['name'];
//   echo $row['valid'];
// }