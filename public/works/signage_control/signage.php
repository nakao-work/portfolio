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
console_log($id);

$data    = array();
$err_msg = array();     // エラーメッセージ

// DB取得
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  // 表示する単一のサイネージデータを取得
  try {
    // SQL文を作成
    $sql = 'SELECT * FROM signage where id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $data[] = $row;
      // $rowsと$dataは同じデータが格納される
      // 以降の処理で使用するのは基本的に$dataとし、$rowsは取得した生データとして保持する。
    }
  } catch (PDOException $e) {
    throw $e;
  }

} catch (PDOException $e) {
  // 接続失敗した場合
  $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage(); // エラーメッセージを配列に格納
  // エラーメッセージ書き出し
  if(count($err_msg) !== 0) {
    foreach($err_msg as $value) {
      echo $value;
    }
  }
  exit();
}

?>

<!doctype html>
<html lang="ja">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>

  <style>
    .left-container {
      background-color: <?php echo $data[0]['content1_bgcolor']; ?>;
    }
    .right-container {
      background-color: <?php echo $data[0]['content2_bgcolor']; ?>;
    }
  </style>
</head>
<body class="signage-body">
  <div class="wrapper">
    <div class="left-container">
      <div class="left-container__content">
        <?php echo $data[0]['content1']; ?>
      </div>
    </div>
    <div class="right-container">
    <div class="right-container__content">
        <?php echo $data[0]['content2']; ?>
      </div>
    </div>
  </div>

  <script>
    if(document.querySelector('video')) {
      let video = document.querySelector('video');
      
      // 自動再生
      // video.muted = true;
      video.controls = true;

      // 中央寄せ
      let videoParent = video.parentNode;
      videoParent.style.textAlign = "center"
    }

    if(document.querySelector('img')) {
      let img = document.querySelector('img');

      // 中央寄せ
      let imgParent = img.parentNode;
      imgParent.style.textAlign = "center"
    }
  </script>
</body>
</html>