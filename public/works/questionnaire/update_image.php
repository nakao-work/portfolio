<?php
// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$data         = array();
$err_msg      = array();     // エラーメッセージ
$result_msg   = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) === TRUE) {
  // dropzoneで送信された画像をimgディレクトリに保存する
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
            echo 'ファイルアップロードに失敗しました';
        }
      } else {
        echo 'ファイルアップロードに失敗しました。再度お試しください。';
      }
    } else {
      echo 'アップロード可能なファイル形式ではありません。';
    }
  }

  
  // 変数定義
  $id = $_POST['id']; // 操作するデータのid
  $datetime = date('Y-m-d H:i:s');  // 現在日時
  // 画像のファイル名のみデータをデータベースに保存
  try {
    // データベースに接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      
    try { 
      //
      // answersテーブルの単一データ(画像関連カラム)を更新
      //
      // SQL文を作成
      $sql = 'UPDATE answers SET new_img_filename = ?, updated_at = ? WHERE id = ?';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
      // SQL文のプレースホルダーに値をバインド
      $stmt->bindValue(1, $new_img_filename, PDO::PARAM_STR);
      $stmt->bindValue(2, $datetime, PDO::PARAM_STR);
      $stmt->bindValue(3, $id, PDO::PARAM_INT);
      // SQLを実行
      $stmt->execute();
      echo '画像の処理が正常に完了しました';
    } catch (PDOException $e) {
      throw $e;
    } 
    
  } catch (PDOException $e) {
      // 接続失敗した場合
      $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
      echo $e->getMessage();
  }

}
?>

