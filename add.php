<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

date_default_timezone_set('Europe/Moscow');
require_once('functions/main.php');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/upload.php');
require_once('functions/validate_lot.php');

$config = require('config.php');

$connection = db_connect($config['db']);

$categories = get_categories($connection);
$lot_data = [];
$user = null;

if ($user_id = get_value($_SESSION, 'user_id')) {
  $user = get_user_by_id($connection, $user_id);
}


$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $lot_data = $_POST;

 // var_dump($lot_data);

  $file_data = get_value($_FILES,'img');

  $errors = validate_lot($lot_data, $file_data);

  if (!$errors) {
    $lot_data['img'] = (upload_img($file_data['tmp_name'], $file_data['name']));
    $lot_id = add_lot($connection, $lot_data, get_value($user, 'id'));

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

if ($user) {
  $content = include_template('add-lot.php', [
  'errors' => $errors,
  'categories' => $categories,
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
    'user' => $user
  ]
);

