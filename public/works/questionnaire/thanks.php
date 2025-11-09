<?php
// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>
</head>

<body class="thanks-body">
    <div class="wrapper">
      <div class="message">
        <h1 class="message__title">ご協力いただき<br>ありがとうございました!</h1>
        <a href='./index.php' class='back-btn'>Topに戻る</a>
      </div>
    </div>
</body>
</html>
