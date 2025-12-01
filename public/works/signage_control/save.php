<?php

// 設定ファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';
 
// URLパラメーターから該当のデータIDを取得
if(isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  exit('URLが正しくありません');
}

$data    = array();
$err_msg = array();     // エラーメッセージ
  
// DB保存
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
  // 入力情報の保存
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content1'])) {
    $content_title = $_POST['content_title'];
    $content1_bgcolor = $_POST['content1_bgcolor'];
    $content1 = $_POST['content1'];
    $content2_bgcolor = $_POST['content2_bgcolor'];
    $content2 = $_POST['content2'];
    
    try {
      // SQL文を作成
      $sql = 'INSERT INTO signage(id, content_title, content1_bgcolor, content1, content2_bgcolor, content2)
              VALUES(?,?,?,?,?,?)
              ON DUPLICATE KEY UPDATE
                content_title = VALUES(content_title),
                content1_bgcolor = VALUES(content1_bgcolor),
                content1 = VALUES(content1),
                content2_bgcolor = VALUES(content2_bgcolor),
                content2 = VALUES(content2);';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
      // SQL文のプレースホルダに値をバインド
      $stmt->bindValue(1, $id, PDO::PARAM_INT);
      $stmt->bindValue(2, $content_title, PDO::PARAM_STR);
      $stmt->bindValue(3, $content1_bgcolor, PDO::PARAM_STR);
      $stmt->bindValue(4, $content1, PDO::PARAM_STR);
      $stmt->bindValue(5, $content2_bgcolor, PDO::PARAM_STR);
      $stmt->bindValue(6, $content2, PDO::PARAM_STR);
      // SQLを実行
      $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    }
  }

} catch (PDOException $e) {
  // 接続失敗した場合
  $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage(); // エラーメッセージを配列に格納
  if(count($err_msg) !== 0) {
    foreach($err_msg as $value) {
      echo $value;  // エラーメッセージ書き出し
    }
  }
  exit();
}

header("Location: ./signage.php?id=" . $id);
exit();

?>