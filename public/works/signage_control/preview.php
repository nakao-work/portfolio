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
  
// 入力情報の保存
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content1'])) {
  $content_title = $_POST['content_title'];
  $content1_bgcolor = $_POST['content1_bgcolor'];
  $content1 = $_POST['content1'];
  $content2_bgcolor = $_POST['content2_bgcolor'];
  $content2 = $_POST['content2'];
}

?>

<!doctype html>
<html lang="ja">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>

  <style>
    .left-container {
      background-color: <?php echo $content1_bgcolor; ?>;
    }
    .right-container {
      background-color: <?php echo $content2_bgcolor; ?>;
    }
  </style>
</head>
<body class="preview-body">
  <button type="button" onclick="history.back()" class="btn-back"><span class="material-symbols-outlined">arrow_back</span>編集ページに戻る</button>
  <div class="wrapper">
    <div class="left-container">
      <div class="left-container__content">
        <?php echo $content1; ?>
      </div>
    </div>
    <div class="right-container">
    <div class="right-container__content">
        <?php echo $content2; ?>
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