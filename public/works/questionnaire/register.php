<?php
// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$data         = array();
$err_msg      = array();     // エラーメッセージ
$result_msg   = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // formから送信されたデータを変数に定義
  $new_img_filename = "";
  $name    = $_POST['user_name'];
  $company = $_POST['company_name'];
  $email   = $_POST['e_mail'];
  if(isset($_POST['q1'])) {
    $question1 = implode("、",$_POST['q1']);
  } else {
    $question1 = "";
  }
  if(isset($_POST['q2'])) {
    $question2 = implode("、", $_POST['q2']);
  } else {
    $question2 = "";
  }
  $message    = $_POST['free_text'];
  $staff_name = $_POST['staff_name'];
  $memo       = $_POST['staff_memo'];
  $event_id   = $_POST['event_id'];
  $datetime   = date('Y-m-d H:i:s');

  // 画像をimgディレクトリに保存する
  if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {
    // 画像の拡張子を取得
    $extension = pathinfo($_FILES['new_img']['name'], PATHINFO_EXTENSION);
    // 指定の拡張子であるかどうかチェック
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'heic'];
    $extension = strtolower($extension);  // 小文字に変換
    if (in_array($extension, $allowed_extensions, true)) {
      // 保存する新しいファイル名の生成（ユニークな値を設定する）
      $new_img_filename = hash('sha256', uniqid(mt_rand(), true)) . '.' . $extension;
      // 同名ファイルが存在するかどうかチェック
      if (is_file(UPLOADED_FILE_PATH . $new_img_filename) !== TRUE) {
        // アップロードされたファイルを指定ディレクトリに移動して保存
        if (move_uploaded_file($_FILES['new_img']['tmp_name'], UPLOADED_FILE_PATH . $new_img_filename) !== TRUE) {
            $err_msg[] = 'ファイルアップロードに失敗しました';
        }
      } else {
        $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
      }
    } else {
      $err_msg[] = 'アップロード可能なファイル形式ではありません。';
    }
  }/* else {
    $err_msg[] = 'ファイルを選択してください';
  }*/



  // formから送信されたデータをデータベースに保存
  try {
      // データベースに接続
      $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
      if (count($err_msg) === 0) {
        try { 
          //
          // answersテーブルに回答を登録
          //
          // SQL文を作成
          $sql = 'INSERT INTO answers(event_id, new_img_filename, name, company, email, question1, question2, message, staff_name, memo, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
          // SQL文を実行する準備
          $stmt = $dbh->prepare($sql);
          // SQL文のプレースホルダーに値をバインド
          $stmt->bindValue(1, $event_id, PDO::PARAM_INT);
          $stmt->bindValue(2, $new_img_filename, PDO::PARAM_STR);
          $stmt->bindValue(3, $name, PDO::PARAM_STR);
          $stmt->bindValue(4, $company, PDO::PARAM_STR);
          $stmt->bindValue(5, $email, PDO::PARAM_STR);
          $stmt->bindValue(6, $question1, PDO::PARAM_STR);
          $stmt->bindValue(7, $question2, PDO::PARAM_STR);
          $stmt->bindValue(8, $message, PDO::PARAM_STR);
          $stmt->bindValue(9, $staff_name, PDO::PARAM_STR);
          $stmt->bindValue(10, $memo, PDO::PARAM_STR);
          $stmt->bindValue(11, $datetime, PDO::PARAM_STR);
          $stmt->bindValue(12, $datetime, PDO::PARAM_STR);
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
  header('Location: ./thanks.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>
</head>
<body class="register-body">
  <?php 
    if(count($err_msg) !== 0) {
      foreach ($err_msg as $value) {
        print "エラー：" . $value;
      }
      echo "<br><br><br><a href='./index.php' class='back-btn'>Topに戻る</a>";
    }
  ?>
</body>
</html>

