<?php

// PHPMailerの読み込み
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 設定ファイルを読み込み
require_once '../config/const.php';
// Composerのオートロード
require __DIR__ . '/../vendor/autoload.php';


// ===== reCAPTCHA の検証 =====
$recaptcha_secret = RECAPTCHA_SECRET_KEY;

// フロントから送信されたトークン
$recaptcha_response = isset($_POST['recaptcha-response']) ? trim($_POST['recaptcha-response']) : '';

if (!$recaptcha_response) {
    echo json_encode(['status' => 'error', 'message' => 'reCAPTCHA が無効です。']);
    exit;
}

// Googleに送信して検証
$verify_url = "https://www.google.com/recaptcha/api/siteverify";
$response = file_get_contents($verify_url . "?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response);
$response_keys = json_decode($response, true);

// 検証失敗時
if (!$response_keys["success"] || $response_keys["score"] < 0.5 || $response_keys["action"] !== "submit") {
    echo json_encode(['status' => 'error', 'message' => 'reCAPTCHA 検証に失敗しました。']);
    exit;
}

// フォームから送信されたデータを取得
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// PHPMailer の初期化
$mail = new PHPMailer(true);    // trueで例外モードを有効に
$mail->CharSet  = "UTF-8";         // 日本語用にUTF-8を指定
$mail->Encoding = "base64";        // 日本語の件名や本文が文字化けしないようにする

try {
    // サーバ設定
    $mail->isSMTP();                                                // SMTPを使う
    $mail->Host       = MAIL_HOST;                                  // SMTPサーバー
    $mail->SMTPAuth   = true;                                       // SMTP認証を有効に
    $mail->Username   = MAIL_USER_NAME;                             // SMTPユーザー名
    $mail->Password   = MAIL_PASSWORD;                              // SMTPパスワード
    $mail->SMTPSecure = 'tls';                                      // 暗号化（ssl or tls）
    $mail->Port       = MAIL_PORT;                                  // SMTPポート

    // 送信者・受信者
    $mail->setFrom('noreply@nakao-portfolio.sakuraweb.com', "Nakao's Portfolio");
    $mail->addAddress('info@nakao-portfolio.sakuraweb.com', '管理者');    // 受信先メールアドレス

    // メール内容
    $mail->isHTML(true);
    $mail->Subject = 'お問い合わせフォームからの送信';
    $mail->Body    = "
        <p>ポートフォリオサイトから、以下のお問い合わせがありました。</p>
        <p><strong>名前:</strong> {$name}</p>
        <p><strong>メール:</strong> {$email}</p>
        <p><strong>メッセージ:</strong><br>" . nl2br($message) . "</p>
    ";

    // テキストメール（プレーンテキスト版）
    $mail->AltBody = "名前: {$name}\nメール: {$email}\nメッセージ:\n{$message}";

    // 送信
    $mail->send();

    // JSONで返す場合（非同期送信用）
    echo json_encode(['status' => 'success', 'message' => '送信が完了しました。']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "送信に失敗しました: {$mail->ErrorInfo}"]);
}

?>