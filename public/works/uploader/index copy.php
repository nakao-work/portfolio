<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- css読み込み -->
  <link rel="stylesheet" href="./css/sanitize.css">
  <link rel="stylesheet" href="./css/index.css">

  <!-- Google Material Symbol -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="index_php">
  <div id="particles-js"></div>
  <div id="wrapper">
    <div class="title-container">
      <h1 class="title">File Uploader</h1>
    </div>
    <form class="form-container" action="up.php" method="post" enctype="multipart/form-data">
      <input class="file-select" type="file" name="upload_file">
      <button class="upload-btn btn" type="submit">
        <span class="material-symbols-outlined">upload</span>Upload
      </button>
    </form>
    <div class="note-container">
      <p>・ファイルをアップロードすると、ダウンロード用のURLが発行されます。</p>
      <p>・ファイルが複数ある場合は、zipファイル等で1つにまとめてください。</p>
      <p>・最大500GBまでのファイルをアップロード可能です。</p>
      <p class="margin-0">【注意】アップロードしたファイルは1週間で削除されます。</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script src="./js/script.js"></script>
</body>
</html>
