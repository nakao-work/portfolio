<?php
session_start();

// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$data       = array();
$staff_data = array();
$err_msg    = array();     // エラーメッセージ
$result_msg = array();    // 完了メッセージ 

// urlからパラメーターを取得
if(isset($_GET['event_id'])) {
  $event_id = $_GET['event_id'];
} else {
  $event_id = null;
};
$id = $_GET['id'];

// action先のURLを生成
if(!empty($event_id)) {
  $link_url = './update_data.php?event_id=' . $event_id;
} else {
  $link_url = './update_data.php';
}

// テーブルの値の取得
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
  try {
    //
    // 「answers」テーブル情報を取得
    //
    // SQL文を作成
    $sql = 'SELECT id, event_id, new_img_filename, name, company, email, question1, question2, message, staff_name, memo, created_at, updated_at FROM `answers` WHERE id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダーに値をバインド
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
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

  try { 
    //
    // 「event_staff」テーブルから情報を取得
    //
    // SQL文を作成
    $sql = 'SELECT event_staff.id, event_staff.staff_num, staff.fullname FROM `event_staff` INNER JOIN `staff` ON event_staff.staff_num = staff.staff_num WHERE event_id = ? ORDER BY event_staff.id ASC;'; //
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダーに値をバインド
    $stmt->bindValue(1, $data[0]["event_id"], PDO::PARAM_INT);
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

$file_size = filesize(UPLOADED_FILE_PATH . $data[0]['new_img_filename']);
console_log($file_size);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>
  
  <!-- Micromodal.js cdn読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/micromodal/dist/micromodal.min.js"></script>

  <!-- notyf cdn読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.css" rel="stylesheet">

  <!-- dropzone cdn読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css" rel="stylesheet">

</head>
<body class="admin-edit-body">
  <?php   
    if(count($err_msg) !== 0) {
      foreach ($err_msg as $value) {
        print "エラー：" . $value;
      }
      exit;
    }
  ?>

  <div id="wrapper" class="wrapper">
    <h1>登録・編集</h1>
    <main>
      <?php foreach ($data as $value)  { ?>
        <form method="post" action="<?php echo $link_url;?>" enctype="multipart/form-data" id="js-questionnaire-edit" class="questionnaire-edit">
          <dl>
            <dt><label for="my-dropzone">■名刺画像</label></dt>
            <dd><div id="my-dropzone" class="dropzone"></div></dd>
          </dl>
          <dl>
            <dt><label for="company">■会社名</label></dt>
            <dd><input id="company" type="text" name="company_name" value="<?php echo htmlspecialchars($value['company']); ?>"></dd>
          </dl>
          <dl>
            <dt><label for="name">■名前</label></dt>
            <dd><input id="name" type="text" name="user_name" value="<?php echo htmlspecialchars($value['name']); ?>"></dd>
          </dl>
          <dl>
            <dt><label for="email">■メールアドレス</label></dt>
            <dd><input id="email" type="text" name="e_mail" value="<?php echo htmlspecialchars($value['email']); ?>"></dd>
          </dl>
          <dl>
            <dt><label for="question1">■弊社のブースにお立ち寄りいただいた目的について</label></dt>
            <dd><input id="q1" type="text" name="q1" value="<?php echo htmlspecialchars($value['question1']); ?>"></dd>
          </dl>
          <dl>
            <dt><label for="question2">■興味のある製品があればご選択ください</label></dt>
            <dd><input id="q2" type="text" name="q2" value="<?php echo htmlspecialchars($value['question2']); ?>"></dd>
          </dl>
          <dl>
            <dt><label for="message">■ご意見ご要望がございましたら、ぜひお聞かせください。</label></dt>
            <dd><textarea id="message" name="free_text"><?php echo htmlspecialchars($value['message']); ?></textarea></dd>
          </dl>
          <dl class="staff-name-container">
            <dt><label for="staff-name" class="staff-name-label">■入力者名</label></dt>
            <?php foreach(array_keys($staff_data) as $index => $key) { ?>
              <?php if($staff_data[$index]["fullname"] == $data[0]['staff_name']) { ?>
                <dd class="radio-container"><input type="radio" id="s1-<?php echo $index + 1; ?>" name="staff_name" value="<?php echo $staff_data[$index]["fullname"]; ?>" checked><label for="s1-<?php echo $index + 1; ?>"><?php echo $staff_data[$index]["fullname"]; ?></label></dd>
              <?php } else { ?>
                <dd class="radio-container"><input type="radio" id="s1-<?php echo $index + 1; ?>" name="staff_name" value="<?php echo $staff_data[$index]["fullname"]; ?>"><label for="s1-<?php echo $index + 1; ?>"><?php echo $staff_data[$index]["fullname"]; ?></label></dd>
              <?php } ?>
            <?php } ?>
          </dl>
          <dl>
            <dt><label for="memo" class="staff-memo-label">■テクトレージ担当者入力欄</label></dt>
            <dd><textarea id="memo" name="staff_memo" class="staff-memo-textarea"><?php echo htmlspecialchars($value['memo']); ?></textarea></dd>
          </dl>
          <div class="btn-container">
            <button type="button" class="btn-container__cancel" onclick="history.back()">キャンセル</button>
            <input type="submit" class="btn-container__submit" value="更新する">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($value['id']); ?>">
            <input type="hidden" name="deleteFile" value="<?php echo htmlspecialchars($value['id']); ?>">
          </div>
        </form>
      <?php } ?>
    </main>
    
    <!-- Micromodal用 -->
    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
      <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
          <div role="document">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title"></h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
              <img src="" id="modal-1-content__image" class="img-zoom">
            </main>
            <!-- <footer class="modal__footer">

            </footer> -->
          </div>
        </div>
      </div>
    </div>

  </div>

  <script>
    // Dropzoneの設定（必要に応じてカスタマイズ可能）
    Dropzone.options.myDropzone = {
      url: "./update_image.php",
      paramName: "new_img", // サーバー側で受け取るフィールド名
      params: { id: "<?php echo htmlspecialchars($value['id']); ?>", deleteFile: ""},
      acceptedFiles: "image/*",
      autoProcessQueue: false,  // フォーム送信時に一緒に処理するため自動アップロードを無効にする
      addRemoveLinks: true,
      dictRemoveFile: '<span class="material-symbols-outlined">cancel</span>',
      dictDefaultMessage: '<span class="material-symbols-outlined">image</span><br>ドラッグ&ドロップで画像を追加<br>またはクリックでファイルを選択',
      init: function() {  // 初回に1回だけ呼び出し
        var myDropzone = this;  // dropzone
        var oldFilename = "<?php echo htmlspecialchars($data[0]['new_img_filename']); ?>"; // 既存の画像のファイル名
        
        // 既存のファイルがある場合、プレビューに表示
        if(oldFilename) {
          var oldFile = {
            name: "<?php echo htmlspecialchars($data[0]['new_img_filename']); ?>",
            size: "<?php echo htmlspecialchars($file_size); ?>"
          };
          this.files.push(oldFile);
          this.displayExistingFile(oldFile, "<?php echo './uploaded_images/' . htmlspecialchars($data[0]['new_img_filename']); ?>");
          console.log(this.files);

          // 既存のファイルが削除された場合、データベースからも削除するようにオプションパラメーターを追加する
          this.on("removedfile", function(file) {
            if(!myDropzone.options.params.deleteFile) {  // 削除ボタンが押されるのが1回目の時だけ処理をする
              // オプションパラメーターに削除するファイル名を追加
              myDropzone.options.params.deleteFile = oldFilename;
              console.log("削除パラメーター追加", myDropzone.options.params);
              console.log('全ファイル', this.files);
              console.log("キューにあるファイル" , this.getQueuedFiles());
            } else {
              console.log("削除", myDropzone.options.params);
              console.log('全ファイル', this.files);
              console.log("キューにあるファイル" , this.getQueuedFiles());
            }
          })
        }
        

        // フォーム送信ボタンが押されたら待機して、先に画像をアップロードする
        document.getElementById('js-questionnaire-edit').addEventListener('submit', function(e) {
          // フォーム送信をブロック
          e.preventDefault();

          // 既存の画像を削除するためのAJAX通信
          // 実際に削除するかはサーバー側で判断
          (async () => {
            try {
              const response = await fetch('./delete_image.php', {
                method: 'POST',
                body: JSON.stringify({
                  id: myDropzone.options.params.id,
                  deleteFile: myDropzone.options.params.deleteFile
                })
              });

              if (!response.ok) {
                throw new Error(`HTTPエラー: ${response.status}`);
              }
              console.log(response);

              // 削除の処理が完了後、アップロードの処理
              if (myDropzone.getQueuedFiles().length > 0) {
                myDropzone.processQueue(); // ファイルがある場合、アップロードを実行
              } else {
                this.submit(); // ファイルがない場合は通常のフォーム送信
              }
              
            } catch (error) {
              console.error('エラー:', error);
            }
          })();
        });

        // アップロード作業が完了したら
        this.on("success", function(file, response) {
          // サーバーからのメッセージを表示
          console.log(response);

          // アップロード待ちやアップロード中のファイルがないことを確認して、formの内容を送信
          if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getUploadingFiles().length === 0) {
            document.getElementById('js-questionnaire-edit').submit();
          }
        });

        // プレビューのクリックイベントを追加
        this.on("thumbnail", function(file, thumbnail) {
          var previewElement = file.previewElement;
          previewElement.addEventListener("click", function(e) {
            // 画像をモダール内にセット
            document.getElementById("modal-1-content__image").src = `./uploaded_images/${file.name}`;
            //モーダルを開く
            MicroModal.show('modal-1');
          });
        });
      },
      accept: function(file, done) {  // ファイルアップロードの度に呼び出し
        if(this.files.length >= 2) {  // length: 既存のファイルとアップロードするファイルを合わせた数値
          this.removeFile(this.files[0]); // 既存のファイルがある状態で新しいファイルが選択されたときは、既存のファイルを削除
          done()
          console.log('全ファイル', this.files);
          console.log("キューにあるファイル" , this.getQueuedFiles());
        } else {
          done();
          console.log('全ファイル', this.files);
          console.log("キューにあるファイル" , this.getQueuedFiles());
        }
      }
    };
  </script>
  <script>
    /* Micromodal.js 設定 */
    MicroModal.init({
      awaitCloseAnimation: true,
      awaitOpenAnimation: true,
      disableScroll: true,
    });

    function openModal(id, filename) {
      MicroModal.show('modal-1');

      let deleteBtn = document.getElementById('js-modal-btn-delete');
      deleteBtn.setAttribute('data-id', `${id}`)
      deleteBtn.setAttribute('data-filename', `${filename}`)
    }
  </script>
</body>
</html>