<?php

// 設定ファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

$data    = array();
$err_msg = array();     // エラーメッセージ

// DB取得
try {
    // データベースに接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      
    // トップに表示するサムネイル用のデータを全て取得
    try {
      // SQL文を作成
      $sql = 'SELECT * FROM signage LIMIT 4';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
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
    exit;
  }

?>

<!doctype html>
<html lang="ja">
<head>
    <!-- <head>の共通部分を読み込み -->
    <?php include './head.php'; ?>
</head>
<body class="index-body">
  <div class="wrapper">
    <header class="c-mb-50"><a href="./index.php"><img src="./assets/images/signagecontrol_logo_rectangle.png" class="img-logo"></a></header>
    <div class="item-container">
      <?php for($i=1; $i<=4; $i++) { ?>
        <div class="item-container__item-outer">
          <div class="item-container__item item-container__item<?php echo $i; ?>">
            <?php if(isset($data[$i-1])) { ?>
              <iframe src="./signage.php?id=<?php echo $i; ?>" class="item-container__item-content"></iframe>
              <div class="overlay" onclick="redirectTo(<?php echo $i; ?>)"></div>
            <?php } else { ?>
              <div class="item-container__item-add"><span class="material-symbols-outlined">add</span></div>
              <div class="overlay" onclick="redirectTo(<?php echo $i; ?>)"></div>
            <?php } ?>
          </div>
          <p><?php if(isset($data[$i-1])) { echo $data[$i-1]['content_title']; } ?></p>
        </div>
      <?php } ?>
    </div>
  </div>

  <script>
    // 各アイテムをクリックした時の遷移処理
    function redirectTo(id) {
      window.location.href = `./editor.php?id=${id}`
    }

    // Topページでは動画をmuteにする
    window.addEventListener('load',function(){

      // すべてのiframeを取得
      let iframes = document.querySelectorAll('iframe');

      // 各iframeをループ処理
      iframes.forEach(iframe => {
        try {
          // iframe内のドキュメントを取得
          let iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

          // iframe内のすべてのvideo要素を取得
          let videos = iframeDoc.querySelectorAll('video');

          // 各video要素をループ処理してミュートにする
          videos.forEach(video => {
            video.muted = true;
          });
        } catch (error) {
          // クロスオリジンの場合にエラーが発生する可能性があるのでキャッチ
          console.error('Error accessing iframe content:', error);
        }
      });
    })

  </script>
</body>
</html>