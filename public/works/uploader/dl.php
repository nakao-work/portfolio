<?php
// 関数を定義したファイルを読み込み
require_once './functions.php';

// DB接続用の情報を定義したファイルを読み込み
require_once './conf/const.php';

$fPath = "";  // ファイルパス用の空変数を定義

function download($fPath, $fMimeType = null) {
  // ファイルが読めない時はエラー(もっときちんと書いた方が良いが今回は割愛)
  if (!is_readable($fPath)) {
    exit($fPath);
  }

  // Content-Typeとして送信するMIMEタイプ(第2引数を渡さない場合は、ファイルから自動判別)
  //-- 三項演算子: (条件式) ? trueの場合 : falseの場合;
  $mimeType = (isset($fMimeType)) ? $fMimeType : (new finfo(FILEINFO_MIME_TYPE))->file($fPath);

  // 適切なMIMEタイプが得られない時は、未知のファイルを示すapplication/octet-streamとする
  if (!preg_match('/\A\S+?\/\S+/', $mimeType)) {
    $mimeType = 'application/octet-stream';
  }

  // Content-Type
  header('Content-Type: ' . $mimeType);

  // ウェブブラウザが独自にMIMEタイプを判断する処理を抑止する
  header('X-Content-Type-Options: nosniff');

  // ダウンロードファイルのサイズ
  header('Content-Length: ' . filesize($fPath));

  // ダウンロード時のファイル名
  //-- Content-Disposition: attachment;　でダウンロードとして扱う
  header('Content-Disposition: attachment; filename="' . $_POST['original_filename'] . '"');

  // keep-aliveを無効にする(サーバーとの接続を閉じる)
  header('Connection: close');

  // readfile()の前に出力バッファリングを無効化する
  //-- ダウンロードの場合はバッファリングが邪魔になる場合があるため
  while (ob_get_level()) { ob_end_clean(); }

  // 出力
  readfile($fPath);

	// 最後に終了させるのを忘れない
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $filePath = UPLOADED_FILE_PATH . "{$_POST['file_name']}.{$_POST['extension']}"; // 実際のファイルパスを指定
  download($filePath, $_POST['mime_type']);
}
?>


