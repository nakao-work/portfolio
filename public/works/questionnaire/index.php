<?php
// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$staff_data = array();
$err_msg      = array();     // エラーメッセージ

// イベント情報の取得
// ※※※注意※※※：新しく展示会用に修正するときには、eventテーブルに手動でイベント情報を入力して、下記SELECT文のWHERE句の値を変更すること
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
  try { 
    //
    // eventsテーブルから情報を取得
    //
    // SQL文を作成
    $sql = 'SELECT event_id, event_name, event_short_name FROM `events` WHERE event_id = 1'; // *****新規イベントの場合はwhere句を変更する*****
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // 単一レコードの取得
    $row = $stmt->fetch();
    // 別の変数にコピー
    $event_data = $row;
  } catch (PDOException $e) {
    throw $e;
  }

  try { 
    //
    // event_staffテーブルから情報を取得
    //
    // SQL文を作成
    $sql = 'SELECT event_staff.id, event_staff.staff_num, staff.fullname FROM `event_staff` INNER JOIN `staff` ON event_staff.staff_num = staff.staff_num WHERE event_id = ? ORDER BY event_staff.id ASC;';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダーに値をバインド
    $stmt->bindValue(1, $event_data["event_id"], PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
    // 単一レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $staff_data[] = $row;
    }
  } catch (PDOException $e) {
    throw $e;
  }

} catch (PDOException $e) {
  // 接続失敗した場合
  $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
}

// エラーがある場合はページの表示を中止して、エラーメッセージを表示
if(count($err_msg) !== 0) {
  foreach ($err_msg as $value) {
    print "エラー：" . $value;
  }
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja" class="index-html">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>
</head>
<body class="index-body">
  <div class="wrapper">
    <div class="logo">
      <img src="./assets/img/logo.png" class="logo__image a-turn">
    </div>
    <div class="form-bg">
      <form method="post" action="./register.php" enctype="multipart/form-data" class="questionnaire">
        <div class="header-area">
          <h1 class="header-area__title"><?php echo $event_data["event_short_name"]; ?></h1>
          <p class="header-area__text">弊社のブースへご来場いただき<br class="c-hide-md">誠にありがとうございます。</p>
          <p class="header-area__text">アンケートにご協力ください。</p>
        </div>
        <dl>
          <dt><label for="upload">■名刺を撮影する<!--　<span>必 須</span>--></label></dt>
          <dd><input id="upload" type="file" name="new_img" capture="environment" accept="image/*"></dd>
        </dl>
        <dl>
          <dt><label for="company">■会社名<!--　<span>必 須</span>--></label></dt>
          <dd><input id="company" type="text" name="company_name"></dd>
        </dl>
        <dl>
          <dt><label for="name">■名前<!--　<span>必 須</span>--></label></dt>
          <dd><input id="name" type="text" name="user_name"></dd>
        </dl>
        <dl>
          <dt><label for="email">■メールアドレス<!--　<span>必 須</span>--></label></dt>
          <dd><input id="email" type="text" name="e_mail"></dd>
        </dl>
        <dl>
          <dt><label for="question1">■弊社のブースにお立ち寄りいただいた目的についてご選択ください</label></dt>
          <dd class="checkbox-container"><input type="checkbox" id="q1-1" name="q1[]" value="製品やサービスに興味があった"><label for="q1-1">製品やサービスに興味があった</label></dd>
          <dd class="checkbox-container"><input type="checkbox" id="q1-2" name="q1[]" value="取引先や関係者に紹介された"><label for="q1-2">取引先や関係者に紹介された</label></dd>
          <dd class="checkbox-container"><input type="checkbox" id="q1-3" name="q1[]" value="たまたま立ち寄った"><label for="q1-3">たまたま立ち寄った</label></dd>
          <dd class="checkbox-container"><input type="checkbox" id="q1-4" name="q1[]" value="" class="js-checkbox-toggle"><label for="q1-4" class="checkbox-container__other">その他</label><input type="text" class="checkbox-container__other-text" disabled></dd>
        </dl>
        <dl>
          <dt><label for="question2">■興味のある製品があればご選択ください</label></dt>
          <dd class="checkbox-container"><input type="checkbox" id="q2-1" name="q2[]" value="製品A"><label for="q2-1">製品A</label></dd>
          <dd class="checkbox-container"><input type="checkbox" id="q2-2" name="q2[]" value="製品B"><label for="q2-2">製品B</label></dd>
          <dd class="checkbox-container"><input type="checkbox" id="q2-3" name="q2[]" value="製品C"><label for="q2-3">製品C</label></dd>
          <dd class="checkbox-container"><input type="checkbox" id="q2-4" name="q2[]" value="" class="js-checkbox-toggle"><label for="q2-4" class="checkbox-container__other">その他</label><input type="text" class="checkbox-container__other-text" disabled></dd>
        </dl>
        <dl>
          <dt><label for="message">■ご意見ご要望がございましたら、ぜひお聞かせください。</label></dt>
          <dd><textarea id="message" name="free_text"></textarea></dd>
        </dl>
        <p class="below-staff-input">以下、スタッフ入力欄</p>
        <dl class="staff-name-container">
          <dt><label for="staff-name" class="staff-name-label">■入力者名</label></dt>
          <?php foreach(array_keys($staff_data) as $index => $value) { ?>
            <?php if($index == 0) { ?>
              <dd class="radio-container"><input type="radio" id="s1-<?php echo $index + 1; ?>" name="staff_name" value="<?php echo $staff_data[$index]["fullname"]; ?>" checked><label for="s1-<?php echo $index + 1; ?>"><?php echo $staff_data[$index]["fullname"]; ?></label></dd>
            <?php } else { ?>
              <dd class="radio-container"><input type="radio" id="s1-<?php echo $index + 1; ?>" name="staff_name" value="<?php echo $staff_data[$index]["fullname"]; ?>"><label for="s1-<?php echo $index + 1; ?>"><?php echo $staff_data[$index]["fullname"]; ?></label></dd>
            <?php } ?>
          <?php } ?>
        </dl>
        <dl>
          <dt><label for="memo" class="staff-memo-label">■備考</label></dt>
          <dd><textarea id="memo" name="staff_memo" class="staff-memo-textarea"></textarea></dd>
        </dl>
        <div class="submit-container">
          <input type="hidden" name="event_id" value="<?php echo $event_data["event_id"]; ?>">
          <input type="submit" class="submit-btn" value="入力内容を送信する">
        </div>
      </form>
    </div>
  </div>

  <script>
    /***** その他が選択された時の処理 */
    const checkboxes = document.querySelectorAll('.js-checkbox-toggle');

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        // チェックボックスの親要素（checkbox-container）を取得
        const container = checkbox.closest('.checkbox-container');
                
        // 子要素の input[type="text"] 要素を取得
        const textInput = container.querySelector('.checkbox-container__other-text');

        // チェックされているかどうかで disabled 属性を切り替え
        if (checkbox.checked) {
            textInput.disabled = false; // チェックされている場合は disabled を解除
        } else {
            textInput.disabled = true; // 未チェックの場合は disabled を追加
        }
      })
    })


    /***** その他の自由入力欄に記述された内容をvalueに渡す */
    const textInputs = document.querySelectorAll('.checkbox-container__other-text');

    textInputs.forEach(textInput => {
      textInput.addEventListener('change', function() {
        // チェックボックスの親要素（checkbox-container）を取得
        const container = textInput.closest('.checkbox-container');
                
        // 子要素の input[type="checkbox"] 要素を取得
        const checkbox = container.querySelector('.js-checkbox-toggle');

        checkbox.value = textInput.value;
        console.log(checkbox.value);
      })
    })
  </script>
</body>
</html>
