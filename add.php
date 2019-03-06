<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/upload.php');
require_once('functions/validate_lot.php');
$config = require('config.php');

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lot_data = [];

if (isset($_SESSION['user_id'])) {
  $is_auth = true;
  $user_name = $_SESSION['user_id']['name'];
}
else {
  $is_auth = false;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $lot_data = $_POST;
  $file_data = $_FILES['img'];

  $errors = validate_lot($lot_data, $file_data);

  if (!$errors) {
    $lot_data['img'] = (upload_img($file_data['tmp_name'], $file_data['name']));
    $lot_id = add_lot($connection, $lot_data);

    if ($lot_id) {
      header("Location: lot.php?lot_id=" . $lot_id);
      exit();
    }
  }
}

$error = [
  'title' => '403 Страница не доступна',
  'description' => 'Войдите или зарегистрируйтесь'
];

if ($is_auth) {
  $content = include_template('add-lot.php', [
  'errors' => $errors,
  'categories' => $categories,
  'lot' => $lot,
  'lot_data' => $lot_data
]);
} else {
  $content = include_template('error.php', [
    'categories' => $categories,
    'error' => $error
  ]);
  header("HTTP/1.0 403 Not Found");
}


echo include_template('layout.php',
  [
    'title' => 'Добавить лот',
    'categories' => $categories,
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name
  ]
);

