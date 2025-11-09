<?php
session_start();

// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$data         = array();
$err_msg      = array();     // エラーメッセージ
$result_msg   = array();

// urlからパラメーターを取得
if(isset($_GET['event_id'])) {
  $event_id = $_GET['event_id'];
} else {
  $event_id = null;
};

// action先のURLを生成
if(!empty($event_id)) {
  $link_url = './admin.php?event_id=' . $event_id;
} else {
  $link_url = './admin.php';
}

// formから送信されたデータを処理する(画像以外)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) === TRUE) {
  
  // formから送信されたデータを変数に定義
  $id      = $_POST['id'];
  $name    = $_POST['user_name'];
  $company = $_POST['company_name'];
  $email   = $_POST['e_mail'];
  $question1 = $_POST['q1'];
  $question2 = $_POST['q2'];
  $message = $_POST['free_text'];
  $staff_name = $_POST['staff_name'];
  $memo = $_POST['staff_memo'];
  $datetime = date('Y-m-d H:i:s');

  // formから送信されたデータをデータベースに保存
  try {
    // データベースに接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      
    if (count($err_msg) === 0) {
      try { 
        //
        // answersテーブルの単一データを更新
        //
        // SQL文を作成
        $sql = 'UPDATE answers SET name = ?, company = ?, email = ?, question1 = ?, question2 = ?, message = ?, staff_name = ?, memo = ?, updated_at = ? WHERE id = ?';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        // SQL文のプレースホルダーに値をバインド
        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $company, PDO::PARAM_STR);
        $stmt->bindValue(3, $email, PDO::PARAM_STR);
        $stmt->bindValue(4, $question1, PDO::PARAM_STR);
        $stmt->bindValue(5, $question2, PDO::PARAM_STR);
        $stmt->bindValue(6, $message, PDO::PARAM_STR);
        $stmt->bindValue(7, $staff_name, PDO::PARAM_STR);
        $stmt->bindValue(8, $memo, PDO::PARAM_STR);
        $stmt->bindValue(9, $datetime, PDO::PARAM_STR);
        $stmt->bindValue(10, $id, PDO::PARAM_INT);
        // SQLを実行
        $stmt->execute();
      } catch (PDOException $e) {
        throw $e;
      }
    }  
  } catch (PDOException $e) {
      // 接続失敗した場合
      $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}

if(count($err_msg) === 0) {
  $_SESSION['message'] = '編集が正常に完了しました';

  header("Location: $link_url");
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <!-- <head>の共通部分を読み込み -->
    <?php include './head.php'; ?>
  </head>
  <body class="update-body">
    <?php 
      if(count($err_msg) !== 0) {
        foreach ($err_msg as $value) {
          print "エラー：" . $value;
        }
        echo "<br><br><br><a href='./admin_edit.php?id={$id}' class='back-btn'>登録・編集画面に戻る</a>";
      }
    ?>
  </body>
</html>

