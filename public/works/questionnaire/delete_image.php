<?php
// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$err_msg      = array();     // エラーメッセージ
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['id']) === TRUE) {

  // 変数定義
  $delete_file = $data['deleteFile'];
  // 画像をディレクトリから削除
  if (isset($delete_file) === TRUE && $delete_file) {
    unlink(UPLOADED_FILE_PATH . $delete_file);

    // 変数定義
    $id = $data['id'];
    $datetime = date('Y-m-d H:i:s');  // 現在日時
    // データベースの画像ファイル名を空にする
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
        $stmt->bindValue(1, "", PDO::PARAM_STR);
        $stmt->bindValue(2, $datetime, PDO::PARAM_STR);
        $stmt->bindValue(3, $id, PDO::PARAM_INT);
        // SQLを実行
        $stmt->execute();
        echo '既存画像の削除処理が正常に完了しました';
      } catch (PDOException $e) {
        throw $e;
      } 
      
    } catch (PDOException $e) {
        // 接続失敗した場合
        $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
        echo $e->getMessage();
    }
  }
}
?>

