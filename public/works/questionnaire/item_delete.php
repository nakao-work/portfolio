<?php
// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$data       = array();
$err_msg    = array();     // エラーメッセージ
$result_msg = array();    // 完了メッセージ 

// 削除ボタンが押された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //ステータスの更新
  try {
    // データベースに接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // 変数を定義
    $params = json_decode(file_get_contents('php://input'), true);
    $id     = $params["id"];
    //
    // answersテーブルを更新
    //
    // SQL文を作成
    $sql = 'DELETE FROM answers WHERE id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダーに値をバインド
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();


    //
    // 登録されている情報の取得
    //
    // SQL文を作成
    $sql = 'SELECT id, new_img_filename, name, company, email, question1, question2, message, staff_name, memo, created_at, updated_at FROM `answers` ORDER BY id DESC';
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

    // 削除成功時のレスポンス
    if ($stmt->rowCount() > 0) {  // クエリによって影響を受けた行数。(削除対象が存在したか確認できる)
      echo json_encode(['status' => 'success', 'message' => 'アイテムが削除されました', 'data' => $data]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'アイテムが見つかりません']);
    }

  } catch (PDOException $e) {
    // 接続失敗した場合
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
  }
}

?>