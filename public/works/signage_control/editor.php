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
      
    // 編集する単一のサイネージデータを取得
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
    exit;
  }

?>

<!doctype html>
<html lang="ja">
<head>
    <!-- <head>の共通部分を読み込み -->
    <?php include './head.php'; ?>
  
    <!-- CKEditor セルフホスティング -->
    <script src="./ckeditor/ckeditor.js"></script>
    <!-- CDNの場合 -->
    <!--
    <script src="//cdn.ckeditor.com/4.7.3/basic/ckeditor.js"></script>
    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
    -->
</head>
<body class="editor-body">
  <div class="wrapper">
    <header><a href="./index.php"><img src="./assets/images/signagecontrol_logo_rectangle.png" class="img-logo"></a></header>
    <form action="./save.php?id=<?php echo $id ?>" method="POST" class="form">
      <div class="title-container">
        <label><input type="text" name="content_title" class="title-container__title" value="<?php if(isset($data[0])) { echo $data[0]['content_title']; } ?>" placeholder="Add new title"></label>
        <div class="btn-container">
            <button formaction="./preview.php?id=<?php echo $id ?>" type="submit" class="btn-container__secondary">プレビュー</button>
            <button type="submit" class="btn-container__primary">保存してサイネージを表示</button>
        </div>
      </div>
      <div class="editor-container">
        <div class="editor-container__left">
          <span class="editor-container__left-name">左画面：</span>
          <label class="editor-container__left-color-label">背景色を選択<input type="color" name="content1_bgcolor" value="<?php echo $data[0]['content1_bgcolor']; ?>" class="editor-container__left-color"></label>
          <textarea name="content1" id="editor"><?php if(isset($data[0])) { echo $data[0]['content1']; } ?></textarea>
        </div>
        <div class="editor-container__right">
          <span class="editor-container__right-name">右画面：</span>
          <label class="editor-container__right-color-label">背景色を選択<input type="color" name="content2_bgcolor" value="<?php echo $data[0]['content2_bgcolor']; ?>" class="editor-container__right-color"></label>
          <textarea name="content2" id="editor2"><?php if(isset($data[0])) { echo $data[0]['content2']; } ?></textarea>
        </div>
      </div>
    </form>
  </div>

    <script>
        CKEDITOR.replace('editor', {
            uiColor: '#D7DDE4',
            width: 'auto',
            height: 600,
            
            // ファイルアップロード設定
            filebrowserBrowseUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/browse.php?type=files', // KCFinderのファイルブラウザURL
            filebrowserUploadUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/upload.php?type=files', // KCFinderのアップロードURL
            filebrowserImageBrowseUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/browse.php?type=files', // 画像用ファイルブラウザ
            filebrowserImageUploadUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/upload.php?type=files', // 画像アップロード用URL

            // アップロード時の"サーバーの応答が不正です。"の対策
            filebrowserUploadMethod:'form'
        });

        CKEDITOR.replace('editor2', {
            uiColor: '#2386C2',
            width: 'auto',
            height: 600,

            // ファイルアップロード設定
            filebrowserBrowseUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/browse.php?type=files', // KCFinderのファイルブラウザURL
            filebrowserUploadUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/upload.php?type=files', // KCFinderのアップロードURL
            filebrowserImageBrowseUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/browse.php?type=files', // 画像用ファイルブラウザ
            filebrowserImageUploadUrl: '<?php echo ROOT_TO_PROJECT_PATH; ?>kcfinder/upload.php?type=files', // 画像アップロード用URL

            // アップロード時の"サーバーの応答が不正です。"の対策
            filebrowserUploadMethod:'form'
        });
    </script>
</body>
</html>