<?php
// 関数を定義したファイルを読み込み
require_once './functions.php';

// DB接続用の情報を定義したファイルを読み込み
require_once './conf/const.php';
 
$uploaded_file_dir    = './uploaded_file/';    // アップロードしたファイルの保存ディレクトリ
$data       = array();
$err_msg    = array();     // エラーメッセージ
$new_filename   = '';   // アップロードした新しいファイル名

// ["name"]=> string(7) "cat.jpg"
// ["type"]=> string(10) "image/jpeg"
// ["tmp_name"]=> string(36) "/Applications/MAMP/tmp/php/phpWrE8YM"
// ["error"]=> int(0)
// ["size"]=> int(113866)

// アップロードファイルの保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // HTTP POST でファイルがアップロードされたかどうかチェック
  if (is_uploaded_file($_FILES['upload_file']['tmp_name']) === TRUE) {
    // ファイルの拡張子を取得
    $extension = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
    // 指定の拡張子であるかどうかチェック
    // if ($extension === 'jpg' || $extension === 'jpeg') {
      // 保存する新しいファイル名の生成（ユニークな値を設定する）
      $new_filename = bin2hex(random_bytes(16));
      // 同名ファイルが存在するかどうかチェック
      if (is_file($uploaded_file_dir . $new_filename) !== TRUE) {
        // アップロードされたファイルを指定ディレクトリに移動して保存
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploaded_file_dir . $new_filename . "." . $extension) !== TRUE) {
            $err_msg[] = 'ファイルアップロードに失敗しました';
        }
      } else {
        $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
      }
    // } else {
    //   $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEGのみ利用可能です。';
    // }
  } else {
    $err_msg[] = 'ファイルを選択してください';
  }
}

// アップロードした新しいファイルの情報をデータベースに登録、既存のファイル名の取得
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 
  // エラーがなければ、アップロードした新しいファイル名を保存
  if (count($err_msg) === 0 && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    try {
      // SQL文を作成
      $sql = 'INSERT INTO uploader(file_name, extension, mime_type, file_size, original_filename) VALUES(?,?,?,?,?)';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
      // SQL文のプレースホルダに値をバインド
      $stmt->bindValue(1, $new_filename, PDO::PARAM_STR);
      $stmt->bindValue(2, $extension, PDO::PARAM_STR);
      $stmt->bindValue(3, $_FILES['upload_file']['type'], PDO::PARAM_STR);
      $stmt->bindValue(4, $_FILES['upload_file']['size'], PDO::PARAM_STR);
      $stmt->bindValue(5, $_FILES['upload_file']['name'], PDO::PARAM_STR);
       // SQLを実行
      $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    }
  }
 
  // 既存のアップロードされたファイル名の取得
  try {
    // SQL文を作成
    $sql = 'SELECT file_name FROM uploader';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $data[] = $row;
    }
  } catch (PDOException $e) {
    throw $e;
  }
} catch (PDOException $e) {
  // 接続失敗した場合
  $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>
</head>
<body class="up-body">
  <?php if(count($err_msg) !== 0) { ?>
  <div class="err_msg">
    <!-- エラーメッセージ表示 -->
    <?php foreach ($err_msg as $value) { ?>
      <p class="display_err_msg">
        <span class="material-symbols-outlined">warning</span>  
        <?php echo $value; ?>
      </p>
    <?php } ?>

    <div class="c-mt-100">
      <a href="./index.php" class="c-move-top-btn c-btn">←Topに戻る</a>
    </div>
  </div>
  <?php } ?>
  
  <div class="success_msg">
    <?php if(count($err_msg) === 0) { ?>

      <h3 class="success-msg">アップロードが完了しました</h3>
      <div class="success-detail-container">
        <span class="material-symbols-outlined check_circle">check_circle</span>
        <p><?php echo $_FILES['upload_file']['name'] ?></p>
        <p class="c-mb-30">
          <?php
          $filesize = $_FILES['upload_file']['size'];
          $filesize = change_filesize_unit($filesize);
          echo $filesize;
          ?>
        </p>
        <p class="download_url_header">ダウンロードURL</p>
        <div class="download_url_container">
          <input type="text" value="<?php echo "http://localhost:8888/www_portfolio/portfolio/works/uploader/predl.php?file=" . $new_filename ?>" class="download_url">
          <span class="material-symbols-outlined content_copy" data-copy="copyarea">content_copy</span>
        </div>
        <p class="c-mb-30">※ファイルは1週間で削除されます。</p>

        <div>
          <a href="./index.php" class="c-move-top-btn c-btn">←Topに戻る</a>
        </div>
      </div>
    <?php } ?>
  </div>
  
  <script src="./js/script.js"></script>
</body>
</html>
