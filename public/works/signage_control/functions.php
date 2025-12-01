<?php

// phpからコンソール出力
function console_log($data){
  echo '<script>';
  echo 'console.log('.json_encode($data).')';
  echo '</script>';
}

?>