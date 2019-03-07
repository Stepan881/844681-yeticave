<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/main.php');
$config = require('config.php');
$user_name = '';

$connection = db_connect($config['db']);
$user = null;

$categories = get_categories($connection);

if ($user_id = get_value($_SESSION, 'user_id')) {
  $user = get_user_by_id($connection, $user_id);
}

if (!get_value($_GET, 'lot_id')) {
  die('Отсутствует id лота в строке запроса');
}

$lot_id = $_GET['lot_id'];
if (!is_numeric($lot_id)) {
  die('Параметр id лота не является числом');
}

$lot = get_lot($connection, $lot_id);

$error = [
  'title' => '404 Страница не найдена',
  'description' => 'Данной страницы не существует на сайте.'
];

if ($lot) {
  $content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot,
    'user' => $user

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
    'user' => $user,
    'user_name' => $user_name,
    'categories' => $categories
  ]
);

