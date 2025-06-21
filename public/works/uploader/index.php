<?php

// 関数を定義したファイルを読み込み
require_once './functions.php';

// DB接続用の情報を定義したファイルを読み込み
require_once './conf/const.php';

?>

<!DOCTYPE html>
<html lang="ja" class="index-html">
<head>
  <!-- <head>の共通部分を読み込み -->
  <?php include './head.php'; ?>

  <!-- recaptcha読み込み -->
  <script src="https://www.google.com/recaptcha/api.js?render=6Lct980qAAAAAMZRBecZfU14AcAg5_tgsmVNyQmR"></script>
</head>
<body class="index-body">
  <!-- ****初期画面**** -->
  <div id="particles-js"></div>
  <div id="wrapper">
    <div class="logo c-mt-50 c-mb-50">
      <h1 class="logo__text">File Uploader</h1>
    </div>
    <form action="up.php" method="post" enctype="multipart/form-data" class="top-upload-form c-mb-50">
      <div id="id-drop-zone" class="drop-zone c-mb-30">
        <span class="material-symbols-outlined">cloud_upload</span>
        <p class="c-m-0">ドラッグ＆ドロップまたはクリックしてファイルを選択</p>
        <p id="id-filename" class="filename"></p>
        <input type="file" name="upload_file" id="id-file-input" class="file-input" style="display: none;">
      </div>
      <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
      <button type="button" id="id-btn-upload" class="btn btn-primary">
        <span class="material-symbols-outlined">upload</span>Upload
      </button>
      <div id="id-progress" class="progress">
        <progress id="id-progress__bar" class="progress__bar" max="100" value="0"></progress>
        <p id="id-progress__val" class="progress__val">0%</p>
      </div>
    </form>
    <div class="note-container c-mb-50">
      <p>・ファイルをアップロードすると、ダウンロード用のURLが発行されます。</p>
      <p>・ファイルが複数ある場合は、zipファイル等で1つにまとめてください。</p>
      <p>・最大5MBまでのファイルをアップロード可能です。</p>
      <p class="margin-0">【注意】アップロードしたファイルは1週間で削除されます。</p>
    </div>
  </div>


  <!-- ****アップロード完了画面**** -->
  <div id="id-up-wrapper" class="up-wrapper">
    <!-- エラーメッセージ -->
    <div id="id-err-container" class="err-container"></div>

    <!-- 成功メッセージ -->
    <div id="id-success-container" class="success-container">
      <h3 class="success-msg">アップロードが完了しました</h3>
      <div class="success-detail-container">
        <span class="material-symbols-outlined check_circle">check_circle</span>
        <p id="id-filename"></p>
        <p id="id-filesize" class="c-mb-30"></p>
        <p class="download_url_header">ダウンロードURL</p>
        <div class="download_url_container">
          <input type="text" value="" id="id-download-url" class="download_url">
          <span class="material-symbols-outlined content_copy" data-copy="copyarea">content_copy</span>
        </div>
        <p class="c-mb-30">※ファイルは1週間で削除されます。</p>
      </div>
    </div>

    <!-- 戻るボタン　成功・エラー共通 -->
    <div id="back-btn-container">
      <a href="./index.php" class="c-move-top-btn c-btn">←Topに戻る</a>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./js/script.js"></script>
  <script>
    /*==================================================
    ファイルアップロード
    ===================================*/
    const dropZone = document.querySelector("#id-drop-zone");
    const fileName = document.querySelector("#id-filename");
    const fileInput = document.querySelector("#id-file-input");
    const btnUpload = document.querySelector('#id-btn-upload');

    // ドロップゾーンをクリックするとファイル選択ダイアログを開く
    dropZone.addEventListener("click", () => fileInput.click());

    // ファイルをドラッグしてきた際のスタイル変更
    dropZone.addEventListener("dragover", (e) => {
      e.preventDefault();
      dropZone.style.backgroundColor = "#02394D";
    });
    dropZone.addEventListener("dragleave", () => {
      dropZone.style.backgroundColor = "";
    });

    // ファイルをドロップした場合
    dropZone.addEventListener("drop", (e) => {
      e.preventDefault();
      dropZone.style.backgroundColor = "";
      const files = e.dataTransfer.files;
      setFilesToInput(files)
    });

    // ファイル選択ダイアログで選択された場合
    fileInput.addEventListener("change", () => setFilesToInput(fileInput.files));

    // ファイルを <input> にセットする関数
    function setFilesToInput(files) {
      // ファイルバリデーション
      if( fileValidation(files[0]['name'], files[0]['size'])) {
        
        // DataTransferオブジェクトを作成
        const dataTransfer = new DataTransfer();

        // ドロップされたファイルをDataTransferに追加
        for (const file of files) {
          dataTransfer.items.add(file);
        }

        // <input type="file"> の files プロパティにセット
        fileInput.files = dataTransfer.files;

        // <input type="file">　にセットされたファイル名を表示
        fileName.innerText = fileInput.files[0]['name'];

        // 確認用ログ
        console.log("Input に設定されたファイル: ", fileInput.files);
        console.log("Input に設定されたファイルのサイズ: ", fileInput.files[0].size);
      }
    }

    // Uploadボタンクリックでファイル送信
    btnUpload.addEventListener('click', function(e) {
      btnUpload.disabled = true;  // ボタン連打不可
      const xhr = new XMLHttpRequest();
      const xhr_u = xhr.upload;
      const fd = new FormData();  // フォームデータ
      const progElement = document.querySelector("#id-progress");
      const bar = document.querySelector("#id-progress__bar");
      const bar_f = document.querySelector("#id-progress__val");
      bar.value = 0;  // プログレスバーの進捗を0%へ

      btnUpload.style.display = "none"; // アップロードボタンを非表示
      progElement.style.display = "flex"; // プログレスバーを表示


      ///////////// XMLHttpRequest 各イベント/////////////
      // アップロード開始
      xhr.onloadstart = function(event) {
        console.log("upload start.");
      }

      // アップロード中（何度も発火）
      xhr_u.onprogress = function(event) {
        var progVal = parseInt(event.loaded/event.total*10000)/100; // 小数点以下2桁
        bar.value = progVal;
        if(progVal == 100){
          bar_f.innerText = "100%";
        }else{
          bar_f.innerText = String(progVal) + " %";
        }
        console.log(bar.value);
      }
      
      // アップロード完了（受信成功時）
      xhr.onload = function(event) {
        // 元の表示を非表示に
        const particlesElement = document.querySelector('#particles-js');
        const indexWrapperElement = document.querySelector('#wrapper');
        particlesElement.style.display = "none";
        indexWrapperElement.style.display = "none"; 

        // アップロード完了画面を表示
        const upWrapperElement = document.querySelector('#id-up-wrapper');
        upWrapperElement.style.display = "block"; 

        // レスポンスの取得
        const response = JSON.parse(xhr.responseText);
        console.log(response);
        
        // レスポンス内容に応じて表示を切り替え
        if(response.status == "error") {
          // エラーの場合
          const errors = response.error;
          const errContainer = document.querySelector("#id-err-container");
          const backBtnContainer = document.querySelector("#back-btn-container");
          errors.forEach(function(errMessage) {
            const p = document.createElement('p');
            p.className = 'err-msg';
            p.innerHTML = `<span class="material-symbols-outlined">warning</span> ${errMessage}`
            errContainer.appendChild(p);
          })
          backBtnContainer.className = "c-mt-100";
          errContainer.style.display = 'block';

        } else if(response.status == "success") {
          // 成功の場合
          const data = response.data;
          const successContainer = document.querySelector("#id-success-container");
          const filename = document.querySelector("#id-filename");
          const filesize = document.querySelector("#id-filesize");
          const url = document.querySelector('#id-download-url');
          const baseURL = "<?php echo PROJECT_ROOT_URL; ?>";
          const backBtnContainer = document.querySelector("#back-btn-container");

          filename.innerText = data[0]['original_filename'];
          filesize.innerText = changeFileSizeUnit(data[0]['file_size']);
          url.value = baseURL + "predl.php?file=" + data[0]['file_name'];
          backBtnContainer.className = "";
          successContainer.style.display = 'block';
        }
      }
  
      // error
      xhr.onerror = function(event) {
        alert("upload error.");
        console.log("upload error.");
      }
  
      // error abort
      xhr.onabort = function(event) {
        alert("upload abort.");
        console.log("upload abort.");
      }
  
      // error timeout
      xhr.ontimeout = function(event) {
        alert("upload timeout.");
        console.log("upload timeout.");
      }
      
      // 処理終了（成功 & 失敗に関係なく発火）
      xhr.onloadend = function(event) {
        console.log("upload end.")
        btnUpload.disabled = false; //ボタン解除
        btnUpload.style.display = "flex"; // アップロードボタンを表示
        progElement.style.display = "none"; // プログレスバーを非表示
        return false;
      }
      ////////////////////////////////////////////////////
  

      //////////////////// メイン処理 ////////////////////
      // ファイルが選択されているか確認
      if(fileInput.files.length == 1){
        xhr.open('post', './up.php'); // post先ファイルを指定
        fd.append('upload_file', fileInput.files[0]); // formへセット 
        grecaptcha.ready(function () {
          grecaptcha.execute("<?php echo RECAPTCHA_SITE_KEY ?>", {action: "submit"}).then(function(token) {
            //reCAPTCHAで発行されたトークンが変数tokenに格納されている
            document.getElementById("recaptchaResponse").value = token;
            fd.append('recaptcha_response', document.getElementById("recaptchaResponse").value); // formへセット 

            xhr.send(fd); // データ送信
          });
        });
  
      // ファイル未選択
      }else{
        swal2DisplayAlert('ファイルエラー', 'ファイルが選択されていません。', 'error', 'OK');
        btnUpload.disabled = false; //ボタン解除
        btnUpload.style.display = "flex"; // アップロードボタンを表示
        progElement.style.display = "none"; // プログレスバーを非表示
      }
      return false;
      ////////////////////////////////////////////////////
    })
  </script>
</body>
</html>
