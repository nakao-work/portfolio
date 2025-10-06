<?php
require_once '../config/const.php';

// actionを取得
$action = $_GET['action'] ?? '';

switch ($action) {
  case 'send_mail':
    require_once dirname(PROJECT_ROOT_PATH) . '/app/send_mail.php';
    break;

  // case 'another_endpoint':
  //   require_once dirname(PROJECT_ROOT_PATH) . '/app/another.php';
  //   break;

  default:
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
    break;
}
