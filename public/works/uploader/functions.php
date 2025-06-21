<?php

// phpからコンソール出力
function console_log($data){
  echo '<script>';
  echo 'console.log('.json_encode($data).')';
  echo '</script>';
}

// ファイルサイズを適切な単位に変換
function change_filesize_unit($filesize) {
  if($filesize <= (1024**2)) {// KB
    $filesize = $filesize/1024;
    $filesize = number_format($filesize,0);
    $filesize .= 'KB';
  } elseif($filesize <= (1024**3)) { // MB
    $filesize = $filesize/(1024**2);
    $filesize = number_format($filesize,0);
    $filesize .= 'MB';
  } elseif($filesize <= (1024**4)) { //GB
    $filesize = $filesize/(1024**3);
    $filesize = number_format($filesize,0);
    $filesize .= 'GB';
  } else { //Others
    $filesize = $filesize/(1024**4);
    $filesize = number_format($filesize,0);
    $filesize .= 'TB';
  }
  return $filesize;
}

?>