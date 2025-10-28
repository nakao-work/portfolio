<?php
// 関数を定義したファイルを読み込み
require_once './functions.php';

// DB接続用の情報を定義したファイルを読み込み
require_once './conf/const.php';

$data       = array();
$err_msg    = array();     // エラーメッセージ
$new_filename   = '';   // アップロードした新しいファイル名

// ["name"]=> string(7) "cat.jpg"
// ["type"]=> string(10) "image/jpeg"
// ["tmp_name"]=> string(36) "/Applications/MAMP/tmp/php/phpWrE8YM"
// ["error"]=> int(0)
// ["size"]=> int(113866)

if (isset($_POST["recaptcha_response"]) && !empty($_POST["recaptcha_response"])) {
  // reCAPTCHAのシークレットキー
  $secret_key = RECAPTCHA_SECRET_KEY;

  // reCAPTCHAのレスポンス
  $recaptcha_response = $_POST['recaptcha_response'];

  // APIリクエスト
  $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$recaptcha_response);
  
  // APIレスポンス確認
  $reCAPTCHA = json_decode($verifyResponse);
  if ($reCAPTCHA->success == false) {
    // 0~1で評価。0.5以上でsuccessとなる
    // $reCAPTCHA->score で点数を取得できる
    $err_msg[] = 'reCAPTCHAがエラーを検知しました。';
  } else {
    $reCAPTCHA_score = $reCAPTCHA->score;
  }
};

// アップロードファイルの保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // HTTP POST でファイルがアップロードされたかどうかチェック
  if (count($err_msg) === 0 && is_uploaded_file($_FILES['upload_file']['tmp_name']) === TRUE) {
    // ファイルの拡張子を取得
    $extension = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);

    // 許可する拡張子リスト
    $allowed_extensions = [
      'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 
      'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'odt', 'ods', 'odp', 
      'mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', 'mpeg', 
      'mp3', 'wav', 'aac', 'flac', 'ogg', 'm4a', 
      'zip', 'rar', '7z', 'tar', 'gz'
    ];

    // 許可する拡張子であるかどうかチェック
    if (in_array($extension, $allowed_extensions)) {
      // 最大ファイルサイズ
      $MAX_FILE_SIZE = 5242880;

      if($_FILES['upload_file']['size'] < $MAX_FILE_SIZE) {
        // 保存する新しいファイル名の生成（ユニークな値を設定する）
        $new_filename = bin2hex(random_bytes(16));
        // 同名ファイルが存在するかどうかチェック
        if (is_file(UPLOADED_FILE_PATH . $new_filename) !== TRUE) {
          // アップロードされたファイルを指定ディレクトリに移動して保存
          if (move_uploaded_file($_FILES['upload_file']['tmp_name'], UPLOADED_FILE_PATH . $new_filename . "." . $extension) !== TRUE) {
              $err_msg[] = 'ファイルアップロードに失敗しました';
          }
        } else {
          $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
        }
      } else {
        $err_msg[] = 'ファイルサイズが5MBを超えています。';
      }
    } else {
      $err_msg[] = '許可されていないファイル形式です。';
    }
  } else {
    $err_msg[] = 'ファイルが選択されていない、または正常に処理されませんでした。';
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
      // 挿入されたレコードのIDを取得
      $lastInsertId = $dbh->lastInsertId();
    } catch (PDOException $e) {
      throw $e;
    }
  }
 
  // 既存のアップロードされたファイル名の取得
  try {
    // SQL文を作成
    $sql = 'SELECT * FROM uploader WHERE id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $lastInsertId, PDO::PARAM_INT);
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
  // $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  $err_msg[] = 'DBエラー：'.$e->getMessage();
}

if(count($err_msg) !== 0) {
  // エラーレスポンスを返す
  echo json_encode([
    'status' => 'error',
    'message' => 'Failed to upload file',
    'data' => null,
    'error' => $err_msg
  ]);
} else {
  // jsonレスポンスを返す
  echo json_encode([
    'status' => 'success',
    'message' => 'Upload completed',
    'data' => $data,
    'error' => null,
    'recaptcha' => $reCAPTCHA_score,
  ]);
}
// kR6TUmXZ+msy
?>