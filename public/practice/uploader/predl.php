<?php
// 関数を定義したファイルを読み込み
require_once './functions.php';

// DB接続用の情報を定義したファイルを読み込み
require_once './conf/const.php';

$data       = array();
$err_msg    = array();     // エラーメッセージ

// 正規のURLかチェック
if (isset($_GET['file'])) {
  try {
    // データベースに接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
    // URLのfileパラメーターがDB上に存在するかチェック
    try {
      // SQL文を作成
      $sql = 'SELECT * FROM uploader WHERE file_name = ?';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
      // SQL文のプレースホルダに値をバインド
      $stmt->bindValue(1, $_GET['file'], PDO::PARAM_STR);
      // SQLを実行
      $stmt->execute();
      // レコードの取得
      $data = $stmt->fetchAll();
    } catch (PDOException $e) {
      throw $e;
    }
  } catch (PDOException $e) {
    // 接続失敗した場合
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }

  // "file"パラメーターの値がDBに存在しない場合
  if (empty($data)) {
    exit("ファイルが存在しないか、有効期限切れのためダウンロードできません。");
  }

} else {
  // URLに"file"のパラメーターがない場合
  echo "無効なURLです";
  exit;
}

?>


<!DOCTYPE html>
<html lang="ja" class="dl-html">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>
</head>
<body class="dl-body">
  <div id="particles-js"></div>
  <div id="wrapper">
    <div class="logo logo--mb-50">
      <h1 class="logo__text">File Uploader</h1>
    </div>
    <div class="main-container">
      <p><?php echo $data[0]['original_filename'] ?></p>
      <p><?php echo change_filesize_unit($data[0]['file_size']) ?></p>
      <form action="dl.php" method="POST">
        <button class="download-btn btn" type="submit">
          <span class="material-symbols-outlined">download</span>Download
        </button>
        <input type="hidden" name="file_name" value="<?php echo $data[0]['file_name'] ?>" >
        <input type="hidden" name="extension" value="<?php echo $data[0]['extension'] ?>" >
        <input type="hidden" name="mime_type" value="<?php echo $data[0]['mime_type'] ?>" >
        <input type="hidden" name="original_filename" value="<?php echo $data[0]['original_filename'] ?>" >
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script src="./js/script.js"></script>
</body>
</html>
