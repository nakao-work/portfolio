<?php
session_start();

// 定数を定義したファイルを読み込み
require_once './conf/const.php';
// 関数を定義したファイルを読み込み
require_once './functions.php';

// 初期化
$event_data   = array();
$data         = array();
$err_msg      = array();     // エラーメッセージ
$result_msg   = array();

// urlからevent_idのパラメーターを取得
if(isset($_GET['event_id'])) {
  $event_id = $_GET['event_id'];
} else {
  $event_id = null;
};

// 編集ページ遷移用のURLを生成
if(!empty($event_id)) {
  $link_url = './admin_edit.php?event_id=' . $event_id . '&id=';
} else {
  $link_url = './admin_edit.php?id=';
}

// テーブルの値の取得
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
  try { 
    //
    // 「events」テーブルから情報を取得
    //
    // SQL文を作成
    $sql = 'SELECT event_id, event_name, event_short_name FROM `events`';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $event_data[] = $row;
    }
  } catch (PDOException $e) {
    throw $e;
  }


  try {
    //
    // 「answers」テーブルから情報を取得
    //
    // SQL文を作成
    if($event_id == null) {
      $sql = 'SELECT id, new_img_filename, name, company, email, question1, question2, message, staff_name, memo, created_at, updated_at FROM `answers` ORDER BY id DESC';
    } else {
      $sql = 'SELECT id, new_img_filename, name, company, email, question1, question2, message, staff_name, memo, created_at, updated_at FROM `answers` WHERE event_id = ? ORDER BY id DESC';
    }
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダーに値をバインド
    if($event_id != null) {
      $stmt->bindValue(1, $event_id, PDO::PARAM_INT);
    }
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $data[] = $row;
    }
    $data_json = json_encode($data);
  } catch (PDOException $e) {
    throw $e;
  }

} catch (PDOException $e) {
  // 接続失敗した場合
  $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>

  <!-- Grid.js cdn読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
  
  <!-- Micromodal.js cdn読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/micromodal/dist/micromodal.min.js"></script>

  <!-- notyf cdn読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.css" rel="stylesheet">

  <!-- ScrollHint -->
  <script src="https://cdn.jsdelivr.net/npm/scroll-hint@1.2.5/js/scroll-hint.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/scroll-hint@1.2.5/css/scroll-hint.min.css" rel="stylesheet">
</head>
<body class="admin-body">
  <div class="header">
    <h1 class="header__title">来場者一覧</h1>
    <label class="header__filter">
      <select id="id-header__filter-select" class="header__filter-select">
        <?php foreach($event_data as $key => $value) {
          if($key == 0) {
            $selected = ($event_id == null) ? 'selected' : '';
            echo '<option value="null"' . $selected . '>' . "すべて" . '</option>';
          }
          $selected = ($event_id == $value["event_id"]) ? 'selected' : '';
          echo '<option value="' . $value["event_id"] . '"' . $selected . '>' . $value["event_short_name"] . "</option>";
        } ?>
      </select>
    </label>
  </div>
  <!-- Grid.js用 -->
  <div id="wrapper" class="wrapper"></div>

  <!-- 削除用　Micromodal -->
  <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
        <div role="document">
          <header class="modal__header">
            <h2 class="modal__title" id="modal-1-title">本当に削除してよろしいですか？</h2>
            <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
          </header>
          <!-- <main class="modal__content" id="modal-1-content">
            
          </main> -->
          <footer class="modal__footer">
            <button type="button" class="modal__btn-cancel modal__btn" data-micromodal-close aria-label="キャンセル">キャンセル</button>
            <button type="button" id="js-modal-btn-delete" class="modal__btn-delete modal__btn" onclick="deleteItem(this)">削除する</button>
          </footer>
        </div>
      </div>
    </div>
  </div>

  <script>
    /* selectボックスの変更に応じてURLを変更 */
    console.log(location.origin,location.pathname);
    const select = document.querySelector("#id-header__filter-select");

    select.addEventListener("change", function () {
      const selectedValue = this.value;
      if(selectedValue == "null") {
        window.location.href = `${location.origin}${location.pathname}`;
      } else {
        window.location.href = `${location.origin}${location.pathname}?event_id=${selectedValue}`;
      }
    });
  </script>

  <script>
    /* Grid.js 設定 */
    let dataObj = <?php echo $data_json; ?>;
    console.log("初回", dataObj);

    const grid = new gridjs.Grid({
      columns: [
        {id: "id", name: "id", width: "90px"},
        {id: "company", name: "会社名"},
        {id: "name", name: "氏名"},
        {id: "email", name: "メールアドレス"},
        {id: "staff_name", name: "入力者", width: "130px"},
        {id: "created_at", name: "登録日", width: "130px"},
        {id: "edit", name: "編集", width: "90px"},
        {id: "delete", name: "削除", width: "90px"},
        {id: "new_img_filename", name: "画像"}
      ],
      sort: true,
      search: true,
      pagination: {
        limit: 50
      },
      data: dataObj.map(row => [
        row.id,
        row.company,
        row.name,
        row.email,
        row.staff_name,
        row.created_at,
        gridjs.html(`<a href='<?php echo $link_url;?>${row.id}' class="gridjs-edit-btn"><span class="material-symbols-outlined">edit</span></a>`),
        gridjs.html(`<button type="button" class="gridjs-delete-btn" onclick="openModal(${row.id},'${row.new_img_filename}')"><span class="material-symbols-outlined" data-micromodal-trigger="modal-1" role="button">delete</span></button>`),
        row.new_img_filename
      ]),
      width: "1100px"
    });
    grid.render(document.getElementById("wrapper"));


    // 削除処理
    async function deleteItem(element) {
      // 現在のページ数、ソート順、検索条件を保持

      // modalを閉じる
      MicroModal.close('modal-1');

      // 削除するアイテムのidを定義
      const id = element.dataset.id;
      const deleteFile = element.dataset.filename
      const submitData = {
        id: id,
        deleteFile: deleteFile,
      };

      console.log(id);
      console.log(deleteFile);

      try {
        // 画像ファイルの削除
        const response = await fetch('./delete_image.php', {
          method: 'POST',
          body: JSON.stringify(submitData),
        });

        const responseData = await response;
        if (!response.ok) {
          throw new Error(`HTTPエラー: ${response.status}`);
        }
        console.log(response);


        // データベースから該当のアイテムを削除
        const response2 = await fetch('./item_delete.php', {
          method: 'POST', // HTTPメソッドを指定
          headers: {
            'Content-Type': 'application/json' // データ形式を指定
          },
          body: JSON.stringify(submitData),
        });
        const responseData2 = await response2.json(); // データを取得
        console.log(responseData2);

        if (responseData2.status === 'success') {
          dataObj = responseData2.data
          console.log('削除後', dataObj); // 取得したデータ

          grid.updateConfig({
            data: dataObj.map(row => [
              row.id,
              row.company,
              row.name,
              row.email,
              row.staff_name,
              row.create_datetime,
              gridjs.html(`<a href='./admin_edit.php?id=${row.id}' class="gridjs-delete-btn"><span class="material-symbols-outlined">edit</span></a>`),
              gridjs.html(`<button type="button" class="gridjs-delete-btn" onclick="openModal(${row.id})"><span class="material-symbols-outlined" data-micromodal-trigger="modal-1" role="button">delete</span></button>`),
            ])
          }).forceRender();


          notyf.success(`正常に削除されました。`);
        } else {
          console.error(responseData2.message); // エラーメッセージ
        }

      } catch (error) {
        console.error('Error:', error); // エラー処理
      }
    }
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

  <script>
    /* notyf 設定 */
    const option = {
      duration: 5000, //表示秒数をミリ秒で指定(0にすると非表示にならない)
      dismissible: true, //閉じるボタンの表示
      position: {x:'right', y:'top'}, //表示位置
      types: [ //カスタム通知用の設定
        {
          type: 'custom',
          background: '#4169e1',
          icon: {
            className: 'material-symbols-outlined',
            tagName: 'span',
            color: '#fff',
            text: 'shopping_cart'
          }
        }
      ]
    };
    const notyf = new Notyf(option);

    <?php if (isset($_SESSION['message'])) { ?>
      notyf.success("<?php echo $_SESSION["message"] ?>");
      <?php unset($_SESSION['message']); ?>
    <?php } ?>

    // 通常の通知の表示方法
      // notyf.error(`error通知`);
      // notyf.success(`success通知`);
    // カスタム通知の表示方法
      // notyf.open({
      //     type: 'custom',
      //     message: 'カスタム通知<br>改行',
      // });
  </script>
    
  <script>
    /* ScrollHint 設定 */
    new ScrollHint('.wrapper', {
      i18n: {
        scrollable: '横スクロール可能です' //表示するテキスト
      }
    });
  </script>

  <!-- <script>
    /* 編集ページから戻ってきたときにページネーションの位置を保持するため */
    // 現在のページを保存
    window.addEventListener('beforeunload', () => {
      const currentPageElement = document.querySelector('.gridjs-currentPage');
      const currentPage = currentPageElement ? parseInt(currentPageElement.textContent.trim(), 10) : 1;
      sessionStorage.setItem('currentPage', currentPage);
    });
    

    /* 編集ページから戻ってきたときにスクロール位置を保持するため */
    // スクロール位置を保存
    window.addEventListener('scroll', function() {
      sessionStorage.setItem('scrollPosition', window.scrollY);
    });

    // ページ読み込み時にスクロール位置を復元
    window.addEventListener('load', function() {
      setTimeout(function() {
        const savedScrollPosition = sessionStorage.getItem('scrollPosition');
        if (savedScrollPosition !== null) {
          window.scrollTo(0, savedScrollPosition); // 保存された位置にスクロール
        }
      }, 100); // grid.jsレンダリング後にスクロールするように遅延処理
    });
  </script> -->
</body>
</html>
