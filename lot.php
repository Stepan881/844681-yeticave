<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
$config = require('config.php');
$user_name = '';
session_start();
if (isset($_SESSION['user_id'])) {
  $is_auth = true;
  $user_name = $_SESSION['user_id']['name'];
}
else {
  $is_auth = false;
}

if (!isset($_GET['lot_id'])) {
  die('Отсутствует id лота в строке запроса');
}

$lot_id = $_GET['lot_id'];
if (!is_numeric($lot_id)) {
  die('Параметр id лота не является числом');
}
$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lot = get_lot($connection, $lot_id);

$error = [
  'title' => '404 Страница не найдена',
  'description' => 'Данной страницы не существует на сайте.'
];

if ($lot) {
  $content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot,
    'is_auth' => $is_auth
  ]);
} else {
  $content = include_template('error.php', [
    'categories' => $categories,
    'lot' => $lot,
    'error' => $error
  ]);
  header("HTTP/1.0 404 Not Found");
}

echo include_template('layout.php',
  [
    'title' => $lot['name'],
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
  ]
);

